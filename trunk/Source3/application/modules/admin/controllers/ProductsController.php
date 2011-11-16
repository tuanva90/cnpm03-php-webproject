<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Admin_ProductsController extends Honey_Controller_Action
{
    //Parameter array received in any Action
    protected $_arrParam;
    //The path of the Controller
    protected $_currentController;
    //The path of the Action
    protected $_actionMain;
    public function init ()
    {
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
        /** Set the initial stylesheet: */
        $this->view->headLink(
        array('rel' => 'shortcut icon', 
        'href' => HTTP_IMAGES . '/logo/favicon.png'), 'PREPEND');
    }
    public function indexAction ()
    {
        $products = new Admin_Model_Products();
        $this->view->products = $products->GetProducts();
    }
    public function deleteAction ()
    {
        $id = $this->_request->getParam('id');
        $this->view->id = $id;
    }
    public function updateAction ()
    {
        $id = $this->_request->getParam('id');
        $this->view->id = $id;
    }
    
    /**
     * productnewAction
     * Excute action for productnewController.
     * Edited by: HuyNVK
     * Modified Date: 14/11/2011
     * Modified Content: Add Body for Function.
     */
    public function productnewAction ()
    {
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
                $status = $result['status'];
                
                //Check whether the values is valid or not
                if($name == "") {
                	$message = $style_error . 'Chưa nhập tên sản phẩm.</p>';
                } else if($description == "") {
                	$message = $style_error . 'Chưa nhập mô tả sản phẩm.</p>';
                } else if($model == "") {
                	$message = $style_error . 'Chưa nhập model sản phẩm.</p>';
                } else if($price == "") {
                	$message = $style_error . 'Chưa nhập giá sản phẩm.</p>';
                } else {
	                //Insert data to database
	                $productModel = new Admin_Model_Products();
	                $now = getdate();
	                $viewed = 1;
	                //$productModel->InsertProduct($model, $image, $price, $date_available, $date_added, $date_modified, $viewed, $sort_order, $status, $nameVI, $descriptionVI);
	                $productModel->InsertProduct($model, $image, $price, $now, $now, $now, $viewed, $order, $status, $name, $description);
	                
                	//Show message
	                $message = $style_success . 'Đã thêm '.$name.' vào cơ sở dữ liệu</p>';
                }
            } else {
                $message = $style_error . 'An Error Occurred.</p>';
            }
        }
        
        $this->view->note = $message;
        $this->view->form = $form;
    }
    public function producteditAction ()
    {}
}