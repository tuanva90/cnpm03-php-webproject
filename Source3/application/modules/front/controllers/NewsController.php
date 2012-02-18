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
		date_default_timezone_set('Asia/Saigon');	
		$this->_arrParam['date'] = date("Y-m-d H:i:s");
		
		if(!isset($this->_arrParam['category_id'])) 
		    $this->_arrParam['category_id'] = 25;
		 		
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
	    
	    // get all the available categories
	    $categories_info = array();
	    $categories = $category->listItem($this->_arrParam, array('task' => 'listall'));
	    
	    if(count($categories) > 0)
	    {
	    	foreach ($categories as $cate)
	    	{
	    	    $cate_info = array();
	    	    $cate_info['news'] = $frontnews->listItemByCate($cate['category_id'], array('task'=>'listbyonecate'));
	    	    $cate_info['categoryinfo'] = $cate; 
	    	    //$category->getItem(array('category_id'=>$cate['category_id']),array('task'=>'info'));
	    	    if(count($cate_info['news']) > 0)
	    			array_push($categories_info, $cate_info);
	    	}
	    }
	    
	    $this->view->arrayItems = $categories_info;
		$this->view->categories_info = $categories;
	    /*-------------------- Get Hotnews ------------------------*/
	    
	    $hotnews = new Front_Model_Hotnews();
	    
	    $arrHotnews = $hotnews->listItem($this->_arrParam, array('task'=>'listTop'));
	    
	    $this->view->arrHotnews = $arrHotnews;
	}
	
	public function listAction(){
		// format: list of news in a category
		
		if($this->_arrParam['category_id'] == "hot-news"){
		    
		    $this->view->Title = 'Tin nổi bật';
		    $this->view->headTitle = $this->view->Title;
		    
		    $hotnews = new Front_Model_Hotnews();
		     
		    $arrHotnews = $hotnews->listItem($this->_arrParam, array('task'=>'listAll'));
		    $this->view->Items = $arrHotnews;
		    $totalItem = $hotnews->countItem($this->_arrParam, array('task' =>'countAll'));
		    $this->view->totalItem = $totalItem;
		    $paginator = new Honey_Paginator();
		    $this->view->panigator = $paginator->createPaginator($totalItem, $this->_paginator);
		}
		else{
			$this->view->Title = 'Tin tức';
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
		
		// redirect to request page;
		$ducnhtrash = new Zend_Session_Namespace('news_support');
	    $back = $ducnhtrash->back;
	    header("location: $back");
	}
	public function addAction(){
	
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	
		$newnews = new Front_Model_NewNews();
		
		if(isset($this->_arrParam['add_news_id']))
			$newnews->saveItem($this->_arrParam, array('task'=>'add'));
		else $newnews->saveItem($this->_arrParam, array('task'=>'addnew'));
		
		// redirect to request page;
		$ducnhtrash = new Zend_Session_Namespace('news_support');
	    $back = $ducnhtrash->back;
	    header("location: $back");
	}
	public function saveAction(){
		//$this->_helper->viewRenderer->setNoRender();
		//$this->_helper->layout->disableLayout();
		$this->view->descriptionPost = stripslashes($_POST['description']);
		//$newnews = new Front_Model_NewNews();
		
		//$newnews->saveItem($this->_arrParam, array('task'=>'edit'));
		
		// redirect to request page;
		//$ducnhtrash = new Zend_Session_Namespace('news_support');
	    //$back = $ducnhtrash->back;
	    //header("location: $back");
	}
	
	public function changeeditmodeAction()
	{
	    $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
	    
	    $ducnhtrash = new Zend_Session_Namespace('news_support');
	    
	    if($ducnhtrash->editmode == 'OFF')
	        $ducnhtrash->editmode = 'ON';
	    else
	        $ducnhtrash->editmode = 'OFF';
	    
		// redirect to request page;
		$ducnhtrash = new Zend_Session_Namespace('news_support');
	    $back = $ducnhtrash->back;
	    header("location: $back");
	}
	
	public function markhotnewsAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$hotnews = new Front_Model_Hotnews();
		
		$hotnews->saveItem($this->_arrParam, array('task' => 'add'));
		
		// redirect to request page;
		$ducnhtrash = new Zend_Session_Namespace('news_support');
	    $back = $ducnhtrash->back;
	    header("location: $back");
	}
	
	
	public function testAction(){
	    $hotnews = new Front_Model_Hotnews();
		$this->view->count770 = $hotnews->countItem(array('news_id'=> 770), array('task'=> 'countOne'));
		
	}
	
	
	public function viewcountAction(){
	    $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
		
	    $news = new Front_Model_NewNews();
	    $curViewed = $news->getViewCountOfNews($this->_arrParam['news_id']);
	    
	    // update
	    
	    $news->updateViewCountOfNews($this->_arrParam['news_id'], ++$curViewed);
	}
}