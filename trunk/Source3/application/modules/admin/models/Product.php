<?php
class Admin_Model_Product extends Honey_Db_Table {
	
	public function init(){
		$this->setName('product');
		$this->setPrimary('product_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		
		$select = $db->select ('DISTINCT COUNT(*) AS totalItem')
					 ->from ( $this->getPrefix() . 'product AS p')
					 ->joinLeft ($this->getPrefix() . 'product_description AS pd', 'pd.product_id = p.product_id')
					 ->where ( 'pd.language = ?', $this->_lang );
				
		$result = $db->fetchOne ( $select );		
		
		return $result;
	
	}
	
	public function listItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		
		$paginator = $arrParam ['paginator'];
		
		if ($options['task'] == 'list') {
			
			$select = $db->select()
					 ->from ( $this->getPrefix() . 'product AS p')
					 ->joinLeft ($this->getPrefix() . 'product_description AS pd', 'pd.product_id = p.product_id')
					 ->where ('pd.language = ?', $this->_lang );

			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
			
			$result = $db->fetchAll($select);
		}
		return $result;
		
	}
	
	public function saveItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		if ($options ['task'] == 'add') {
			$data_p = array(
		        'quantity'		=> (int)$arrParam ['quantity'],
		        'image'    		=> $arrParam ['image'],
				'price'    		=> (float)$arrParam ['price'],
		        'sort_order'  	=> $arrParam ['sort_order'],
				'date_added'	=> date ("Y-m-d"),
		        'date_modified' => date ("Y-m-d"),
		        'status'  		=> (int)$arrParam ['status']
		    );  
			$db->insert($this->getPrefix() . 'product', $data_p);
			
			$product_id = $db->lastInsertId();
			
			foreach ($arrParam['product_description'] as $language => $value) {
				
				$data_pd = array(
			        'product_id'		=> (int)$product_id,
			        'language'    		=> $language,
			        'name'  			=> $value ['name'],
					'meta_keywords' 	=> $value ['meta_keywords'],
			        'meta_description'  => $value ['meta_description'],
			        'description'  		=> $value ['description'],
		        );  
				$db->insert($this->getPrefix() . 'product_description', $data_pd);
			
			}
		}
		
		if ($options ['task'] == 'edit') {						
			$where = 'product_id = ' . $arrParam ['product_id'];
			$data_p = array(
		        'quantity'		=> (int)$arrParam ['quantity'],
		        'image'    		=> $arrParam ['image'],
				'price'    		=> (float)$arrParam ['price'],
		        'sort_order'  	=> $arrParam ['sort_order'],
		        'date_modified' => date ("Y-m-d"),
		        'status'  		=> (int)$arrParam ['status']
		    );  
			$db->update($this->getPrefix() . 'product', $data_p, $where);
			
			$db->delete($this->getPrefix() . 'product_description', $where);
			
			foreach ($arrParam['product_description'] as $language => $value) {
				
				$data_pd = array(
			        'product_id'		=> $arrParam ['product_id'],
			        'language'    		=> $language,
			        'name'  			=> $value ['name'],
					'meta_keywords' 	=> $value ['meta_keywords'],
			        'meta_description'  => $value ['meta_description'],
			        'description'  		=> $value ['description'],
		        );  
				$db->insert($this->getPrefix() . 'product_description', $data_pd);
			
			}
			
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$db = Zend_Registry::get ('connectDB');
			$select = $db->select()
						 ->from($this->getPrefix() . 'product')
						 ->where('product_id = ?', (int)$arrParam['product_id']);
			
			$result = $db->fetchRow($select);
			
			$product_data = array(
				'product_id'	=> $result['product_id'],
				'quantity'		=> $result['quantity'],
				'image'			=> $result['image'],
				'price'			=> $result['price'],
				'sort_order'	=> $result['sort_order'],
				'date_added'	=> $result['date_added'],
				'date_modified'	=> $result['date_modified'],
				'status'		=> $result['status'],
				'product_description' => $this->getProductDescriptions($result['product_id'])
			);
			return $product_data;
		}		
	}
	
	protected function getProductDescriptions($product_id) {
		$db = Zend_Registry::get('connectDB');		
		$select = $db->select()
					 ->from($this->getPrefix() . 'product_description')
					 ->where('product_id = ?', (int)$product_id);
			
		$result = $db->fetchAll($select );
		
		$product_description_data = array();		
		
		foreach ($result as $rs) {
			$product_description_data[$rs['language']] = array(
				'name'             => $rs['name'],
				'meta_keywords'    => $rs['meta_keywords'],
				'meta_description' => $rs['meta_description'],
				'description'      => $rs['description']
			);
		}
		
		return $product_description_data;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		
		$db = Zend_Registry::get('connectDB');
		
		if ($options ['task'] == 'delete' && !empty($arrParam['product_id'])) {						
			$where = ' product_id = ' . (int)$arrParam ['product_id'];
			$db->delete($this->getPrefix() . 'product', $where);
			$db->delete($this->getPrefix() . 'product_description', $where);	
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
			$where = 'product_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		
		if ($arrParam ['product_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'product_id = ' . (int)$arrParam ['product_id'];
			$this->update ( $data, $where );
		}
	}
}