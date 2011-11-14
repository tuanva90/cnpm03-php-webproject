<?php

class Admin_TestController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	public function init() {
		$this->_arrParam = $this->_request->getParams ();		
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
				
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
		/** Set the initial stylesheet: */
		$this->view->headLink ( array ('rel' => 'shortcut icon', 'href' => HTTP_IMAGES . '/logo/favicon.png' ), 'PREPEND' );
	
	}
	
	public function indexAction() {
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
	
	public function viewtestAction(){
		$this->_helper->viewRenderer->setNoRender ();		
	}
}