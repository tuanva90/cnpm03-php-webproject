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
}