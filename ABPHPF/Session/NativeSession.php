<?php
/**
 * ABPHPF Framework
 *
 * LICENSE
 *
 *
 * @category   ABPHPF
 * @package    ABPHPF\Session
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 * @version    $Id: ISession.php $
 */

namespace ABPHPF\Session;


/**
 * NativeSession class.
 *
 * @category   ABPHPF
 * @package    ABPHPF\Session
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	
	class NativeSession implements \ABPHPF\Session\ISession {

    /**
     * Check whether or not the session was started
     *
     * @var bool
     */
    private static $_sessionStarted = false;
	
		public function __construct($name, $lifetime = 3600, $path = null, $domain = null, $secure = false) {
			if(strlen(trim($name)) < 1) $name = "_default";
			
			session_name($name);
			session_set_cookie_params($lifetime, $path, $domain, $secure, true);
			session_start();

			self::$_sessionStarted = true;
		}//__construct()
		
	  /**
	   * Get Session item
	   * 	   
	   *@return mixed
	   */
		public function __get($name) {
			return (isset($_SESSION[$name])?$_SESSION[$name]:NULL);
		}//__get

	  /**
	   * Set Session item
	   *
	   *@param  string $name
	   *@param  mixed $value		 	   
	   */
		public function __set($name, $value) {
			$_SESSION[$name] = $value;
		}//__set
		
	  /**
	   * isset Session item
	   *
	   *@param  string $name
	   * 	   
	   *@return bool
	   */
		public function __isset($name){
			return isset($_SESSION[$name]);
		}//__isset

	  /**
	   * unset Session item
	   *
	   *@param  string $name
	   * 	   
	   *@return void
	   */
		public function __unset($name) {
			unset($_SESSION[$name]);
		}//__unset

	  /**
	   * Get Session id
	   *
	   *@return string	   
	   */
		public function getSessionId() {
			return session_id();
		}//getSessionId

	  /**
	   * Save session data
	   *
	   */
		public function saveSession() {
			session_write_close();
		}//getSessionId

	  /**
	   * Destroy session data
	   *
	   */
		public function destroySession() {
			session_destroy();
			self::$_sessionStarted = false;
		}//getSessionId

	  /**
	   * Regenerate Session id
	   *
	   *@return void	   
	   */
		public function regenerateId(){
			session_regenerate_id(true);
		}//regenerateId()
		
    /**
     * isStarted() - convenience method to determine if the session is already started.
     *
     * @return bool
     */
		public static function isStarted() {
			return self::$_sessionStarted;
		}//isStarted();
		
	}//NativeSession