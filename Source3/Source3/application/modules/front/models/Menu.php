<?php
class Front_Model_Menu extends Honey_Db_Table {
	
	public function init(){
		$this->setName('menu');
		$this->setPrimary('menu_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		
		$select = $db->select ('DISTINCT COUNT(*) AS totalItem')
					 ->from ( $this->getPrefix() . 'menu AS m')
					 ->joinLeft ($this->getPrefix() . 'menu_description AS md', 'md.menu_id = m.menu_id');
		
		$select->where ( 'md.language = ?', $this->_lang );
		
		$result = $db->fetchOne ( $select );		
		
		return $result;
	
	}
	
	public function listItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		
		if ($options['task'] == 'list') {
			
			if (!empty($arrParam['parent_id'])) {
				$parent_id = (int)$arrParam['parent_id'];
			} else {
				$parent_id = 0;
			}
			
			$select = $db->select()
	  				  ->from(array('m' => $this->getPrefix() . 'menu'))
	  				  ->joinLeft(array('md' => $this->getPrefix() . 'menu_description'), 'm.menu_id = md.menu_id')
	  				  ->where('md.language = ?', $this->_lang)
	  				  ->where('m.parent_id = ?', $parent_id)
	  				  ->where('m.status = ?', 1)
	  				  ->where('m.sort_order <> ?', -1)
	  				  ->order('m.sort_order');
	  		$result =  $db->fetchAll($select);
	  		return $result;
		}
		
	}
	
	protected function getPath($menu_id) {
		$db = Zend_Registry::get ('connectDB');
		
		$select = "SELECT name, parent_id FROM " . $this->getPrefix() . "menu m LEFT JOIN " . $this->getPrefix() . "menu_description md ON (m.menu_id = md.menu_id) WHERE m.menu_id = '" . (int)$menu_id . "' AND md.language = '" . mysql_escape_string($this->_lang) . "' ORDER BY m.sort_order, md.name ASC";
							 
		$menu_info = $db->fetchRow($select);
		
		if ($menu_info['parent_id']) {
			return $this->getPath($menu_info['parent_id']) . ' > ' . $menu_info['name'];
		} else {
			return $menu_info['name'];
		}
	}
	
	public function getCategoriesByParentId($menu_id) {		
		$db = Zend_Registry::get ('connectDB');
		$menu_data = array();
		
		$select = "SELECT menu_id FROM " . $this->getPrefix() . "menu WHERE parent_id = '" . (int)$menu_id . "'";
		
		foreach ($db->fetchAll($select) as $menu) {
			$menu_data[] = $menu['menu_id'];
			
			$children = $this->getCategoriesByParentId($menu['menu_id']);
			
			if ($children) {
				$menu_data = array_merge($children, $menu_data);
			}			
		}
		
		return $menu_data;
	}
	
	public function saveItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		$view = new Honey_View_Helper_CmsSeoStr();
		if ($options ['task'] == 'add') {
			$data_c = array(
		        'image'			=> $arrParam ['image'],
		        'parent_id'    	=> $arrParam ['parent_id'],
		        'sort_order'  	=> $arrParam ['sort_order'],
				'date_added'	=> date ( "Y-m-d H:i:s" ),
		        'date_modified' => date ( "Y-m-d H:i:s" ),
		        'status'  		=> $arrParam ['status']
		    );  
			$db->insert($this->getPrefix() . 'menu', $data_c);
			
			$menu_id = $db->lastInsertId();
			
			foreach ($arrParam['menu_description'] as $language => $value) {
				
				$data_md = array(
			        'menu_id'		=> $menu_id,
			        'language'    		=> $language,
			        'name'  			=> $value ['name'],
					'slug'  			=> $view->CmsSeoStr($value ['name']),
					'meta_keywords' 	=> $value ['meta_keywords'],
			        'meta_description'  => $value ['meta_description'],
			        'description'  		=> $value ['description'],
		        );  
				$db->insert($this->getPrefix() . 'menu_description', $data_md);
			
			}
		}
		
		if ($options ['task'] == 'edit') {						
			$where = 'menu_id = ' . $arrParam ['menu_id'];
			$data_c = array(
		        'image'			=> $arrParam ['image'],
		        'parent_id'    	=> $arrParam ['parent_id'],
		        'sort_order'  	=> $arrParam ['sort_order'],
		        'date_modified' => date ( "Y-m-d H:i:s" ),
		        'status'  		=> $arrParam ['status']
		    );   
			$db->update($this->getPrefix() . 'menu', $data_c, $where);
			
			$db->delete($this->getPrefix() . 'menu_description', $where);
			
			foreach ($arrParam['menu_description'] as $language => $value) {
				
				$data_md = array(
			        'menu_id'		=> $arrParam ['menu_id'],
			        'language'    		=> $language,
			        'name'  			=> $value ['name'],
					'slug'  			=> $view->CmsSeoStr($value ['name']),
					'meta_keywords' 	=> $value ['meta_keywords'],
			        'meta_description'  => $value ['meta_description'],
			        'description'  		=> $value ['description'],
		        );  
				$db->insert($this->getPrefix() . 'menu_description', $data_md);
			
			}
			
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$db = Zend_Registry::get ('connectDB');
			$select = $db->select()
						 ->from($this->getPrefix() . 'menu')
						 ->where('menu_id = ?', $arrParam['menu_id']);
			
			$result = $db->fetchRow($select);
			
			$menu_data = array(
				'menu_id'	=> $result['menu_id'],
				'image'			=> $result['image'],
				'parent_id'		=> $result['parent_id'],
				'sort_order'	=> $result['sort_order'],
				'date_added'	=> $result['date_added'],
				'date_modified'	=> $result['date_modified'],
				'status'		=> $result['status'],
				'menu_description' => $this->getmenuDescriptions($result['menu_id'])
			);
			return $menu_data;
		}		
	}
	
	protected function getmenuDescriptions($menu_id) {
		$db = Zend_Registry::get('connectDB');		
		$select = $db->select()
					 ->from($this->getPrefix() . 'menu_description')
					 ->where('menu_id = ?', (int)$menu_id);
			
		$result = $db->fetchAll($select );
		
		$menu_description_data = array();		
		
		foreach ($result as $rs) {
			$menu_description_data[$rs['language']] = array(
				'name'             => $rs['name'],
				'meta_keywords'    => $rs['meta_keywords'],
				'meta_description' => $rs['meta_description'],
				'description'      => $rs['description']
			);
		}
		
		return $menu_description_data;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		
		$db = Zend_Registry::get ( 'connectDB' );
		
		if ($options ['task'] == 'delete' && !empty($arrParam['menu_id'])) {						
			$where = ' menu_id = ' . (int)$arrParam ['menu_id'];
			$db->delete($this->getPrefix() . 'menu', $where);
			$db->delete($this->getPrefix() . 'menu_description', $where);
			
			$select = $db->select('menu_id')
						 ->from($this->getPrefix() . 'menu')
						 ->where('parent_id = ?', (int)$arrParam ['menu_id']);
			
			foreach($db->fetchAll($select) as $result) {
				$this->deleteItem(array('menu_id' => $result['menu_id']),  array('task' => 'delete'));
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
			$where = 'menu_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		if ($arrParam ['menu_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'menu_id = ' . $arrParam ['menu_id'];
			$this->update ( $data, $where );
		}
	
	}
}