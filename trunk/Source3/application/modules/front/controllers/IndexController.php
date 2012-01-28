<?php
class IndexController extends Honey_Controller_Action {
	
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
		

	}

	public function saveblockAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		
  		$info = array(	"module_id" => $_POST['module_id'], 
						"name" 		=> $_POST['name'],
						"file_name" => $_POST['file_name'],
  						"is_showed"	=> $_POST['is_showed'],
  						"position"	=> $_POST['position'],
  						"sort_order"=> $_POST['sort_order'],
  						"option"	=> $_POST['option']
  		);
  		
  		$modules = new Front_Model_Module();
  		$modules->updateItem($info);
  		
		echo json_encode($info);
	}
}