<?php
class Block_BlkHelloWorld extends Zend_View_Helper_Abstract{

	public function BlkHelloWorld ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;

		//Setting default values
		
		//Setting module-option
		eval($info['option']);
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkHelloWorld' . DS . 'default.php');
	}
}