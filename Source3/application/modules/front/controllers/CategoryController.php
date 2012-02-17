<?php
class CategoryController extends Honey_Controller_Action {
	
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
		$model = new Front_Model_Category();
		$this->view->items = $model->listItem(null, array('task'=>'listall'));
	}
	
	public function newAction() {
		$this->_helper->layout()->disableLayout();
	}
	
	public function editAction() {
		$this->_helper->layout()->disableLayout();
		$model = new Front_Model_Category();
		$this->view->item = $model->getItem(array('category_id' => $_POST['id']), array('task' => 'edit'));
	}
	
	public function deleteAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		try {
	  		$model = new Front_Model_Category();
	  		$option ['task'] = 'delete';
	  		$parram['category_id'] = $_POST['id'];
	  		$model->deleteItem($parram, $option);
  		} catch(Exception $e) {
  			echo $e->getMessage();
  		}
  		echo "finished";
	}
	
	public function saveeditAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
		try {
			$parram['category_id'] = $_POST['id'];
	  		$parram['image'] = null;
	  		$parram['parent_id'] = '0';
	  		$parram['sort_order'] = '0';
	  		$parram['status'] = '1';
	  		$parram['category_description']['vi_VN']['name'] = $_POST['name'];
	  		$parram['category_description']['vi_VN']['meta_keywords'] = "";
	  		$parram['category_description']['vi_VN']['meta_description'] = "";
	  		$parram['category_description']['vi_VN']['description'] = "";
	  		$model = new Front_Model_Category();
	  		$model->saveItem($parram, array('task'=>'edit'));
  		} catch(Exception $e) {
  			echo $e->getMessage();
  		}
	}
	
	public function savenewAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
		try {
	  		$parram['image'] = null;
	  		$parram['parent_id'] = '0';
	  		$parram['sort_order'] = '0';
	  		$parram['status'] = '1';
	  		$parram['category_description']['vi_VN']['name'] = $_POST['name'];
	  		$parram['category_description']['vi_VN']['meta_keywords'] = "";
	  		$parram['category_description']['vi_VN']['meta_description'] = "";
	  		$parram['category_description']['vi_VN']['description'] = "";
	  		$model = new Front_Model_Category();
	  		$model->saveItem($parram, array('task'=>'add'));
  		} catch(Exception $e) {
  			echo $e->getMessage();
  		}
	}
}