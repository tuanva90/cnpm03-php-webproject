<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Db/Adapter/Mysqli.php';
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
		
		$pageLink=array();
		$seperator='|';
		
		$q=http_build_query(array(
    								'page'=>$page->first,
    								'counter'=>$itemPerPage));
		$pageLink[]= "<a href=\"?$q\">Trang đầu</a>";
		if(!empty($page->previous))
		{
			$q=http_build_query(array(
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
	public function editAction()
   {
   $params = array('host'		=>'localhost',
                'username'	=>'root',
				'password'  =>'12345',
				'dbname'	=>'source3'
               );
   $DB = new Zend_Db_Adapter_Mysqli($params);
   $request = $this->getRequest();
   $id 	 = $request->getParam("id");

   $sql = "SELECT * FROM `cms_product` WHERE product_id='".$id."'";
   $result = $DB->fetchRow($sql);
   print_r($result);
   $this->view->assign('data',$result);
   $this->view->assign('action', $request->getBaseURL()."/products/processedit");
   $this->view->assign('title','Product Editing');
   //$this->view->assign('label_name','Name');
   $this->view->assign('label_model','Model');	
   $this->view->assign('label_price','Price');	
   $this->view->assign('label_sort_order','Sort Order');
   $this->view->assign('label_submit','Edit');		
   $this->view->assign('description','Please update this form completely:');		
 }
public function processeditAction()
    {
    $params = array('host'		=>'localhost',
                'username'	=>'root',
				'password'  =>'12345',
				'dbname'	=>'cms_product'
               );
    $DB = new Zend_Db_Adapter_Mysqli($params);
    $request = $this->getRequest();
   
    $sql = "UPDATE `cms_product` SET  `model` = '".$request->getParam('model')."',
                           `price` = '".$request->getParam('price')."',
						   `sort_order` = '".$request->getParam('sort_order')."'
        WHERE product_id = '".$request->getParam('id')."'";
    $DB->query($sql);

   $this->view->assign('title','Editing Process');
   $this->view->assign('description','Editing success');  	
	
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