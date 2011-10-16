<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */

class Honey_View_Helper_CmsTranslator extends Zend_View_Helper_Abstract {
	
	public function __construct() {
	
	}
	
	private static function _getLang() {
		$config = Honey_Config::getConfig ();
		$lang = $config->web->language->code;
		
		/**
		 * In the front-end section, loads the language based on the route URL
		 * @since 2.0.8
		 */
		if ('false' == $config->localization->enable || (Zend_Layout::getMvcInstance () != null && 'admin' == Zend_Layout::getMvcInstance ()->getLayout ())) {
			return $lang;
		} else {
			return Zend_Controller_Front::getInstance ()->getRequest ()->getParam ( 'lang', $lang );
		}
	}
	
	/**
	 * @param string $key Key to translate
	 * @param string $module Name of module. If this is not specified, 
	 * it will take the current module
	 * @return string
	 */
	public function cmsTranslator($key = null, $module = null, $controller = null) {
		/*
		if (null == $key && null == $module && null == $controller) {
			return $this;
		}
		*/
		/**
		 * Get current null
		 */
		if (null == $key) {
			return $this;
		}
		
		/**
		 * Get current module
		 */
		if (null == $module) {
			$module = Zend_Controller_Front::getInstance ()->getRequest ()->getModuleName ();
		}
		
		/**
		 * Get current module
		 */
		if (null == $controller) {
			$controller = Zend_Controller_Front::getInstance ()->getRequest ()->getControllerName ();
		}
		
		/**
		 * Get current language
		 */
		$lang = self::_getLang ();
		
		/**
		 * If we want to use the file in languages directory
		 */
		
		$global_file = APPLICATION_PATH . DS . 'modules' . DS . $module . DS . 'languages' . DS . $lang . DS . 'lang.' . $lang . '.ini';
		if (file_exists ( $global_file ) && file_get_contents ( $global_file ) != '') {
			$translate = new Zend_Translate ( 'Ini', $global_file, $lang );
			if ($translate->_ ( $key ) != $key) {
				return $translate->_ ( $key );
			} else {
				$file = APPLICATION_PATH . DS . 'modules' . DS . $module . DS . 'languages' . DS . $lang . DS . $controller . '.ini';
				if (file_exists ( $file ) && file_get_contents ( $file ) != '') {
					$translate = new Zend_Translate ( 'Ini', $file, $lang );
					if ($translate->_ ( $key ) != $key)
						return $translate->_ ( $key );
				}
			}
		}
		
		return $key;
	}

}
