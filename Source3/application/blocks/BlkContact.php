<?php
class Block_BlkContact extends Zend_View_Helper_Abstract{

	public function BlkContact ($info){
		//...
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		//Setting module-option
		//eval($info['option']);
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkContact' . DS . 'default.php');
	}
}