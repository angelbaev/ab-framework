<?php
/**
 * ABPHPF Framework
 *
 * LICENSE
 *
 *
 * @category   ABPHPF
 * @package    ABPHPF\Routers
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 * @version    $Id: JsonRPCRouter.php $
 */

namespace ABPHPF\Routers;


/**
 * JsonRPC router class.
 *
 * @category   ABPHPF
 * @package    ABPHPF\Routers
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	
	class JsonRPCRouter implements \ABPHPF\Routers\IRouter {
		
		private $_map = array();
		private $_requestId;
		private $_post = array();
		
		public function __construct() {
			if(!$this->isJsonRequest()) {
				throw new \Exception('Require json request', 400);
			}
		}//__construct()
		
	  /**
	   * Array map method to jsonRPC routers
	   * 	   
	   *@return void
	   */
		public function setMap($a) {
			if(is_array($a)) $this->_map = $a;
		}//setMap()
		
	  /**
	   * Get content type
	   * 	   
	   *@return string
	   */
		private function serverContentType() {
			return $_SERVER['CONTENT_TYPE'];
		}//serverContentType()
		
	  /**
	   * Get Request url sigments
	   * 	   
	   *@return string
	   */
		public function getURI(){
			if(!is_array($this->_map) || !count($this->_map)) {
				$config = \ABPHPF\App::getInstance()->getConfig()->rpcRoutes;
				if(is_array() && count($config) > 0) { 
					$this->setMap($config);
				} else {
					throw new \Exception('Router require method map', 500);
				}
				
			}

				$request = json_decode(file_get_contents('php://input'), true);
				
				if(!is_array($request) || !isset($request['method'])) {
					throw new \Exception('Require json request', 400);
				} else {
					if(isset($this->_map[$request['method']]) && $this->_map[$request['method']]) {
						$this->_requestId = $request['id'];
						$this->_post = $request['params'];
						
						return $this->_map[$request['method']];
					} else {
						throw new \Exception('Method not found', 501);
					}
				}
			//return substr($_SERVER["PHP_SELF"], strlen($_SERVER['SCRIPT_NAME']) + 1);
		}
		
	  /**
	   * Check if Request method is json application
	   * 	   
	   * If have json request this method return true or not return false	   
	   *@return bool
	   */
		public function isJsonRequest() {
			return (($this->getRequest() != 'POST' || empty($this->serverContentType()) || $this->serverContentType() != 'application/json')?false:true );
		}//isJsonRequest()
		
	  /**
	   * Get Request method
	   * 	   
	   *@return string
	   */
		public function getRequest(){
			return $_SERVER["REQUEST_METHOD"];
		}

	  /**
	   * Get Request id
	   * 	   
	   *@return mixed
	   */
		public function getRequestId(){
			return $this->_requestId;
		}
		
	  /**
	   * Get POST method
	   * 	   
	   *@return mixed
	   */
		public function getPost(){
			return $this->_post;
		}
	
	}//JsonRPCRouter