<?php
class Front_Model_Invoice extends Honey_Db_Table{	
	
	public function init(){
		$this->setName('invoice');
		$this->setPrimary('invoice_id');
		parent::init();
	}
	
	public function saveItem($arrParam = null, $options = null){
		
		if($options['task'] == 'public-order'){			
			$row =  $this->fetchNew();
			$row->full_name 			= $arrParam['full_name'];
			$row->email 		= $arrParam['email'];
			$row->phone 		= $arrParam['phone'];
			$row->address 		= $arrParam['address'];
			$row->shipping 		= $arrParam['shipping'];
			$row->comment 		= $arrParam['comment'];
			$row->created 		= '';
			$row->status 		= 0;			
			$id = $row->save();			
		}
		return $id;
	}
}