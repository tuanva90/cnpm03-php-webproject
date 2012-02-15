<?php
class Block_BlkMostViewed extends Zend_View_Helper_Abstract{

	public function BlkMostViewed ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		//Setting default value
		$amount_items = 5;
		
		//Declare module-option
		eval($info['option']);
		
		$news_model = new Front_Model_News();
		$arrParam['order_mode'] = "viewed DESC";
		$arrParam['paginator'] = array(
			'itemCountPerPage' => $amount_items,
			'currentPage' => 1,
		);
		$items = $news_model->listItem($arrParam,array('task'=>'list'));
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkMostViewed' . DS . 'default.php');
	}
}