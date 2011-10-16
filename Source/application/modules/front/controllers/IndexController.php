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
		
		/** Set the initial stylesheet: */
		$this->view->headLink ( array ('rel' => 'shortcut icon', 'href' => HTTP_IMAGES . '/logo/favicon.png' ), 'PREPEND' );
		$this->view->headLink ( array ('rel' => 'canonical', 'href' => 'http://' ) );
		
		//$config = Honey_Config::getConfig ();
		//print_r ( $config->web->name );
		
		$products = new Front_Model_Catalog_Product ();
		
		$this->view->products = $products->getProducts();
	

	}
	
	public function viewAction() {
	
	}

}