<?php
class Front_Model_Menu extends Honey_Db_Table {
	
	public function init(){
		$this->setName('menu');
		$this->setPrimary('id');
		parent::init();
	}
	
	public function listAllItem($parent) {
		if($parent == null) {
			$parent = array();
			$parent['position'] = "...";
			$parent['name'] = "";
			$children = Front_Model_Menu::getChildren(null);
		} else {
			$children = Front_Model_Menu::getChildren($parent['id']);	
		}
		$children_new = array();
		foreach($children as $sub) {
			if($sub['is_inside'] == 1) {
				$sub['link'] = HTTP_SERVER.$sub['link'];
			}
			$sub['position'] = $parent['position'].$parent['name']."/";
			$sub = Front_Model_Menu::makeMenu($sub);
			$children_new[] = $sub;
		}
		
		$parent['children'] = $children_new;
		return $parent;
	}
	
	public function listAllExceptItem($parent, $except) {
		if($parent == null) {
			$parent = array();
			$parent['position'] = "...";
			$parent['name'] = "";
			$children = Front_Model_Menu::getChildren(null);
		} else {
			$children = Front_Model_Menu::getChildren($parent['id']);	
		}
		$children_new = array();
		foreach($children as $sub) {
			if($sub['id'] != $except) {
				if($sub['is_inside'] == 1) {
					$sub['link'] = HTTP_SERVER.$sub['link'];
				}
				$sub['position'] = $parent['position'].$parent['name']."/";
				$sub = Front_Model_Menu::makeMenu($sub);
				$children_new[] = $sub;
			}
		}
		
		$parent['children'] = $children_new;
		return $parent;
	}
	
	public function deleteMenu($id) 
	{
		$db = Zend_Registry::get ('connectDB');
		$where =  'id= '.$id;
		$db->delete('cms_menu', $where);
	}
	
	public static function getDetailedItem($id) {
		$db = Zend_Registry::get('connectDB');
			
		$select = $db->select()
  				  ->from(array('m' => 'cms_menu'))
  				  ->where('m.id = ?', $id);
  		$item =  $db->fetchRow($select);
  		if($item['parent']==null || $item['parent'] == 0) {
  			$item['position'] = ".../";
  		} else {
  			$parent = Front_Model_Menu::getDetailedItem($item['parent']);
  			$item['position'] = $parent['position'].$parent['name']."/";
  		}
  		
  		return $item;
	}
	
	public static function getItem($id) {
		$db = Zend_Registry::get('connectDB');
			
		$select = $db->select()
  				  ->from(array('m' => 'cms_menu'))
  				  ->where('m.id = ?', $id);
  		$result =  $db->fetchRow($select);
  		
  		return $result;
	}
	
	public static function makeMenu($parent) {
	if($parent == null) {
			$parent = array();
			$parent['position'] = "...";
			$parent['name'] = "";
			$children = Front_Model_Menu::getShowedChildren(null);
		} else {
			$children = Front_Model_Menu::getShowedChildren($parent['id']);	
		}
		$children_new = array();
		foreach($children as $sub) {
			if($sub['is_inside'] == 1) {
				$sub['link'] = HTTP_SERVER.$sub['link'];
			}
			$sub['position'] = $parent['position'].$parent['name']."/";
			$sub = Front_Model_Menu::makeMenu($sub);
			$children_new[] = $sub;
		}
		
		$parent['children'] = $children_new;
		return $parent;
	}
	
	public static function getChildren($parent_id) {
		$db = Zend_Registry::get('connectDB');
		
		if($parent_id == null) {
			$select = $db->select()
  				  ->from(array('m' => 'cms_menu'))
  				  ->where('m.parent = 0')
  				  ->order('m.sort_order');
		} else {
			$select = $db->select()
  				  ->from(array('m' => 'cms_menu'))
  				  ->where('m.parent = ?', $parent_id)  			
  				  ->order('m.sort_order');
		}
		
  		$result =  $db->fetchAll($select);
  		return $result;
	}
	
	public static function getShowedChildren($parent_id) {
		$db = Zend_Registry::get('connectDB');
		
		if($parent_id == null) {
			$select = $db->select()
  				  ->from(array('m' => 'cms_menu'))
  				  ->where('m.parent = ?', 0)
  				  ->where('m.is_showed = ?', true)
  				  ->order('m.sort_order');
		} else {
			$select = $db->select()
  				  ->from(array('m' => 'cms_menu'))
  				  ->where('m.parent = ?', $parent_id)
  				  ->where('m.is_showed = ?', true)
  				  ->order('m.sort_order');
		}
		
  		$result =  $db->fetchAll($select);
  		return $result;
	}
	
	public function newMenu($info) {
		$db = Zend_Registry::get('connectDB');
		$menu = array(
				'name' => $info['name'],
				'description' => $info['description'],
				'parent' => $info['parent'],
				'is_inside' => ($info['is_inside'] == 1),
				'link' => $info['link'],
				'sort_order' => $this->getLastOrder($info['parent']) + 1,
				'is_showed' => ($info['is_showed'] == 1),
				);
		$result = $db->insert('cms_menu',$menu);
		//$result = $db->insert('cms_menu',$info);
		return $result;
	}
	
	public function saveMenu($info) {
		$db = Zend_Registry::get('connectDB');
		$where = 'id='.$info['id'];
		$menu = array(
				'name' => $info['name'],
				'description' => $info['description'],
				'parent' => $info['parent'],
				'is_inside' => ($info['is_inside'] == 1),
				'link' => $info['link'],
				'sort_order' => $info['sort_order'],
				'is_showed' => ($info['is_showed'] == 1),
				);
		$result = $db->update('cms_menu',$menu,$where);
		return $result;
	}
	
	public function getLastOrder($parent) {
		$db = Zend_Registry::get('connectDB');
		$query = 'Select max(sort_order) as last_order from cms_menu where parent='.$parent;
		$result = $db->fetchRow($query);
		return $result['last_order'];
	}
	
	public function saveOrder($order) {
		$db = Zend_Registry::get('connectDB');
		$where = null;
		$temp = null;
		$result = null;
		for($i = 0; $i < count($order); $i++) {
			$temp = $this->getItem($order[$i]);
			$temp['sort_order'] = $i;
			$where = 'id='.$order[$i];
			$result = $db->update('cms_menu',$temp,$where);
		}
		return $result;
	}
}