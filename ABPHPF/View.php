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
 * @version    $Id: View.php $
 */

namespace ABPHPF;


/**
 * View base class.
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */
	
	class View {
		private static $_instance = NULL;
		private $viewPath = NULL;
		private $viewDir = NULL;
		private $data = array();
		private $layout_parts = array();
		private $layout_data = array();
		private $ext = '.php';
		private $securty_mode = false;
		
		private function __construct() {
			$this->viewPath = \ABPHPF\App::getInstance()->getConfig()->app['viewsDirectory'];
			if($this->viewPath == NULL) {
				$this->viewPath = realpath('../views/');
			}
		}//__construct()
		
		public function __get($name) {
			return (isset($this->data[$name])?$this->data[$name]:NULL);
		}//__get()
		
		public function __set($name, $value) {
			$this->data[$name] = $value;
		}//__set()
		
		public function setViewDirectory($path) {
			$path = trim($path);
			
			if($path) {
				$path = realpath($path) . DIRECTORY_SEPARATOR;
				if(is_dir($path) && is_readable($path)) {
					$this->viewDir = $path;
				} else {
						throw new \Exception('view path',500);				
				}
			} else {
				throw new \Exception('view path',500);
			}
		}//setViewDirectory()
		
		public function getLayoutData($name) {
			return (isset($this->layout_data[$name])?$this->layout_data[$name]:NULL);
		}//getLayoutData()

		public function setLayoutData($name, $value) {
			$this->layout_data[$name] = $value;
		}//getLayoutData()
		
		public function append($name, $template) {
			if($name && $template) {
				$this->layout_parts[$name] = $template;
			} else {
				throw new \Exception('Layout ruqire valid name and tepmplate', 500);
			}
		}//append()
		
		private function _include_template($file){
			if($this->viewDir == NULL) {
				$this->setViewDirectory($this->viewPath);
			}
			
			$___template = $this->viewDir	.	str_replace('.', DIRECTORY_SEPARATOR, $file)	.	$this->ext;
			
			if(file_exists($___template) && is_readable($___template)) {
				if($this->securty_mode) {
					extract($this->data);
					extract($this->layout_data);
					/*
						$arr = get_class_vars(__CLASS__)
						unset(); ...
					*/
					ob_start();
					include_once($___template);
					$output = ob_get_contents();
					ob_end_clean();
					return $output;
				} else {
					ob_start();
					include_once($___template);
					return ob_get_clean();
				}
			} else {
				throw new \Exception('View ' . $file . ' cannot be included', 500);
			}
		}//_include_template()
		
		public function render($name, $data = array(), $returnAsString = false) {
			if(is_array($data) && count($data)) $this->data = array_merge($this->data, $data);
			
			if(count($this->layout_parts) > 0) {
				foreach($this->layout_parts as $template_name => $template_path) {
					$recurce = $this->_include_template($template_path);
					if($recurce) {
						$this->setLayoutData($template_name, $template_path);
					}
				}
			}
			
			if($returnAsString) {
				return  $this->_include_template($name);
			} else {
				echo $this->_include_template($name);
			}
		}//render()
		
		
		
		public static function getInstance() {
			if(self::$_instance == NULL) {
				self::$_instance = new self();
			}
			
			return self::$_instance;
		}//getInstance()
	}//View