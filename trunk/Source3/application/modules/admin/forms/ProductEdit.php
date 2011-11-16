<?php
class Admin_Form_ProductEdit extends Zend_Form{
	public function init(){
		$txtname = new Zend_Form_Element_Text('name');
		$txtname->setLabel('Name :');
		
		$description = new Zend_Form_Element_Textarea('description');
        	$description->setLabel('Description: ')
                   	->setAttrib('rows','4')
                    	->setAttrib('cols','40');
		               
                $cbxcatalog= new Zend_Form_Element_Select('catalog');
		$cbxcatalog->setLabel('Catalog: ');
		$cbxcatalog->addMultiOption(array('type'=>'Product Type'));
		$cbxcatalog->setMultiOptions(array('type'=>'Product Type'));    	
		
		$txtmodel = new Zend_Form_Element_Text('model');
		$txtmodel->setLabel('Model :');
		
		$image = new Zend_Form_Element_File('image');
		$image->setLabel('Image: ');
		
		$txtprice = new Zend_Form_Element_Text('price');
		$txtprice->setLabel('Price :');

		
		$txtorder = new Zend_Form_Element_Text('order');
		$txtorder->setLabel('Order :');

		$cbxstatus= new Zend_Form_Element_Select('status');
		$cbxstatus->setLabel('Status : ');
		$cbxstatus->addMultiOption(array('published' =>'Published', 'unpublished' =>'Unpublished'));
		$cbxstatus->setMultiOptions(array('published' =>'Published', 'unpublished' =>'Unpublished'));			
		
		$this->addElements(array($txtname,$description,$cbxcatalog,$txtmodel,$image,$txtprice,$txtorder, $cbxstatus));

		$this->addDecorator('formElements');
		$this->addDecorator('form');
		$this->addDisplayGroup(	array('name','description'),'Product');
		$this->addDisplayGroup(	array('catalog','model','image','price','order','status'),'Details');
		
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
		//print_r($arrParam);
		$this->getElement("name")->setValue($arrParam['name']);
		$this->getElement("description")->setValue($arrParam['description']);
		$this->getElement("model")->setValue($arrParam['model']);		
	}
}
?>
