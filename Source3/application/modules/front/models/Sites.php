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
		$db->delete('cms_sites_module', 'site_id='.$id);
		$db->delete('cms_sites', 'id='.$id);
	}
	
	public function getItem($id) {
		$db = Zend_Registry::get('connectDB');
  		$select = $db->select()
  				  ->from('cms_sites')
  				  ->where('id = ?', $id);
  		
		$result = $db->fetchRow($select);
  		return $result;
	}
	
	public function getItemByName($name) {
		$db = Zend_Registry::get('connectDB');
  		$select = $db->select()
  				  ->from('cms_sites')
  				  ->where('name = ?', $name);
  		
		$result = $db->fetchRow($select);
  		return $result;
	}
	
	public function newSite($name, $content, $order) {
		$db = Zend_Registry::get ('connectDB');
		$site = array('name' => $name, 'content' => $content);
		$db->insert('cms_sites', $site);
		$id = $db->lastInsertID();
		$this->saveModulePosition($id, $order);
	}
	
	public function editSite($id, $name, $content, $order) {
		$db = Zend_Registry::get ('connectDB');
		$site = array('id'=> $id, 'name' => $name, 'content' => $content);
		$where = "id=".$id;
		$db->update('cms_sites', $site, $where);
		$this->saveModulePosition($id, $order);
	}
	
	public function saveModulePosition($id, $order) {
		$db = Zend_Registry::get ('connectDB');
		$data = null;
		
		//Delete the modules not in $order list
		$where = $db->quoteInto('site_id=?', $id) . ' AND ' .
				 $db->quoteInto('module_id NOT IN (?)', $order);
		$result = $db->delete('cms_sites_module', $where);
		
		//Insert and update the modules in $order list
		$sql = "INSERT INTO cms_sites_module(site_id, module_id, sort_order) VALUES (?, ?, ?)
				ON DUPLICATE KEY UPDATE sort_order = ?";
		for($i = 0; $i < count($order); $i++) {
			$data[$i] = array($id, $order[$i], $i, $i);
			$result = $db->query($sql, $data[$i]);
		}
	}
}