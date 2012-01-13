<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Admin_LinkController extends Honey_Controller_Action {
	
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
			$filter->unsetAll();
			$filter->filter_title 	= '';
			$filter->col 		= 'l.link_id';
			$filter->order 		= 'DESC';
		}
		
		$this->_arrParam['filter']['filter_title'] 	= $filter->filter_title;
		$this->_arrParam['filter']['col'] 		= $filter->col;
		$this->_arrParam['filter']['order'] 	= $filter->order;
		
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
	}
	
	public function indexAction() {
		
		$this->view->Title = 'Link :: List';
		$this->view->headTitle($this->view->Title, true);
		
		$link = new Admin_Model_Link();
		$this->view->Items = $link->listItem($this->_arrParam, array('task'=>'list'));
		$totalItem  = $link->countItem($this->_arrParam);
		
		$paginator = new Honey_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem, $this->_paginator);
	}
	
	public function filterAction(){
		$filter = new Zend_Session_Namespace($this->_namespace);
		
		if($this->_arrParam['type'] == 'search'){
			if($this->_arrParam['key'] == 1){
				$filter->filter_title = trim($this->_arrParam['filter_title']);
			}else{
				$filter->filter_title = '';
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
		$status = new Admin_Model_Link();		
		$status->changeStatus($this->_arrParam);
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function addAction(){
		$this->view->Title = 'Link :: Add New';
		$this->view->headTitle($this->view->Title,true);
		
		$category = new Admin_Model_Category ();
		$this->view->categories = $category->listItem(array(), array('task' => 'list'));
		
		$web = new Admin_Model_LinkWeb();
		$this->view->webs = $web->listItem($this->_arrParam, array('task'=>'list'));
		
		if($this->_request->isPost()){
			$group = new Admin_Model_Link();
			$group->saveItem($this->_arrParam, array('task'=>'add'));
			$this->_redirect($this->_actionMain);
		}
		
	}
	
	public function infoAction(){
		$this->view->Title = 'Link :: Information';
		$this->view->headTitle($this->view->Title,true);
		
		$link = new Admin_Model_Link();
		$this->view->Item = $link->getItem($this->_arrParam, array('task'=>'edit'));
		$this->view->link_category = $link->getCategoriesToLinkId($this->_arrParam, array('task'=>'info'));
		
		$category = new Admin_Model_Category ();
		$this->view->categories = $category->listItem(array(), array('task' => 'list'));
		
		$web = new Admin_Model_LinkWeb();
		$this->view->webs = $web->listItem($this->_arrParam, array('task'=>'list'));
		
	}
	
	public function editAction(){
		$this->view->Title = 'Link :: Edit';
		$this->view->headTitle($this->view->Title,true);
		
		$link = new Admin_Model_Link();
		$this->view->Item = $link->getItem($this->_arrParam, array('task'=>'edit'));
		$this->view->link_category = $link->getCategoriesToLinkId($this->_arrParam, array('task'=>'info'));
		
		$category = new Admin_Model_Category ();
		$this->view->categories = $category->listItem(array(), array('task' => 'list'));
		
		$web = new Admin_Model_LinkWeb();
		$this->view->webs = $web->listItem($this->_arrParam, array('task'=>'list'));
		
		if($this->_request->isPost()){
			$group = new Admin_Model_Link();
			$group->saveItem($this->_arrParam, array('task'=>'edit'));
			$this->_redirect($this->_actionMain);
		}
	}

	public function deleteAction(){
		$this->view->Title = 'LinkCron :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost()){
			$tblGroup = new Admin_Model_Link();
			$tblGroup->deleteItem($this->_arrParam,array('task'=>'delete'));
			$this->_redirect($this->_actionMain);
		}
	}
	
	public function multiDeleteAction(){
		
		if($this->_request->isPost()){
			$tblGroup = new Admin_Model_Link();
			$tblGroup->deleteItem($this->_arrParam,array('task'=>'multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
}