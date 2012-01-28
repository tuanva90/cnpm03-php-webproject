<?php
class Block_BlkLogin extends Zend_View_Helper_Abstract{

	public function BlkLogin ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		//Setting default value
		$use_forgot_password_link = 0;
		$use_keep_signed_in = 0;		
		
		//Setting module-option
		eval($info['option']);
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkLogin' . DS . 'default.php');
	}
}