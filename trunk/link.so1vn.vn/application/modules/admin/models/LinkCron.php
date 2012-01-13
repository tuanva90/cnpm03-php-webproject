<?php
class Admin_Model_LinkCron extends Honey_Db_Table {
	
	public function init(){
		$this->setName('link_cron');
		$this->setPrimary('link_cron_id');
		parent::init();
	}
	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');
		$filter = $arrParam['filter'];
		
		$select = $db->select()
					 ->from($this->getPrefix() . 'link_cron', array('COUNT(link_cron_id) AS totalItem' ));
		
		if (!empty($filter['filter_name'])) {
			$filter_name = '%' . $filter['filter_name'] . '%';
			$select->where ('name LIKE ?', $filter_name);
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
						 ->from($this->getPrefix() . 'link_cron AS lc', array('lc.link_cron_id', 'lc.name', 'lc.source', 'lc.frequency', 'lc.priority', 'lc.status AS status', 'lc.last_update'))
						 ->joinLeft($this->getPrefix() . 'link_web AS lw', 'lc.link_web_id = lw.link_web_id', 'lw.website_name AS website_name');
			
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
				$select->where('name LIKE ?', $filter_name );
			}
			
			$result = $db->fetchAll($select);
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'add') {
			$row = $this->fetchNew ();
			$row->name = $arrParam ['name'];
						
			$categoryIds = array_unique($arrParam ['link_category']);
			$categoryIds = implode('-', $categoryIds);		
			$row->category_ids = $categoryIds;
			
			$row->source = $arrParam ['source'];
			$row->link_web_id = (int)$arrParam ['link_web_id'];
			$row->frequency = (int)$arrParam ['frequency'];
			$row->priority = (int)$arrParam ['priority'];
			$row->status = (int)$arrParam ['status'];
			$row->last_update = date ( "Y-m-d H:i:s" );
			$row->date_added = date ( "Y-m-d H:i:s" );
			$row->date_modified = date ( "Y-m-d H:i:s" );
			
			$row->save ();
		}
		
		if ($options ['task'] == 'edit') {
			$where = 'link_cron_id = ' . $arrParam ['link_cron_id'];
			
			$row = $this->fetchRow($where);
			$row->name = $arrParam ['name'];
						
			$categoryIds = array_unique($arrParam ['link_category']);
			$categoryIds = implode('-', $categoryIds);		
			$row->category_ids = $categoryIds;
			
			$row->source = $arrParam ['source'];
			$row->link_web_id = (int)$arrParam ['link_web_id'];
			$row->frequency = (int)$arrParam ['frequency'];
			$row->priority = (int)$arrParam ['priority'];
			$row->status = (int)$arrParam ['status'];
			$row->date_modified = date ( "Y-m-d H:i:s" );
			
			$row->save ();
		}
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		
		if ($options ['task'] == 'info' || $options ['task'] == 'edit') {
			$where = 'link_cron_id = ' . (int)$arrParam ['link_cron_id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		if ($options ['task'] == 'delete') {
			$where = ' link_cron_id = ' . (int)$arrParam ['link_cron_id'];
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
				$where = 'link_cron_id IN (' . $ids . ')';
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
			$where = 'link_cron_id IN (' . $ids . ')';
			$this->update ( $data, $where );
		}
		
		if ($arrParam ['link_cron_id'] > 0) {
			if ($arrParam ['type'] == 1) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			$data = array ('status' => $status );
			$where = 'link_cron_id = ' . (int)$arrParam ['link_cron_id'];
			$this->update ( $data, $where );
		}
	}
}