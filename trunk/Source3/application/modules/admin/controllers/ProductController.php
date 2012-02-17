<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Admin_ProductController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	//Paging parameters
	protected $_paginator;
	
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
		
		$product = new Admin_Model_Product();
		$this->view->Items = $product->listItem($this->_arrParam, array('task'=>'list'));
		$totalItem  = $product->countItem($this->_arrParam);
		
		$paginator = new Honey_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem, $this->_paginator);
	}

	public function statusAction(){
		$status = new Admin_Model_Product();		
		$status->changeStatus($this->_arrParam);
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function addAction(){
		$this->view->Title = 'Product :: Add New';
		$this->view->headTitle($this->view->Title,true);
		
		$product = new Admin_Model_Product ();
		$this->view->languages = Honey_Config::getConfig ()->localization->languages->details;
		
		if($this->_request->isPost()){
			$product->saveItem($this->_arrParam, array('task'=>'add'));
			$this->_redirect($this->_actionMain);
		}
		
	}
	
	public function infoAction(){
		$this->view->Title = 'Product :: Information';
		$this->view->headTitle($this->view->Title,true);
		
		$product = new Admin_Model_Product();
		$product->view->Item = $product->getItem($this->_arrParam, array('task'=>'info'));
		$this->view->languages = Honey_Config::getConfig ()->localization->languages->details;
	}
	
	public function editAction(){
		$this->view->Title = 'Product :: Edit';
		$this->view->headTitle($this->view->Title,true);
		
		$product = new Admin_Model_Product();
		$this->view->Item = $product->getItem($this->_arrParam, array('task'=>'info'));
		$this->view->languages = Honey_Config::getConfig ()->localization->languages->details;
		
		if($this->_request->isPost()){
			$product->saveItem($this->_arrParam, array('task'=>'edit'));
			$this->_redirect($this->_actionMain);
		}
	}

	public function deleteAction(){
		$this->view->Title = 'Product :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost()){
			$product = new Admin_Model_Product();
			$product->deleteItem($this->_arrParam,array('task'=>'delete'));
			$this->_redirect($this->_actionMain);
		}
	}
	
	public function multiDeleteAction(){
		
		if($this->_request->isPost()){
			$product = new Admin_Model_Product();
			$product->deleteItem($this->_arrParam,array('task'=>'multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
}