<?php
class ServicesController extends Honey_Controller_Action{
	
	protected $_arrParam;
	
	protected $_currentController;
	
	protected $_actionMain;
	
	public function init(){
		$this->_arrParam = $this->_request->getParams();
		
		$this->_currentController = '/'.$this->_arrParam['module'].'/'.$this->_arrParam['controller'];
		
		$this->_actionMain = '/'.$this->_arrParam['module'].'/'.$this->_arrParam['controller'].'/'.'index';
		/**
		 * VIEW
		 */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout = 'index';
		$layoutPath = APPLICATION_PATH.'/templates/front/default';
		$this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
	}
	
	public function indexAction(){
		
	}
	
	public function getnewsAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		$webservices = new Front_Model_Webservices();
		
		$newses = $webservices->getNews($this->_arrParam['news_id']);
		
		if(count($newses) <= 0){
			$json['error'] = "Error:Get news failed! News not available.";
		}
		else{
		$json['news_id'] = $newses[0]['news_id'];
		$json['author'] = $newses[0]['author'];
		$json['image'] = $newses[0]['image'];
		$json['viewed'] = $newses[0]['viewed'];
		$json['sort_order'] = $newses[0]['sort_order'];
		$json['status'] = $newses[0]['status'];
		$json['date_added'] = $newses[0]['date_added'];
		$json['date_modified'] = $newses[0]['date_modified'];
		
		foreach($newses as $news){
		if($news['language'] == 'en_US')
		{
			$json['en_language'] = 'en_US';
			$json['en_title'] = $news['title'];
			$json['en_summary'] = $news['summary'];
			$json['en_description'] = $news['description'];
			$json['en_meta_keywords'] = $news['meta_keywords'];
			$json['en_meta_description'] = $news['meta_description'];
		}
		if($news['language'] == 'vi_VN')
		{
			$json['vi_language'] = 'vi_VN';
			$json['vi_title'] = $news['title'];
			$json['vi_summary'] = $news['summary'];
			$json['vi_description'] = $news['description'];
			$json['vi_meta_keywords'] = $news['meta_keywords'];
			$json['vi_meta_description'] = $news['meta_description'];
		}
		}
		$json['success'] = "Success:Get news success!";
		}
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}
	
	public function getnewstitleAction(){
	    $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
	    
	    $json = array();
	    
	    $webservices = new Front_Model_Webservices();
	    
	    $newstitles = $webservices->getNewsTitle($this->_arrParam['news_id']);
	    
	    if(count($newstitles) <= 0){
	    	$json['error'] = "Lỗi: Bài viết không tồn tại";
	    }
	    else{
	        $json['news_title'] = $newstitles[0]['title'];
	    }
	    $json['success'] = "Lấy tiêu đề bài viết thành công";
	    
	    $this->getResponse()->setBody(Zend_Json::encode($json));
	}
}