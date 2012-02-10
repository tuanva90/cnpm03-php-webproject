<?php
class MenuController extends Honey_Controller_Action {
	
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

		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );
	}
	
	public function indexAction() {
		$this->_helper->layout()->disableLayout();
		
		$menu_model = new Front_Model_Menu();
		$menu = $menu_model->listAllItem(null);
		$this->view->items = $menu['children'];
		$this->view->last = $menu_model->getLastOrder(0);
	}
	
	public function newAction() {
		$this->_helper->layout()->disableLayout();
	}
	
	public function deleteAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		
  		if(isset($_POST['id'])) {
  			$id = $_POST['id'];
  			$model = new Front_Model_Menu();
  			$model->deleteMenu($id);
  		}
	}
	
	public function editAction() {
		$this->_helper->layout()->disableLayout();
		
		$this->view->item = Front_Model_Menu::getDetailedItem($_POST['id']);
	}
	
	public function sortAction() {
		$this->_helper->layout()->disableLayout();
		$model = new Front_Model_Menu();
		$this->view->item = $model->listAllItem(null);
	}
	
	public function childsortAction() {
		$this->_helper->layout()->disableLayout();
		if(isset($_POST['parent_id']) && $_POST['parent_id'] != null) {
			$model = new Front_Model_Menu();
			$this->view->children = $model->getChildren($_POST['parent_id']);
			$this->view->parent_id = $_POST['parent_id']; 
		}
	}
	
	public function savenewAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		$menu_model = new Front_Model_Menu();
  		$menu_model->newMenu($_POST);
	}
	
	public function saveeditAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		$menu_model = new Front_Model_Menu();
  		$menu_model->saveMenu($_POST);
	}
	
	public function selectpositionAction() {
		$this->_helper->layout()->disableLayout();
		
		$model = new Front_Model_Menu();
		$this->view->item = $model->listAllItem(null);
		if(isset($_POST['id']) && $_POST['id'] != null) {
			$selected = $model->getDetailedItem($_POST['id']);
			$this->view->selected = $selected;
		}
	}
	
	public function savechildpositionAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
		try{
			if(isset($_POST['order'])) {
				$menu_model = new Front_Model_Menu();
				$menu_model->saveOrder($_POST['order']);
			}
			echo "finished";
		} catch(Exception $ex) {
			echo "Error:".$ex->getMessage();
		}
	}
	
	public function selectlinkAction() {
		$this->_helper->layout()->disableLayout();
	}
}