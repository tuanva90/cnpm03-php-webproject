<?php
class Admin_Model_LinkWeb extends Honey_Db_Table {
	
	public function init(){
		$this->setName('link_web');
		$this->setPrimary('link_web_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');
		
		$select = $db->select()
					 ->from($this->getPrefix() . 'link_web', array('COUNT(link_web_id) AS totalItem' ));
		
		$result = $db->fetchOne($select);
		return $result;
	
	}
	
	public function listItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		
		if ($options ['task'] == 'list') {
			$select = $db->select()
						 ->from($this->getPrefix() . 'link_web')
						 ->order('website_name ASC');
			
			$result = $db->fetchAll($select);
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'add') {
			$row = $this->fetchNew ();
			$row->website_name = $arrParam ['website_name'];			
			$row->screen_name = $arrParam ['screen_name'];
			$row->website_url = $arrParam ['website_url'];
			$row->status = (int)$arrParam ['status'];
			
			$row->save ();
		}
		
		if ($options ['task'] == 'edit') {
			$where = 'link_web_id = ' . $arrParam ['link_web_id'];
			
			$row = $this->fetchRow($where);
			
			$row->website_name = $arrParam ['website_name'];			
			$row->screen_name = $arrParam ['screen_name'];
			$row->website_url = $arrParam ['website_url'];
			$row->status = (int)$arrParam ['status'];
			
			$row->save ();
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$where = 'link_web_id = ' . (int)$arrParam ['link_web_id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		if ($options ['task'] == 'delete') {
			$where = ' link_web_id = ' . (int)$arrParam ['link_web_id'];
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
				$where = 'link_web_id IN (' . $ids . ')';
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
			$where = 'link_web_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		
		if ($arrParam ['link_web_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'link_web_id = ' . (int)$arrParam ['link_web_id'];
			$this->update ( $data, $where );
		}
	}
}