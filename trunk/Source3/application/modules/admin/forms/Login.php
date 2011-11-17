<?php
class Admin_Form_Login extends Zend_Form{
public $buttonDecorators = array('ViewHelper', 
    array(array('data' => 'HtmlTag'), 
    array('tag' => 'td', 'class' => 'element')), 
    array(array('label' => 'HtmlTag'), 
    array('tag' => 'td', 'placement' => 'prepend')), 
    array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $elementDecorators = array(array('ViewHelper'), array('Errors'), 
    array('Description'), array('Label', array('separator' => '')), 
    array('HtmlTag', array('tag' => 'p')));
    public function init ()
    {
        $this->setMethod('post')->setAttrib('id', 'login');
        $fusername = new Zend_Form_Element_Text('username');
        $fusername->setLabel('Username:')->setRequired(true);
        $fusername->setDecorators($this->elementDecorators);
        $fpassword = new Zend_Form_Element_Password('password');
        $fpassword->setLabel('Password:')->setRequired(true);
        $fpassword->setDecorators($this->elementDecorators);
        $fsubmit = new Zend_Form_Element_Submit('submit');
        $fsubmit->setLabel('Login');
        $fsubmit->setDecorators($this->buttonDecorators);
        $ftxtare = new Zend_Form_Element_Textarea('1');
        $ftxtare->setAttrib('cols', '50');
        $ftxtare->setAttrib('rows', '4');
        $ftxtare->setValue('<Error>');
        $ftxtare->setAttrib('disabled', 'disabled');
        $ftxtare->setAttrib('style', 'background-color: pink;');
        $ftxtare->setDecorators($this->elementDecorators);
        $this->addElements(array($ftxtare, $fusername, $fpassword, $fsubmit));
    }
}
?>