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
 * Database session class.
 *
 * @category   ABPHPF
 * @package    ABPHPF\Session
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
 	//TODO: implementacia na db drivera  ..... 
	class DBSession implements \ABPHPF\Session\ISession {

    /**
     * Session Name 
     *
     * @var string
     */
		private $sessionName;

    /**
     * Database object
     *
     * @var resurce
     */
		private $db;

    /**
     * Session lifetime
     *
     * @var string
     */
		private $lifetime;

    /**
     * Session path
     *
     * @var string
     */
		private $path;

    /**
     * Session domain
     *
     * @var string
     */
		private $domain;

    /**
     * Session secure mode
     *
     * @var bool
     */
		private $secure;

    /**
     * Session garbage collection probability
     *
     * @var int
     */
		private $gc_probability = 5;
    /**
     * Session id
     *
     * @var string
     */
		private $sessionId = NULL;

    /**
     * Check whether or not the session was started
     *
     * @var bool
     */
    private static $_sessionStarted = false;

    /**
     * Session data
     *
     * @var array
     */
		private $sessionData = array();
		
		
		public function __construct($db, $name, $lifetime = 3600, $path = null, $domain = null, $secure = false) {
			//TODO: __construct param $tableName = 'session' ???
			if(strlen(trim($name)) < 1) $name = "_default";
			
			$this->db = $db;
			$this->sessionName = $name;
			$this->lifetime = $lifetime;
			$this->path = $path;
			$this->domain = $domain;
			$this->secure = $secure;
			$this->sessionId = (isset($_COOKIE[$name])?$_COOKIE[$name]?NULL);
			
			$this->session_GC();
			
			if(strlen($this->sessionId) < 32 ) {
				$this->writeSession();
			} else if (!$this->validateSession()) {
				$this->writeSession();
			}
		}//__construct()

	  /**
	   * Get Session item
	   * 	   
	   *@return mixed
	   */
		public function __get($name) {
			return (isset($this->sessionData[$name])?$this->sessionData[$name]:NULL);
		}//__get

	  /**
	   * isset Session item
	   *
	   *@param  string $name
	   * 	   
	   *@return bool
	   */
		public function __isset($name){
			return isset($this->sessionData[$name]);
		}//__isset

	  /**
	   * unset Session item
	   *
	   *@param  string $name
	   * 	   
	   *@return void
	   */
		public function __unset($name) {
			unset($this->sessionData[$name]);
		}//__unset

	  /**
	   * Set Session item
	   *
	   *@param  string $name
	   *@param  mixed $value		 	   
	   */
		public function __set($name, $value) {
			$this->sessionData[$name] = $value;
		}//__set
		
	  /**
	   * Start session data
	   *
	   *@return  void		 	   
	   */
		private function writeSession() {
			$this->sessionId = md5(uniqid('abphpf_', TRUE));
			//TODO: db query ...
			setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
			
			self::$_sessionStarted = true;
		}//writeSession()
		
	  /**
	   * Validate session data
	   *
	   *@return  void		 	   
	   */
		private function validateSession() {
		
		}//validateSession()
		
	  /**
	   * Garbage collection
	   *
		 * This deletes expired session rows from database
		 * if the probability percentage is met
		 * 		 
	   *@access	private
	   *@return	void		 	   
	   */
		private function session_GC() {
			//TODO: database query
			srand(time());
			if((rand() % 100) < $this->gc_probability) {
			
			}
			
		}//clearSession()
		
	  /**
	   * Get Session id
	   *
	   *@return string	   
	   */
		public function getSessionId() {
			return $this->sessionId;
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
			$this->sessionId = session_regenerate_id(true);
		}//regenerateId()

    /**
     * isStarted() - convenience method to determine if the session is already started.
     *
     * @return bool
     */
		public static function isStarted() {
			return self::$_sessionStarted;
		}//isStarted();
		
	}//DBSession
	