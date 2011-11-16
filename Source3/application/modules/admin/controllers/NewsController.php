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
		$this->view->model = $model;
	}
	public function newAction(){

	}
	public function deleteAction(){
		$message = "";
		$n_id = $this->_request->getParam('news_id');    	   	
    	$model = new Admin_Model_News();// khai bao model    		
    	$news_item = $model->getNews_item($n_id);
    	if(empty($news_item)){// thÃ´ng bÃ¡o nÃªu khÃ´ng thÃ¬m tháº¥y News   
    		$this->view->message = "KhÃ´ng tÃ¬m tháº¥y News_ID= ".$n_id;    
    	}
    	$n_language = "vi_VN";// táº¡m thá»�i code cá»©ng: ngÃ´n ngá»¯ lÃ  Tiáº¿ng Viá»‡t
    	$news_dectiption = $model->getNews_description($n_id, $n_language);
    	$this->view->news_item = array_merge ($news_item, $news_dectiption);// merge giÃ¡ trá»‹ 2 máº£ng, khÃ´ng merge cÅ©ng Ä‘Æ°á»£c    	
	}
	public function editAction(){	    
		$message = "";
		$n_id = $this->_request->getParam('news_id');    	   	
    	$model = new Admin_Model_News();// khai bao model    		
    	$news_item = $model->getNews_item($n_id);
    	if(empty($news_item)){// thÃ´ng bÃ¡o nÃªu khÃ´ng thÃ¬m tháº¥y News   
    		$this->view->message = "KhÃ´ng tÃ¬m tháº¥y News_ID= ".$n_id;    		
    	}     	
    	$n_language = "vi_VN";// táº¡m thá»�i code cá»©ng: ngÃ´n ngá»¯ lÃ  Tiáº¿ng Viá»‡t
    	$news_dectiption = $model->getNews_description($n_id, $n_language);
    	// GÃ¡n giÃ¡ trá»‹ xuá»‘ng View (edit.phtml)
    	$this->view->news_item = array_merge ($news_item, $news_dectiption);// merge giÃ¡ trá»‹ 2 máº£ng, khÃ´ng merge cÅ©ng Ä‘Æ°á»£c    	
		
		$form = new Admin_Form_NewsEdit();
		$style_error = '<p style="background:#FF0000; text-align: center; padding: 3px;">';
        $style_success = '<p style="background:#33CC66; text-align: center; padding: 3px;">';
        $message = '';
		
		//submit save button
		if($this->_request->isPost())
		{
			if($form->isValid($_POST)){
				$submitButton = $form->getUnfilteredValue('submit');
				$cancelButton = $form->getUnfilteredValue('cancel');
				if(!is_null($submitButton)){
					
				}else{
					$this->_helper->redirector('index');
				}
				$message = $style_error . 'Chưa nhập tên sản phẩm.</p>';
			}else
				$message = $style_success . 'Đã thêm '.$name.' vào cơ sở dữ liệu</p>';
		}else
			$message = $style_success . 'Cancel</p>';
		$this->view->note = $message;
        $this->view->form = $form;
	}
}