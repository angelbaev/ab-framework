<?php
/**
 * ABPHPF Framework
 *
 * LICENSE
 *
 *
 * @category   ABPHPF
 * @package    
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 * @version    $Id: App.php $
 */

namespace ABPHPF;

/**
 * @see Loader
 */
include_once 'Loader.php';

/**
 * Class for Application.
 *
 * @category   ABPHPF
 * @package    
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */

  class App {
    
    /**
     * Instance
     *
     * @var object|resource|null
     */
    private static $_instance = NULL;
    /**
     * Config
     *
     * @var object|null
     */
    private $_config = NULL;
    /**
     * Router
     *
     * @var object|resource|null
     */
    private $router = NULL;
    /**
     * Database connection
     *
     * @var object|resource|null
     */
    private $db = NULL;
    /**
     * Session
     *
     * @var object|null
     */
    private $_session = NULL;
    /**
     * frontController
     *
     * @var object|null
     */
    private $_frontController = NULL;
    /**
     * Constructor
     * 
     *
     */
    private function __construct() {
    	set_exception_handler(array($this, '_exceptionHandler'));
    	\ABPHPF\Loader::registerNamespace('ABPHPF', dirname(__FILE__) . DIRECTORY_SEPARATOR);
    	\ABPHPF\Loader::registerAutoLoad();
    	
    	$this->_config = \ABPHPF\Config::getInstance();
    	
    	if($this->_config->getConfigPatch() == NULL) 
    		$this->setConfigFolder('../config');
    }//__construct()
    
    public function run() {
    	$this->_frontController = \ABPHPF\FrontController::getInstance();
    	
    	if($this->router instanceof \ABPHPF\Routers\IRouter) {
				$this->_frontController->setRouter($this->router);
			} else if ($this->router == 'JsonRPCRouter') {
				$this->_frontController->setRouter(new \ABPHPF\Routers\JsonRPCRouter());
			} else if ($this->router == 'CLIRouter') {
				$this->_frontController->setRouter(new \ABPHPF\Routers\DefaultRouter());
			} else {
				$this->_frontController->setRouter(new \ABPHPF\Routers\DefaultRouter());
			}

			//\ABPHPF\App::getInstance()->getConfig()->app['viewsDirectory']
      $this->_frontController->dispatch();
    }//run()
    
    public function setConfigFolder($path) {
			$this->_config->setConfigPatch($path);
		}//setConfigFolter()
		
		public function getConfigFolder() {
			return $this->_config->getConfigPatch(); 
		}
		
		public function getConfig() {
			return $this->_config;
		}
		
		public function getRouter() {
			return $this->router;
		}

		public function setRouter($router) {
			return $this->router = $router;
		}
		
		public function getSession() {
			return $this->_session;
		}
		
		public function setSession(\ABPHPF\Session\ISession $session) {
			$this->_session = $session;
		}//setSession()
		
		public function DB($connection = 'default') {
			//Diff DB engine ...
		}//DB()
		
		
    /**
     * Returns the App instance.
     *
     * @return Zend_Db_Profiler
     */
    public static function getInstance() {
      if(self::$_instance == NULL) {
        self::$_instance = new self();
				//new \ABPHPF\App();
      }
      
      return self::$_instance;
    }//getInstance()
    
    public function _exceptionHandler(\Exception $ex) {
			if ($this->_config && $this->_config->app['displayExceptions'] == true ) {
				echo '<pre>' . print_r($ex, true) . '</pre>';
			} else {
				print "<pre>";
				print_r($ex);
				print "</pre>";
				$this->displayError($ex->getCode());
			}
		}//_exceptionHandler()
		
		public function displayError($error) {
			try {
				$view = \ABPHPF\View::getInstance();
				$view->render('errors.'	.	$error);
			} catch(\Exception $exc) {
				\ABPHPF\Common::headerStatus($error);
				echo '<h1>' . $error . '</h1>';
				exit();
			}
		}//displayError()
		
		public function __destruct() {
			if($this->_session != NULL) {
				$this->_session->saveSession();
			}
		}
    
  }//App