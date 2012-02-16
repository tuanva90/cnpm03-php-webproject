<?php
class Block_BlkModuleDefault extends Zend_View_Helper_Abstract{

	public function BlkModuleDefault ($info){
		
		$view  = $this->view;
		$arrParam = $view->arrParam;
		
		//Setting default value
		//Option default values go here		
		
		//Setting module-option
		//Turn the line below on to load option from database
		//eval($info['option']);
		
		require_once(APPLICATION_PATH . DS . DS . 'blocks' . DS. 'BlkModuleDefault' . DS . 'default.php');
	}
}