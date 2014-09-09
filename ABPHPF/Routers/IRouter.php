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
 * @version    $Id: IRouter.php $
 */

namespace ABPHPF\Routers;


/**
 * Router interface.
 *
 * @category   ABPHPF
 * @package    ABPHPF\Routers
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	
	interface IRouter {
		
	  /**
	   * Get Request url sigments
	   * 	   
	   *@return string
	   */
		public function getURI();

	  /**
	   * Get Request method
	   * 	   
	   *@return string
	   */
		public function getRequest(); 

	  /**
	   * Get POST method
	   * 	   
	   *@return mixed
	   */
		public function getPost();

	}//IRouter