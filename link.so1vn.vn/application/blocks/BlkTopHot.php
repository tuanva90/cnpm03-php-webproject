<?php
class Block_BlkTopHot extends Zend_View_Helper_Abstract{

	public function blkTopHot (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		/*
		echo '<pre>';
		print_r($arrParam);
		echo '</pre>';
		*/
		
		$link = new Link_Model_Link();
		
		$hots = $link->getTopHots(array('limit'=>80), null);
		
		require_once (APPLICATION_PATH . DS . DS . 'blocks' . DS . 'BlkTopHot' . DS . 'default.php');
	}
}