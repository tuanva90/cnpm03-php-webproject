<?php
class Admin_Form_ArticleMove extends Zend_Form{
	public function init(){
		
		$lbxsectioncat= new Zend_Form_Element_Multiselect('sectioncat');
		$lbxsectioncat->setLabel('Move to Section/Category:  ');
		$lbxsectioncat->setMultiOptions(array('about'=>'About C&C'));

		$lblarticlemove = new Zend_Form_Element_Text('articlemove');
		$lblarticlemove->setLabel('Articles being moved :');

		
		$this->addElements(array($lbxsectioncat,$lblarticlemove));

		$this->addDecorator('formElements');
		$this->addDecorator('form');
		$this->addDisplayGroup(	array('sectioncat','articlemove'),'Move');
		 
	}
}
?>
