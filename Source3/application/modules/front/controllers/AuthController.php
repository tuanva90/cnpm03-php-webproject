<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */

class AuthController extends Honey_Controller_Action {
	
	//Parameter is an array containing information such as headers, paths, and script locations. 
	protected $_server;
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	protected $_namespace;
	
	/**
	 * Init controller
	 * 
	 * @return void
	 */
	public function init() {
		$this->_server = $_SERVER;
		
		$this->_arrParam = $this->_request->getParams ();
		
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
		
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
				
		/** Set the initial stylesheet: */
		$this->view->headLink ( array ('rel' => 'shortcut icon', 'href' => HTTP_IMAGES . '/logo/favicon.png' ), 'PREPEND' );
	
	}
	
	public function indexAction() {
	}
	
	/* ========== Frontend actions ========================================== */
	
	/**
	 * Deny access	 * 
	 * @return void
	 */
	public function denyAction() {
	}
	
	/**
	 * Login
	 * 
	 * @return void
	 */
	public function loginAction() {
	    $this->_helper->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
		$this->view->Title = 'Login';
		$this->view->headTitle ( $this->view->Title, true );

		$username = json_decode($_POST['username']);
		$login['username'] = 'admin';
		$login['password']= json_decode($_POST['password']);
		$infoTemp['status'] = false;
		
		if ($this->_request->isPost ()) {
			$auth = new Honey_Plugin_Permission_Auth ();
			if ($auth->login ( $login )) {// auth thanh cong
				
				$info = new Honey_Plugin_Permission_Info ();
				$info->createInfo ();
				//$this->view->id=$info->getMemberInfo();
				$infoTemp['status']=true;
				$infoTemp['name'] = $login['username'];
				
				$ducnhtrash = new Zend_Session_Namespace('news_support');
				$ducnhtrash->back = $_SERVER['REQUEST_URI'];
				$ducnhtrash->editmode = 'ON';
			} else {
				$error [] = $auth->getError ();
				$this->view->messageError = $error;
			}
		}
		echo json_encode($infoTemp);
	}
	
	/**
	 * Logout	 * 
	 * @return void
	 */
	public function logoutAction() {
	    $this->_helper->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
	    
		$this->view->Title = 'Logout';
		$this->view->headTitle ( $this->view->Title, true );
		$auth = new Honey_Plugin_Permission_Auth ();
		$auth->logout ();
		
		$info = new Honey_Plugin_Permission_Info ();
		$info->destroyInfo ();
		
		$ducnhtrash = new Zend_Session_Namespace('news_support');
		$ducnhtrash->unsetAll();
	}
	
	/**
	 * Forgot password	 * 
	 * @return void
	 */
	public function forgotAction() {
	}
	
	/**
	 * Reset password
	 * @return void
	 */
	public function resetAction() {
	}
	
	/**
	 * Get Member Info
	 * @return void
	 */
	public function getmemberAction(){
	    $info = new Honey_Plugin_Permission_Info();
	    $this->view->member = $info->getMemberInfo();
	}
}
