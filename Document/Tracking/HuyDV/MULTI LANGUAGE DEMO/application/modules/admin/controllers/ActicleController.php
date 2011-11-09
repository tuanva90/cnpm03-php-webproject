<?php
class Admin_ActicleController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	protected $_namespace;
	
	public function init() {
		//Mang tham so nhan duoc o moi Action
		$this->_arrParam = $this->_request->getParams ();
		
		//Duong dan cua Controller
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		//Duong dan cua Action chinh		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
				
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
	}
	
	public function indexAction() {		
		$this->view->Title = 'Acticle : Acticle Manager : List';
		$this->view->headTitle ( $this->view->Title, true );
		
		/*
		 * code kết nối mode lấy dữ liệu 
		 * và truyền tham số ra view
		 * 
		 */
		
	}
	
	public function statusAction() {
		
		/* 
		 * code thao tác dữ liệu
		 */
		
		
		$this->_redirect ( $this->_actionMain );
		$this->_helper->viewRenderer->setNoRender ();
	}
	
	public function addAction() {
		
		$this->view->Title = 'Acticle : Acticle Manager : Add';
		$this->view->headTitle ( $this->view->Title, true );
		
		/*
		 * code kết nối mode lấy dữ liệu 
		 * và truyền tham số ra view
		 * 
		 */
				
		if ($this->_request->isPost ()) {
						
			/* 
			 * code thao tác dữ liệu
			 */
			
			$this->_redirect ( $this->_actionMain );
		
		}
	
	}
	public function infoAction() {
		$this->view->Title = 'Acticle : Acticle Manager : Info';
		$this->view->headTitle ( $this->view->Title, true );
		
		/*
		 * code kết nối mode lấy dữ liệu 
		 * và truyền tham số ra view
		 * 
		 */
	
	}
	
	public function editAction() {
		$this->view->Title = 'Acticle : Acticle Manager : Edit';
		$this->view->headTitle ( $this->view->Title, true );
		
		/*
		 * code kết nối mode lấy dữ liệu 
		 * và truyền tham số ra view
		 * 
		 */
		
		if ($this->_request->isPost ()) {
			/* 
			 * code thao tác dữ liệu
			 */
			
			$this->_redirect ( $this->_actionMain );
		}
	
	}
	
	public function deleteAction() {
		$this->view->Title = 'Acticle : Acticle Manager : Delete';
		$this->view->headTitle ( $this->view->Title, true );
		
		if ($this->_request->isPost ()) {
			/* 
			 * code thao tác dữ liệu
			 */
			$this->_redirect ( $this->_actionMain );
		}
	}

}