<?php
class Admin_Model_News  extends Zend_Db_Table{

	protected $_name   = 'cms_news';
	

	
	public function getNews($page,$limit) {
		
		$db = Zend_Registry::get ( 'connectDB' );
	
	
		$select = $db->select()
        			  ->from(array('n' => 'cms_news'))
        			  ->joinLeft(array('nd' => 'cms_news_description'), 'n.news_id = nd.news_id')
	  				  ->limitPage($page, $limit)
	  				  ->order('n.sort_order DESC');
        			  ;
		
        	$result = $db->fetchAll($select);
        	
			return $result;
	}

	

	
	public function getNews_item($n_id) {		
		$db = Zend_Registry::get ( 'connectDB' );		
		$sql= $db->select()
				->from(array('n' => 'cms_news'))
				 ->where('n.news_id = ?',$n_id)
        		->joinLeft(array('nd' => 'cms_news_description'), 'n.news_id = nd.news_id');
	  				 
		$result=$db->fetchRow($sql);
			return $result;		
          
	}
	

	public function countItem() {
		$db = Zend_Registry::get ( 'connectDB' );
		
		
		$select = $db->select ('COUNT(n.user_id) AS totalItem' )
		->from('cms_news AS n');
				//->from (  'cms_news AS n', array ('COUNT(n.user_id) AS totalItem' ) );
		
		
		$result = $db->fetchOne ( $select );
		return $result;
	
	}
	
	public function deleteNews($n_id) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where =  'news_id= '.$n_id;
		$db->delete ( 'cms_news', $where);
		 
		
		
	}
	
	public function updateNews($n_id,$n_image,$n_sort_order,$n_status,$n_date_modified) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = ' news_id ='.$n_id;
		$data = array (
		
		'image' => $n_image,
		 
		'sort_order'=>$n_sort_order,
		'status'=>$n_status,
		
		'date_modified'=>$n_date_modified
		);
		
		 $db->update ( 'cms_news', $data, $where );
	

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
	
	////////////////////////////////ThaoNX////////////////
	public function insertNews_Item2($arrParam) 
	{
		$db = Zend_Registry::get ( 'connectDB' );
		
		$data = array (		
		'author'=>$arrParam['author'],	
		'image' => $arrParam['image'],
		'sort_order' => $arrParam['order'],
		'status'=>$arrParam['status'],
		'date_added'=>$arrParam['date_added']	
		);
		
		$db->insert ( 'cms_news', $data );
		$n_id= $db->lastInsertId();
		$result = $this->insertNews_description2($n_id,$arrParam);
		return $result;
		
	}
	
	public function insertNews_description2($n_id,$arrParam) 
	{
		$db = Zend_Registry::get ( 'connectDB' );
		
		$data = array (	
		'news_id'=>$n_id,
		'language'=>'vi_VN',	
		'title' => $arrParam['title'],
		'summary' => $arrParam['description'],
		'description'=>$arrParam['content']	
		);		
		$result = $db->insert ( 'cms_news_description', $data );
		return  $result;
		
	}
	
	public function updateNews2($n_id,$arrParam) 
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = ' news_id ='.(int)$n_id;
		$data = array (
		
		'image' => $arrParam['image'],
		 
		'sort_order'=> $arrParam['image'],
		
		'date_added'=> $arrParam['date_added'],
		);
		
		 $db->update ( 'cms_news', $data, $where );
		 $this->updateNews_description2($n_id, "vi_VN", $arrParam);
	}
	
public function updateNews_description2($n_id,$language,$arrParam)  
	{
		
		$db = Zend_Registry::get ( 'connectDB' );
		$where = "news_id = " . (int)$n_id;		
		$data = array (
		'title' => $arrParam['title'],
		'description' => $arrParam['content'],
		'summary'=>$arrParam['description'],
		);
		
		 $db->update ( 'cms_news_description', $data, $where );
	}
	
	
	
}
?>