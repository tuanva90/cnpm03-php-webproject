<?php
class Front_Model_Webservices extends Honey_Db_Table{
	function init(){
		parent::init();
	}
	
	// De danh cho ngay sau :)) when the day comes, dataType:'xml' :))
	/*
	function getNews($newsid)
	{
		$db = Zend_Registry::get('connectDB');
		
			$result = $db->select()
					->from(array('n'=>$this->getPrefix().'news'))
					->joinLeft(array('nd'=>$this->getPrefix().'news_description'), 'n.news_id=nd.news_id')
					->where('n.news_id = ?',$newsid);
		
		$xmlresult = '<?xml version="1.0" standalone="yes"?><response>';
		$xmlresult .= '<newses><news><news_id>'.$result[0]['news_id'].'</news_id>';
		$xmlresult .= '<author>'.$result[0]['author'].'</author>';
		$xmlresult .= '<image>'.$result[0]['image'].'</image>';
		$xmlresult .= '<viewed>'.$result[0]['viewed'].'</viewed>';
		$xmlresult .= '<sort_order>'.$result[0]['sort_order'].'</sort_order>';
		$xmlresult .= '<status>'.$result[0]['status'].'</status>';
		$xmlresult .= '<date_added>'.$result[0]['date_added'].'</date_added>';
		$xmlresult .= '<date_modified>'.$result[0]['date_modified'].'</date_modified></news>';
		
		$xmlresult .= '<news_description><language>'.$result[0]['language'].'</language>';
		$xmlresult .= '<title>'.$result[0]['title'].'</title>';
		$xmlresult .= '<summary>'.$result[0]['summary'].'</summary>';
		$xmlresult .= '<description>'.$result[0]['description'].'</description>';
		$xmlresult .= '<meta_keywords>'.$result[0]['meta_keywords'].'</meta_keywords>';
		$xmlresult .= '<meta_description>'.$result[0]['meta_description'].'</meta_description></news_description>';
		
		$xmlresult .= '<news_description><language>'.$result[0]['language'].'</language>';
		$xmlresult .= '<title>'.$result[0]['title'].'</title>';
		$xmlresult .= '<summary>'.$result[0]['summary'].'</summary>';
		$xmlresult .= '<description>'.$result[0]['description'].'</description>';
		$xmlresult .= '<meta_keywords>'.$result[0]['meta_keywords'].'</meta_keywords>';
		$xmlresult .= '<meta_description>'.$result[0]['meta_description'].'</meta_description></news_description>';
		
		$xmlresult .= '</response>';
		
		return simplexml_load_string($xmlresult);
		
	}
	*/
	function getNews($newsid)
	{
		$db = Zend_Registry::get('connectDB');
		
		$result = $db->select()
					->from(array('n'=>$this->getPrefix().'news'))
					->joinLeft(array('nd'=>$this->getPrefix().'news_description'), 'n.news_id=nd.news_id')
					->where('n.news_id = ?',$newsid)
					->where('nd.language = ?', $this->_lang);
		$newses = $db->fetchAll($result);
		return $newses;
	}
	
	function getNewsTitle($newsid){
	    $db = Zend_Registry::get('connectDB');
	    
		$result = $db->select('title')
					->from(array('n'=>$this->getPrefix().'news'))
					->joinLeft(array('nd'=>$this->getPrefix().'news_description'), 'n.news_id=nd.news_id')
					->where('n.news_id = ?',$newsid)
					->where('nd.language = ?', $this->_lang);
		$newstitle = $db->fetchAll($result);
		return $newstitle;
	}
}