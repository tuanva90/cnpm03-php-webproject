<?php
class Admin_Model_Acticle extends Honey_Db_Table {
	
	public function init(){
		/* 
		 * Khai báo bảng dữ liệu chính
		 * Và khai báo khóa chính
		 */
		$this->setName('acticle');
		$this->setPrimary('acticle_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		/*
		 * Lấy kết nối cơ sở dữ liệu
		 */		
		$db = Zend_Registry::get ( 'connectDB' );
		
		/*
		 * Hàm đếm số record
		 */
	
	}
	
	public function listItem($arrParam = null, $options = null) {
		/*
		 * Lấy kết nối cơ sở dữ liệu
		 */		
		$db = Zend_Registry::get ( 'connectDB' );
		
		/*
		 * Hàm lấy dữ liệu từ data và trả vể array
		 */
		
	}
	
	public function saveItem($arrParam = null, $options = null) {
		if ($options ['task'] == 'add') {
			/* 
			 * Hàm lưu dữ liệu khi thêm
			 */
		}
		
		if ($options ['task'] == 'edit') {						
			
			/* 
			 * Hàm lưu dữ liệu khi sửa
			 */
			
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			/*
			 * Lấy dữ liêu (1 record) để show khi xem thông tin hoặc sửa thông tin
			 */
		}
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'delete') {						
			/*
			 * Hàm xóa 1 dữ liệu
			 */
		}
		
		if ($options ['task'] == 'muti-delete') {						
			/*
			 * Hàm xóa nhiều dữ liệu
			 */
		}
	}
	
	public function changeStatus($arrParam = null, $options = null) {
		$selected = $arrParam ['selected'];
		
		if (count ( $selected ) > 0) {
			/*
			 * Hàm thay đổi status của nhiều record
			 */
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$ids = implode ( ',', $selected );
			$data = array ('status' => $status );
			$where = 'acticle_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		if ($arrParam ['acticle_id'] > 0) {
			/*
			 * Hàm thay đổi status của 1 record
			 */
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'acticle_id = ' . $arrParam ['acticle_id'];
			$this->update ( $data, $where );
		}
	
	}
}