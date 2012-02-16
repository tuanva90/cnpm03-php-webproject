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
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );
		
	}
	
	public function indexAction() {
		
		

	}
	
	public function detailAction() {
		
		}

}