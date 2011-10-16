<?php
/**
 * huydang1920@gmail.com
 */
class Admin_UserPermissionController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	//Paging parameters
	protected $_paginator;
	
	protected $_namespace;
	
	public function init() {
		$this->_arrParam = $this->_request->getParams ();
		
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
		
		$config = Honey_Config::getConfig ();		
		$this->_paginator = array(
			'itemCountPerPage' => $config->web->admin->itemCountPerPage, 
			'pageRange' => $config->web->admin->pageRange,
		);		
		$this->_paginator['currentPage'] = $this->_request->getParam('page',1);		
		$this->_arrParam['paginator'] = $this->_paginator;
		
		//Luu cac du lieu filter vao SESSION
		//Dat ten SESSION
		$this->_namespace = $this->_arrParam['module'] . '-' . $this->_arrParam['controller'];
		$filter = new Zend_Session_Namespace($this->_namespace);
		//$filter->unsetAll();
		if(empty($filter->col)){
			$filter->filter_name 	= '';
			$filter->col 		= 'ug.user_group_id';
			$filter->order 		= 'ASC';
		}
		$this->_arrParam['filter']['filter_name'] 	= $filter->filter_name;
		$this->_arrParam['filter']['col'] 		= $filter->col;
		$this->_arrParam['filter']['order'] 	= $filter->order;
		
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
		
		$this->view->Title = 'Member :: Group manager :: List';
		$this->view->headTitle($this->view->Title, true);
		
		$groups = new Admin_Model_UserGroup();
		$this->view->Items = $groups->listItem($this->_arrParam, array('task'=>'list'));
		$totalItem  = $groups->countItem($this->_arrParam);
		
		$paginator = new Honey_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem, $this->_paginator);
	}
	
	public function filterAction(){
		$filter = new Zend_Session_Namespace($this->_namespace);
		
		if($this->_arrParam['type'] == 'search'){
			if($this->_arrParam['key'] == 1){
				$filter->filter_name = trim($this->_arrParam['filter_name']);
			}else{
				$filter->filter_name = '';
			}
		}
		
		if($this->_arrParam['type'] == 'order'){
			$filter->col = $this->_arrParam['col'];
			$filter->order = $this->_arrParam['by'];
		}
	
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}

	public function statusAction(){
		$status = new Admin_Model_UserGroup();		
		$status->changeStatus($this->_arrParam);
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function addAction(){
		$this->view->Title = 'Member :: Group manager :: Add New';
		$this->view->headTitle($this->view->Title,true);
		
		if($this->_request->isPost()){
			$group = new Admin_Model_UserGroup();
			$group->saveItem($this->_arrParam, array('task'=>'add'));
			$this->_redirect($this->_actionMain);
		}
		
	}
	
	public function infoAction(){
		$this->view->Title = 'Member :: Group manager :: Information';
		$this->view->headTitle($this->view->Title,true);
		$group = new Admin_Model_UserGroup();
		$this->view->Item = $group->getItem($this->_arrParam, array('task'=>'info'));
		
	}
	
	public function editAction(){
		$this->view->Title = 'Member :: Group manager :: Edit';
		$this->view->headTitle($this->view->Title,true);
		$group = new Admin_Model_UserGroup();
		$this->view->Item = $group->getItem($this->_arrParam, array('task'=>'edit'));
		
		if($this->_request->isPost()){
			$group = new Admin_Model_UserGroup();
			$group->saveItem($this->_arrParam, array('task'=>'edit'));
			$this->_redirect($this->_actionMain);
		}
	}

	public function deleteAction(){
		$this->view->Title = 'Member :: Group manager :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost()){
			$tblGroup = new Admin_Model_UserGroup();
			$tblGroup->deleteItem($this->_arrParam,array('task'=>'delete'));
			$this->_redirect($this->_actionMain);
		}
	}
	
	public function multiDeleteAction(){
		
		if($this->_request->isPost()){
			$tblGroup = new Admin_Model_UserGroup();
			$tblGroup->deleteItem($this->_arrParam,array('task'=>'multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function sortAction(){
		if($this->_request->isPost()){
			$tblGroup = new Admin_Model_UserGroup();
			$tblGroup->sortItem($this->_arrParam);
			$this->_redirect($this->_actionMain);
		}
		
		$this->_helper->viewRenderer->setNoRender();
	}
}