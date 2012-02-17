<?php
class Block_BlkSearch extends Zend_View_Helper_Abstract{

	public function BlkSearch ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;

		//Setting default values
		
		//Setting module-option
		eval($info['option']);
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkSearch' . DS . 'default.php');
	}
}