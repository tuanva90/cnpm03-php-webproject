<?php
class IndexController extends Honey_Controller_Action {
	
	
	public function init() {
		/* Layout */
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
				
	}
	
	public function indexAction() {	
		

	}

}