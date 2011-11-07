<?php
class Admin_Form_ConfigSystem extends Zend_Form
{
    public function init ()
    {        
        $this->setMethod('post');
        $this->setAttrib('id', 'siteform');
        //$this->setDecorators(array(
        //		'FormElements', 
        //		array('HtmlTag', array('tag' => 'table')), 'Form')
        //	);
        //site name		
        $timezone = new Zend_Form_Element_Select(
        'timezone');
        $timezone->setLabel("Time zone: ")
            ->addMultiOption('Ho Chi Minh', 'Ho Chi Minh')
            ->addMultiOption('New York', 'New York');
        //type Database
        $database = new Zend_Form_Element_Select('database');
        $database->setLabel("Database: ")
            ->addMultiOption('Mysql', 'Mysql')
            ->addMultiOption('Mysqli', 'Mysqli');
        //Host address
        $host = new Zend_Form_Element_Text('host');
        $host->setLabel("Host: ")->setOptions(array('size' => '30'));
        //Database name	
        $dbname = new Zend_Form_Element_Text('dbname');
        $dbname->setLabel("Database name: ")->setOptions(array('size' => '30'));
        //Database prefix	
        $dbprefix = new Zend_Form_Element_Text('dbprefix');
        $dbprefix->setLabel("Database presfix: ")->setOptions(
        array('size' => '30'));
        //enable FTP
        $enableFTP = new Zend_Form_Element_Radio('enableFTP');
        $enableFTP->setLabel("Enable FTP: ")
            ->addMultiOption('On', 'On')
            ->addMultiOption('Off', 'Off')
            ->setSeparator('');
        //ftphost
        $ftphost = new Zend_Form_Element_Text('ftphost');
        $ftphost->setLabel("Ftp host: ")->setOptions(array('size' => '30'));
        $ftpusername = new Zend_Form_Element_Text('ftpusername');
        $ftpusername->setLabel("FTP username: ")->setOptions(
        array('size' => '30'));
        $ftppassword = new Zend_Form_Element_Password('ftppassword');
        $ftppassword->setLabel("Ftp password: ")->setOptions(
        array('size' => '30'));
        //Create button
        $save=new Zend_Form_Element_Submit('save');
        $save->setLabel('Save');
       	$cancel=new Zend_Form_Element_Reset('cancel');
       	$cancel->setLabel('Cancel');
        
        $help=new Zend_Form_Element_Button('help');
        $help->setLabel('Help');
        /////////////////////
        $this->addElements(
        array($timezone, $database, $host, $dbname, $dbprefix, $enableFTP, 
        $ftphost, $ftpusername, $ftppassword,$save,$cancel,$help));
        $this->addDisplayGroup(
        array('timezone', 'database', 'host', 'dbname', 'dbprefix'), 'system', 
        array('legend' => 'System Setting'));
        $this->addDisplayGroup(
        array('enableFTP', 'ftphost', 'ftpusername', 'ftppassword'), 'ftp', 
        array('legend' => 'FTP'));
        $this->addDisplayGroup(
        array('save','cancel','help'),'submit',
        array('legend'=>'Submit'));
    }
}
?>