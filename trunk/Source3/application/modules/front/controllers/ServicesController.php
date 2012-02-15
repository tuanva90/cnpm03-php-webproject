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
		$this->getResponse()->setHeader('Content-type', 'application/json;charset=UTF-8', true);
		
		$json = array();
		
		$webservices = new Front_Model_Webservices();
		
		$newses = $webservices->getNews($this->_arrParam['news_id']);
		
		if(count($newses) <= 0){
			$json['error'] = "Error:Get news failed! News not available.";
		}
		else{
		$json['news_id'] = $newses[0]['news_id'];
		$json['category_id'] = $newses[0]['category_id'];
		$json['author'] = $newses[0]['author'];
		$json['image'] = $newses[0]['image'];
		$json['viewed'] = $newses[0]['viewed'];
		$json['sort_order'] = $newses[0]['sort_order'];
		$json['status'] = $newses[0]['status'];
		$json['date_added'] = $newses[0]['date_added'];
		$json['date_modified'] = $newses[0]['date_modified'];
		
		$json['language'] = $newses[0]['language'];
		$json['title'] = $newses[0]['title'];
		$json['summary'] = html_entity_decode($newses[0]['summary']);
		$json['description'] = html_entity_decode($newses[0]['description']);
		$json['meta_description'] = $newses[0]['meta_description'];
		$json['meta_keywords'] = $newses[0]['meta_keywords'];
		
		$json['success'] = "Success:Get news success!";
		}
		//Zend_Json::$useBuiltinEncoderDecoder = true;
		$this->getResponse()->setBody(Zend_Json::encode($json));
		//$this->view->json = json_encode($json);
	}
	
	public function getnewssummaryAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		$this->getResponse()->setHeader('Content-type', 'application/json;charset=UTF-8', true);
		
		$json = array();
		
		$webservices = new Front_Model_Webservices();
		
		$newses = $webservices->getNews($this->_arrParam['news_id']);
		
		if(count($newses) <= 0){
			$json['error'] = "Error:Get news failed! News not available.";
		}
		else{
			$json['summary'] = html_entity_decode($newses[0]['summary']);
			$json['success'] = "Lấy thông tin thành công";
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
	
	public function getcategorylistAction(){
	    $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
	    
	    $json = array();
	    
	    $category = new Front_Model_Category();
	    
	    $categories = $category->listItem($this->_arrParam, array('task' => 'listall'));
	    
	    $this->view->categories = $categories;
	    
	    if(count($categories) <= 0)
	    	$json['error'] = count($categories);
	    
	    else{
	     	foreach($categories as $cate)
	     	{
	     	    $child['category_id'] = $cate['category_id'];
	     	    $child['name'] = $cate['name'];
	     	    
	     	    array_push($json,$child);
	     	}
	     	$json['success'] = "Lấy danh mục thành công!";
	    }
	    
	    $this->getResponse()->setBody(Zend_Json::encode($json));
	}
	
	public function countennewsAction(){
	    
	    $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
	    
	    $json = array();
	    
	    $news = new Front_Model_NewNews();
	    
	    $newscount = $news->countennews($this->_arrParam['news_id']);
	    
	    if(!isset($newscount))
	        $json['error'] = "Lỗi: không xác định";
	    
	    else{
	        $json['count'] = $newscount;
	        $json['success'] = "Đếm số tin thành công";
	    }
	    
	    $this->getResponse()->setBody(Zend_Json::encode($json));
	}
}