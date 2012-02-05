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
  	
  	public function getItem($id) {
  		$db = Zend_Registry::get('connectDB');
  		$select = $db->select()
  				  ->from('cms_module')
  				  ->where('module_id = ?', $id);
  		
		$result = $db->fetchRow($select);
  		return $result;
  	}
  	
  	public function getItemByName($name) {
  		$db = Zend_Registry::get('connectDB');
  		$select = $db->select()
  				  ->from('cms_module')
  				  ->where('name = ?', $name);
  		
		$result = $db->fetchRow($select);
  		return $result;
  	}
  	
  	public function updateItem($arrParram) {
  		$db = Zend_Registry::get('connectDB');
		$where = 'module_id ='.$arrParram['module_id'];
		$module = array(
		'module_id'		=> $arrParram['module_id'],
		'name'		=> $arrParram['name'],
		'file_name' => $arrParram['file_name'],
		'is_showed'	=> $arrParram['is_showed'],
		'position'	=> $arrParram['position'],
		'sort_order'=> $arrParram['sort_order'],
		'option'	=> $arrParram['option']
		);

		$result = $db->update('cms_module',$module,$where);
		return $result;
  	}
  	
	public static function savePosition($position, $order) {
		$db = Zend_Registry::get('connectDB');
		$modules = new Front_Model_Module();
		$where = null;
		$temp = null;
		$result = null;
		for($i = 0; $i < count($order); $i++) {
			if($order[$i] != "main-content"){
				$temp = $modules->getItem($order[$i]);
				$temp['position'] = $position;
				$temp['sort_order'] = $i;
				$where = 'module_id ='.$temp['module_id'];
				$result = $db->update('cms_module',$temp,$where);
			}
		}
		return $result;
	}
}