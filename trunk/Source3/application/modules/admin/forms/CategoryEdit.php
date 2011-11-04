<?php
class Admin_Form_CategoryEdit extends Zend_Form{
	public function init(){
		
			
		$lblscope = new Zend_Form_Element_Text('scope');
		$lblscope->setLabel('Scope :');
		
		$txttitlee = new Zend_Form_Element_Text('titlee');
		$txttitlee->setLabel('Title :');
		
		$txtalias = new Zend_Form_Element_Text('alias');
		$txtalias->setLabel('Alias :');
		
		
		$rbtnpublished = new Zend_Form_Element_Radio('published');
		$rbtnpublished->setLabel('Published : ');
		$rbtnpublished->addMultiOptions(array('yes'=>'Yes', 'no'=>'No'));

		$cbxsection= new Zend_Form_Element_Select('section');
		$cbxsection->setLabel('Section : ')->setRequired(true);
		$cbxsection->addMultiOption(array('group' =>'About C&C Group'));
		$cbxsection->setMultiOptions(array('group' =>'About C&C Group'));
		$cbxsection->setRequired(true)->addValidator('NotEmpty', true);

		$lblcatorder = new Zend_Form_Element_Select('catorder');
		$lblcatorder->setLabel('Category Order :');
		$lblcatorder->setMultiOptions(array('0'=>'0','1'=>'1','2'=>'2'));
		
		$lbxaccesslevel= new Zend_Form_Element_Multiselect('accesslevel');
		$lbxaccesslevel->setLabel('Access Level  : ');
		$lbxaccesslevel->setMultiOptions(array('public' =>'Public', 'registered'=>'Registered', 'special'=>'Special'));

		$cbximage= new Zend_Form_Element_Select('image');
		$cbximage->setLabel('Image : ')->setRequired(true);
		$cbximage->addMultiOption(array('selectimage' =>'-Select Image-'));
		$cbximage->setMultiOptions(array('selectimage' =>'-Select Image-'));
		$cbximage->setRequired(true)->addValidator('NotEmpty', true);

		$cbximagepos= new Zend_Form_Element_Select('imagepos');
		$cbximagepos->setLabel('Image Position : ')->setRequired(true);
		$cbximagepos->addMultiOption(array('center' =>'Center','left'=>'Left','right'=>'Right'));
		$cbximagepos->setMultiOptions(array('center' =>'Center','left'=>'Left','right'=>'Right'));
		$cbximagepos->setRequired(true)->addValidator('NotEmpty', true);
								

		$texteditor = new Zend_Form_Element_Textarea('texteditor');
        	$texteditor->setLabel('Description')
                   	->setAttrib('rows','8')
                    	->setAttrib('cols','40')                 
                    	->addFilter('StripTags')
                    	->addFilter('StringTrim')
                    	->addValidator('NotEmpty');
		
		
		
		$fbtnimage = new Zend_Form_Element_Button('Image');
		$fbtnimage->setValue('Image');					
				
		
		
		$this->addElements(array($lblscope,$txttitlee,$txtalias,$rbtnpublished,$cbxsection,$lblcatorder,$lbxaccesslevel,$cbximage,$cbximagepos,$texteditor,$fbtnimage));

		$this->addDecorator('formElements');
		$this->addDecorator('form');
		$this->addDisplayGroup(	array('scope','titlee','alias','published','section','catorder','accesslevel','image','imagepos'),'Details');
		$this->addDisplayGroup(	array('texteditor','Image'),'Description');
		 
	}
}
?>
