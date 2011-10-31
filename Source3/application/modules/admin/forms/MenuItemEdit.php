<?php
class Admin_Form_MenuItemEdit extends Zend_Form{
	public function init(){
		
			
		$lbltype = new Zend_Form_Element_Text('type');
		$lbltype->setLabel('Type :');
		
		$txttitle = new Zend_Form_Element_Text('title');
		$txttitle->setLabel('Title :');
		
		$txtalias = $this->createElement('text', 'alias');
		$txtalias->setLabel('Alias : ');
		
		$lbllink = $this->createElement('text', 'link');
		$lbllink->setLabel('Link : ');
				
		$cbxdisplay= new Zend_Form_Element_Select('display');
		$cbxdisplay->setLabel('Display : ')->setRequired(true);
		$cbxdisplay->addMultiOption(array('a' =>'AA','b'=>'BB', 'c' =>'CC'));
		$cbxdisplay->setMultiOptions(array('a' =>'AA','b'=>'BB', 'c' =>'CC'));
		$cbxdisplay->setRequired(true)->addValidator('NotEmpty', true);
		
		$lbxparent= new Zend_Form_Element_Multiselect('parentitems');
		$lbxparent->setLabel('Parent item : ');
		$lbxparent->setMultiOptions(array('abc' =>'ABC', 'cbc'=>'CBC'));
		
		$lbxaccesslevel= new Zend_Form_Element_Multiselect('accesslevel');
		$lbxaccesslevel->setLabel('Access Level  : ');
		$lbxaccesslevel->setMultiOptions(array('public' =>'Public', 'registered'=>'Registered', 'special'=>'Special'));
								
		$lbxopenln= new Zend_Form_Element_Multiselect('openln');
		$lbxopenln->setLabel('On click, open click  : ');
		$lbxopenln->setMultiOptions(array('abc' =>'ABC', 'cbc'=>'CBC'));
		
		$rbtnpublished = new Zend_Form_Element_Radio('published');
		$rbtnpublished->setLabel('Published : ');
		$rbtnpublished->addMultiOptions(array('yes'=>'Yes', 'no'=>'No'));
		
		$fbtnsave = new Zend_Form_Element_Button('Save');
		$fbtnsave->setValue('Save');					
				
		$fbtnapply = new Zend_Form_Element_Button('apply');
		$fbtnapply->setLabel('Apply');
		
		$fbtnchangetype = new Zend_Form_Element_Button('changetype');
		$fbtnchangetype->setLabel('Change type');
								
		$fbtncancel = new Zend_Form_Element_Button('cancel');
		$fbtncancel->setLabel('Cancel');		 
		
		$fbtnhelp = new Zend_Form_Element_Button('help');
		$fbtnhelp->setLabel('Help');	
		
		$this->addElements(array($lbltype,$txttitle,$txtalias,$lbllink,$cbxdisplay,$lbxparent,$rbtnpublished,$lbxaccesslevel,$lbxopenln,$fbtnsave,$fbtnapply,$fbtncancel,$fbtnhelp,$fbtnchangetype));

		$this->addDecorator('formElements');
		$this->addDecorator('form');
		$this->addDisplayGroup(	array('type','changetype'),'Type');
		$this->addDisplayGroup(	array('title','alias','link','display','published','parentitems','accesslevel','openln'),'options');
		 
	}
}
?>
