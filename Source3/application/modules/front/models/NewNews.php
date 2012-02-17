<?php
class Front_Model_NewNews extends Honey_Db_Table{
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
	
	public function listItemByCate($category_id, $option = null)
	{
		$db = Zend_Registry::get('connectDB');
	    if($option['task'] == 'listbyonecate'){
	    	$select = $db->select()
	    	->from(array('n'=>$this->getPrefix().'news'))
	    	->joinLeft(array('nd'=>$this->getPrefix().'news_description'), 'n.news_id = nd.news_id')
	    	->where('n.status = ?', 1)
	    	->where('n.category_id = ?', $category_id)
	    	->where('nd.language = ?', $this->_lang)
	    	->order('n.date_modified DESC');
	    	
	    	$result = $db->fetchAll($select);
	    }
	    return $result;

	}
	
	public function listItemByManyCate($arrParam = null,$option = null)
	{
	    $db = Zend_Registry::get('connectDB');
	    $paginator = $arrParam['paginator'];
	    $child_categories = $arrParam['child_categories'];
	    array_push($child_categories, $arrParam['category_id']);
	    if($option['task'] == 'listbymanycate'){
	    	$select = $db->select()
	    	->from(array('n'=>$this->getPrefix().'news'))
	    	->joinLeft(array('nd'=>$this->getPrefix().'news_description'), 'n.news_id = nd.news_id')
	    	->where('n.status = ?', 1)
	    	->where('nd.language = ?', $this->_lang)
	    	->where('n.category_id IN (?)', $child_categories)
	    	->order(array('n.date_modified DESC', 'n.sort_order ASC'));
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
	
	public function countItemByCate($arrParam = null, $option = null)
	{
	    $db = Zend_Registry::get('connectDB');
	    
	    $child_categories = $arrParam['child_categories'];
	    array_push($child_categories, $arrParam['category_id']);
	    
	    $select = $db->select('n.news_id')
	    		->from(array('n'=>$this->getPrefix().'news'))
	    		->joinLeft(array('nd'=>$this->getPrefix().'news_description'), 'n.news_id = nd.news_id')
	    		->where('n.status = ?', 1)
	    		->where('n.category_id IN (?)', $child_categories)
	    		->where('nd.language = ?', $this->_lang);
	    
	    $result = $db->fetchAll($select);
	    return count($result);
	}
	public function deleteItem($arrParam = null, $option = null)
	{
		$db = Zend_Registry::get('connectDB');
		$where = ' news_id = '.$arrParam['news_id'];
		$db->delete($this->getPrefix().'news', $where);
		$db->delete($this->getPrefix().'news_description', $where);
		$db->delete($this->getPrefix().'hotnews', $where);
	}
	
	public function saveItem($arrParam = null, $option = null)
	{
		$db = Zend_Registry::get('connectDB');
		if ($option['task'] == 'addnew')
		{
			$thenews = array(
				'category_id'=>$arrParam['category'],
				'image'=> $arrParam['image'],
				'sort_order'=> $arrParam['sort-order'],
				'status'=> $arrParam['status'],
				'date_added'=> $arrParam['date'],
				'date_modified'=> $arrParam['date'],
				'author'=> $arrParam['user']
			);
			$db->insert($this->getPrefix().'news', $thenews);
			
			$newsid = $db->lastInsertId();
			
			$thenews_description = array(
				'news_id' => $newsid,
				'language' => $arrParam['language'],
				'title' => stripslashes($arrParam['title']),
				'summary' => stripslashes($arrParam['summary']),
				'description' => stripslashes($arrParam['description']),
				'meta_keywords' => $arrParam['metakeywords'],
				'meta_description' => $arrParam['metadescription']
			);
			
			$db->insert($this->getPrefix().'news_description', $thenews_description);
		}
		elseif($option['task'] == 'add')
		{
		    $thenews_description = array(
		    	'news_id' => $arrParam['add_news_id'],
		    	'language' => $arrParam['language'],
		    	'title' => stripslashes($arrParam['title']),
				'summary' => stripslashes($arrParam['summary']),
				'description' => stripslashes($arrParam['description']),
				'meta_keywords' => $arrParam['metakeywords'],
				'meta_description' => $arrParam['metadescription']
		    );
		    
		    $db->insert($this->getPrefix().'news_description',$thenews_description);
		}
		elseif ($option['task'] == 'edit')
		{
			$where = 'news_id = '.$arrParam['save_news_id'];
			
			$thenews = array(
				'category_id' => $arrParam['category'],
				'image'=> $arrParam['image'],
				'sort_order'=> $arrParam['sort-order'],
				'status'=> $arrParam['status'],
				'date_modified'=> $arrParam['date']
			);
			$db->update($this->getPrefix().'news',$thenews,$where);
			
			$thenews_description = array(
				'title' => stripslashes($arrParam['title']),
				'summary' => stripslashes($arrParam['summary']),
				'description' => stripslashes($arrParam['description']),
				'meta_keywords' => $arrParam['metakeywords'],
				'meta_description' => $arrParam['metadescription']
			);
			$where = array('news_id = '.$arrParam['save_news_id'], "language ='" + $arrParam['language'] + "'");
			$db->update($this->getPrefix().'news_description',$thenews_description,$where);
			
		}
	}
	
	public function getItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');
	
		if ($options ['task'] == 'info') {
			$select = $db->select()
			->from(array('n' => $this->getPrefix() . 'news'))
			->where('n.news_id=?',$arrParam['news_id'])
			->joinLeft(array('nd' => $this->getPrefix() . 'news_description'), 'n.news_id = nd.news_id')
			->where('nd.language = ?', $this->_lang);
			$result = $db->fetchRow($select);
		}
		return $result;
	}
	
	public function testfunction()
	{
				$db = Zend_Registry::get('connectDB');
		
			$result = $db->select()
					->from(array('n'=>$this->getPrefix().'news'))
					->joinLeft(array('nd'=>$this->getPrefix().'news_description'), 'n.news_id=nd.news_id')
					->where('n.news_id = ?',753);
					return $db->fetchAll($result);
	}
	
	public function countennews($news_id)
	{
	    $db = Zend_Registry::get('connectDB');
	    $select = $db->select()
	    	->from($this->getPrefix().'news_description', array('count(*) as newscount'))
	    	->where('news_id = ?', $news_id)
	    	->where('language = ?', "en_US");
	    
	    $result = $db->fetchOne($select);
	    return $result;
	}
	
	public function getViewCountOfNews($news_id)
	{
	    $db = Zend_Registry::get('connectDB');
	    
	    $select = $db->select()
	    	->from($this->getPrefix().'news', array('viewed'))
	    	->where('news_id = ?', $news_id);
	    $result = $db->fetchOne($select);
	}
	
	public function updateViewCountOfNews($news_id, $view)
	{
	    $db = Zend_Registry::get('connectDB');
	    
	   	$data = array(
	   		'viewed' => $view
	   	);
	   	
	   	$where = 'news_id = '.$news_id;
	   	
	   	$db->update($this->getPrefix().'news', $data, $where);
	}
}