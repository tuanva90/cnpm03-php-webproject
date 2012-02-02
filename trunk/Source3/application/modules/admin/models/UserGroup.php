<?php
class Admin_Model_UserGroup extends Honey_Db_Table {
	
	public function init(){
		$this->setName('user_group');
		$this->setPrimary('user_group_id');
		parent::init();
	}
	
	public function itemInSelectbox($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		if ($options == null) {
			$select = $db->select ()->from ( $this->getPrefix() . 'user_group', array ('user_group_id', 'name' ) );
			$result = $db->fetchPairs ( $select );
			$result [0] = ' -- Select an Item -- ';
			ksort ( $result );
		
		}
		return $result;
	}
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		$filter = $arrParam ['filter'];
		
		$select = $db->select ()->from ( $this->getPrefix() . 'user_group AS ug', array ('COUNT(ug.user_group_id) AS totalItem' ) );
		
		if (! empty ( $filter ['filter_name'] )) {
			$filter_name = '%' . $filter ['filter_name'] . '%';
			$select->where ( 'ug.name LIKE ?', $filter_name );
		}
		
		$result = $db->fetchOne ( $select );
		return $result;
	
	}
	
	public function sortItem($arrParam = null, $options = null) {
		
		$selected = $arrParam ['selected'];
		$order = $arrParam ['order'];
		if (count ( $selected ) > 0) {
			foreach ( $selected as $key => $val ) {
				$where = ' user_group_id = ' . $val;
				$data = array ('sort_order' => $order [$val] );
				$this->update ( $data, $where );
			}
		}
	}
	
	public function listItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		
		$paginator = $arrParam ['paginator'];
		$filter = $arrParam ['filter'];
		
		if ($options ['task'] == 'list') {
			$select = $db->select ()
						 ->from ( $this->getPrefix() . 'user_group AS ug', array ('user_group_id', 'name', 'status', 'sort_order' ) )
						 ->joinLeft ( $this->getPrefix() . 'user AS u', 'ug.user_group_id = u.user_group_id', 'COUNT(u.user_id) AS members' )
						 ->group ( 'ug.user_group_id' );
			
			if (! empty ( $filter ['col'] ) && ! empty ( $filter ['order'] )) {
				$select->order ( $filter ['col'] . ' ' . $filter ['order'] );
			
			}
			
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
			
			if (! empty ( $filter ['filter_name'] )) {
				$filter_name = '%' . $filter ['filter_name'] . '%';
				$select->where ( 'ug.name LIKE ?', $filter_name );
			}
			
			$result = $db->fetchAll ( $select );
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'add') {
			$row = $this->fetchNew ();
			$row->name = $arrParam ['name'];
			$row->avatar = $arrParam ['avatar'];
			$row->date_added = date ( "Y-m-d H:i:s" );
			$row->date_modified = date ( "Y-m-d H:i:s" );
			$row->status = $arrParam ['status'];
			$row->sort_order = $arrParam ['sort_order'];
			
			$row->save ();
		}
		
		if ($options ['task'] == 'edit') {
			$where = 'user_group_id = ' . $arrParam ['user_group_id'];
			
			$row = $this->fetchRow ( $where );
			$row->name = $arrParam ['name'];
			$row->avatar = $arrParam ['avatar'];
			$row->date_modified = date ( "Y-m-d H:i:s" );
			$row->status = $arrParam ['status'];
			$row->sort_order = $arrParam ['sort_order'];
			
			$row->save ();
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$where = 'user_group_id = ' . $arrParam ['user_group_id'];
			$result = $this->fetchRow ( $where )->toArray ();
		}
		return $result;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		if ($options ['task'] == 'delete') {
			$where = ' user_group_id = ' . $arrParam ['user_group_id'];
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
				$where = 'user_group_id IN (' . $ids . ')';
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
			$where = 'user_group_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		
		if ($arrParam ['user_group_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'user_group_id = ' . $arrParam ['user_group_id'];
			$this->update ( $data, $where );
		}
	}
}