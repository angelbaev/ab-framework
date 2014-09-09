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
 * Session interface.
 *
 * @category   ABPHPF
 * @package    ABPHPF\Session
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	interface ISession {
		
	  /**
	   * Get Session id
	   *
	   *@return string	   
	   */
		public function getSessionId();

	  /**
	   * Save session data
	   *
	   */
		public function saveSession();

	  /**
	   * Destroy session data
	   *
	   */
		public function destroySession();

	  /**
	   * Regenerate Session id
	   *
	   *@return void	   
	   */
		public function regenerateId();

	  /**
	   * Get Session item
	   * 	   
	   *@return mixed
	   */
		public function __get($name);

	  /**
	   * Set Session item
	   *
	   *@param  string $name
	   *@param  mixed $value		 	   
	   */
		public function __set($name, $value);

	  /**
	   * isset Session item
	   *
	   *@param  string $name
	   * 	   
	   *@return bool
	   */
		public function __isset($name);

	  /**
	   * unset Session item
	   *
	   *@param  string $name
	   * 	   
	   *@return void
	   */
		public function __unset($name);
	}//ISession
