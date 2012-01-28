<?php
class Block_BlkNewestProduct extends Zend_View_Helper_Abstract{

	public function BlkNewestProduct ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		//Setting default value
		$amount_items = 5;
		
		//Declare module-option
		eval($info['option']);
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkNewestProduct' . DS . 'default.php');
	}
}