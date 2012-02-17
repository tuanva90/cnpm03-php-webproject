<?php
class Block_BlkImpressiveProduct extends Zend_View_Helper_Abstract{

	public function BlkImpressiveProduct ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		//Setting default value
		$amount_items = 5;		
		//Declare module-option
		eval($info['option']);
		$product_model = new Front_Model_Product();
		$arrParam['order_mode'] = "viewed DESC";
		$arrParam['paginator'] = array(
			'itemCountPerPage' => $amount_items,
			'currentPage' => 1,
		);
		$items = $product_model->listItem($arrParam,array('task'=>'list'));
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkImpressiveProduct' . DS . 'default.php');
	}
}