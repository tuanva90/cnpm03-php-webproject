<?php
class Block_BlkFrontMenu extends Zend_View_Helper_Abstract{

	public function blkFrontMenu (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkFrontMenu' . DS . 'default.php');
	}
}