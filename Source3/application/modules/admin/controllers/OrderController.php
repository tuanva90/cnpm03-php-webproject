<?php
/**
 * huydang1920@gmail.com
 */
class Admin_OrderController extends Honey_Controller_Action {
	
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
			$filter->filter_name 	= '';
			$filter->col 		= 'invoice_id';
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
		
	}
	
	public function indexAction() {
		
		$this->view->Title = 'Order :: List';
		$this->view->headTitle($this->view->Title, true);
		
		$invoice = new Admin_Model_Invoice();
		$this->view->Items = $invoice->listItem($this->_arrParam, array('task'=>'list'));
		$totalItem  = $invoice->countItem($this->_arrParam);
		
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
		$status = new Admin_Model_Invoice();		
		$status->changeStatus($this->_arrParam);
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function addAction(){
		$this->view->Title = 'Order :: Add New';
		$this->view->headTitle($this->view->Title,true);
		
		if($this->_request->isPost()){
			$group = new Admin_Model_Invoice();
			$group->saveItem($this->_arrParam, array('task'=>'add'));
			$this->_redirect($this->_actionMain);
		}
		
	}
	
	public function infoAction(){
		$this->view->Title = 'Order :: Information';
		$this->view->headTitle($this->view->Title,true);
		
		$invoice = new Admin_Model_Invoice();
		$this->view->Item = $invoice->getItem($this->_arrParam, array('task'=>'info'));
		
		$invoiceDetail = new Admin_Model_InvoiceDetail();
		$this->view->Items = $invoiceDetail->listItem($this->_arrParam, array('task'=>'list'));
	}
	
	public function editAction(){
		$this->view->Title = 'Order :: Edit';
		$this->view->headTitle($this->view->Title,true);
		
		$invoice = new Admin_Model_Invoice();
		$this->view->Item = $invoice->getItem($this->_arrParam, array('task'=>'edit'));
		
		if($this->_request->isPost()){
			$group = new Admin_Model_Invoice();
			$group->saveItem($this->_arrParam, array('task'=>'edit'));
			$this->_redirect('/admin/order/');
		}
	}

	public function deleteAction(){
		$this->view->Title = 'Order :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost()){
			$invoice = new Admin_Model_Invoice();
			$invoice->deleteItem($this->_arrParam, array('task'=>'delete'));
			
			$invoicedetail = new Admin_Model_InvoiceDetail();
			$invoicedetail->deleteItem($this->_arrParam, array('task'=>'delete'));
			
			$this->_redirect('/admin/order/');
		}
	}
	
	public function multiDeleteAction(){
		
		if($this->_request->isPost()){
			$tblGroup = new Admin_Model_Invoice();
			$tblGroup->deleteItem($this->_arrParam,array('task'=>'multi-delete'));
			$this->_redirect('/admin/order/');
		}
		$this->_helper->viewRenderer->setNoRender();
	}
}