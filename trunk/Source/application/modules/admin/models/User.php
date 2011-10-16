<?php
class Admin_Model_User extends Zend_Db_Table {
	protected $_name = 'user';
	protected $_primary = 'user_id';
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ( 'connectDB' );
		$filter = $arrParam ['filter'];
		
		$select = $db->select ()->from ( 'user AS u', array ('COUNT(u.user_id) AS totalItem' ) );
		
		if (! empty ( $filter ['filter_username'] )) {
			$filter_username = '%' . $filter ['filter_username'] . '%';
			$select->where ( 'u.username LIKE ?', $filter_username );
		}
		
		if ($filter ['user_group_id'] > 0) {
			$select->where ( 'u.user_group_id = ?', $filter ['user_group_id'] );
		}
		$result = $db->fetchOne ( $select );
		return $result;
	
	}
	
	public function sortItem($arrParam = null, $options = null) {
		
		$selected = $arrParam ['selected'];
		$order = $arrParam ['order'];
		if (count ( $selected ) > 0) {
			foreach ( $selected as $key => $val ) {
				$where = ' user_id = ' . $val;
				$data = array ('order' => $order [$val] );
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
						 ->from ( 'user AS u', array ('user_id', 'username', 'status', 'email', 'date_added' ) )
						 ->joinLeft ( 'user_group AS ug', 'ug.user_group_id = u.user_group_id', 'name as group' );
			
			if (! empty ( $filter ['col'] ) && ! empty ( $filter ['order'] )) {
				$select->order ( $filter ['col'] . ' ' . $filter ['order'] );
			
			}
			
			if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
			
			if (! empty ( $filter ['filter_username'] )) {
				$filter_username = '%' . $filter ['filter_username'] . '%';
				$select->where ( 'u.username LIKE ?', $filter_username);
			}
			
			if ($filter ['user_group_id'] > 0) {
				$select->where ( 'u.user_group_id = ?', $filter ['user_group_id'] );
			}
			$result = $db->fetchAll ( $select );
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'add') {
			$row = $this->fetchNew ();
			$encode = new Honey_Encode ();
			$row->user_group_id = $arrParam ['user_group_id'];
			$row->username = $arrParam ['username'];
			$row->avatar = $arrParam ['avatar'];
			$row->password = $encode->password ( $arrParam ['password'] );
			$row->firstname = $arrParam ['firstname'];
			$row->lastname = $arrParam ['lastname'];
			$row->birthday = $arrParam ['birthday'];
			$row->email = $arrParam ['email'];
			$row->status = $arrParam ['status'];
			$row->ip = $_SERVER ['REMOTE_ADDR'];
			$row->date_added = date ( "Y-m-d H:i:s" );
			$row->sign = $arrParam ['sign'];
			
			$row->save ();
		}
		
		if ($options ['task'] == 'edit') {
						
			$where = 'user_id = ' . $arrParam ['user_id'];
			
			$row = $this->fetchRow ( $where );
			$encode = new Honey_Encode ();
			$row->user_group_id = $arrParam ['user_group_id'];
			$row->username = $arrParam ['username'];
			$row->avatar = $arrParam ['avatar'];
			if (! empty ( $arrParam ['password'] )) {
				$row->password = $encode->password ( $arrParam ['password'] );
			}
			$row->firstname = $arrParam ['firstname'];
			$row->lastname = $arrParam ['lastname'];
			$row->birthday = $arrParam ['birthday'];
			$row->email = $arrParam ['email'];
			$row->status = $arrParam ['status'];
			$row->ip = $_SERVER ['REMOTE_ADDR'];
			$row->date_added = date ( "Y-m-d H:i:s" );
			$row->sign = $arrParam ['sign'];
			
			$row->save ();
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$db = Zend_Registry::get ( 'connectDB' );
			$select = $db->select ()->from ( 'user as u' )
									->joinLeft ( 'user_group as ug', 'u.user_group_id = ug.user_group_id', array ('name as group' ) )
									->where ( 'u.user_id = ?', $arrParam ['user_id'] );
			
			$result = $db->fetchRow ( $select );
		}
		
		if ($options ['task'] == 'delete') {
			$where = 'user_id = ' . $arrParam ['user_id'];
			$result = $this->fetchRow ( $where )->toArray ();
		}
		return $result;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		if ($options ['task'] == 'delete') {
						
			$where = ' user_id = ' . $arrParam ['user_id'];
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
				$where = 'user_id IN (' . $ids . ')';
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
			$where = 'user_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		if ($arrParam ['user_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'user_id = ' . $arrParam ['user_id'];
			$this->update ( $data, $where );
		}
	
	}
	/**
	 * Check user exist or not
	 * 
	 * @return void
	 */
	public function checkExist($checkFor, $value) {
		$db = Zend_Registry::get ( 'connectDB' );
		
		$select = $db->select ()->from ( 'user', array ('COUNT(user_id) AS totalItem' ) );

		switch ($checkFor) {
			case 'username':
				$select->where ( 'username = ?', $value );
				break;
			case 'email':
				$select->where ( 'email = ?', $value );
				break;
		}	
		$result = $db->fetchOne ( $select );
		
		return ($result == 0) ? false : true;
	
	}
}