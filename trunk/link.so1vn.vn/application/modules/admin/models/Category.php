<?php
class Admin_Model_Category extends Honey_Db_Table {
	
	public function init(){
		$this->setName('category');
		$this->setPrimary('category_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		
		$select = $db->select ('DISTINCT COUNT(*) AS totalItem')
					 ->from ( $this->getPrefix() . 'category AS c')
					 ->joinLeft ($this->getPrefix() . 'category_description AS cd', 'cd.category_id = c.category_id');
		
		$select->where ( 'cd.language = ?', $this->_lang );
		
		$result = $db->fetchOne ( $select );		
		
		return $result;
	
	}
	
	public function listItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		
		if ($options['task'] == 'list') {
			
			if (!empty($arrParam['parent_id'])) {
				$parent_id = $arrParam['parent_id'];
			} else {
				$parent_id = 0;
			}
			
			$category_data = array();
			
			$select = "SELECT * FROM " . $this->getPrefix() . "category c LEFT JOIN " . $this->getPrefix() . 
						"category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . 
						"' AND cd.language = '" . mysql_escape_string($this->_lang) . 
						"' ORDER BY c.sort_order, cd.name ASC";
						
			foreach ($db->fetchAll($select) as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPath($result['category_id']),
					'slug'  	  => $result['slug'],
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order'],
					'date_added'  => $result['date_added']
				);
			
				$category_data = array_merge(
						$category_data, 
						$this->listItem(array('parent_id'=>$result['category_id']), array('task' => 'list'))
				);
			}
			
			return $category_data;
		}
		
	}
	
	protected function getPath($category_id) {
		$db = Zend_Registry::get ('connectDB');
		
		$select = "SELECT name, parent_id FROM " . $this->getPrefix() . "category c LEFT JOIN " . $this->getPrefix() . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language = '" . mysql_escape_string($this->_lang) . "' ORDER BY c.sort_order, cd.name ASC";
							 
		$category_info = $db->fetchRow($select);
		
		if ($category_info['parent_id']) {
			return $this->getPath($category_info['parent_id']) . ' > ' . $category_info['name'];
		} else {
			return $category_info['name'];
		}
	}
	
	public function saveItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		$view = new Honey_View_Helper_CmsSeoStr();
		if ($options ['task'] == 'add') {
			$data_c = array(
		        'image'			=> $arrParam ['image'],
		        'parent_id'    	=> (int)$arrParam ['parent_id'],
				'top'    		=> (int)$arrParam ['top'],
				'column'    	=> (int)$arrParam ['column'],
		        'sort_order'  	=> $arrParam ['sort_order'],
				'date_added'	=> date ( "Y-m-d H:i:s" ),
		        'date_modified' => date ( "Y-m-d H:i:s" ),
		        'status'  		=> (int)$arrParam ['status']
		    );  
			$db->insert($this->getPrefix() . 'category', $data_c);
			
			$category_id = $db->lastInsertId();
			
			foreach ($arrParam['category_description'] as $language => $value) {
				
				$data_cd = array(
			        'category_id'		=> (int)$category_id,
			        'language'    		=> $language,
			        'name'  			=> $value ['name'],
					'slug'  			=> $view->CmsSeoStr($value ['name']),
					'meta_keywords' 	=> $value ['meta_keywords'],
			        'meta_description'  => $value ['meta_description'],
			        'description'  		=> $value ['description'],
		        );  
				$db->insert($this->getPrefix() . 'category_description', $data_cd);
			
			}
		}
		
		if ($options ['task'] == 'edit') {						
			$where = 'category_id = ' . $arrParam ['category_id'];
			$data_c = array(
		        'image'			=> $arrParam ['image'],
		        'parent_id'    	=> (int)$arrParam ['parent_id'],
				'top'    		=> (int)$arrParam ['top'],
				'column'    	=> (int)$arrParam ['column'],
		        'sort_order'  	=> $arrParam ['sort_order'],
		        'date_modified' => date ( "Y-m-d H:i:s" ),
		        'status'  		=> (int)$arrParam ['status']
		    );   
			$db->update($this->getPrefix() . 'category', $data_c, $where);
			
			$db->delete($this->getPrefix() . 'category_description', $where);
			
			foreach ($arrParam['category_description'] as $language => $value) {
				
				$data_cd = array(
			        'category_id'		=> (int)$arrParam ['category_id'],
			        'language'    		=> $language,
			        'name'  			=> $value ['name'],
					'slug'  			=> $view->CmsSeoStr($value ['name']),
					'meta_keywords' 	=> $value ['meta_keywords'],
			        'meta_description'  => $value ['meta_description'],
			        'description'  		=> $value ['description'],
		        );  
				$db->insert($this->getPrefix() . 'category_description', $data_cd);
			
			}
			
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$db = Zend_Registry::get ('connectDB');
			$select = $db->select()
						 ->from($this->getPrefix() . 'category')
						 ->where('category_id = ?', (int)$arrParam['category_id']);
			
			$result = $db->fetchRow($select);
			
			$category_data = array(
				'category_id'	=> $result['category_id'],
				'image'			=> $result['image'],
				'parent_id'		=> $result['parent_id'],
				'top'			=> $result['top'],
				'column'		=> $result['column'],
				'sort_order'	=> $result['sort_order'],
				'date_added'	=> $result['date_added'],
				'date_modified'	=> $result['date_modified'],
				'status'		=> $result['status'],
				'category_description' => $this->getCategoryDescriptions($result['category_id'])
			);
			return $category_data;
		}		
	}
	
	protected function getCategoryDescriptions($category_id) {
		$db = Zend_Registry::get('connectDB');		
		$select = $db->select()
					 ->from($this->getPrefix() . 'category_description')
					 ->where('category_id = ?', (int)$category_id);
			
		$result = $db->fetchAll($select );
		
		$category_description_data = array();		
		
		foreach ($result as $rs) {
			$category_description_data[$rs['language']] = array(
				'name'             => $rs['name'],
				'meta_keywords'    => $rs['meta_keywords'],
				'meta_description' => $rs['meta_description'],
				'description'      => $rs['description']
			);
		}
		
		return $category_description_data;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		
		$db = Zend_Registry::get ( 'connectDB' );
		
		if ($options ['task'] == 'delete' && !empty($arrParam['category_id'])) {						
			$where = ' category_id = ' . (int)$arrParam ['category_id'];
			$db->delete($this->getPrefix() . 'category', $where);
			$db->delete($this->getPrefix() . 'category_description', $where);
			
			$select = $db->select('category_id')
						 ->from($this->getPrefix() . 'category')
						 ->where('parent_id = ?', (int)$arrParam ['category_id']);
			
			foreach($db->fetchAll($select) as $result) {
				$this->deleteItem(array('category_id' => $result['category_id']),  array('task' => 'delete'));
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
			$where = 'category_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		if ($arrParam ['category_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'category_id = ' . $arrParam ['category_id'];
			$this->update ( $data, $where );
		}
	
	}
}