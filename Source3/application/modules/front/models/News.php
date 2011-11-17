<?php
class Front_Model_News extends Honey_Db_Table{	
	
	public function init(){
		$this->setName('news');
		$this->setPrimary('news_id');
		parent::init();
	}
	
	public function listItem($arrParam = null, $options = null) {
  		$db = Zend_Registry::get('connectDB');
  		$paginator = $arrParam ['paginator'];
  		if ($options ['task'] == 'list') {
	  		$select = $db->select()
	  				  ->from(array('n' => $this->getPrefix() . 'news'))
	  				  ->joinLeft(array('nd' => $this->getPrefix() . 'news_description'), 'n.news_id = nd.news_id')
	  				  ->where('n.status = ?', 1)
	  				  ->where('nd.language = ?', $this->_lang)
	  				  ->order('n.sort_order DESC');
  			
	  		if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
	  		
			$result = $db->fetchAll($select);
  		}
  		return $result;
  	}
  	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');		
		$select = $db->select()
					 ->from($this->getPrefix() . 'news', array('COUNT(news_id) AS totalItem' ))
					 ->where('status = ?', 1);
		
		$result = $db->fetchOne($select);
		return $result;
	
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
}