<?php
class Admin_Model_News{
	
  	public function getNews(){

      	$db = Zend_Registry::get('connectDB');
  		$sql = $db->select()
  				  ->from('cms_news');  				  
  		$result =  $db->fetchAll($sql);
  		return $result;
  	}
}
?>