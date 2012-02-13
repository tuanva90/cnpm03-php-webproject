<?php
class Admin_Model_InvoiceDetail extends Honey_Db_Table{	
	
	public function init(){
		$this->setName('invoice_detail');
		$this->setPrimary('invoice_detail_id');
		parent::init();
	}
	
	public function listItem($arrParam = null, $options = null) {
		$db = Zend_Registry::get('connectDB');
		
		if ($options ['task'] == 'list') {
			$select = $db->select()
						 ->from ( $this->getPrefix() . 'invoice_detail AS id', array('id.quantity', 'id.price',))
						 ->joinLeft ($this->getPrefix() . 'product AS p', 'p.product_id = id.product_id', array('p.product_id'))
						 ->joinLeft ($this->getPrefix() . 'product_description AS pd', 'pd.product_id = p.product_id', array('pd.name'))
						 ->where('pd.language = ?', $this->_lang)
						 ->where('id.invoice_id = ?', $arrParam['invoice_id'] )
						 ->order('id.product_id ASC');
			
			$result = $db->fetchAll($select);
		}
		return $result;
	
	}
	
	public function deleteItem($arrParam = null, $options = null) {
		if ($options ['task'] == 'delete') {
			$where = ' invoice_id = ' . (int)$arrParam ['invoice_id'];
			$this->delete ( $where );
		}
		
		if ($options ['task'] == 'multi-delete') {
			$selected = $arrParam ['selected'];
		
			if (count ( $selected ) > 0) {
				if ($arrParam ['type'] == 1) {
					$status = 1;
				} else {
					$status = 0;
				}
		
				$ids = implode ( ',', $selected );
				$where = 'invoice_id IN (' . $ids . ')';
				$this->delete ( $where );
			}
		}
	}
}