<?php
class Admin_Model_NewNews extends Honey_Db_Table{
	public function init(){
		$this->setName('news');
		$this->setPrimary('news_id');
		parent::init();
	}
	
	public function listItem($arrParam = null, $option = null)
	{
		$db = Zend_Registry::get('connectDB');
		$paginator = $arrParam['paginator'];
		if ($option['task'] == 'list'){
			$select = $db->select()
					->from(array('n'=>'cms_news'))
					->joinLeft(array('nd'=>'cms_news_description'), 'n.news_id=nd.news_id')
					->where('n.status = ?',1)
					->where('nd.language = ?', $this->_lang)
					->order('n.news_id DESC');
		
		if ($paginator['itemCountPerPage'] > 0){
			$page = $paginator['currentPage'];
			$rowCount = $paginator['itemCountPerPage'];
			$select->limitPage($page,$rowCount);
		}
		$result = $db->fetchAll($select);
		}
		return $result;
	}
	
	public function countItem($arrParam = null, $options = null)
	{
		$db = Zend_Registry::get('connectDB');
		$select = $db->select()
		->from('cms_news', array('COUNT(news_id) as totalItems'))
		->where('status = ?',1);
		
		$result = $db->fetchOne($select);
		return $result;
	}
	
	public function deleteItem($arrParam = null, $option = null)
	{
		$db = Zend_Registry::get('connectDB');
		$where = ' news_id = '.$arrParam['news-id'];
		$db->delete($this->getPrefix().'news', $where);
		$db->delete($this->getPrefix().'news_description', $where);
	}
	
	public function saveItem($arrParam = null, $option = null)
	{
		$db = Zend_Registry::get('connectDB');
		if ($option['task'] == 'add')
		{
			$thenews = array(
				'author'=> $arrParam['user'],
				'image'=> $arrParam['image'],
				'sort_order'=> $arrParam['sort-order'],
				'status'=> $arrParam['status'],
				'date_added'=> $arrParam['date']
			);
			$db->insert($this->getPrefix().'news', $thenews);
			
			$newsid = $db->lastInsertId();
			
			$thenews_description_vi = array(
				'news_id' => $newsid,
				'language' => 'vi_VN',
				'title' => $arrParam['vi_title'],
				'summary' => $arrParam['vi_summary'],
				'description' => $arrParam['vi_description'],
				'meta_keywords' => $arrParam['vi_metakeywords'],
				'meta_description' => $arrParam['vi_metadescription']
			);
			
			$thenews_description_en = array(
				'news_id' => $newsid,
				'language' => 'en_US',
				'title' => $arrParam['en_title'],
				'summary' => $arrParam['en_summary'],
				'description' => $arrParam['en_description'],
				'meta_keywords' => $arrParam['en_metakeywords'],
				'meta_description' => $arrParam['en_metadescription']
			);
			
			$db->insert($this->getPrefix().'news_description', $thenews_description_vi);
			$db->insert($this->getPrefix().'news_description', $thenews_description_en);
		}
	}
}