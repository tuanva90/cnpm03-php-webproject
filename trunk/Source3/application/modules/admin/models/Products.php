<?php
class Admin_Model_Products extends Zend_Db_Table{
//------------------------------------Get--------------------------------------------//

	public function GetProducts() {		
		$db = Zend_Registry::get ( 'connectDB' );
		$select = $db->select()
        			  ->from(array('n' => 'cms_product'))
        			  ->joinLeft(array('nd' => 'cms_product_description'), 'n.product_id = nd.product_id')
	  				  ->limitPage(0, 10);
        			  ;
		
        	$result = $db->fetchAll($select);    	
			return $result;
	}
	public function getProduct_item($p_id) {
		
		$db = Zend_Registry::get ( 'connectDB' );
		
		
		$sql= $db->select()
				->from(array('p' => 'cms_product'))
        			  ->joinLeft(array('pd' => 'cms_product_description'), 'p.product_id = pd.product_id')
	  				  ->where('p.product_id = ?',$p_id);
		$result=$db->fetchRow($sql);
			return $result;
			
          
	}
	public function GetProduct_Description($product_id,$language) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$sql= $db->select()
				->from('cms_product_description')
				->where('product_id = ?',$product_id)
				->where('language = ?',$language);
				;
		$result=$db->fetchAll($sql);
			return $result;
		
	}
//------------------------------------Delete--------------------------------------------//
	public function DeleteProduct($n_id) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where =  'product_id= '.$n_id;
		$db->delete ( 'cms_product', $where);		
	}
	public function DeleteProductDescription($Product_ID,$Language)
  	{
  		$db = Zend_Registry::get ( 'connectDB' );
		$where = array(
				'product_id' => $Product_ID, 
				'language' => $Language
				);	
		 $db->delete ( 'cms_product_description', $where);
  	}
//------------------------------------Update--------------------------------------------//
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
		$where = 'product_id ='.$product_id;
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
		$Language_Vi = 'VI';		
		$where = 'product_id ='. $product_id ;
		$Product_Description = array(
		'language'		=>$Language_Vi,
		'name'			=>$nameVI,
		'description'	=>$descriptionVI);		
		$db->update('cms_product_description',$Product_Description,$where);
	}
//--------------------------------Insert------------------------------------------------//
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
									$descriptionVI
									) 
	{
		$db = Zend_Registry::get('ConnectDB');
		$Product = array(
      	'model'     =>$model ,
     	'image'    	=>$image ,
      	'price'  	=>$price ,
		'date_available'	=>$date_available,
		'date_added'	=>$date_added,
		'date_modified'	=>$date_modified,
		'viewed'	=>$viewed,
		'sort_oder'	=>$sort_order,
		'status'	=>$status
		);      
		$db->insert('cms_product',$Product);
	}
	public function InsertProductDescription($product_id,
												$language,
												$name,
												$meta_keywords,
												$meta_description,
												$description												
												)
	{
		$db = Zend_Registry::get('ConnectDB');
		$data = array(
		'product_id'	=>$product_id,
		'language'		=>$language,
		'name'			=>$name,
		'meta_keywords'	=>$meta_keywords,
		'meta_description'	=>$meta_description,
		'decription'	=>$description);
		
		$db->insert('cms_product_description',$data);													
	}
}
?>