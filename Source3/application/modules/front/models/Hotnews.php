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
			$select = "SELECT * FROM ".$this->getPrefix()."hotnews as hn LEFT JOIN ".$this->getPrefix()."news as n ON n.news_id = hn.news_id LEFT JOIN ".$this->getPrefix()."news_description as nd ON nd.news_id = hn.news_id WHERE nd.language = '".$this->_lang."' AND n.status = 1 ORDER BY hn.date_added ASC";
			
			if ($paginator['itemCountPerPage'] > 0){
				$page = $paginator['currentPage'];
				$rowCount = $paginator['itemCountPerPage'];
				$startindex = ($page - 1) * $rowCount;
				$select = $select.' LIMIT '.$startindex.','.$rowCount;
			}
			$result = $db->fetchAll($select);
			return $result;
		}
		if($option['task'] == 'listTop')
		{
			$select = "SELECT * FROM ".$this->getPrefix()."hotnews as hn LEFT JOIN ".$this->getPrefix()."news as n ON n.news_id = hn.news_id LEFT JOIN ".$this->getPrefix()."news_description as nd ON nd.news_id = hn.news_id WHERE nd.language = '".$this->_lang."' AND n.status = 1 ORDER BY hn.date_added ASC limit 0,5";
			$result = $db->fetchAll($select);
			return $result;
		}
	}
	
	public function countItem($arrParam = null, $option = null){
	    $db = Zend_Registry::get('connectDB');
	    if($option['task'] == 'countAll')
	    {
	        $select = $db->select()
	        	->from($this->getPrefix().'hotnews', array('COUNT(*) as hotnewscount'));
	        
	        $result = $db->fetchOne($select);
	        return $result;
	    }
	}
	
	public function saveItem($arrParam = null, $option = null)
	{
	    $db = Zend_Registry::get('connectDB');
	    
	    if($option['task'] == 'add')
	    {
	        $i_data = array(
	        	'news_id' => $arrParam['news_id'],
	        	'date_added' => $arrParam['date']
	        );
	        
	        $db->insert($this->getPrefix().'hotnews', $i_data);
		}
	}
}