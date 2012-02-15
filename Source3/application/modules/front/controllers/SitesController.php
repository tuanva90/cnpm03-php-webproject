<?php
class SitesController extends Honey_Controller_Action {
	
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

		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );
		
	}
	
	public function indexAction() {
		$this->_helper->layout()->disableLayout();
		
		$model = new Front_Model_Sites();
		$sites = $model->listItem();
		$this->view->items = $sites;
	}
	
	public function newAction() {
		$this->_helper->layout()->disableLayout();
		$module_model = new Front_Model_Module();
		$this->view->modules = $module_model->listAllItem();
	}
	
	public function editAction() {
		$this->_helper->layout()->disableLayout();
		$this->view->item = Front_Model_Menu::getDetailedItem($_POST['id']);
	}
	
	public function deleteAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		
  		if(isset($_POST['id'])) {
  			$id = $_POST['id'];
  			$model = new Front_Model_Sites();
  			$model->deleteItem($id);
  		}
	}
}