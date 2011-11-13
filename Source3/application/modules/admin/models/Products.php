<?php
class Admin_Model_Products{
	
  	public function GetProducts(){

      	$db = Zend_Registry::get('connectDB');
  		$sql = 'SELECT * FROM cms_product,cms_product_description';  				  
  		$result =  $db->fetchAll($sql);
  		return $result;
  	}
  	public function DeleteProduct($Product_ID)
  	{
  		$db = Zend_Registry::get('ConnectDB');
  		$where = "'product_id' = $Product_ID" ;
  		$db->delete('cms_product',$where);
  	}
	public function UpdateProduct($product_id,
									$model,
									$image, 
									$price, 
									$date_available,
									$date_added,
									$date_modified,
									$viewed,
									$sort_order,
									$status,
									$nameVI,
									$descriptionVI) 
	{		
		$db = Zend_Registry::get('ConnectDB');
		//Cáº­p nháº­t vĂ o báº£ng cms_product
		$where = "'product_id' = $product_id" ;
		$Product = array(
      	'model'     =>$model ,
     	'image'    	=>$image ,
      	'price'  	=>$price ,
		'date_available'	=>$date_available,
		'date_added'	=>$date_added,
		'date_modified'	=>$date_modified,
		'viewed'	=>$viewed,
		'sort_oder'	=>$sort_order,
		'status'	=>$status);
		$db->update('cms_product',$Product,$where);
		
		//Máº·c Ä‘á»‹nh ngĂ´n ngá»¯ lĂ  tiáº¿ng viá»‡t
		$Language_Vi = 'VI';
		
		//Cáº­p nháº­t vĂ o báº£n cms_product_description
		$Product_Description = array(
		'product_id'	=>$product_id,
		'language'		=>$Language_Vi,
		'name'			=>$nameVI,
		'description'	=>$descriptionVI);		
		$db->update('cms_product_description',$Product,$where);
	}
	public function InsertProduct($model,
									$image, 
									$price, 
									$date_available,
									$date_added,
									$date_modified,
									$viewed,
									$sort_order,
									$status,
									$nameVI,
									$descriptionVI) 
	{
		$db = Zend_Registry::get('ConnectDB');
		
		//táº¡o máº£ng cĂ¡c giĂ¡ trá»‹ truyá»�n vĂ o báº£ng cms_product
		$Product = array(
      	'model'     =>$model ,
     	'image'    	=>$image ,
      	'price'  	=>$price ,
		'date_available'	=>$date_available,
		'date_added'	=>$date_added,
		'date_modified'	=>$date_modified,
		'viewed'	=>$viewed,
		'sort_oder'	=>$sort_order,
		'status'	=>$status);      
		$db->insert('cms_product',$Product);
		
		//Láº¥y ID phĂ¡t sinh tá»± Ä‘á»™ng khi thĂªm vĂ o báº£ng.
		$id = $db->lastInsertId();
		
		//Máº·c Ä‘á»‹nh ngĂ´n ngá»¯ lĂ  tiáº¿ng viá»‡t
		$Language_Vi = 'VI';
		
		//Táº¡o máº£ng cĂ¡c giĂ¡ trá»‹ truyá»�n vĂ o báº£ng Product_description.
		$Product_Description = array(
		'product_id'	=>$id,
		'language'		=>$Language_Vi,
		'name'			=>$nameVI,
		'description'	=>$descriptionVI);		
		$db->insert('cms_product_description',$Product_Description);
	}
}
?>