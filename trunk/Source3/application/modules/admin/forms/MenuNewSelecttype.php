<?php
class Admin_Form_MenuNewSelectType extends Zend_Form
{
	public function init(){
		
		$fbtncancle = new Zend_Form_Element_Button('cancle');
		$fbtncancle->setLabel('Cancle');
		
		$fbtnhelp = new Zend_Form_Element_Button('help');
		$fbtnhelp->setLabel('Help');
		
		$fmltselect = new Zend_Form_Element_Multiselect('selectmenuitemtype');
		$fmltselect->setLabel('Select manu item type :');
		
		$this->addElements(array($fbtncancle,$fbtnhelp,$fmltselect));
		$this->addDecorator('formElements');
		
		$this->addDisplayGroup(	array('selectmenuitemtype'),'ItemType');
	}
	
}

?>