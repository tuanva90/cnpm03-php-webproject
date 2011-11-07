<?php 
class Admin_Form_SectionManager extends Zend_Form
{
	public function init(){
	
			$btnPunish = new Zend_Form_Element_Button('Punish');
			$btnUnpunish = new Zend_Form_Element_Button('Unpunish');
			$btnDelete = new Zend_Form_Element_Button('Delete');
			$btnEdit = new Zend_Form_Element_Button('Edit');
			$btnNew = new Zend_Form_Element_Button('New');
			$btnHelp = new Zend_Form_Element_Button('Help');
			        
			$this ->addElement($btnPunish)
			    	->addElement($btnUnpunish)
			    	->addElement($btnDelete)
			    	->addElement($btnEdit)
			    	->addElement($btnNew)
			    	->addElement($btnHelp);
	}

}
?>