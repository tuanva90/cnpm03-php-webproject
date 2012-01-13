<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Admin_CategoryController extends Honey_Controller_Action {
	
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
		
		$this->view->Title = 'Category';
		$this->view->headTitle ( $this->view->Title, true );
		
		$category = new Admin_Model_Category ();
		$this->view->Items = $category->listItem ( $this->_arrParam, array ('task' => 'list' ) );
		
	}
	
	public function statusAction() {
		$status = new Admin_Model_Category ();
		$status->changeStatus( $this->_arrParam );
		$this->_redirect ( $this->_actionMain );
		$this->_helper->viewRenderer->setNoRender ();
	}
	
	public function addAction() {
		
		$this->view->Title = 'Category';
		$this->view->headTitle ( $this->view->Title, true );
		
		$category = new Admin_Model_Category ();
		$this->view->categories = $category->listItem ( array(), array ('task' => 'list' ) );
		$this->view->languages = Honey_Config::getConfig ()->localization->languages->details;
				
		if ($this->_request->isPost ()) {			
			$category->saveItem ( $this->_arrParam, array ('task' => 'add' ) );
			$this->_redirect ( $this->_actionMain );
		
		}
	
	}
	public function infoAction() {
		$this->view->Title = 'Category : Info';
		$this->view->headTitle ( $this->view->Title, true );
		$category = new Admin_Model_Category ();
		$this->view->Item = $category->getItem($this->_arrParam, array ('task' => 'info'));		
		$this->view->categories = $category->listItem ( array(), array ('task' => 'list'));
		$this->view->languages = Honey_Config::getConfig ()->localization->languages->details;
	
	}
	
	public function editAction() {
		$this->view->Title = 'Category : Edit';
		$this->view->headTitle ( $this->view->Title, true );
		
		$category = new Admin_Model_Category ();
		$this->view->Item = $category->getItem($this->_arrParam, array ('task' => 'info'));		
		$this->view->categories = $category->listItem ( array(), array ('task' => 'list'));
		$this->view->languages = Honey_Config::getConfig ()->localization->languages->details;
		
		if ($this->_request->isPost ()) {
			$category->saveItem ( $this->_arrParam, array ('task' => 'edit' ) );
			$this->_redirect ( $this->_actionMain );
		}
	
	}
	
	public function deleteAction() {
		$this->view->Title = 'Category : Delete';
		$this->view->headTitle ( $this->view->Title, true );
		if ($this->_request->isPost ()) {
			$category = new Admin_Model_Category ();
			$category->deleteItem ( $this->_arrParam, array ('task' => 'delete' ) );
			$this->_redirect ( $this->_actionMain );
		}
	}

}