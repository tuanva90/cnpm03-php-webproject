<?php
class Block_BlkFrontMenu2 extends Zend_View_Helper_Abstract{

	public function blkFrontMenu2 (){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		/*
		echo '<pre>';
		print_r($arrParam);
		echo '</pre>';
		*/
		$query = new Front_Model_Menu();
		$menus = $query->listItem(array('parent_id' => 0), array('task'=>'list'));
		
		$menu_data = array();
		
		foreach ($menus as $menu) {
			if ($menu['top']) {
				$children_data = array();
				
				$children = $query->listItem(array('parent_id' => $menu['menu_id']), array('task'=>'list'));
				
				foreach ($children as $child) {
									
					$children_data[] = array(
						'name'  => $child['name'],
						'href'  => $child['link']	
					);					
				}
				
				// Level 1
				$menu_data[] = array(
					'name'     => $menu['name'],
					'children' => $children_data,
					'column'   => $menu['column'] ? $menu['column'] : 1,
					'href'     => $menu['link']
				);
			}
		}
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkFrontMenu2' . DS . 'default.php');
	}
}