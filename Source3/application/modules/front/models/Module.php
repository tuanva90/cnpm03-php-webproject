<?php
class Front_Model_Module extends Honey_Db_Table{	
	
	public function init(){
		$this->setName('module');
		$this->setPrimary('module_id');
		parent::init();
	}
	
	public function listItem($position) {
  		$db = Zend_Registry::get('connectDB');
  		$select = $db->select()
  				  ->from('cms_module')
  				  ->where('position = ?', $position)
  				  ->where('is_showed = ?', 1)
  				  ->order('sort_order ASC');
  		
		$result = $db->fetchAll($select);
  		return $result;
  	}
}