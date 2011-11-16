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
		
		$this->view->Title = 'News :: List';
		$this->view->headTitle($this->view->Title, true);
		$news = new Front_Model_News();		
		$this->view->Items = $news->listItem($this->_arrParam, array('task'=>'list'));
		$totalItem  = $news->countItem($this->_arrParam);		
		$paginator = new Honey_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem, $this->_paginator);
	

	}
	
	public function detailAction() {
		$news = new Front_Model_News();		
		$this->view->Item = $news->getItem($this->_arrParam, array('task'=>'info'));
		$this->view->Title = 'News :: '.$this->view->Item['title'];
		$this->view->headTitle($this->view->Title, true);

	}

}