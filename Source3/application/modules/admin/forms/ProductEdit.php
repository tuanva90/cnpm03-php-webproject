<?php
class Admin_Form_ProductEdit extends Zend_Form{
	public function init(){
		$txtname = new Zend_Form_Element_Text('name');
		$txtname->setLabel('Name :')
			->setAttrib('style', 'width:500px');
		
		$description = new Zend_Form_Element_Textarea('description');
        	$description->setLabel('Description: ')
                   	->setAttrib('rows','15')
                    	->setAttrib('cols','40')->setAttrib('style', 'width:800px');;
		               
                $cbxcatalog= new Zend_Form_Element_Select('catalog');
		$cbxcatalog->setLabel('Catalog: ');
		$cbxcatalog->addMultiOption(array('type'=>'Product Type'));
		$cbxcatalog->setMultiOptions(array('type'=>'Product Type'));    	
		
		$txtmodel = new Zend_Form_Element_Text('model');
		$txtmodel->setLabel('Model :'
			)->setAttrib('style', 'width:200px');;
		
		$image = new Zend_Form_Element_Text('image');
		$image->setLabel('Image :')
			->setAttrib('style', 'width:300px');
		
		$txtprice = new Zend_Form_Element_Text('price');
		$txtprice->setLabel('Price :');

		
		$txtorder = new Zend_Form_Element_Text('order');
		$txtorder->setLabel('Order :');

		$cbxstatus= new Zend_Form_Element_Select('status');
		$cbxstatus->setLabel('Status : ');		
		$cbxstatus->setMultiOptions(array('1' =>'Published', '0' =>'Unpublished'));			
		
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
		
		$description = $arrParam['description'];
		$description =  html_entity_decode($description, ENT_QUOTES, 'UTF-8'); 		
		$description =  html_entity_decode($description, ENT_NOQUOTES, 'UTF-8');
		$this->getElement("description")->setValue($description);
		
		$this->getElement("price")->setValue($arrParam['price']);
		
		$this->getElement("order")->setValue($arrParam['sort_order']);
		
		$this->getElement("status")->setValue($arrParam['status']);
		
        $this->getElement("image")->setValue($arrParam['image']);
		
		$this->getElement("model")->setValue($arrParam['model']);		
	}
}
?>
