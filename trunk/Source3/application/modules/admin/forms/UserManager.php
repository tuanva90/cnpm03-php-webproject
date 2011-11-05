<?php 
class Admin_Form_UserManager extends Zend_Form
{
	public function init(){
		
		$fbtnlogout = new Zend_Form_Element_Button('logout');
		$fbtnlogout->setLabel('LogOut');
									
		$fbtndelete = new Zend_Form_Element_Button('delete');
		$fbtndelete->setLabel('Delete');
		
		$fbtnedit = new Zend_Form_Element_Button('edit');
		$fbtnedit->setLabel('Edit');
		
		$fbtnnew = new Zend_Form_Element_Button('new');
		$fbtnnew->setLabel('New');
		
		$fbtnhelp = new Zend_Form_Element_Button('help');
		$fbtnhelp->setLabel('Help');
		
		$fbtngo = new Zend_Form_Element_Button('go');
		$fbtngo->setLabel('Go');
		
		$fbtnreset = new Zend_Form_Element_Reset('reset');
		$fbtnreset->setLabel('Reset');
		
		$ftxtfilter = new Zend_Form_Element_Text('filter');
		$ftxtfilter->setLabel('Filter: ');
		
		$fcmbselectgroup = new Zend_Form_Element_Select('selectgroup');
		$fcmbselectgroup->setLabel('SelectGroup :')->setRequired(true);
		$fcmbselectgroup->addMultiOption(array('a' =>'Admin','b'=>'Moderator', 'c' =>'Register','d'=>'Guest'));
		$fcmbselectgroup->setMultiOptions(array('a' =>'Admin','b'=>'Moderator', 'c' =>'Register','d'=>'Guest'));
		$fcmbselectgroup->setRequired(true)->addValidator('NotEmpty', true);
		
		$fcmbselectlogstatus = new Zend_Form_Element_Select('selectlogstatus');
		$fcmbselectlogstatus->setLabel('SelectLogStatus :')->setRequired(true);
		$fcmbselectlogstatus->addMultiOption(array('a' =>'Online','b'=>'Offline'));
		$fcmbselectlogstatus->setMultiOptions(array('a' =>'Online','b'=>'Offline'));
		$fcmbselectlogstatus->setRequired(true)->addValidator('NotEmpty', true);
		
		$fcmbdisplay = new Zend_Form_Element_Select('display');
		$fcmbdisplay->setLabel('Display :')->setRequired(true);
		$fcmbdisplay->addMultiOption(array('a' =>'1','b'=>'2'));
		$fcmbdisplay->setMultiOptions(array('a' =>'1','b'=>'2'));
		$fcmbdisplay->setRequired(true)->addValidator('NotEmpty', true);
		
		
		$this->addElements(array($ftxtfilter,$fbtngo,$fbtnreset,$fcmbselectgroup,$fcmbselectlogstatus,$fcmbdisplay,$fbtnlogout,$fbtndelete,$fbtnedit,$fbtnnew,$fbtnhelp));
		$this->addDecorator('formElements');
		$this->addDecorator('form');
		
		$this->addDisplayGroup(	array('filter','go','reset','selectgroup','selectlogstatus','display'),'User');
	}

}
?>