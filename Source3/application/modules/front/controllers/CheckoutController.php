<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class CheckoutController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
		
	//Paging parameters
	protected $_paginator;
	
	protected $_namespace;
		
	public function init() {
		$this->_arrParam = $this->_request->getParams ();
		
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';

		$config = Honey_Config::getConfig ();		
		$this->_paginator = array(
			'itemCountPerPage' => $config->web->front->itemCountPerPage, 
			'pageRange' => $config->web->front->pageRange,
		);
			
		$this->_paginator['currentPage'] = $this->_request->getParam('page',1);		
		$this->_arrParam['paginator'] = $this->_paginator;
		
		//Luu cac du lieu filter vao SESSION
		//Dat ten SESSION
		$this->_namespace = $this->_arrParam['module'] . '-' . $this->_arrParam['controller'];
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		//$ssFilter->unsetAll();
		if(empty($ssFilter->col)){
			$ssFilter->keywords 	= '';
		}
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );		
	}
	
	public function additemAction(){				
		$yourCart = new Zend_Session_Namespace('cart');		
		$ssInfo = $yourCart->getIterator();		
		$filter = new Zend_Filter_Digits();
		$id = $filter->filter($this->_arrParam['id']);			
		if(count($yourCart->cart) == 0){			
			$cart[$id] = 1;
			$yourCart->cart = $cart;
		} else {
			//echo '<br>Trong gio hang da co san pham';
			$tmp = $ssInfo['cart'];
			if(array_key_exists($id,$tmp) == true){
				$tmp[$id] = $tmp[$id] + 1;
			}else{
				$tmp[$id] = 1;
			}			
			$yourCart->cart = $tmp;			
		}		
		$this->_redirect($this->_currentController . '/cart');
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function cartAction(){
		$yourCart = new Zend_Session_Namespace('cart');	

		if($this->_request->isPost()){
			$itemProduct = $this->_arrParam['itemProduct'];			
			if(count($itemProduct)>0)
				foreach($itemProduct as $key => $val){
					if($val == 0 ){
						unset($itemProduct[$key]);
				}
			}			
			$yourCart->cart = $itemProduct;
		}		
		$ssInfo = $yourCart->getIterator();
		
		if(empty($ssInfo['cart'])){
			$this->_redirect('/product/');
		}
		
		$tblProduct = new Front_Model_Product();
		$this->_arrParam['cart'] = $ssInfo['cart'];		
		$this->view->Items = $tblProduct->listItem($this->_arrParam, array('task'=>'view-cart'));
		
		$this->view->cart =  $ssInfo['cart'];		
	}

	public function orderAction(){
		$yourCart = new Zend_Session_Namespace('cart');
			
		$ssInfo = $yourCart->getIterator();
		
		if(empty($ssInfo['cart'])){
			$this->_redirect('/product/');
		}
		
		$tblProduct = new Front_Model_Product();
		$this->_arrParam['cart'] = $ssInfo['cart'];
		
		$this->view->Items = $tblProduct->listItem($this->_arrParam, array('task'=>'view-cart'));
		$this->view->cart =  $ssInfo['cart'];
			
		if($this->_request->isPost()){
			$tblInvoice = new Front_Model_Invoice();
			$invoice_id = $tblInvoice->saveItem($this->_arrParam, array('task'=>'public-order'));			
			$tblInvoiceDetail = new Front_Model_InvoiceDetail();
			$this->_arrParam['invoice_id'] = $invoice_id;
			$tblInvoiceDetail->saveItem($this->_arrParam);
			$yourCart->unsetAll();
			$this->_redirect('/product/');
		}
	}
}