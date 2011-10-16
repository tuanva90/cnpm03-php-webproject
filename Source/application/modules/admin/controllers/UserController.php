<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Admin_UserController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	//Paging parameters
	protected $_paginator = array ('itemCountPerPage' => 5, 'pageRange' => 3 );
	
	protected $_namespace;
	
	public function init() {
		//Mang tham so nhan duoc o moi Action
		$this->_arrParam = $this->_request->getParams ();
		
		//Duong dan cua Controller
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		//Duong dan cua Action chinh		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
		
		$this->_paginator ['currentPage'] = $this->_request->getParam ( 'page', 1 );
		$this->_arrParam ['paginator'] = $this->_paginator;
		
		//Luu cac du lieu filter vao SESSION
		//Dat ten SESSION
		$this->_namespace = $this->_arrParam ['module'] . '-' . $this->_arrParam ['controller'];
		$filter = new Zend_Session_Namespace ( $this->_namespace );
		//$filter->unsetAll();
		if (empty ( $filter->col )) {
			$filter->filter_username = '';
			$filter->col = 'u.user_id';
			$filter->order = 'DESC';
			$filter->user_group_id = 0;
		}
		$this->_arrParam ['filter'] ['filter_username'] = $filter->filter_username;
		$this->_arrParam ['filter'] ['col'] = $filter->col;
		$this->_arrParam ['filter'] ['order'] = $filter->order;
		$this->_arrParam ['filter'] ['user_group_id'] = $filter->user_group_id;
		
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
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
	
	public function filterAction() {
		$filter = new Zend_Session_Namespace ( $this->_namespace );
		
		if ($this->_arrParam ['type'] == 'search') {
			if ($this->_arrParam ['key'] == 1) {
				$filter->filter_username = trim ( $this->_arrParam ['filter_username'] );
			} else {
				$filter->filter_username = '';
			}
		}
		
		if ($this->_arrParam ['type'] == 'group') {
			$filter->user_group_id = $this->_arrParam ['user_group_id'];
		}
		
		if ($this->_arrParam ['type'] == 'order') {
			$filter->col = $this->_arrParam ['col'];
			$filter->order = $this->_arrParam ['by'];
		}
		
		$this->_redirect ( $this->_actionMain );
		$this->_helper->viewRenderer->setNoRender ();
	}
	
	public function statusAction() {
		$tblUser = new Admin_Model_User ();
		$tblUser->changeStatus ( $this->_arrParam );
		$this->_redirect ( $this->_actionMain );
		$this->_helper->viewRenderer->setNoRender ();
	}
	
	public function addAction() {
		
		$this->view->Title = 'Member :: User manager :: Add new';
		$this->view->headTitle ( $this->view->Title, true );
		
		$group = new Admin_Model_UserGroup ();
		$this->view->group = $group->itemInSelectbox ();
		
		if ($this->_request->isPost ()) {
			//$validator = new Default_Form_ValidateUser($this->_arrParam);
			//if($validator->isError() == true){				
			//	$this->view->messageError = $validator->getMessageError();
			//	$this->view->Item = $validator->getData();
			

			//}else{
			$user = new Admin_Model_User ();
			//	$arrParam = $validator->getData(array('upload'=>true));				
			$user->saveItem ( $this->_arrParam, array ('task' => 'add' ) );
			$this->_redirect ( $this->_actionMain );
		
		//}
		}
	
	}
	
	public function infoAction() {
		$this->view->Title = 'Member :: User manager :: Information';
		$this->view->headTitle ( $this->view->Title, true );
		$user = new Admin_Model_User ();
		$this->view->Item = $user->getItem ( $this->_arrParam, array ('task' => 'info' ) );
	
	}
	
	public function editAction() {
		$this->view->Title = 'Member :: User manager :: Edit';
		$this->view->headTitle ( $this->view->Title, true );
		
		$group = new Admin_Model_UserGroup ();
		$this->view->group = $group->itemInSelectbox ();
		
		$user = new Admin_Model_User ();
		$this->view->Item = $user->getItem ( $this->_arrParam, array ('task' => 'info' ) );
		
		if ($this->_request->isPost ()) {
			//$validator = new Default_Form_ValidateUser ( $this->_arrParam );
			//if ($validator->isError () == true) {
				//$this->view->messageError = $validator->getMessageError ();
				//$this->view->Item = $validator->getData ();
			
			//} else {
				$user = new Admin_Model_User ();
				//$arrParam = $validator->getData ( array ('upload' => true ) );
				$user->saveItem ( $this->_arrParam, array ('task' => 'edit' ) );
				$this->_redirect ( $this->_actionMain );
			//}
		}
	
	}
	
	public function deleteAction() {
		$this->view->Title = 'Member :: User manager :: Delete';
		$this->view->headTitle ( $this->view->Title, true );
		if ($this->_request->isPost ()) {
			$user = new Admin_Model_User ();
			$user->deleteItem ( $this->_arrParam, array ('task' => 'delete' ) );
			$this->_redirect ( $this->_actionMain );
		}
	}
	
	public function multiDeleteAction() {
		
		if ($this->_request->isPost ()) {
			$tblUser = new Admin_Model_User ();
			$tblUser->deleteItem ( $this->_arrParam, array ('task' => 'multi-delete' ) );
			$this->_redirect ( $this->_actionMain );
		}
		$this->_helper->viewRenderer->setNoRender ();
	}
	
	/**
	 * Check user exist or not
	 * 
	 * @return void
	 */
	public function checkAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request   = $this->getRequest();
		$checkType = $request->getParam('check_type');
		$original  = $request->getParam('original');
		$value 	   = $request->getParam($checkType);
				
		if ($original == null || ($original != null && $value != $original)) {
			$user = new Admin_Model_User();
			$result = $user->checkExist($checkType, $value);
		}			
		($result == true) ? $this->getResponse()->setBody('false') 
						  : $this->getResponse()->setBody('true');
	}

}