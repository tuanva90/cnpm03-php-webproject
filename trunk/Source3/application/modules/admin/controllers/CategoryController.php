<?php
class Admin_CategoryController extends Honey_Controller_Action
{
    public function init ()
    {
        /* Layout */
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
    }
    public function indexAction ()
    {
        /* Code */
    }
    public function categorynewAction ()
    {}
    public function categoryeditAction ()
    {}
	public function categorymanagerAction ()
    {}
	public function frontpagemanagerAction ()
    {}
}