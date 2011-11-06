<?php
class Admin_ArticleController extends Honey_Controller_Action
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
        $this->view->curent = $this->_module . '/' . $this->_controller . '/' .
         $this->_action;
    }

    public function indexAction ()
    {}
    public function sectionnewAction ()
    {}
    public function articlemoveAction ()
    {}
    public function sectioneditAction ()
    {}
    public function articlelistAction ()
    {
    	$this->view->form = new Admin_Form_ArticleList();    	
    }
   		
}