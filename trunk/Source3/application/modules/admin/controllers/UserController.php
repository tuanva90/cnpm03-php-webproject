<?php
class Admin_UserController extends Honey_Controller_Action
{
    public function init ()
    {
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
    }
    public function indexAction ()
    {}
    public function editAction ()
    {}
    public function newAction ()
    {}
}