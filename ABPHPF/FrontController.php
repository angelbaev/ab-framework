<?php
/**
 * ABPHPF Framework
 *
 * LICENSE
 *
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 * @version    $Id: FrontController.php $
 */

namespace ABPHPF;


/**
 * FrontController class.
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	
	class FrontController {

		private static $_instance = NULL;
		private $_ns = NULL;
		private $_controller = NULL;
		private $_action = NULL;
		private $_router = NULL;
		private $_params = array();
		
		private function __construct() {
		
		}//__construct()
		
		public function getRouter() {
			return $this->_router;
		}//getRouter()
		
		public function getParams() {
			return $this->_params;
		}//getParams()

		public function getParam($name) {
			return (isset($this->_params[$name])?$this->_params[$name]:false);
//			return array_key_exists($name, $this->_params);
		}//getParams()
		
		public function setRouter(\ABPHPF\Routers\IRouter $router) {
			$this->_router = $router;
		}//setRouter()

		public function setParams(array $params) {
			$this->_params = array_merge($this->_params, $params);
		}//getParams()

		public function setParam($name, $value) {
			$this->_params[$name] = $value;
		}//getParams()

		public function clearParam($name) {
			if(isset($this->_params[$name])) unset($this->_params[$name]);
		}//clearParam()
		
		public function clearParams(array $params) {
			foreach($params as $key => $val)
				$this->clearParam($key);
		}//clearParams()
		
		public function dispatch() {
			if(is_null($this->_router)) {
				throw new \Exception('No valid router found',500);
			}

			$_URI = $this->_router->getURI();
			$routers = \ABPHPF\App::getInstance()->getConfig()->routes;
			$_RC = NULL;
			
			if(is_array($routers) && count($routers) > 0) {
				foreach($routers as $name => $router) {
					if(stripos($_URI, $name) === 0 && ($_URI == $name || stripos($_URI, $name . '/') === 0) && $router['namespace']) {
						$this->_ns = $router['namespace'];
						$_URI = substr($_URI, strlen($name) + 1);
						$_RC = $router;
						break;
					}
				}
			} else {
				throw new \Exception('Default route missing', 500);
			}
			
			if($this->_ns == NULL && $routers['*']['namespace']) {
				$this->_ns = $routers['*']['namespace'];
				$_RC = $routers['*'];
			} else if ($this->_ns == NULL && !$routers['*']['namespace']){
				throw new \Exception('Default route missing', 500);
			}
			
			$input = \ABPHPF\Input::getInstance();
			$this->setParams(explode('/', $_URI));

			if($this->getParam(0)) {
				$this->_controller = strtolower($this->getParam(0));
				
				if ($this->getParam(1)) {
					$this->_action = strtolower($this->getParam(1));
					$this->clearParams(array(0, 1));
					$input->setGet(array_values($this->getParams()));
				} else {
					$this->_action = $this->getDefaultAction();
				}
			} else {
				$this->_controller = $this->getDefaultController();
				$this->_action = $this->getDefaultAction();
			}
			
			if(is_array($_RC) && isset($_RC['controllers'])) {
				if($_RC['controllers'][$this->_controller]['methods'][$this->_action]){
					$this->_action = strtolower($_RC['controllers'][$this->_controller]['methods'][$this->_action]);
				}
				
				if(isset($_RC['controllers'][$this->_controller]['to'])){
					$this->_controller = strtolower($_RC['controllers'][$this->_controller]['to']);
				}            
			}
			
			$input->setPost($this->_router->getPost());

			$CI = $this->_ns	.	'\\'	.	ucfirst($this->_controller);

			$Controller = new $CI();
			$Controller->dispatch($this->_action);
			
			//$Controller->{$this->_action}();
		}//dispatch()
		
		public function getDefaultController() {
			$controler = \ABPHPF\App::getInstance()->getConfig()->app['default_controller'];
			
			if($controler) {
				return strtolower($controler);
			} else {
				return 'index';
			}
		}//getDefaultController()
		
		public function getDefaultAction() {
			$action = \ABPHPF\App::getInstance()->getConfig()->app['default_action'];

			if($action) {
				return strtolower($action);
			} else {
				return 'index';
			}
		}//getDefaultAction()

		public static function getInstance() {
			if(self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}//getInstance()
	}//FrontController