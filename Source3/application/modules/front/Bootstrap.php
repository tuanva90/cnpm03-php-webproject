<?php
class Front_Bootstrap extends Zend_Application_Module_Bootstrap {
	
	protected function _initView() {
		$view = new Zend_View ();
		/** Set view encoding to UTF-8 */
		$view->setEncoding ( 'UTF-8' );
		$view->doctype ( 'XHTML1_STRICT' );
	}
}
