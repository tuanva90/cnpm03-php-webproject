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
		$this->view->news = $model->getNews(1,50);	
		$this->view->model = $model;
	}
	public function newAction(){		
		$form = new Admin_Form_NewsEdit();
		if($this->_request->isPost())
		{
			//get value posted
			$style_error = '<p style="background:#FF0000; text-align: center; padding: 3px;">';
        	$style_success = '<p style="background:#33CC66; text-align: center; padding: 3px;">';
			$data =$this->getRequest()->getPost();
			
			$title = $data['title'];
			$author = $data['author'];
			$summary = $data['description'];
			$content = $data['content'];
			$image = $data['image'];
			$order = $data['order'];
			$status = $data['status'];
			$date_added = date ( "Y-m-d H:i:s" );
			$data['date_added'] = $date_added;
			if($form->isValid($_POST)){
			
				$submitButton = $form->getUnfilteredValue('submit');
				$cancelButton = $form->getUnfilteredValue('cancel');
				
				if(!is_null($submitButton)){//pressed save button
				//check whether the values is valid or not
					if($title=="") {
						$message = $style_error . 'Chưa nhập tựa đề của bài viết.</p>';
					} else if($author == "") {
						$message = $style_error . 'Chưa nhập tác giả của bài viết.</p>';
					} else if($summary == "") {
						$message = $style_error . 'Chưa nhập tóm tắt của bài viết.</p>';
					} else if($content == "") {
						$message = $style_error . 'Chưa nhập nội dung bài viết.</p>';
					} else if($image=="") {
						$message = $style_error . 'Chưa chọn ảnh cho bài viết.</p>';
					} else {//if fields is valid
					 //Test data
	                $message = $style_success . 'Title: ' . $title . '<br/>';
	                $message = $message . 'Author: ' . $author . '<br/>';
	                $message = $message . 'Price: ' . $image . '<br/>';
	                $message = $message . 'Order: ' . $order . '<br/>';
	                $message = $message . 'Status: ' . $status . '<br/>';
	                $message = $message . 'Date_added: ' . $date_added. '<br/>';

	                //Insert to CSDL
	                
	                $n_model = new Admin_Model_News();
	                $n_model->insertNews_Item2($data);
	                //$message = $style_success . 'Thêm thành công <br/>';
				}
			}
		}			
		}
		$this->view->note = $message;
        $this->view->form = $form;
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
    	$n_model = new Admin_Model_News();// khai bao model    		
    	$n_item = $n_model->getNews_item($n_id);
    	if(empty($n_item)){// thÃ´ng bÃ¡o nÃªu khÃ´ng thÃ¬m tháº¥y News   
    		$this->view->message = "KhÃ´ng tÃ¬m tháº¥y News_ID= ".$n_id;    		
    	}     	
    	$n_language = "vi_VN";// táº¡m thá»�i code cá»©ng: ngÃ´n ngá»¯ lÃ  Tiáº¿ng Viá»‡t    	
		$form = new Admin_Form_NewsEdit();
		$form->setValue($n_item);
		$style_error = '<p style="background:#FF0000; text-align: center; padding: 3px;">';
        $style_success = '<p style="background:#33CC66; text-align: center; padding: 3px;">';
        $message = '';
		
		//submit event
		if($this->_request->isPost())
		{
			//get value posted
			$data =$this->getRequest()->getPost();
			
			$title = $data['title'];
			$author = $data['author'];
			$summary = $data['description'];
			$content = $data['content'];
			$image = $data['image'];
			$order = $data['order'];
			$status = $data['status'];
			$date_added = date ( "Y-m-d H:i:s" );
			$data['date_added'] = $date_added;
			if($form->isValid($_POST)){
			
				$submitButton = $form->getUnfilteredValue('submit');
				$cancelButton = $form->getUnfilteredValue('cancel');
				
				if(!is_null($submitButton)){//pressed save button
				//check whether the values is valid or not
					if($title=="") {
						$message = $style_error . 'Chưa nhập tựa đề của bài viết.</p>';
					} else if($author == "") {
						$message = $style_error . 'Chưa nhập tác giả của bài viết.</p>';
					} else if($summary == "") {
						$message = $style_error . 'Chưa nhập tóm tắt của bài viết.</p>';
					} else if($content == "") {
						$message = $style_error . 'Chưa nhập nội dung bài viết.</p>';
					} else if($image=="") {
						$message = $style_error . 'Chưa chọn ảnh cho bài viết.</p>';
					} else {//if fields is valid
						 //Test data
	                $message = $style_success . 'Title: ' . $title . '<br/>';
	                $message = $message . 'Author: ' . $author . '<br/>';
	                $message = $message . 'Price: ' . $image . '<br/>';
	                $message = $message . 'Order: ' . $order . '<br/>';
	                $message = $message . 'Status: ' . $status . '<br/>';
	                $message = $message . 'Date_added: ' . $date_added. '<br/>';	  	        
	                //code
	                $result = $n_model->updateNews2($n_id, $data);
	                
	                	$message = $style_success . 'Thanh Cong <br/>';
					}
				}else{//cancel creating article, go back to new list page
					$this->_helper->redirector('index');
				}			
			}
		}			
		$this->view->note = $message;
        $this->view->form = $form;
	}
}