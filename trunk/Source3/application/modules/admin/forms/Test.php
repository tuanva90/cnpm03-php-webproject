

<?php
class Admin_Form_Test extends Zend_Form{
	public function init(){
		$txtname = new Zend_Form_Element_Textarea('title');
		$txtname->setLabel('Title :');		
		$this->addElement($txtname);	
		
		
	}
}
?>
