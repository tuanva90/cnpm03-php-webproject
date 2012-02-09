<?php
class Front_Model_Product extends Honey_Db_Table{	
	
	public function init(){
		$this->setName('product');
		$this->setPrimary('product_id');
		parent::init();
	}
	/*
	public function updateViewed($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
		$data = array ('status' => $status );
		$where = 'link_cron_id = ' . (int)$arrParam ['link_cron_id'];
		$this->update ( $data, $where );
	}
	*/
	
	public function listItem($arrParam = null, $options = null) {
  		$db = Zend_Registry::get('connectDB');
  		$paginator = $arrParam ['paginator'];
  		if ($options ['task'] == 'list') {
	  		$select = $db->select()
	  				  ->from(array('p' => $this->getPrefix() . 'product'))	  				  
	  				  ->joinLeft(array('pd' => $this->getPrefix() . 'product_description'), 'p.product_id = pd.product_id')
	  				  ->where('p.status = ?', 1)
	  				  ->where('pd.language = ?', $this->_lang)
	  				  ->order('p.product_id DESC');
  			
	  		if ($paginator ['itemCountPerPage'] > 0) {
				$page = $paginator ['currentPage'];
				$rowCount = $paginator ['itemCountPerPage'];
				$select->limitPage ( $page, $rowCount );
			}
	  		
			return $result = $db->fetchAll($select);
  		}
  		
		if($options['task'] == 'view-cart'){
			if(count($arrParam['cart'])>0){
				$i = 1;
				$ids = '';
				foreach ($arrParam['cart'] as $key => $val){
					if($i  == 1 ){
						$ids .=  $key;
					}else{
						$ids .=  ',' . $key;
					}
					$i ++;
				}				
				$select = $db->select()
						->from(array('p' => $this->getPrefix() . 'product'))	  				  
	  				 	->joinLeft(array('pd' => $this->getPrefix() . 'product_description'), 'p.product_id = pd.product_id')
	  				    ->where('p.status = ?', 1)
	  				  	->where('pd.language = ?', $this->_lang)
						->where('p.product_id IN (' . $ids . ')');									 
				return $result = $db->fetchAll($select);
			}
		}
  	}
  	
  	
	public function countItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');		
		$select = $db->select()
					 ->from($this->getPrefix() . 'product', array('COUNT(product_id) AS totalItem' ))
					 ->where('status = ?', 1);
		
		$result = $db->fetchOne($select);
		return $result;
	
	}
	
	public function getItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get ('connectDB');
		if ($options ['task'] == 'info') {
	  		$select = $db->select()
	  				  ->from(array('p' => $this->getPrefix() . 'product'))
	  				  ->where('p.product_id=?',$arrParam['product_id'])
	  				  ->joinLeft(array('pd' => $this->getPrefix() . 'product_description'), 'p.product_id = pd.product_id')
	  				  ->where('pd.language = ?', $this->_lang);
			$result = $db->fetchRow($select);
		}
		return $result;
	}
  	
  	public function getProducts(){
  		$db = Zend_Registry::get('connectDB');
  		$sql = $db->select()
  				  ->from(array('p' => $this->getPrefix() . 'product'))
  				  ->joinLeft(array('pd' => $this->getPrefix() . 'product_description'), 'p.product_id = pd.product_id');
  		$result =  $db->fetchAll($sql);
  		return $result;
  	}
}