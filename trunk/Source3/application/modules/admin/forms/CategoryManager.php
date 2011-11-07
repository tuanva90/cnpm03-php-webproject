<?php
class Admin_Form_CategoryManager extends Zend_Form{
	public function init(){
			$btnPunish = new Zend_Form_Element_Button('Punish');
			$btnUnpunish = new Zend_Form_Element_Button('Unpunish');
			$btnDelete = new Zend_Form_Element_Button('Delete');
			$btnMove = new Zend_Form_Element_Button('Move');
			$btnCopy = new Zend_Form_Element_Button('Copy');
			$btnEdit = new Zend_Form_Element_Button('Edit');
			$btnNew = new Zend_Form_Element_Button('New');
			$btnHelp = new Zend_Form_Element_Button('Help');
			        
			$this ->addElement($btnPunish)
			    	->addElement($btnUnpunish)
			    	->addElement($btnMove)
			    	->addElement($btnCopy)
			    	->addElement($btnDelete)
			    	->addElement($btnEdit)
			    	->addElement($btnNew)
			    	->addElement($btnHelp);
	} 
}

?>