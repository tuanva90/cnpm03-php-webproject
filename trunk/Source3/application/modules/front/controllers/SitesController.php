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
		
		if(!isset($this->_arrParam['category_id'])) 
		    $this->_arrParam['category_id'] = 1;
		
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';

		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );
		
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
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
		$this->view->main = $module_model->getItemByName("Main");
	}
	
	public function savenewAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		try {
	  		if(isset($_POST)) {
	  			$order = $_POST['order'];
	  			$name = $_POST['name'];
	  			$content = $_POST['content'];
	  			$new_order = null;
	  			
	  			//Turn $order's item type from "li00" to "00"
	  			foreach($order as $item) {
	  				$new_order[] = substr($item, 2);
	  			}
	  			
	  			//Save to database
	  			$site_model = new Front_Model_Sites();
	  			$site_model->newSite($name, $content, $new_order);
	  		}
  		} catch(Exception $e) {
  			echo "Error: " . $e->getMessage();
  		}
	}
	
	public function editAction() {
		$this->_helper->layout()->disableLayout();
		$module_model = new Front_Model_Module();
		$site_model = new Front_Model_Sites();
		$this->view->site = $site_model->getItem($_POST['id']);
		$this->view->selected_module = $module_model->getItemBySite($_POST['id']);
		$this->view->modules = $module_model->listAllItem();
		$this->view->main = $module_model->getItemByName("Main");
	}
	
	public function saveeditAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		try {
	  		if(isset($_POST)) {
	  			$id = $_POST['id'];
	  			$order = $_POST['order'];
	  			$name = $_POST['name'];
	  			$content = $_POST['content'];
	  			$new_order = null;
	  			
	  			//Turn $order's item type from "li00" to "00"
	  			foreach($order as $item) {
	  				$new_order[] = substr($item, 2);
	  			}
	  			
	  			//Save to database
	  			$site_model = new Front_Model_Sites();
	  			$site_model->editSite($id, $name, $content, $new_order);
	  		}
  		} catch(Exception $e) {
  			echo "Error: " . $e->getMessage();
  		}
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
	
	public function viewAction() {
		$site_model = new Front_Model_Sites();
		$module_model = new Front_Model_Module();
		$this->view->item = $site_model->getItem($this->_arrParam['id']);
		$this->view->modules = $module_model->getItemBySite($this->_arrParam['id']);
	}
}