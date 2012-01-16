<?php
class Block_BlkLogin extends Zend_View_Helper_Abstract{

	public function BlkLogin (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkLogin' . DS . 'default.php');
	}
}