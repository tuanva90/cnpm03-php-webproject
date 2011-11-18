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
	public function getProduct_item2($p_id,$language) {
		$language = "vi_VN";
		$db = Zend_Registry::get ( 'connectDB' );		
		
		$sql= $db->select()
				->from(array('p' => 'cms_product'))
					->where('p.product_id = ?',$p_id)					
        			->joinLeft(array('pd' => 'cms_product_description'), 'p.product_id = pd.product_id')
        			->where('p.lang = ?', $language);	  				  
		$result=$db->fetchRow($sql);
			return $result;          
	}
	public function getProduct_item($p_id) {
		
		$db = Zend_Registry::get ( 'connectDB' );		
		$sql= $db->select()
				->from(array('p' => 'cms_product'))
					->where('p.product_id = ?',$p_id)
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
	
	public function DeleteProductDescription($n_id)
  	{
  		$db = Zend_Registry::get ( 'connectDB' );
		$where = 'product_id= '.$n_id;
		 $db->delete ( 'cms_product_description', $where);
  	}
//------------------------------------Update--------------------------------------------//
	public function UpdateProduct($product_id,$arrParam) 
	{		
		$db = Zend_Registry::get('ConnectDB');
		$where = 'product_id ='.$product_id;
		$Product = array(
      	'model'     => $arrParam['model'] ,
		'quantity' 	=> $arrParam['quantity'],
     	'image'    	=> $arrParam['image'] ,
      	'price'  	=>$arrParam['price'] ,
		'date_available'	=>$arrParam['date_available'],
		'status'	=> $arrParam['status'],
		'date_added'	=>$arrParam['date_added'] ,
		'date_modified'	=>$arrParam['date_modified'] ,
		'viewed'	=> $arrParam['viewed'],
		'sort_order'	=>$arrParam['sort_order']
		); 
		$result = $db->update('cms_product',$Product,$where);
		return $result;
		
	}
	

	
	
	public function Update_product_description($product_id,$arrParam)
	{
		$db = Zend_Registry::get('connectDB');
		$Language_Vi = 'VI';		
		$where = 'product_id ='. $product_id ;
		$data = array(
				'meta_keywords' => $arrParam['meta_keywords'],
				'meta_description' =>$arrParam['meta_description'],
		        'name'	=> $arrParam ['name'],				
			    'description'	=> $arrParam ['description'],
		    );
		$db->update('cms_product_description',$data,$where);
	}
//--------------------------------Insert------------------------------------------------//
	public function InsertProduct($arrParam) 
	{
		$db = Zend_Registry::get('connectDB');
		$Product = array(
      	'model'     => $arrParam['model'] ,
		'quantity' 	=> $arrParam['quantity'],
     	'image'    	=> $arrParam['image'] ,
      	'price'  	=>$arrParam['price'] ,
		'date_available'	=>$arrParam['date_available'],
		'status'	=> $arrParam['status'],
		'date_added'	=>$arrParam['date_added'] ,
		'date_modified'	=>$arrParam['date_modified'] ,
		'viewed'	=> $arrParam['viewed'],
		'sort_order'	=>$arrParam['sort_order']
				);      
		$db->insert('cms_product',$Product);
	}
	public function InsertProductDescription($p_id,$arrParam)
	{
		$db = Zend_Registry::get('connectDB');
		$data = array(
				'meta_keywords' => $arrParam['meta_keywords'],
				'meta_description' =>$arrParam['meta_description'],
		        'name'	=> $arrParam ['name'],				
			    'description'	=> $arrParam ['description'],
		    );		
		$db->insert('cms_product_description',$data);													
	}

///////////////////By ThaoNX/////////////////

	
	public function update_product2($p_id,$arrParam){
		$db = Zend_Registry::get('connectDB');
			$where = 'product_id = ' . (int)$p_id;
			
			$data = array(
		        'model'	=> $arrParam ['model'],	
				'image'	=> $arrParam ['image'],	
				'price'	=> $arrParam ['price'],	
				'sort_order'=> $arrParam ['oder'],	
				'status' =>$arrParam ['status'],
				'date_added'=> date ( "Y-m-d H:i:s" ),	
		    );
		   $result =  $db->update('cms_product', $data, $where);
		   $result =  $this->update_product_description2($p_id, $arrParam);
		return $result;
			
	}
	
	public function update_product_description2($p_id,$arrParam){
		$db = Zend_Registry::get('connectDB');
			$where = "product_id = " . (int)$p_id;			
			$data = array(
		        'name'	=> $arrParam ['name'],				
			    'description'	=> $arrParam ['description'],
		    );
		   $result =  $db->update('cms_product_description', $data, $where);
		return $result;
			
	}
}
?>

