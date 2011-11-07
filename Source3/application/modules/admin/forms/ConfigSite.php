<?php
class Admin_Form_ConfigSite extends Zend_Form
{
    public function init ()
    {    
    	$pathConfig=APPLICATION_PATH.'/configs/application.ini';
		$config = new Zend_Config_Ini($pathConfig,null);
		/////////////////////////////// 
        $this->setMethod('post');
        $this->setAttrib('id', 'siteform');
        // ***create form element**//
        //site name		
        $sitename = new Zend_Form_Element_Text('sitename');
        $sitename->setLabel("Site name: ")->setOptions(array('size' => '50'));
        $sitename->setValue($config->web->name);
        //site decription
        $sitedecription = new Zend_Form_Element_Textarea(
        'sitedecription');
        $sitedecription->setLabel("Site decription: ")->setOptions(
        array('rows' => 3, 'cols' => '50'));
        $sitedecription->setValue($config->web->meta->description);
        //message
        $message = new Zend_Form_Element_Textarea('message');
        $message->setLabel("Ofline Message: ")->setOptions(
        array('rows' => 2, 'cols' => '50'));
        $message->setValue($config->web->offline->message);
        //site staus
        $status = new Zend_Form_Element_Radio('status');
        $status->setLabel("Default editor: ")
            ->addMultiOption('On', 'On')
            ->addMultiOption('Off', 'Off')
            ->setSeparator('');
        $status->setValue($config->web->offline->enable);
        //default editor
        $editor = new Zend_Form_Element_Select('editor');
        $editor->setLabel("Default editor: ")
            ->addMultiOption('none', 'none')
            ->addMultiOption('FCKeditor', 'FCKeditor');
        $editor->setValue($config->web->editor);
        $defaultlimit = new Zend_Form_Element_Text('defaultlimit');
        $defaultlimit->setLabel("Default Limit: ");
        $defaultlimit->setValue($config->web->admin->pageRange);
        //button Save,Help,Cancel
        $save=new Zend_Form_Element_Submit('save');
        $save->setLabel('Save');
        $cancel=new Zend_Form_Element_Reset('cancel');
        $cancel->setLabel('Cancel');
        
        $help=new Zend_Form_Element_Button('help');
        $help->setLabel('Help');
        
        // ***Add form element**//
        $this->addElements(
        array($sitename, $sitedecription, $message, $status, $editor, 
        $defaultlimit,$save,$cancel,$help));
        // ***create form Group**//
        $this->addDisplayGroup(
        array('sitename', 'sitedecription', 'message', 'status', 'editor', 
        'defaultlimit','save','cancel','help'), 'config', array('legend' => 'Site Setting'));
    }
}
?>