<?php
class Block_BlkSharing extends Zend_View_Helper_Abstract{

	public function blkSharing (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		/*
		echo '<pre>';
		print_r($arrParam);
		echo '</pre>';
		*/
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkSharing' . DS . 'default.php');
	}
}