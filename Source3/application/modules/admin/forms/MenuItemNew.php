<?php
class Admin_Form_MenuItemNew extends Zend_Form{
	
	public function init(){
		$fbtnsave = new Zend_Form_Element_Button('save');
		$fbtnsave->setLabel('Save');
		
		$fbtnapply = new Zend_Form_Element_Button('apply');
		$fbtnapply->setLabel('Apply');
		
		$fbtncancle = new Zend_Form_Element_Button('cancle');
		$fbtncancle->setLabel('Cancle');
		
		$fbtnhelp = new Zend_Form_Element_Button('help');
		$fbtnhelp->setLabel('Help');
		
		$fbtnchangetype = new Zend_Form_Element_Button('changetype');
		$fbtnchangetype->setLabel('ChangeType');
		
		$fmltselect = new Zend_Form_Element_Multiselect('type');
		$fmltselect->setLabel('Type :');
		$fmltselect->addMultiOption(array('a' =>'dp1','b'=>'dp2', 'c' =>'dp3','d'=>'dp4'));
		$fmltselect->setMultiOptions(array('a' =>'dp1','b'=>'dp2', 'c' =>'dp3','d'=>'dp4'));
		$fmltselect->setRequired(true)->addValidator('NotEmpty', true);
		
		$ftxttitle = new Zend_Form_Element_Text('title');
		$ftxttitle->setLabel('Title: ');
	
		$ftxtalias = new Zend_Form_Element_Text('alias');
		$ftxtalias->setLabel('Alias: ');
		
		$ftxtlink = new Zend_Form_Element_Text('link');
		$ftxtlink->setLabel('Link: ');
		
		$fcmbdisplay = new Zend_Form_Element_Select('display');
		$fcmbdisplay->setLabel('Display :')->setRequired(true);
		$fcmbdisplay->addMultiOption(array('a' =>'dp1','b'=>'dp2', 'c' =>'dp3','d'=>'dp4'));
		$fcmbdisplay->setMultiOptions(array('a' =>'dp1','b'=>'dp2', 'c' =>'dp3','d'=>'dp4'));
		$fcmbdisplay->setRequired(true)->addValidator('NotEmpty', true);
		
		$fmltparentitem = new Zend_Form_Element_Multiselect('parent');
		$fmltparentitem->setLabel('Parent Item :');
		$fmltparentitem->addMultiOption(array('a' =>'dp1','b'=>'dp2', 'c' =>'dp3','d'=>'dp4'));
		$fmltparentitem->setMultiOptions(array('a' =>'dp1','b'=>'dp2', 'c' =>'dp3','d'=>'dp4'));
		$fmltparentitem->setRequired(true)->addValidator('NotEmpty', true);
		
		$frdbpublish = new Zend_Form_Element_Radio('publish');
		$frdbpublish->setLabel('Published :');
		$frdbpublish->addMultiOption(array('a' =>'Yes','b'=>'No'));
		$frdbpublish->setMultiOptions(array('a' =>'Yes','b'=>'No'));
		
		$fmltaccesslevel = new Zend_Form_Element_Multiselect('accesslevel');
		$fmltaccesslevel->setLabel('Access Level :');
		$fmltaccesslevel->addMultiOption(array('a' =>'public','b'=>'registered', 'c' =>'special'));
		$fmltaccesslevel->setMultiOptions(array('a' =>'public','b'=>'registered', 'c' =>'special'));
		$fmltaccesslevel->setRequired(true)->addValidator('NotEmpty', true);
		
		$fmltopen = new Zend_Form_Element_Multiselect('open');
		$fmltopen->setLabel('Onclick, Open in :');
		$fmltopen->addMultiOption(array('a' =>'public','b'=>'registered', 'c' =>'special'));
		$fmltopen->setMultiOptions(array('a' =>'public','b'=>'registered', 'c' =>'special'));
		$fmltopen->setRequired(true)->addValidator('NotEmpty', true);

		
		$this->addElements(array($fmltopen,$fmltaccesslevel,$frdbpublish,$fmltparentitem,$fcmbdisplay,$ftxtalias,$ftxtlink,$ftxttitle,$fbtnsave,$fbtnapply,$fbtncancle,$fbtnhelp,$fmltselect,$fbtnchangetype));
		$this->addDecorator('formElements');
		
		$this->addDisplayGroup(	array('type','changetype'),'ItemType');
		$this->addDisplayGroup(	array('title','alias','link','display','parent','publish','accesslevel','open'),'Info');
		
	}	
}
?>