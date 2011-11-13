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
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
		/** Set the initial stylesheet: */
		$this->view->headLink ( array ('rel' => 'shortcut icon', 'href' => HTTP_IMAGES . '/logo/favicon.png' ), 'PREPEND' );
	
	}
	
	public function indexAction() {
		$products = new Admin_Model_Products();	
		$this->view->products=$products->GetProducts();
	}
	public function deleteAction(){
    	$id = $this->_request->getParam('id');
    	$this->view->id=$id;
    }
	public function updateAction(){
    	$id = $this->_request->getParam('id');
    	$this->view->id=$id;
    }
	public function productnewAction(){		
	}
	public function producteditAction(){
	}
}