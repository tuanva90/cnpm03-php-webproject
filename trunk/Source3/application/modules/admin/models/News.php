<?php
class Admin_Model_News  extends Zend_Db_Table{

	
	public function getNews() {
		
		$db = Zend_Registry::get ( 'connectDB' );
	
	
		$select = $db->select()
        			  ->from(array('n' => 'cms_news'))
        			  ->joinLeft(array('nd' => 'cms_news_description'), 'n.news_id = nd.news_id')
	  				  ->limitPage(0, 10);
        			  ;
		
        	$result = $db->fetchAll($select);
        	
			return $result;
	}

	public function getNews_item($n_id) {
		
		$db = Zend_Registry::get ( 'connectDB' );
		
		
		$sql= $db->select()
				->from(array('n' => 'cms_news'))
        			  ->joinLeft(array('nd' => 'cms_news_description'), 'n.news_id = nd.news_id')
	  				  ->where('n.news_id = ?',$n_id);
		$result=$db->fetchRow($sql);
			return $result;
			
          
	}
	
	public function deleteNews($n_id) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where =  'news_id= '.$n_id;
		$db->delete ( 'cms_news', $where);
		 
		
		
	}
	
	public function updateNews($n_id,$n_image,$n_viewed,$n_sort_order,$n_status,$n_date_added,$n_date_modified) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = ' news_id ='.$n_id;
		$data = array (
		'image' => $n_image,
		 'viewed' => $n_viewed ,
		'sort_order'=>$n_sort_order,
		'status'=>$n_status,
		'date_added'=>$n_date_added,
		'date_modified'=>$n_date_modified
		);
		
		 $db->update ( 'cms_news', $data, $where );
	

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
		
		 $db->insert ( 'cms_news', $data );
		
	}

	
	
	
	
public function getNews_description($n_id,$n_language) 
{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$sql= $db->select()
				->from('cms_news_description')
				->where('news_id = ?',$n_id)
				->where('language = ?',$n_language);
				;
		$result=$db->fetchAll($sql);
			return $result;
		
	}
	
	public function deleteNews_description($n_id,$n_language) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = array(
				'news_id' => $n_id, 
				'language' => $n_language
				);	
		 $db->delete ( 'cms_news_description', $where);
		
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
		
		 $db->update ( 'cms_news_description', $data, $where );
		
	

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
		
		$db->insert ( 'cms_news_description', $data );
		
	}
	
	
}
?>