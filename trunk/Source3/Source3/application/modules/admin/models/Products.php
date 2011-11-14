<?php
class Admin_Model_Products{
//-------------------------------Lấy-------------------------------------------//
  	public function GetProducts(){

      	$db = Zend_Registry::get('connectDB');
  		$sql = 'SELECT * FROM cms_product';  				  
  		$result =  $db->fetchAll($sql);
  		return $result;
  	}
//-------------------------------Xóa-------------------------------------------//
  	public function DeleteProduct($Product_ID)
  	{
  		$db = Zend_Registry::get('ConnectDB');
  		$where = "'product_id' = $Product_ID" ;
  		$db->delete('cms_product',$where);
  	}
	public function DeleteProductDescription($Product_ID)
  	{
  		$db = Zend_Registry::get('ConnectDB');
  		$where = "'product_id' = $Product_ID" ;
  		$db->delete('cms_product_description',$where);
  	}
//------------------------------Sửa--------------------------------------------//
	public function UpdateProduct($product_id,
									$model,
									$image, 
									$price, 
									$date_available,
									$date_added,
									$date_modified,
									$viewed,
									$sort_order,
									$status) 
	{		
		$db = Zend_Registry::get('ConnectDB');
		//Cap nhat vao bang cms_product
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
	}
	public function Update_product_description($product_id,
												$nameVI,
												$descriptionVI)
	{
		$db = Zend_Registry::get('ConnectDB');
		//Mặc định ngôn ngữ là tiếng việt
		$Language_Vi = 'VI';
		
		$where = "'product_id' = $product_id" ;
		
		//Cập nhật vào bản cms_product_description
		$Product_Description = array(
		'product_id'	=>$product_id,
		'language'		=>$Language_Vi,
		'name'			=>$nameVI,
		'description'	=>$descriptionVI);		
		$db->update('cms_product_description',$Product_Description,$where);
	}
//--------------------------------Thêm------------------------------------------//
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
		
		//Cac thong tin truyen vao cms_product
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
		
		//lay ID san pham moi them.
		$id = $db->lastInsertId();
		
		//
		$Language_Vi = 'VI';
		
		//nhap thong tin cho bang Product_description.
		$Product_Description = array(
		'product_id'	=>$id,
		'language'		=>$Language_Vi,
		'name'			=>$nameVI,
		'description'	=>$descriptionVI);		
		$db->insert('cms_product_description',$Product_Description);
	}
}
?>