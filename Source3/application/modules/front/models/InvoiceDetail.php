<?php
class Front_Model_InvoiceDetail extends Honey_Db_Table{	
	
	public function init(){
		$this->setName('invoice_detail');
		$this->setPrimary('invoice_detail_id');
		parent::init();
	}
	
	public function saveItem($arrParam = null, $options = null){
		
		if($options == null){
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
				
				$db = Zend_Registry::get('connectDB');
				$select = $db->select()
							 ->from(array('p' => $this->getPrefix() . 'product'), array('product_id','price'))							
							 ->where('p.product_id IN (' . $ids . ')');
				$result = $db->fetchAll($select);
				$tmp = array();				
				$cart = $arrParam['cart'];
				
				foreach ($result as $key => $val){					
					$val['quantity'] = $cart[$val['product_id']];
					$tmp[] = $val;
				}
			}	
			foreach ($tmp as $key_1 => $info){
				$row =  $this->fetchNew();
				$row->product_id 	= $info['product_id'];
				$row->quantity 		= $info['quantity'];
				$row->price 		= $info['price'];
				$row->invoice_id	= $arrParam['invoice_id'];
				$row->save();
			}			
		}
	}
}