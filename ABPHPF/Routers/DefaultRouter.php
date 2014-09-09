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
 * @version    $Id: DefaultRouter.php $
 */

namespace ABPHPF\Routers;


/**
 * Default router class.
 *
 * @category   ABPHPF
 * @package    ABPHPF\Routers
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	
	class DefaultRouter implements \ABPHPF\Routers\IRouter {
		
	  /**
	   * Get Request url sigments
	   * 	   
	   *@return string
	   */
		public function getURI(){
			return substr($_SERVER["PHP_SELF"], strlen($_SERVER['SCRIPT_NAME']) + 1);
		}

	  /**
	   * Get Request method
	   * 	   
	   *@return string
	   */
		public function getRequest(){
			return $_SERVER["REQUEST_METHOD"];
		}
		
	  /**
	   * Get POST method
	   * 	   
	   *@return mixed
	   */
		public function getPost(){
			return $_POST;
		}

	  /**
	   * Get GET method
	   * 	   
	   *@return mixed
	   */
		public function getGet(){
			return $_GET;
		}
		
	}//DefaultRouter