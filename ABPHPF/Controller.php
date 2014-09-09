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
 * @version    $Id: Controller.php $
 */

namespace ABPHPF;


/**
 * Default controller class.
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */

	abstract class Controller {
		
		public $app;

    /**
     * @var array of existing class methods
     */
    protected $_classMethods;
 
    /**
     * View object
     * @var view
     */
		public $view;
		public $config;
		public $input;
		public $_helper;
		
		public function __construct() {

			//$this->_helper = new Zend_Controller_Action_HelperBroker($this);
			$this->init();
		}//__construct()
		
		public function init() {
		
		}//init()

		public function __get($name) {
		//	return $this->registry->get($key);
		}//__get
		
		public function __set($name, $value) {
		//	$this->registry->set($key, $value);
		}//__set
		/*
		public function helper($helper) {
			$this->_helper = $helper;
			return $this;
		}
		*/
    /**
     * Get a helper by name
     *
     * @param  string $helperName
     * @return object
     */
		public function getHelper($helperName) {
			 return $this->_helper->{$helperName};
		}//getHelper()
		
    /**
     * Get a clone of a helper by name
     *
     * @param  string $helperName
     * @return object
     */
		public function getHelperClone($helperName) {
			return clone $this->_helper->{$helperName};
		}//getHelperClone()
		
    /**
     * Pre-dispatch routines
     *
     * Called before action method. If using class with
     *
     * @return void
     */
		public function preDispatch() {
		
		}//preDispatch()
		
    /**
     * Post-dispatch routines
     *
     * Called after action method execution. If using class with
     *
     * @return void
     */
		public function postDispatch() {
		
		}//postDispatch()
		
		public function dispatch($action) {
			$this->preDispatch();
			
			if(NULL === $this->_classMethods) {
				$this->_classMethods = get_class_methods($this);
			}
			
			/*
				TODO:
				if recuset a redirect stop dispatch ..
			*/
			
			if(in_array($action, $this->_classMethods)) {
				$this->$action();
			} else {
				throw new \Exception('No valid action found', 500);
			}
			 
			$this->postDispatch();
		}//dispatch()
		
		final protected function forward($action, $controller = NULL, $args = array()) {
			if( NULL === $controller) {
			//	$controller = get_class();
				$this->dispatch($action);
			} else {
				try {
					//in_array($class_name, get_declared_classes());
					if(class_exists($controller)) {
						$CI = new $controller();
						$CI->dispatch($action);
					}
				} catch(Exception $e) {
					echo $e->getMessage();
				}
			}
		}//forward()

		protected function redirect($url, $status = 302) {
			header('Status: ' . $status);
			header('Location: ' . str_replace('&amp;', '&', $url));
			exit();
		}
		
	}//Controller()


