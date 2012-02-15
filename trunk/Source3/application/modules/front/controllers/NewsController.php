<?php
class NewsController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	//Paging parameters
	protected $_paginator;
	
	public function init() {
		$this->_arrParam = $this->_request->getParams ();
		$this->_arrParam['user'] = 'ducnh'; 
		$this->_arrParam['date'] = date("Y-m-d H:i:s");
		
		if(!isset($this->_arrParam['category_id'])) 
		    $this->_arrParam['category_id'] = 1;
		 		
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
		
		$config = Honey_Config::getConfig ();		
		$this->_paginator = array(
			'itemCountPerPage' => $config->web->front->itemCountPerPage, 
			'pageRange' => $config->web->front->pageRange,
		);
			
		$this->_paginator['currentPage'] = $this->_request->getParam('page',1);		
		$this->_arrParam['paginator'] = $this->_paginator;
		
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );
		
	}
	
	public function indexAction() {
	    
	     
	    // Also categories view
	    $this->view->Title = 'Front :: News';
	    $this->view->headTitle = $this->view->Title;
	    
	    // this array will contain all the data of newses that go by category_id
	    $categories = array();
	    
	    // an instance of Category class
	    $category = new Front_Model_Category();
	    // an instance of NewNews class
	    $frontnews = new Front_Model_NewNews();
	    
	    // get category_id from request
	    $category_id = $this->_arrParam['category_id'];
	    
	    // then get all the newses that has category_id = $category_id
	    $category_info = array();
	    $category_info['news'] = $frontnews->listItemByCate($category_id, array('task'=>'listbyonecate'));
	    $category_info['categoryinfo'] = $category->getItem(array('category_id'=>$this->_arrParam['category_id']),array('task'=>'info'));
	    array_push($categories, $category_info);
	    
	    // get child categories
	    $child_categories = array();
	    $child_categories = $category->getCategoriesByParentId($category_id);
	    
	    if(count($child_categories) > 0)
	    {
	    	foreach ($child_categories as $child_category)
	    	{
	    	    $child_category_info = array();
	    	    $child_category_info['news'] = $frontnews->listItemByCate($child_category, array('task'=>'listbyonecate'));
	    	    $child_category_info['categoryinfo'] = $category->getItem(array('category_id'=>$child_category),array('task'=>'info'));
	    		array_push($categories, $child_category_info);
	    	}
	    }
	    
	    $this->view->arrayItems = $categories;
	

	}
	
	public function listAction(){
		// format: list of news in a category
		$this->view->Title = 'Front :: News';
		$this->view->headTitle = $this->view->Title;
		
		$category = new Front_Model_Category();
		$frontnews = new Front_Model_NewNews();
		
		// get child categories
		$this->_arrParam['child_categories'] = $category->getCategoriesByParentId($this->_arrParam['category_id']);
		$this->view->Items = $frontnews->listItemByManyCate($this->_arrParam,array('task'=>'listbymanycate'));
		
		$totalItem = $frontnews->countItemByCate($this->_arrParam);
		$this->view->totalItem = $totalItem;
		$paginator = new Honey_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem, $this->_paginator);
	
	}
	
	public function detailAction() {
		$news = new Front_Model_NewNews();
		
		$this->view->Item = $news->getItem($this->_arrParam, array('task'=>'info'));
		$this->view->Title = 'News :: '.html_entity_decode($this->view->Item['title']);
		$this->view->headTitle($this->view->Title, true);
		
	}
	
	
	public function deleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	
		$newnews = new Front_Model_NewNews();
		$newnews->deleteItem($this->_arrParam);
	
		$_SESSION['delete_news_message'] = "Delete success!";
		$this->_helper->redirector('list', 'news', 'front');
	}
	public function addAction(){
	
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	
		$newnews = new Front_Model_NewNews();
		
		if(isset($this->_arrParam['add_news_id']))
			$newnews->saveItem($this->_arrParam, array('task'=>'add'));
		else $newnews->saveItem($this->_arrParam, array('task'=>'addnew'));
		$_SESSION['add_news_message'] = "Add news success!";
	
		$this->_helper->redirector('list','news', 'front');
		//$this->view->whatuget = stripslashes($_POST['description']);
	}
	public function saveAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	
		$newnews = new Front_Model_NewNews();
		
		$newnews->saveItem($this->_arrParam, array('task'=>'edit'));
		$_SESSION['edit_news_message'] = "Edit news success!";
	
		$this->_helper->redirector('list','news', 'front');
	}
	
	public function editsummaryAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$news = new Front_Model_NewNews();
		
		$news->saveItem($this->_arrParam, array('task'=>'edit_summary'));
		
		$_SESSION['edit_news_message'] = "Edit news success!";
	
		$this->_helper->redirector('list','news', 'front');
	}
	
	public function changeeditmodeAction()
	{
	    $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
	    session_start();
	    if(isset($_SESSION['EditMode']))
	    {
	        if($_SESSION['EditMode'] == 'ON')
	            $_SESSION['EditMode'] = 'OFF';
	        else $_SESSION['EditMode'] = 'ON';
	    }
	    else{
	        $_SESSION['EditMode'] = 'OFF';
	    }
	    
	    // redirect to request page;
	    $back = $_SESSION['back'];
	    unset($_SESSION['back']);
	    header("location: $back");
	}
	
	public function markhotnewsAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
	}
}