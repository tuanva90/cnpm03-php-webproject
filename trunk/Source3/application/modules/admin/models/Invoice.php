<?php
class Admin_Model_Invoice extends Honey_Db_Table{	
	
	public function init(){
		$this->setName('invoice');
		$this->setPrimary('invoice_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');
		$filter = $arrParam['filter'];
		
		$select = $db->select()
					 ->from($this->getPrefix() . 'invoice', array('COUNT(invoice_id) AS totalItem' ));
		
		if (!empty($filter['filter_name'])) {
			$filter_name = '%' . $filter['filter_name'] . '%';
			$select->where ('full_name LIKE ?', $filter_name);
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
						 ->from($this->getPrefix() . 'invoice');
			
			if (!empty($filter['col']) && !empty($filter ['order'])) {
				$select->order($filter['col'] . ' ' . $filter['order']);
			
			}
			
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
			
			if (! empty ( $filter ['filter_name'] )) {
				$filter_name = '%' . $filter ['filter_name'] . '%';
				$select->where('full_name LIKE ?', $filter_name );
			}
			
			$result = $db->fetchAll($select);
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null) {
	
		if ($options ['task'] == 'add') {
			$row = $this->fetchNew ();
			$row->full_name 	= $arrParam['full_name'];
			$row->email 		= $arrParam['email'];
			$row->phone 		= $arrParam['phone'];
			$row->address 		= $arrParam['address'];
			$row->shipping 		= $arrParam['shipping'];
			$row->comment 		= $arrParam['comment'];
			$row->created 		= '';
			$row->status 		= $arrParam['status'];
				
			$row->save ();
		}
	
		if ($options ['task'] == 'edit') {
			$where = 'invoice_id = ' . $arrParam ['invoice_id'];
				
			$row = $this->fetchRow($where);
			$row->full_name 	= $arrParam['full_name'];
			$row->email 		= $arrParam['email'];
			$row->phone 		= $arrParam['phone'];
			$row->address 		= $arrParam['address'];
			$row->shipping 		= $arrParam['shipping'];
			$row->comment 		= $arrParam['comment'];
			$row->created 		= '';
			$row->status 		= $arrParam['status'];
				
			$row->save ();
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
	
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$where = 'invoice_id = ' . (int)$arrParam ['invoice_id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		if ($options ['task'] == 'delete') {
			$where = ' invoice_id = ' . (int)$arrParam ['invoice_id'];
			$this->delete ( $where );
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
				$where = 'invoice_id IN (' . $ids . ')';
				$this->delete ( $where );
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
			$where = 'invoice_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
	
		if ($arrParam ['invoice_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
				
			$data = array ('status' => $status );
			$where = 'invoice_id = ' . (int)$arrParam ['invoice_id'];
			$this->update ( $data, $where );
		}
	}
}