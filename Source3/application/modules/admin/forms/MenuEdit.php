<?php
class Admin_Form_MenuEdit
    extends Zend_Form
{
    public function init()
    {
       $this->setAction ( '' )
          ->setMethod ( 'post' );
      
		$uniquename=$this->CreateElement('text','uniquename')  

                       ->setLabel('Unique Name:');
  

       $uniquename->setDecorators(array(  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr')) 

           ));

        
	   $title=$this->CreateElement('text','description1') 

                       ->setLabel('Title');
  

       $title->setDecorators(array(

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))  

		));
	   $description=$this->CreateElement('text','description') 

                       ->setLabel('Description');
  

       $description->setDecorators(array(

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))  

		));  

       $btnSave=$this->CreateElement('submit','save')  

                       ->setLabel('Save');  

       $btnSave->setDecorators(array(  

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'right')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr'))  

       ));
	   $btnCancel=$this->CreateElement('submit','cancel')  

                       ->setLabel('Cancel');

       $btnCancel->setDecorators(array( 

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'right')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr'))  

       ));
	   

       $this->addElements(array(

            $uniquename,             
			   
			$title,
			
			$description            

       ));
		
       $this->setDecorators(array( 

               'FormElements',

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

               'Form' 

       ));
	   
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
 
		
	   
	}
}
?>