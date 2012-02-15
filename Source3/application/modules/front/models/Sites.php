<?php
class Front_Model_Sites extends Honey_Db_Table{
	public function init(){
		$this->setName('news');
		$this->setPrimary('news_id');
		parent::init();
	}
	
	public function listItem()
	{
		$db = Zend_Registry::get('connectDB');
		$select = $db->select()
				->from(array('n'=>'cms_sites'));
	
		$result = $db->fetchAll($select);
		return $result;
	}
	
	public function deleteItem($id) {
		$db = Zend_Registry::get ('connectDB');
		$where =  'id= '.$id;
		$db->delete('cms_sites', $where);
	}
	
	public function getDetailedItem($id) {
		
	}
}