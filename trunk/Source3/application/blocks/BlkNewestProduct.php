<?php
class Block_BlkNewestProduct extends Zend_View_Helper_Abstract{

	public function BlkNewestProduct ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		//Setting default value
		$amount_items = 5;
		
		//Declare module-option
		eval($info['option']);
		$product_model = new Front_Model_Product();
		$arrParam['order_mode'] = "date_added DESC";
		$arrParam['paginator'] = array(
			'itemCountPerPage' => $amount_items,
			'currentPage' => 1,
		);
		$items = $product_model->listItem($arrParam,array('task'=>'list'));
		require(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkNewestProduct' . DS . 'default.php');
	}
}