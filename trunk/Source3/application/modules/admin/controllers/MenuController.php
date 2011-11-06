<?php
class Admin_MenuController extends Honey_Controller_Action
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
    public function menuitemeditAction ()
    {
        /* Code */
    }
    public function menumanagerAction ()
    {
        /* Code */
    }
    public function menutrashAction ()
    {
        /* Code */
    }
    public function menucopyAction ()
    {
        /* Code */
    }
    public function menueditAction ()
    {
        /* Code */
    }
    public function menunewAction ()
    {
        /* Code */
    }
    public function menuitemmanagerAction ()
    {
        /* Code */
    }
    public function menuitemnewselecttypeAction ()
    {
        $form = new Admin_Form_MenuNewSelectType();
        $this->view->form = $form;
    }
    public function menuitemnewAction ()
    {
        $form = new Admin_Form_MenuItemNew();
        $this->view->form = $form;
    }
}