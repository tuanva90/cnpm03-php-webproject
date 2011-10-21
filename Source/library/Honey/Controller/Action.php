<?php
class Honey_Controller_Action extends Zend_Controller_Action {
	
	public function init() {
	
	}
	
	protected function loadTemplate($layout, $layoutPath, $fileConfig = 'template.ini', $sectionConfig = 'template') {
		
		//Set NULL
		$this->view->headTitle ()->set ( '' );
		$this->view->headMeta ()->getContainer ()->exchangeArray ( array () );
		$this->view->headLink ()->getContainer ()->exchangeArray ( array () );
		$this->view->headScript ()->getContainer ()->exchangeArray ( array () );
		
		$module = Zend_Controller_Front::getInstance ()->getRequest ()->getModuleName ();		
		$filename = APPLICATION_PATH . DS . 'modules' . DS . $module . DS . 'configs' . DS . $fileConfig;
		
		$section = $sectionConfig;
		$config = new Zend_Config_Ini ( $filename, $section );
		$config = $config->toArray ();
		
		/** 
		 * Set the initial title: 
		 */
		$this->view->headTitle ( $config ['title'] );
		
		/** 
		 * Set the initial meta: 
		 * */
		if (count ( $config ['metaHttp'] ) > 0) {
			foreach ( $config ['metaHttp'] as $key => $value ) {
				$tmp = explode ( "|", $value );
				$this->view->headMeta ()->appendHttpEquiv ( $tmp [0], $tmp [1] );
			}
		}
		
		if (count ( $config ['metaName'] ) > 0) {
			foreach ( $config ['metaName'] as $key => $value ) {
				$tmp = explode ( "|", $value );
				$this->view->headMeta ()->appendName ( $tmp [0], $tmp [1] );
			}
		}
		
		/** 
		 * Set the initial css: 
		 */
		if (count ( $config ['fileCss'] ) > 0) {
			foreach ( $config ['fileCss'] as $key => $css ) {
				$this->view->headLink ()->appendStylesheet ( HTTP_PUBLIC . $css, 'screen' );
			}
		}
		
		/** 
		 * Set the initial javascript: 
		 */
		if (count ( $config ['fileJs'] ) > 0) {
			foreach ( $config ['fileJs'] as $key => $js ) {
				$this->view->headScript ()->appendFile ( HTTP_PUBLIC . $js, 'text/javascript' );
			}
		}
		
		/**
		 * Set layout
		 */
		$option = array ('layout' => $layout, 'layoutPath' => $layoutPath );
		Zend_Layout::startMvc ( $option );
	
	}

}