<?php
class Admin_IndexController extends Honey_Controller_Action
{
    public function init ()
    {
        /* Layout */
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
        /* Get Params*/
        $this->_arrParam = $this->_request->getParams();
        $this->_module = $this->_arrParam['module'];
        $this->_controller = $this->_arrParam['controller'];
        $this->_action = $this->_arrParam['action'];
        //debug
        $this->view->curent = $this->_module . '/' . $this->_module . '/' .
         $this->_action;
    }
    public function indexAction ()
    {
        /* Code */
    }
}