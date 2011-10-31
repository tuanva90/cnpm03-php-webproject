<?php
class Admin_ActicleController extends Honey_Controller_Action
{
    public function init ()
    {
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
    }
    public function indexAction ()
    {}
    public function sectionnewAction ()
    {}
    public function articlemoveAction ()
    {}
    public function sectioneditAction ()
    {}
}