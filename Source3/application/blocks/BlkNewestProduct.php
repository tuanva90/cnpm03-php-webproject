<?php
class Block_BlkNewestProduct extends Zend_View_Helper_Abstract{

	public function BlkNewestProduct (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		/*
		echo '<pre>';
		print_r($arrParam);
		echo '</pre>';
		*/
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkNewestProduct' . DS . 'default.php');
	}
}