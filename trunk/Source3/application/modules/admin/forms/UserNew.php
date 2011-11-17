<?php
class Admin_Form_UserNew extends Zend_Form
{
    public function init ()
    {
        // create 				
        $fusername = new Zend_Form_Element_Text('username');
        $fusername->setLabel('Username:')
            ->setRequired(true)
            ->addValidator('NotEmpty');
        $fpassword = new Zend_Form_Element_Text('password');
        $fpassword->setLabel('Password:');
        $fcfpassword = $this->createElement('text', 'cfpassword');
        $fcfpassword->setLabel('Confirm password : ');
        $femail = $this->createElement('text', 'email');
        $femail->setLabel('Your email : ')->setRequired(true);
        $femail->addValidator(new Zend_Validate_EmailAddress());
        $femail->addFilters(
        array(new Zend_Filter_StringTrim(), new Zend_Filter_StringToLower()));
        $fdate = $this->createElement('text', 'date');
        $fdate->setLabel('Registration date : ');
        $fdate->addValidator(new Zend_Validate_Date('MM-DD-YY'));
        $freemail = new Zend_Form_Element_Checkbox('reemail');
        $freemail->setLabel('Receive System Email : ');
        $fbluser = new Zend_Form_Element_Checkbox('blockuser');
        $fbluser->setLabel('Block this user : ');
        $fbtnsave = new Zend_Form_Element_Button('Save');
        $fbtnsave->setValue('Save');
        $rdgroupuser = new Zend_Form_Element_Radio('usergroup');
        $rdgroupuser->setLabel('User group : ');
        $rdgroupuser->addMultiOptions(
        array('admin' => 'Admin', 'register' => 'Register', 
        'manager' => 'Manager'));
        $fbtnsave_new = new Zend_Form_Element_Button('save_new');
        $fbtnsave_new->setLabel('Save&New');
        $fbtnsave_close = new Zend_Form_Element_Button('save_close');
        $fbtnsave_close->setLabel('Save&Close');
        $fbtncancel = new Zend_Form_Element_Button('cancel');
        $fbtncancel->setLabel('Cancel');
        $this->addElements(
        array($fusername, $fpassword, $fcfpassword, $femail, $fdate, $freemail, 
        $fbluser, $rdgroupuser, $fbtnsave, $fbtnsave_close, $fbtnsave_new, 
        $fbtncancel));
        $this->addDecorator('formElements');
        $this->addDecorator('form');
        $this->addDisplayGroup(
        array('username', 'password', 'cfpassword', 'email', 'date', 'reemail', 
        'blockuser'), 'Userdetails');
        $this->addDisplayGroup(array('usergroup'), 'Usergroup');
    }
}
?>