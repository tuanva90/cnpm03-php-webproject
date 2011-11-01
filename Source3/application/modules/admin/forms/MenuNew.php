<?php

class Admin_Form_MenuNew extends Zend_Form
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->setAction('MenuNew');
		$this->setMethod('post');
		$this->setDescription('Media Component');
		$this->setAttrib('sitename','CMS');
		
		//Add elements
		
		//Create txtUniqueName
		$txtUniqueName=new Zend_Form_Element_Text('txtUniqueName');
		$txtUniqueName->setLabel("Unique Name:");
		$this->addElement($txtUniqueName);
		
		//Create txtUniqueName
		$txtUniqueName=new Zend_Form_Element_Text('txtUniqueName');
		$txtUniqueName->setLabel("Unique Name:");
		$this->addElement($txtUniqueName);
		
		//Create txtTitle
		$txtTitle=new Zend_Form_Element_Text('txtTitle');
		$txtTitle->setLabel("Title");
		$this->addElement($txtTitle);
		
		//Create txtDescription
		$txtDescription=new Zend_Form_Element_Text('txtDescription');
		$txtDescription->setLabel("Description");
		$this->addElement($txtDescription);
		
		//Create txtModuleName
		$txtModuleName=new Zend_Form_Element_Text('txtModuleName');
		$txtModuleName->setLabel("Module Name");
		$this->addElement($txtModuleName);
		
		$txtModuleName->setDisableLoadDefaultDecorators(true);		
	    //Create btnSave
		$btnSave=new Zend_Form_Element_Button('btnSave');
		$btnSave->setLabel('Save');
		$this->addElement($btnSave);
		
		//Create btnHelp
		$btnHelp=new Zend_Form_Element_Button('btnHelp');
		$btnHelp->setLabel('Help');
		$this->addElement($btnHelp);
		
		//Create btnCancel
		$btnCancel=new Zend_Form_Element_Button('btnCancel');
		$btnCancel->setLabel('Cancel');
		$this->addElement($btnCancel);
		
	}


}

