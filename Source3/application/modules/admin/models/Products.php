<?php
class Admin_Model_Products{
	
  	public function getProducts(){

      	$db = Zend_Registry::get('connectDB');
  		$sql = $db->select()
  				  ->from('cms_product');  				  
  		$result =  $db->fetchAll($sql);
  		return $result;
  	}
}
?>