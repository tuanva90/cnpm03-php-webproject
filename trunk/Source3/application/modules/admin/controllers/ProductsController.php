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
		$this->view->headScript()->appendFile(HTTP_PUBLIC.'/javascript/cms-jquery.js');
		
	}
	
	public function indexAction() {
			$products = new Admin_Model_Products();	
		$data=$products->GetProducts();
		
		//////////////////////////////////////////////////
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($data));
		
		$currentPage=isset($_GET['page'])?(int)htmlentities($_GET['page']):1;
		$paginator->setCurrentPageNumber($currentPage);
		
		$itemPerPage=isset($_POST['counter'])?(int)htmlentities($_GET['counter']):4;
		$paginator->setItemCountPerPage($itemPerPage);
		$paginator->setPageRange(3);
		$page=$paginator->getPages('Sliding');
        $pageLink = array();
        $seperator = '|';
        $q = http_build_query(
        array('page' => $page->first, 'counter' => $itemPerPage));
        $pageLink[] = "<a href=\"?$q\">Trang đầu</a>";
        if (! empty($page->previous)) {
            $q = http_build_query(
            array(
    								'page'=>$page->previous,
    								'counter'=>$itemPerPage));
			$pageLink[]= "<a href=\"?$q\"><</a>";
		}
		foreach ($page->pagesInRange as $x)
		{
			if($x==$page->current)
			{
				$pageLink[]=$x;
			}
			else 
			{
				$q=http_build_query(array(
    								'page'=>$x,
    								'counter'=>$itemPerPage));
				$pageLink[]= "<a href=\"?$q\">$x</a>";
			}
		}
		
		if(!empty($page->next))
		{
			$q=http_build_query(array(
    								'page'=>$page->next,
    								'counter'=>$itemPerPage));
			$pageLink[]= "<a href=\"?$q\">></a>";
		}
		
		$q=http_build_query(array(
    								'page'=>$page->last,
    								'counter'=>$itemPerPage));
		$pageLink[]= "<a href=\"?$q\">Trang cuối</a>";
		
		$this->view->pageLink=$pageLink;
		$this->view->seperator=$seperator;
		$this->view->products = $paginator;
	}
	public function deleteAction(){
    	$id = $this->_request->getParam('id');
    	$this->view->id=$id;
    	$products = new Admin_Model_Products();	
    	$products->DeleteProduct($id);
    }
	public function updateAction(){
    	$id = $this->_request->getParam('id');
    	$this->view->id=$id;
    }
    
    /**
     * productnewAction
     * Excute action for productnewController.
     * Edited by: HuyNVK
     * Modified Date: 14/11/2011
     * Modified Content: Add Body for Function.
     */
    public function productnewAction () {
        //Create an Admin_Form_ProductNew()
        $form = new Admin_Form_ProductNew();
        $style_error = '<p style="background:#FF0000; text-align: center; padding: 3px;">';
        $style_success = '<p style="background:#33CC66; text-align: center; padding: 3px;">';
        $message = '';
        
        if ($this->_request->isPost()) {
            if ($form->isValid($_POST)) {
            	//Get value posted
            	$result = $form->getValues();
            	$name = $result['name'];
                $description = $result['description'];
                $catalog = $result['catalog'];
                $model = $result['model'];
                $image = $result['image'];
                $price = $result['price'];
                $order = $result['order'];
                //$status = $result['status'];
                $status = 1;
                //Check whether the values is valid or not
                if($name == "") {
                	$message = $style_error . 'ChÆ°a nháº­p tĂªn sáº£n pháº©m.</p>';
                } else if($description == "") {
                	$message = $style_error . 'ChÆ°a nháº­p mĂ´ táº£ sáº£n pháº©m.</p>';
                } else if($model == "") {
                	$message = $style_error . 'ChÆ°a nháº­p model sáº£n pháº©m.</p>';
                } else if($price == "") {
                	$message = $style_error . 'ChÆ°a nháº­p giĂ¡ sáº£n pháº©m.</p>';
                } else {
	                
                	//Insert data to database
	                $productModel = new Admin_Model_Products();
	                $now1 = date ( "Y-m-d " );
	                $now = date ( "Y-m-d H:i:s" );
	                $viewed = 1;
	                $quantity =2;
	            //$productModel->InsertProduct($model,$quantity, $image, $price, $now1,$status, $now, $now, $viewed, $order );
	                	              
                	//Show message
	                $message = $style_success . 'Ä�Ă£ thĂªm '.$name.' vĂ o cÆ¡ sá»Ÿ dá»¯ liá»‡u</p>';
	                
                	
                	
	                //Test data
	                $message = $style_success . 'Name: ' . $name . '<br/>';
	                $message = $message . 'Description: ' . $description . '<br/>';
	                $message = $message . 'Catalog: ' . $order . '<br/>';
	                $message = $message . 'Model: ' . $model . '<br/>';
	                $message = $message . 'Image: ' . $image . '<br/>';
	                $message = $message . 'Price: ' . $price . '<br/>';
	                $message = $message . 'Order: ' . $now1 . '<br/>';
	                $message = $message . 'Status: ' . $status . '<br/>';
	                
                }
            } else {
                $message = $style_error . 'An Error Occurred.</p>';
            }
        }
        
        $this->view->note = $message;
        $this->view->form = $form;
    }
    public function editAction ()    
    {
        $p_id = $this->_request->getParam('id');
        $form = new Admin_Form_ProductEdit();
        
        $p_model = new Admin_Model_Products();
        $p_item = $p_model->getProduct_item($p_id);
        $form->setValue($p_item);
        
        $style_error = '<p style="background:#FF0000; text-align: center; padding: 3px;">';
        $style_success = '<p style="background:#33CC66; text-align: center; padding: 3px;">';
        $message = '';
        if ($this->_request->isPost()) {
            if ($form->isValid($_POST)) {
            	//Get value posted
            	$value = $form->getValues();
            	$name = $value['name'];
                $description = $value['description'];
                $catalog = $value['catalog'];
                $model = $value['model'];
                $image = $value['image'];
                $price = $value['price'];
                $order = $value['order'];
                $status = $value['status'];
                $value['date_added']='12345';
                //Check whether the values is valid or not
                if($name == "") {
                	$message = $style_error . 'Chưa nhập tên sản phẩm</p>';
                } else if($description == "") {
                	$message = $style_error . 'Chưa nhập mô tả sản phẩm.</p>';
                } else if($model == "") {
                	$message = $style_error . 'Chưa nhập Model sản phẩm.</p>';
                } else if($price == "") {
                	$message = $style_error . 'Chưa nhập giá sản phẩm.</p>';
                } else {       	
	                //Test data
	                $message = $style_success . 'Name: ' . $name . '<br/>';
	                $message = $message . 'Catalog: ' . $catalog . '<br/>';
	                $message = $message . 'Model: ' . $model . '<br/>';
	                $message = $message . 'Image: ' . $image . '<br/>';
	                $message = $message . 'Price: ' . $price . '<br/>';
	                $message = $message . 'Order: ' . $order . '<br/>';
	                $message = $message . 'Status: ' . $status . '<br/>';
	                $message = $message . 'Date_added: ' . $value['date_added'] . '<br/>';	  	        
	                //code
	                $test = $p_model->update_product2($p_id, $value);	                
                	//Show message
                	if($test){
	               		$message = $style_success . 'Đã update.</p>';
                	}else{
                		$message = $style_success . 'Error.</p>';
                	}               
                }
            } else {
                $message = $style_error . 'An Error Occurred.</p>';
            }
        }
        $this->view->p_name = $p_item['name'];
        $this->view->note = $message;
        $this->view->form = $form;
    }
}