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
 * @version    $Id: Validation.php $
 */

namespace ABPHPF;


/**
 * Validation class.
 *
 * @category   ABPHPF
 * @package    ABPHPF
 * @subpackage 
 * @copyright  Copyright (c) 2011-2013 AB-Labs  (http://ab-labs.info/)
 * @license    
 */

	class Validation {

     /**
     * Validation rules
     *
     * @var array
     */
		private $_rules = array();

     /**
     * Validation erros
     *
     * @var array
     */
		private $_errors = array();
		
		public function setRule($rule, $value, $params = NULL, $name = NULL) {
			$this->_rule[] = array(
				'value' => $value, 
				'rule' => $rule, 
				'param' => $params, 
				'name' => $name
			);
			return $this;
		}//setRule()
		
		public function validate() {
		
		}//validate()
		
		public function getErrors() {
			return $this->_errors;
		}//getErrors()
		
		public function __call($a, $b) {
			throw new \Exception('Invalid validation rule', 500);
		}//__call()
		
		public static function required($val) {
			if(is_array($val) {
				return !empty($val);
			} else {
				return $val != '';
			}
		}//required()

    public static function matches($val1, $val2) {
        return $val1 == $val2;
    }//matches()

    public static function matchesStrict($val1, $val2) {
        return $val1 === $val2;
    }//matchesStrict()

    public static function different($val1, $val2) {
        return $val1 != $val2;
    }//different()

    public static function differentStrict($val1, $val2) {
        return $val1 !== $val2;
    }//differentStrict()

    public static function minlength($val1, $val2) {
        return (mb_strlen($val1) >= $val2);
    }

    public static function maxlength($val1, $val2) {
        return (mb_strlen($val1) <= $val2);
    }//maxlength()

    public static function exactlength($val1, $val2) {
        return (mb_strlen($val1) == $val2);
    }//exactlength()

    public static function gt($val1, $val2) {
        return ($val1 > $val2);
    }//gt()

    public static function lt($val1, $val2) {
        return ($val1 < $val2);
    }//lt()

    public static function alpha($val1) {
        return (bool) preg_match('/^([a-z])+$/i', $val1);
    }//alpha()

    public static function alphanum($val1) {
        return (bool) preg_match('/^([a-z0-9])+$/i', $val1);
    }//alphanum()

    public static function alphanumdash($val1) {
        return (bool) preg_match('/^([-a-z0-9_-])+$/i', $val1);
    }//alphanumdash()

    public static function numeric($val1) {
        return is_numeric($val1);
    }//numeric()

    public static function email($val1) {
        return filter_var($val1, FILTER_VALIDATE_EMAIL) !== false;
    }//email()

    public static function emails($val1) {
			if (is_array($val1)) {
				foreach ($val1 as $v) {
					if (!self::email($val1)) {
						return false;
					}
				}
			} else {
				return false;
			}
			return true;
    }//emails()

    public static function url($val1) {
        return filter_var($val1, FILTER_VALIDATE_URL) !== false;
    }//url()

    public static function ip($val1) {
        return filter_var($val1, FILTER_VALIDATE_IP) !== false;
    }//ip()

    public static function regexp($val1, $val2) {
        return (bool) preg_match($val2, $val1);
    }//regexp()

    public static function custom($val1, $val2) {
        if ($val2 instanceof \Closure) {
            return (boolean) call_user_func($val2, $val1);
        } else {
            throw new \Exception('Invalid validation function', 500);
        }
    }//custom()
	
	}//Validation