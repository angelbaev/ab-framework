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
 * @version    $Id: Config.php $
 */

namespace ABPHPF;


/**
 * Config class.
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	
	final class Config {
		private static $instance = NULL;
		private $_configPatch = NULL;
		private $data = array();
		
	  /**
	   * Constructor
	   * 	
	   *@access	private		    
	   *@return mixed
	   */
		private function __construct() {
		
		
		}//__construct()
		
	  /**
	   * Get config patch
	   *
	   *@access	public
	   *@return  string	 	   
	   */
		public function getConfigPatch() {
			return $this->_configPatch;
		}//getConfigPatch()

	  /**
	   * Set config patch
	   *
	   *@access	public
	   *@return  void	 	   
	   */
		public function setConfigPatch($path) {
			if(!$path) {
				throw new \Exception('Empty config folder path:');
			}
			
			$_configPatch = realpath($path);
			
			if($_configPatch != false && is_dir($_configPatch) && is_readable($_configPatch)) {
				//clear old config data
				$this->data = array();
				$this->_configPatch = $_configPatch	.	DIRECTORY_SEPARATOR;
				$ns = $this->app['namespaces'];
				//load namespaces
				if(is_array($ns)) {
					\ABPHPF\Loader::registerNamespaces($ns);
				}
			} else {
				throw new \Exception('Config directory read error:' . $path);
			}
		}//setConfigPatch()

	  /**
	   * include config folder
	   *
	   *@access	public
	   *@return  void	 	   
	   */
		public function includeCFile($path) {
			if(!$path) {
				throw new \Exception('Empty config folder path:');
			}
			
			$CFile = realpath($path);

			if($CFile != false && is_file($CFile) && is_readable($CFile)) {
//				$basename = explode('.php', basename($CFile))[0];
				$basename = explode('.php', basename($CFile));
				$basename = $basename[0];
				$this->data[$basename] = include_once ($CFile);
			} else {
				 throw new \Exception('Config file read error:' . $path);
			}
		}//includeCFile()
		
	  /**
	   * get config param
	   *
	   *@access	public
	   *@param  string $name
	   *@return  mixed	 	   
	   */
		public function __get($name) {
			if(!isset($this->data[$name])) {
				$this->includeCFile($this->getConfigPatch()	.	$name	.	'.php');
			}
			
			if(array_key_exists($name, $this->data)) {
				return $this->data[$name];
			}
			return NULL;
		}//__get()
		
	  /**
	   * return current instance
	   *
	   *@access	public
	   *
	   *@return  object	 	   
	   */
		public static function getInstance() {
			if (self::$instance === NULL) {
				self::$instance = new \ABPHPF\Config();
//				self::$instance = new self();
			} 
			return self::$instance;
		}//getInstance()
		
	}//Config