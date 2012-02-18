<?php
class HinhanhController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	//Paging parameters
	protected $_paginator;
	
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
		
		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );
		
	}
	
	public function indexAction() {
		$this->view->huy = '';
		if($this->_request->isPost()){
			$this->view->huy = $this->_arrParam['album'];
		}

	}
	
	public function detailAction() {
		
		}

}