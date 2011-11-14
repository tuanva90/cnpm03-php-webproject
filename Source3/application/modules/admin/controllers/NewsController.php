<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Admin_NewsController extends Honey_Controller_Action {
	
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
		$model = new Admin_Model_News();
		$this->view->news = $model->getNews();	
	}
	public function newAction(){

	}
	public function deleteAction(){
		$message = "";
		$n_id = $this->_request->getParam('news_id');    	   	
    	$model = new Admin_Model_News();// khai bao model    		
    	$news_item = $model->getNews_item($n_id);
    	if(empty($news_item)){// thông báo nêu không thìm thấy News   
    		$this->view->message = "Không tìm thấy News_ID= ".$n_id;    
    	}
    	$n_language = "vi_VN";// tạm thời code cứng: ngôn ngữ là Tiếng Việt
    	$news_dectiption = $model->getNews_description($n_id, $n_language);
    	$this->view->news_item = array_merge ($news_item, $news_dectiption);// merge giá trị 2 mảng, không merge cũng được    	
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