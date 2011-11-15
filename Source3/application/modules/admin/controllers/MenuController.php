<?php

class Admin_MenuController extends Honey_Controller_Action {
	
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
				
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
		/** Set the initial stylesheet: */
		$this->view->headLink ( array ('rel' => 'shortcut icon', 'href' => HTTP_IMAGES . '/logo/favicon.png' ), 'PREPEND' );
	
	}
	
	public function indexAction() {
		$model = new Front_Model_Menu();
		$this->view->currentController = $this->_currentController;
		$this->view->menus = $model->listItem(array('parent_id' => 0), array('task'=>'list'));
	}
	public function newAction(){

	}
	public function deleteAction(){	
		$message = "";
		$m_id = $this->_request->getParam('menu_id');    	   	
    	$model = new Admin_Model_Menu();// khai bao model    		
    	//$menu_item = $model->getItem2($m_id,array('task'=>'edit','lang'=>'vi_VN'));
    	if(empty($menu_item)){// thông báo nêu không thìm thấy News   
    		$this->view->message = "Không tìm thấy Menu= ".$m_id;    
    	} 
    	$this->view->menu_item = $menu_item;   	   
    
	}
	public function editAction(){	    
		$message = "";
		$n_id = $this->_request->getParam('news_id');    	   	
    	$model = new Admin_Model_News();// khai bao model    		
    	$news_item = $model->getNews_item($n_id);
    	if(empty($news_item)){// thông báo nêu không thìm thấy News   
    		$this->view->message = "Không tìm thấy News_ID= ".$n_id;    		
    	}     	
    	$n_language = "vi_VN";// tạm thời code cứng: ngôn ngữ là Tiếng Việt
    	$news_dectiption = $model->getNews_description($n_id, $n_language);
    	// Gán giá trị xuống View (edit.phtml)
    	$this->view->news_item = array_merge ($news_item, $news_dectiption);// merge giá trị 2 mảng, không merge cũng được    	
	}
}