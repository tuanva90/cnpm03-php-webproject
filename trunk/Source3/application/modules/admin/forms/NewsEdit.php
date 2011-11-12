<?php
class Admin_Form_NewsEdit extends Zend_Form{
	public function init(){
		$txtname = new Zend_Form_Element_Text('title');
		$txtname->setLabel('Title :');
		
		$description = new Zend_Form_Element_Textarea('description');
        	$description->setLabel('Description: ')
                   	->setAttrib('rows','2')
                    	->setAttrib('cols','60');		               
                   	
		
		$txtcontent = new Zend_Form_Element_Textarea('content');
		$txtcontent->setLabel('Content :')
					->setAttrib('rows','10')
                    ->setAttrib('cols','60');
		
		$image = new Zend_Form_Element_File('image');
		$image->setLabel('Image: ');
		$image->addValidator('Extension', true, 'jpg,png,gif');
		
		$txtorder = new Zend_Form_Element_Text('order');
		$txtorder->setLabel('Order :');

		$cbxstatus= new Zend_Form_Element_Select('status');
		$cbxstatus->setLabel('Status : ');
		$cbxstatus->addMultiOption(array('published' =>'Published', 'unpublished' =>'Unpublished'));
		$cbxstatus->setMultiOptions(array('published' =>'Published', 'unpublished' =>'Unpublished'));	
		
		$this->addElements(array($txtname,$description,$txtcontent,$image,$txtorder, $cbxstatus));	
		
	
		$this->addDecorator('formElements');
		$this->addDecorator('form');
		$this->addDisplayGroup(	array('title','description','content','image','price','order','status'),'News');	
		
		$this->addElement('submit', 'submit', array( 
        'label' => 'Save', 
        'decorators' => array( 
            'ViewHelper', 
        ), 
    ));				
		$this->addElement('submit', 'cancel', array( 
        'label' => 'Cancel', 
        'decorators' => array( 
            'ViewHelper', 
        ), 
    )); 

		$this->addDisplayGroup(array('submit', 'cancel'), 'submitButtons', array( 
        'decorators' => array( 
            'FormElements', 
            array('HtmlTag', array('tag' => 'div', 'class' => 'element')), 
        ), 
    )); 	
	}
}
?>
