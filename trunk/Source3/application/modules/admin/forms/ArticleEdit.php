<?php
class Admin_Form_ArticleEdit extends Zend_Form{
	public function init(){
		$btnReview = new Zend_Form_Element_Button('Review');
		$btnSave = new Zend_Form_Element_Button('Save');
		$btnApply = new Zend_Form_Element_Button('Apply');
		$btnClose = new Zend_Form_Element_Button('Close');
		$btnHelp = new Zend_Form_Element_Button('Help');
		
		$txtTitle = new Zend_Form_Element_Text('Title');
		$txtTitle->setLabel('Title:');
		
		$txtAlias = new Zend_Form_Element_Text('Alias');
		$txtAlias->setLabel('Alias:');
		
		$cmbSection =new Zend_Form_Element_Select('Section');
		$cmbSection->setLabel('Section:');
		$cmbSection->addMultiOptions(array('PL'=>'Public', 'RG'=>'Registered','SP'=>'Special'));
		
		$rdbPublic= new Zend_Form_Element_Radio('Public');
		$rdbPublic->setLabel('Public');
		$rdbPublic->addMultiOptions(array('Y'=>'Yes', 'N'=>'No'));
		//$sdbFrontPage =
		$sdbFrontPage= new Zend_Form_Element_Radio('Front Page');
		$sdbFrontPage->setLabel('Front Page');
		$sdbFrontPage->addMultiOptions(array('Y'=>'Yes', 'N'=>'No'));
		
		$cmbCategory =new Zend_Form_Element_Select('Category');
		$cmbCategory->setLabel('Category:');
		$cmbCategory->addMultiOptions(array('PL'=>'Public', 'RG'=>'Registered','SP'=>'Special'));

		$TextEditor = new Zend_Form_Element_TextArea('textEditor');
		
		$btnImage = new Zend_Form_Element_Button('Image');
		$btnPageBreak = new Zend_Form_Element_Button('PageBreak');
		$btnReadMore = new Zend_Form_Element_Button('ReadMore');

			$this ->addElement($btnReview)
				->addElement($btnSave)
				->addElement($btnApply)
			    ->addElement($btnClose)
			    ->addElement($btnHelp)
			    ->addElement($txtTitle)
			    ->addElement($txtAlias)
			    ->addElement($cmbSection)
			    ->addElement($rdbPublic)
			    ->addElement($sdbFrontPage)
			    ->addElement($cmbCategory)
			    ->addElement($TextEditor)
			    ->addElement($btnImage)
			    ->addElement($btnPageBreak)
			    ->addElement($btnReadMore);
	}
}
?>
