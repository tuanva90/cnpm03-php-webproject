<?php
class Admin_Model_News {
	
	public function getNews() {
		
		$db = Zend_Registry::get ( 'connectDB' );
		$sql = "SELECT *  
        		FROM cms_news 
        		";
		$result=$db->fetchAll($sql);
			return $result;
	}

	public function getNews_item($n_id) {
		
		$db = Zend_Registry::get ( 'connectDB' );
		$sql = "SELECT *  
        		FROM cms_news 
		WHERE news_id = ?   
        		";
		$result=$db->fetchAll($sql,array($n_id));
			return $result;
          
	}
	
	public function deleteNews($n_id) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = " news_id = $n_id";
		$n = $db->delete ( 'cms_news', $where);
		return $n; // ki?m tra có th?c hi?n thành công hay không
	}
	
	public function updateNews($n_id,$n_image,$n_viewed,$n_sort_order,$n_status,$n_date_added,$n_date_modified) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = " news_id = $n_id";
		$data = array (
		'image' => $n_image,
		 'viewed' => $n_viewed ,
		'sort_order'=>$n_sort_order,
		'status'=>$n_status,
		'date_added'=>$n_date_added,
		'date_modified'=>$n_date_modified
		);
		
		$n = $db->update ( 'cms_news', $data, $where );
		return $n; // ki?m tra có th?c hi?n thành công hay không
	

	}
	
	public function insertNews($n_image,$n_viewed,$n_sort_order,$n_status,$n_date_added,$n_date_modified) 
	{
		$db = Zend_Registry::get ( 'connectDB' );
		
		$data = array (		
		'image' => $n_image,
		 'viewed' => $n_viewed ,
		'sort_order'=>$n_sort_order,
		'status'=>$n_status,
		'date_added'=>$n_date_added,
		'date_modified'=>$n_date_modified
		);
		
		$n = $db->insert ( 'cms_news', $data );
		return $n; // ki?m tra có th?c hi?n thành công hay không
	}

	
	
	
	
public function getNews_description($n_id,$n_language) 
{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$sql = "SELECT *  
        FROM cms_news_description 
        WHERE news_id = ?     
        AND language = ?";
		$db->fetchAll($sql,array($n_id,$n_language));
        
			return $result;
	}
	
	public function deleteNews_description($n_id,$n_language) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = array(
				'news_id' => $n_id, 
				'language' => $n_language
				);	
		$n = $db->delete ( 'cms_news_description', $where);
		return $n; // ki?m tra có th?c hi?n thành công hay không
	}
	
	public function updateNews_description($n_id,$n_language,$n_title,$n_summary,$n_description)  
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = array(
				'news_id' => $n_id, 
				'language' => $n_language
				);	
				$data = array (
		'title' => $n_title,
		 'summary' => $n_summary,
		'description'=>$n_description	
		);
		
		$n = $db->update ( 'cms_news_description', $data, $where );
		return $n; // ki?m tra có th?c hi?n thành công hay không
	

	}
	
	public function insertNews_description($n_id,$n_language,$n_title,$n_summary,$n_description) 
	{
		$db = Zend_Registry::get ( 'connectDB' );
		
		$data = array (	
		'news_id'=>$n_id,
		'language'=>$n_language,	
		'title' => $n_title,
		 'summary' => $n_summary,
		'description'=>$n_description	
		);
		
		$n = $db->insert ( 'cms_news_description', $data );
		return $n; // ki?m tra có th?c hi?n thành công hay không
	}
	
	
}
?>