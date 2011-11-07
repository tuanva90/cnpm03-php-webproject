<?php
class Admin_Form_FrontPageManager extends Zend_Form{
	public function init(){
		$btnArchive = new Zend_Form_Element_Button('Archive');
		$btnPunish = new Zend_Form_Element_Button('Punish');
		$btnUnpunish = new Zend_Form_Element_Button('Unpunish');
		$btnRemove = new Zend_Form_Element_Button('Remove');
		$btnHelp = new Zend_Form_Element_Button('Help');
			        
			$this ->addElement($btnArchive)
				->addElement($btnPunish)
				->addElement($btnUnpunish)
			    ->addElement($btnRemove)
			    ->addElement($btnHelp);
	}
}
?>