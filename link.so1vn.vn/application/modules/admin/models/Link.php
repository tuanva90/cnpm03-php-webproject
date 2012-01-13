<?php
class Admin_Model_Link extends Honey_Db_Table {
	
	public function init(){
		$this->setName('link');
		$this->setPrimary('link_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');
		$filter = $arrParam['filter'];
		
		$select = $db->select()
					 ->from($this->getPrefix() . 'link', array('COUNT(link_id) AS totalItem' ));
		
		if (!empty($filter['filter_title'])) {
			$filter_title = '%' . $filter['filter_title'] . '%';
			$select->where ('title LIKE ?', $filter_title);
		}
		
		$result = $db->fetchOne($select);
		return $result;
	
	}
	
	public function listItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		
		$paginator = $arrParam ['paginator'];
		$filter = $arrParam ['filter'];
		
		if ($options ['task'] == 'list') {
			$select = $db->select()
						 ->from($this->getPrefix() . 'link AS l')
						 ->joinLeft($this->getPrefix() . 'link_web AS lw', 'l.link_web_id = lw.link_web_id', 'lw.website_name AS website_name');
			
			if (!empty($filter['col']) && !empty($filter ['order'])) {
				$select->order($filter['col'] . ' ' . $filter['order']);
			
			}
			
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
			
			if (! empty ( $filter ['filter_title'] )) {
				$filter_title = '%' . $filter ['filter_title'] . '%';
				$select->where('title LIKE ?', $filter_title );
			}
			
			$result = $db->fetchAll($select);
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		$view = new Honey_View_Helper_CmsSeoStr();
		
		if ($options ['task'] == 'add') {
			
			if($arrParam['slug']) $arrParam['slug'] = $view->CmsSeoStr($arrParam ['slug']);
			else $arrParam['slug'] = $view->CmsSeoStr($arrParam['title']);
			
			$data = array(
		        'title'			=> $arrParam ['title'],
		        'slug'    		=> $arrParam ['slug'],
		        'description'  	=> $arrParam ['description'],
				'method'  		=> 'post',
				'image'  		=> $arrParam ['image'],
				'link_source'  	=> $arrParam ['link_source'],
				'link_web_id'  	=> (int)$arrParam ['link_web_id'],
				'date_added'	=> date ( "Y-m-d H:i:s" ),
		        'status'  		=> (int)$arrParam ['status']
		    );
			$db->insert($this->getPrefix() . 'link', $data);
			$link_id = $db->lastInsertId();
			
			/*
			 * add link_to_category
			 */
			$db->delete($this->getPrefix() . 'link_to_category', 'link_id = ' . $link_id);
			
			foreach($arrParam['link_category'] as $category_id){
				$db->insert($this->getPrefix() . 'link_to_category', array('link_id' => $link_id, 'category_id' => $category_id));
			}
		}
		
		if ($options ['task'] == 'edit') {
			$where = 'link_id = ' . (int)$arrParam ['link_id'];
			
			$data = array(
		        'title'			=> $arrParam ['title'],
		        'slug'    		=> $arrParam ['slug'],
		        'description'  	=> $arrParam ['description'],
				'method'  		=> 'post',
				'image'  		=> $arrParam ['image'],
				'link_source'  	=> $arrParam ['link_source'],
				'link_web_id'  	=> (int)$arrParam ['link_web_id'],
				'date_added'	=> date ( "Y-m-d H:i:s" ),
		        'status'  		=> (int)$arrParam ['status']
		    );
		    $db->update($this->getPrefix() . 'link', $data, $where);
			$link_id = (int)$arrParam ['link_id'];
			
			/*
			 * add link_to_category
			 */
			$db->delete($this->getPrefix() . 'link_to_category', 'link_id = ' . $link_id);
			
			foreach($arrParam['link_category'] as $category_id){
				$db->insert($this->getPrefix() . 'link_to_category', array('link_id' => $link_id, 'category_id' => $category_id));
			}
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$where = 'link_id = ' . (int)$arrParam ['link_id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
	}
	
	public function getCategoriesToLinkId($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$select = $db->select()
					 	 ->from($this->getPrefix() . 'link_to_category')
					 	 ->where ('link_id = ?', (int)$arrParam ['link_id']);
		}
		$result = $db->fetchAll($select);
		$data = array();
		foreach($result as $rs){
			$data[] = $rs['category_id'];
		}
		return $data;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		if ($options ['task'] == 'delete') {
			$db->delete($this->getPrefix() . 'link', 'link_id = ' . (int)$arrParam ['link_id']);
			$db->delete($this->getPrefix() . 'link_to_category', 'link_id = ' . (int)$arrParam ['link_id']);
		}
		
		if ($options ['task'] == 'multi-delete') {
			$selected = $arrParam ['selected'];
			
			if (count ( $selected ) > 0) {
				if ($arrParam ['type'] == 1) {
					$status = 1;
				} else {
					$status = 0;
				}
				
				$ids = implode ( ',', $selected );
				$where = 'link_id IN (' . $ids . ')';
				
				$db->delete($this->getPrefix() . 'link', $where);
				$db->delete($this->getPrefix() . 'link_to_category', $where);
			}
		}
	}
	
	public function changeStatus($arrParam = null, $options = null) {
		$selected = $arrParam ['selected'];
		
		if (count ( $selected ) > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$ids = implode ( ',', $selected );
			$data = array ('status' => $status );
			$where = 'link_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		
		if ($arrParam ['link_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'link_id = ' . (int)$arrParam ['link_id'];
			$this->update ( $data, $where );
		}
	}
}