<?php
/**
 * @author: DucNH
 * @Class: Front_Model_Hotnews
 **/

class Front_Model_Hotnews extends Honey_Db_Table{
	function init(){
		$this->setName('hotnews');
		$this->setPrimary('id');
		parent::init();
	}

	public function listItem($arrParam = null, $option = null)
	{
		$db = Zend_Registry::get('connectDB');
		$paginator = $arrParam['paginator'];
		if($option['task'] == 'listAll')
		{
			$select = $db->select()
			->from(array('hn' => $this->getPrefix().'hotnews'))
			->joinLeft(array('n' => $this->getPrefix().'news', 'hn.news_id = n.news_id'))
			->joinLeft(array('nd' => $this->getPrefix().'news_description', 'hn.news_id = nd.news_id'))
			->where('nd.language = ?', $this->_lang)
			->order('hn.date_added DESC');
			if ($paginator['itemCountPerPage'] > 0){
				$page = $paginator['currentPage'];
				$rowCount = $paginator['itemCountPerPage'];
				$select->limitPage($page,$rowCount);
			}
			$result = $db->fetchAll($select);
			return $result;
		}
		if($option['task'] == 'listtop')
		{
			$select = $db->select()
			->from(array('hn' => $this->getPrefix().'hotnews'))
			->joinLeft(array('n' => $this->getPrefix().'news', 'hn.news_id = n.news_id'))
			->joinLeft(array('nd' => $this->getPrefix().'news_description', 'hn.news_id = nd.news_id'))
			->where('nd.language = ?', $this->_lang)
			->order('hn.date_added DESC')
			->limit(0,5);
			$result = $db->fetchAll($select);
			return $result;
		}
	}
}