<?php
class Admin_UserController extends Honey_Controller_Action
{
    public function init ()
    {
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
    }
    public function indexAction (){
    	
    }
    public function editAction ()
    {}
    public function newAction ()
    {}
	public function managerAction()
    {
    	$this->view->Title = 'Member :: User manager :: List';
		$this->view->headTitle ( $this->view->Title, true );
		
		$user = new Admin_Model_User ();
		$this->view->Items = $user->listItem ( $this->_arrParam, array ('task' => 'list' ) );
		
		$group = new Admin_Model_UserGroup ();
		$this->view->group = $group->itemInSelectbox ();
		
		$totalItem = $user->countItem ( $this->_arrParam );
		
		$paginator = new Honey_Paginator ();
		$this->view->panigator = $paginator->createPaginator ( $totalItem, $this->_paginator );
    }
}