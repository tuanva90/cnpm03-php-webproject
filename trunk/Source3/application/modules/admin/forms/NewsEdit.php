<?php
class Admin_Form_NewsEdit extends Zend_Form{
	public function init(){
		$txtname = new Zend_Form_Element_Text('title');
		$txtname->setLabel('Title :')
				->setAttrib('style', 'width:500px');
		
		$txtauthor = new Zend_Form_Element_Text('author');
		$txtauthor->setLabel('Author :')
				->setAttrib('style', 'width:150px');
		
		$description = new Zend_Form_Element_Textarea('description');
        	$description->setLabel('Description: ')
                   	->setAttrib('rows','4')
                    	->setAttrib('cols','100');          
                   			
		$txtcontent = new Zend_Form_Element_Textarea('content');
		$txtcontent->setLabel('Content :')
					->setAttrib('rows','10')
                    ->setAttrib('cols','60');
		
		$image = new Zend_Form_Element_File('image');
		$image->setLabel('Image: ');
		//$image->addValidator('Extension', true, 'jpg,png,gif');
		
		$txtorder = new Zend_Form_Element_Text('order');
		$txtorder->setLabel('Order :');

		$cbxstatus= new Zend_Form_Element_Select('status');
		$cbxstatus->setLabel('Status : ');
		$cbxstatus->addMultiOption(array('published' =>'Published', 'unpublished' =>'Unpublished'));
		$cbxstatus->setMultiOptions(array('published' =>'Published', 'unpublished' =>'Unpublished'));
		
		$this->addElements(array($txtname,$txtauthor,$description,$txtcontent,$image,$txtorder, $cbxstatus));	
		
	
		$this->addDecorator('formElements');
		$this->addDecorator('form');
		$this->addDisplayGroup(	array('title','author','description','content','image','price','order','status'),'News');	
		
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
	public function setValue($arrParam) {
		
		$this->getElement("title")->setValue(html_entity_decode($arrParam['title'], ENT_QUOTES, 'UTF-8'));
		$this->getElement("author")->setValue($arrParam['author']);
		$this->getElement("description")->setValue(html_entity_decode($arrParam['summary'], ENT_QUOTES, 'UTF-8'));
		//$content = $arrParam['description'];
		//$content =  html_entity_decode($content, ENT_QUOTES, 'UTF-8'); 		
		//$content =  html_entity_decode($content, ENT_NOQUOTES, 'UTF-8');		
		$this->getElement("content")->setValue(html_entity_decode($arrParam['description'], ENT_QUOTES, 'UTF-8'));
		$this->getElement("image")->setValue($arrParam['image']);
		$this->getElement("order")->setValue($arrParam['sort_order']);
		$this->getElement("status")->setValue($arrParam['status']);
	}
}
?>
