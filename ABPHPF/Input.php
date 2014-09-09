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
 * @version    $Id: Input.php $
 */

namespace ABPHPF;


/**
 * Input class.
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */

	class Input {
    /**
     * Input object
     *
     * @var mixed
     */
		private static $instance = NULL;

    /**
     * Array GET vars
     *
     * @var array
     */
		private $_get = array();

    /**
     * Array POST vars
     *
     * @var array
     */
		private $_post = array();

    /**
     * Array COOKIES vars
     *
     * @var array
     */
		private $_cookies = array();
		
	  /**
	   * Constructor
	   * 	
	   *@access	private		    
	   *@return void
	   */
		private function __construct() {
			$this->_cookies = $_COOKIE;
		}//__construct()
		
	  /**
	   * GET Array Maps
	   * 	
	   *@access	public		    
	   *@param string $a 
	   *		   
	   *@return void
	   */
		public function setGet($a) {
			if(is_array($a)) $this->_get = $a;
		}//setGet()
		
	  /**
	   * Post Array Maps
	   * 	
	   *@access	public		    
	   *@param string $a 
	   *		   
	   *@return void
	   */
		public function setPost($a) {
			if(is_array($a)) $this->_post = $a;
		}//setPost()
		
	  /**
	   * Check GET var if exist
	   * 	
	   *@access	public		    
	   *@param string $id 
	   *		   
	   *@return mixed
	   */
		public function hasGet($id) {
			return array_key_exists($id, $this->_get);
		}//hasGet()

	  /**
	   * Check POST var if exist
	   * 	
	   *@access	public		    
	   *@param string $name 
	   *		   
	   *@return mixed
	   */
		public function hasPost($name) {
			return array_key_exists($name, $this->_post);
		}//hasPost()

	  /**
	   * Check COOKIE var if exist
	   * 	
	   *@access	public		    
	   *@param string $name 
	   *		   
	   *@return mixed
	   */
		public function hasCookies($name) {
			return array_key_exists($name, $this->_cookies);
		}//hasCookies()
		
	  /**
	   * GET input data ...
	   * 	
	   *@access	public		    
	   *@param string $name 
	   *@param string $validators 
	   *@param string $default 
	   *		   
	   *@return mixed
	   */
		public function get($id, $validators = NULL, $default = NULL) {
			if($this->hasGet($id)) {
				if(!is_null($validators)) {
					return \ABPHPF\Common::validate($id, $validators);
				}
				return $this->_get[$id];
			}
			return $default;
		}//get()
		
	  /**
	   * POST input data ...
	   * 	
	   *@access	public		    
	   *@param string $name 
	   *@param string $validators 
	   *@param string $default 
	   *		   
	   *@return mixed
	   */
		public function post($name, $validators = NULL, $default = NULL) {
			if($this->hasPost($name)) {
				if(!is_null($validators)) {
					return \ABPHPF\Common::validate($name, $validators);
				}
				return $this->_post[$name];
			}
			return $default;
		}//post()

	  /**
	   * COOKIES input data ...
	   * 	
	   *@access	public		    
	   *@param string $name 
	   *@param string $validators 
	   *@param string $default 
	   *		   
	   *@return mixed
	   */
		public function cookies($name, $validators = NULL, $default = NULL) {
			if($this->hasCookies($name)) {
				if(!is_null($validators)) {
					return \ABPHPF\Common::validate($name, $validators);
				}
				return $this->_cookies[$name];
			}
			return $default;
		}//cookies()

	  /**
	   * Return current instance on Input object
	   * 	
	   *@access	public		    
	   *@return object
	   */
		public static function getInstance() {
			if(self::$instance == NULL) {
				self::$instance = new self();
			}
			
			return self::$instance;
		}//getInstance()
		
	}	//Input()