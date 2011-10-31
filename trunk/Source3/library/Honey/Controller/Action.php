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
		$this->view->headTitle ( $config ['headTitle'] );
		
		/** 
		 * Set the initial headLink: 
		 * */
		if (! empty ( $config ['headLink'] ) && count ( $config ['headLink'] ) > 0) {
			foreach ( $config ['headLink'] as $key => $value ) {
				$tmp = explode ( "|", $value );
				$this->view->headLink ()->headLink ( array ('rel' => $tmp [0], 'href' => $tmp [1] ) );
			}
		}
		
		/** 
		 * Set the initial meta: 
		 * */
		if (! empty ( $config ['metaHttp'] ) && count ( $config ['metaHttp'] ) > 0) {
			foreach ( $config ['metaHttp'] as $key => $value ) {
				$tmp = explode ( "|", $value );
				$this->view->headMeta ()->appendHttpEquiv ( $tmp [0], $tmp [1] );
			}
		}
		
		if (! empty ( $config ['metaName'] ) && count ( $config ['metaName'] ) > 0) {
			foreach ( $config ['metaName'] as $key => $value ) {
				$tmp = explode ( "|", $value );
				$this->view->headMeta ()->appendName ( $tmp [0], $tmp [1] );
			}
		}
		
		/** 
		 * Set the initial css: 
		 */
		if (! empty ( $config ['headStyle'] ) && count ( $config ['headStyle'] ) > 0) {
			foreach ( $config ['headStyle'] as $key => $css ) {
				$this->view->headLink ()->appendStylesheet ( HTTP_PUBLIC . $css, 'screen' );
			}
		}
		
		/** 
		 * Set the initial javascript: 
		 */
		if (! empty ( $config ['headScript'] ) > 0) {
			foreach ( $config ['headScript'] as $key => $js ) {
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