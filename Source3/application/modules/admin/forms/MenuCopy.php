<?php
class Admin_Form_MenuCopy
    extends Zend_Form
{
    public function init()
    {
       $this->setAction ( '' )
          ->setMethod ( 'post' );   
		
	   
	   $this->addElement (new Zend_Form_Element_Submit('submit', array(
         'label' => ' Save ',
         'class' =>   'ui-state-default ui-corner-all ui-button',
         'decorators'    =>   array('ViewHelper')
			))
		);
		$this->addElement (new Zend_Form_Element_Button('cancel', array(
         'label' => 'Cancel',
         'class' =>   'ui-state-default ui-corner-all ui-button',
         'decorators'    =>   array('ViewHelper')
			))
		);
		$this->addElement (new Zend_Form_Element_Button('help', array(
         'label' => '  Help  ',
         'id'    =>   'delete-button',
         'class' =>   'ui-state-default ui-corner-all ui-button',
         'decorators'    =>   array('ViewHelper')
			))
		);
 
		$this->addDisplayGroup(array('submit', 'cancel','help'), 'submitButtons', array(
		'decorators' => array(
         'FormElements',
         array('HtmlTag', array('tag' => 'div','align'=>'right', 'class' => 'form-buttons')),
			),
		));
 
		$title = new Zend_Form_Element_Text('firstName');
        $title->setLabel('New menu title')
                  ->setRequired(true)
                  ->addValidator('NotEmpty');

        $moduleName = new Zend_Form_Element_Text('lastName');
        $moduleName->setLabel('New module name')
                 ->setRequired(true)
                 ->addValidator('NotEmpty'); 
				 
		$this->addElements(array($title, $moduleName));
	   
	}
}
?>