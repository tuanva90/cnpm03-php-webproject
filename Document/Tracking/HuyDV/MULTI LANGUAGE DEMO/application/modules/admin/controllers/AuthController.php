<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */

class Admin_AuthController extends Honey_Controller_Action {
	
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
		
		$layout = 'auth';
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
		$this->view->Title = 'Login';
		$this->view->headTitle ( $this->view->Title, true );
		
		$auth = Zend_Auth::getInstance ();
		
		/**
		 * Redirect to index if user has logged in already
		 */
		if ($auth->hasIdentity ()) {
			$this->_redirect('/admin/index');
		}
		
		if ($this->_request->isPost ()) {
			$auth = new Honey_Plugin_Permission_Auth ();
			if ($auth->login ( $this->_arrParam )) {
				
				$info = new Honey_Plugin_Permission_Info ();
				$info->createInfo ();
				$this->_redirect($this->_server['HTTP_REFERER']);
			} else {
				$error [] = $auth->getError ();
				$this->view->messageError = $error;
			}
		}
	}
	
	/**
	 * Logout	 * 
	 * @return void
	 */
	public function logoutAction() {
		
		$this->view->Title = 'Logout';
		$this->view->headTitle ( $this->view->Title, true );
		$auth = new Honey_Plugin_Permission_Auth ();
		$auth->logout ();
		
		$info = new Honey_Plugin_Permission_Info ();
		$info->destroyInfo ();
		
		$this->_redirect ( '/admin/auth/login' );
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
}
