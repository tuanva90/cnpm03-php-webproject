<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Admin_ProductsController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	public function init() {
//		$this->_arrParam = $this->_request->getParams ();		
//		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];		
//		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
				
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
		/** Set the initial stylesheet: */
		$this->view->headLink ( array ('rel' => 'shortcut icon', 'href' => HTTP_IMAGES . '/logo/favicon.png' ), 'PREPEND' );
	
	}
	
	public function indexAction() {
		$model = new Admin_Model_Products();
		$products = $model->getProducts();
		$this->view->products = $products[''];	

	}
	
	public function productnewAction(){		
	}
	public function producteditAction(){
	}
}