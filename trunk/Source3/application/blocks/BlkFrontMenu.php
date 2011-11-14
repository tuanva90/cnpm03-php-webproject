<?php
class Block_BlkFrontMenu extends Zend_View_Helper_Abstract{

	public function blkFrontMenu (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		/*
		echo '<pre>';
		print_r($arrParam);
		echo '</pre>';
		*/
		$query = new Front_Model_Category();
		$categories = $query->listItem(array('parent_id' => 0), array('task'=>'list'));
		
		$menu_data = array();
		
		foreach ($categories as $category) {
			if ($category['top']) {
				$children_data = array();
				
				$children = $query->listItem(array('parent_id' => $category['category_id']), array('task'=>'list'));
				
				foreach ($children as $child) {
					/*
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true	
					);
					
					$product_total = $this->model_catalog_product->getTotalProducts($data);
					*/
									
					$children_data[] = array(
						'name'  => $child['name'],
						'href'  => $view->baseUrl('/link/index/index/category/' . $child['category_id'])	
					);					
				}
				
				// Level 1
				$menu_data[] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $view->baseUrl('/link/index/index/category/' . $category['category_id'])
				);
			}
		}
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkFrontMenu' . DS . 'default.php');
	}
}