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
 * @version    $Id: Loader.php $
 */

namespace ABPHPF;


/**
 * Loader class.
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */

	class Loader {
    /**
     * Array with registred namespaces
     *
     * @var array
     */
		private static $namespaces = array();
		
	  /**
	   * Constructor
	   * 	
	   *@access	private		    
	   *@return void
	   */
		private function __construct() {
		
		}//__construct()
		
	  /**
	   * register AutoLoad class method
	   * 	
	   *@access	public		    
	   *@return void
	   */
		public static function registerAutoLoad() {
			spl_autoload_register(array("\ABPHPF\Loader", "setupAutoload"));
		}//registerAutoLoad()
		
	  /**
	   * setupAutoload method
	   * 	
	   *@access	public		    
	   *@return void
	   */
		public static function setupAutoload($class) {
			self::addClass($class);
		}//setupAutoload()
		
	  /**
	   * Include file by class name
	   * 	
	   *@access	public		    
	   *@return void
	   */
		public static function addClass($class) {
				foreach(self::$namespaces as $namespace => $path) {
					if(strpos($class, $namespace) === 0) {
						$file = realpath(substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $path, 0, strlen($namespace)) . '.php');
						if($file && is_readable($file)) {
							include_once($file);
						} else {
							throw new \Exception('File cannot be included:' . $file);
						}
						break;
					}
				}
		}//addClass()
		
	  /**
	   * Register PHP namepsace
	   * 	
	   *@access	public		    
	   *@return void
	   */
		public static function registerNamespace($namespace, $path) {
			$namespace = trim($namespace);
			
			if(!empty($namespace)) {
				if(!$path) {
					throw new \Exception('Invalid path');
				}
				$r_path = realpath($path);
				
				if($r_path && is_dir($r_path) && is_readable($r_path)) {
					self::$namespaces[$namespace	.	'\\'] = $r_path	.	DIRECTORY_SEPARATOR;
				} else {
					throw new \Exception('Namespace directory read error:' . $path);
				}
			} else {
				throw new \Exception('Invalid namespace:' . $namespace);
			}
		}//registerNamespace()
		
	  /**
	   * Register PHP array with namepsaces
	   * 	
	   *@access	public		    
	   *@return void
	   */
		public static function registerNamespaces($a) {
			if(is_array($a)) {
				foreach($a as $namespace => $path) {
					self::registerNamespace($namespace, $path);
				}
			} else {
				throw new \Exception('Invalid namespaces');
			}
		}//registerNamespaces()
		
	  /**
	   * Return Array with all registred namespaced
	   * 	
	   *@access	public		    
	   *@return array
	   */
		public static function getNamespaces() {
			return self::$namespaces;
		}//getNamespaces()
		
	  /**
	   * Remove registred namespace
	   * 	
	   *@access	public		    
	   *@return void
	   */
		public static function removeNamespace($namespace) {
			if(isset(self::$namespaces[$namespace])) {
				unset(self::$namespaces[$namespace]);
			}
		}//removeNamespace
		
	  /**
	   * Clear all registred namespaces
	   * 	
	   *@access	public		    
	   *@return void
	   */
		public static function clearNamespaces() {
			self::$namespaces = array();
		}//clearNamespaces()
		
	}