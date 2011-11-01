<?php
class Admin_MediaController extends Honey_Controller_Action
{
    public function init ()
    {
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
    }
    public function indexAction()
    {
        // action body
    }      
    public function frameAction()
    {    	
    }
    
    
}