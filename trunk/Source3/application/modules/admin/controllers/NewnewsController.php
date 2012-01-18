<?php
class Admin_NewnewsController extends Honey_Controller_Action{
	
	// parameter array received in any action
	protected $_arrParam;
	
	// the path of the controller
	protected $_currentController;
	
	// the path of the Action
	protected $_actionMain;
	
	// paging parameters
	protected $_paginator = array('itemCountPerPage' => 5, 'pageRange' => 3);
	
	// ?
	protected $_namespace;
	
	public function init(){
		// mang tham so nhan duoc o moi action
		$this->_arrParam = $this->_request->getParams();
		$this->_arrParam['user'] = 'ducnh'; 
		$this->_arrParam['date'] = date("m-d-Y H:i:s");

		// Duong dan cua Controller;
		$this->_currentController = '/'.$this->_arrParam['module'].'/'.$this->_arrParam['controller'];
		
		// Duong dan cua Action chinh
		$this->_actionMain = '/'.$this->_arrParam['module'].'/'.$this->_arrParam['controller'].'/'.'index';
		
		// config
		$config = Honey_Config::getConfig();
		
		// set paginator parameters
		$this->_paginator['itemCountPerPage'] = $config->web->front->itemCountPerPage;
		$this->_paginator['pageRange'] = $config->web->front->pageRange;
		// get paginator parameters
		$this->_paginator['currentPage'] = $this->_request->getParam('page',1);
		$this->_arrParam['paginator'] = $this->_paginator;
		
		
		// Luu cac du lieu filter vao SESSION
		// Dat ten SESSION
		
		
		/**
		 * View
		 */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout = 'index';
		$layoutPath = APPLICATION_PATH.'/templates/admin/default';
		$this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
		
	}
	
	public function indexAction(){
		$this->view->Title = 'Admin :: News';
		$this->view->headTitle = $this->view->Title;
		
		$adminnews = new Admin_Model_NewNews();
		$this->view->Items = $adminnews->listItem($this->_arrParam, array('task'=>'list'));
		
		$totalItems = $adminnews->countItem($this->_arrParam);
		$paginator = new Honey_Paginator();
		$this->view->paginator = $paginator->createPaginator($totalItems, $this->_paginator);
		
		// 
		$this->view->testparam = $this->_arrParam;
	}
	public function deleteAction(){
		// $this->_arrParam['news-remove'] = $this->_request->getPost('news-remove');
		// get news-id for delete action
		$this->_arrParam['news-id'] = $this->_request->getPost('news-id');
		
		$adminews = new Admin_Model_NewNews();
		$adminews->deleteItem($this->_arrParam);
		
		$_SESSION['delete_news_message'] = "Delete success!";
		$this->_helper->redirector('index', 'newnews', 'admin');
	}
	public function saveAction(){
		$adminnews = new Admin_Model_NewNews();
		if ($this->_arrParam['save-news-id'] == ""){
			$adminnews->saveItem($this->_arrParam, array('task'=>'add'));
			$_SESSION['add_news_message'] = "Add news success!";
		}
		else{
			$adminnews->saveItem($this->_arrParam, array('task'=>'edit'));
			$_SESSION['edit_news_message'] = "Edit news success!";
		}
		
		$this->_helper->redirector('index','newnews', 'admin');
	}
	public function uploadAction(){
		$adminnews = new Admin_Model_NewNews();
		$this->view->testresult = $adminnews->testfunction();
	}
}