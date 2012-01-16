<?php
class Block_BlkImpressiveProduct extends Zend_View_Helper_Abstract{

	public function BlkImpressiveProduct (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		/*
		echo '<pre>';
		print_r($arrParam);
		echo '</pre>';
		*/
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkImpressiveProduct' . DS . 'default.php');
	}
}