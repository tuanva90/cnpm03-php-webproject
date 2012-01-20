<?php
/**
 * WDS Project - WDS
 * @name ErrorController.php
 * @package application/modules/front/controllers
 * @author Ä�áº·ng VÄƒn Huy
 * @version 1.0
 * License http://cnpm03-php-webproject.googlecode.com/svn/trunk/
 */
class ErrorController extends Zend_Controller_Action {
	
	private $_notifier;
	private $_error;
	private $_environment;
	private $_mailer;
	private $_session;
	private $_profiler;
	
	public function init() {
		
		$bootstrap = $this->getInvokeArg ( 'bootstrap' );
		
		$this->_environment = $bootstrap->getEnvironment ();
		$db = $bootstrap->getResource ( 'db' );
		$profiler = $db->getProfiler ();
		
		$this->_mailer = new Zend_Mail ();
		$this->_error = $this->_getParam ( 'error_handler' );
		$this->_session = new Zend_Session_Namespace ();
		$this->_profiler = $profiler;
		$this->_server = $_SERVER;
	}
	
	public function errorAction() {
		
		switch ($this->_error->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE :
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER :
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION :
				
				// 404 error -- Controller or Action not found
				$this->getResponse ()->setHttpResponseCode ( 404 );
				$this->view->message = 'Page not found';
				break;
			default :
				// Application error
				$this->getResponse ()->setHttpResponseCode ( 500 );
				$this->view->message = 'Application error';
				break;
		}
		
		// Conditionally display exceptions
		if ($this->getInvokeArg ( 'displayExceptions' ) == true) {
			$this->view->environment = $this->_environment;
			$this->view->errors = $this->_error;
			$this->view->session = $this->_session;
			$this->view->server = $this->_server;
			
			// TODO
			$query = $this->_profiler->getLastQueryProfile ();
			$this->view->query = $query;
		
		}
		
		$this->_helper->layout->setLayoutPath ( APPLICATION_PATH . DS . 'templates' . DS . 'front' . DS . 'default' );
		$this->_helper->layout ()->setLayout ( 'error' );	

		$this->view->request = $this->_error->request;
		
		self::Wlog ();
		self::notify ();
	
	}
	
	private function Wlog() {
		/**
		 * Log File Contents
		 * Chá»©a pháº§n Ä‘áº§u - thÃ´ng tin website - thá»�i gian vÃ  há»‡ thá»‘ng
		 * Pháº§n thÃ¢n chÆ°a thÃ´ng tin lá»—i
		 * @var $errorMessage String
		 */
		// Khá»Ÿi táº¡o Ä‘á»‘i tÆ°á»£ng thÃ´ng tin lá»—i
		$exp = $this->_error->exception;
		$errorMessage = get_class ( $exp );
		
		// ThÃ´ng tin báº¯t Ä‘áº§u báº±ng mÃ£ lá»—i náº¿u cÃ³
		if ($exp->getCode ()) {
			$errorMessage .= ' (' . $exp->getCode () . ') ';
		}
		// ThÃ´ng tin Ä‘Æ°á»£c ghi thÃ nh tá»«ng dÃ²ng
		$errorMessage .= PHP_EOL . 'Message: ' . $exp->getMessage () . PHP_EOL . 'Stack trace: ' . count ( $exp->getTrace () ) . PHP_EOL;
		$numTrace = 0;
		foreach ( $exp->getTrace () as $trace ) {
			$errorMessage .= '#' . $numTrace ++ . PHP_EOL . '-- File: ' . $trace ['file'] . PHP_EOL . '-- Line: ' . $trace ['line'] . PHP_EOL . '-- Function: ' . $trace ['function'] . PHP_EOL . '-- Class: ' . $trace ['class'] . PHP_EOL . PHP_EOL;
		}
		$errorMessage .= PHP_EOL;
		
		// Táº¡o Ä‘á»‹nh dáº¡ng pháº§n Ä‘áº§u cho files log [TÃ¹y Chá»�n]
		$logFormat = 'Honey CMS - %timestamp%' . PHP_EOL . '%priorityName% [%priority%]: %message%' . PHP_EOL;
		
		// Ä�Æ°á»�ng dáº«n vÃ  tÃªn cá»§a file logs
		$logFile = TEMP_PATH . DS . 'logs' . DS . date ( 'd-m-Y' ) . '.log';
		
		// Má»Ÿ file logs
		$stream = @fopen ( $logFile, 'a', false );
		// Náº¿u nhÆ° khÃ´ng má»Ÿ Ä‘Æ°á»£c hay file log chÆ°a Ä‘Æ°á»£c táº¡o
		if (! $stream) {
			// Táº¡o file logs má»›i
			$stream = @fopen ( $logFile, 'w', false );
		}
		/*
		// Khá»Ÿi táº¡o Ä‘á»‘i tÆ°á»£ng ghi log vÃ o files
		$logWriter = new Zend_Log_Writer_Stream ( $stream );
		// Thiáº¿t láº­p Ä‘á»‹nh dáº¡ng file log theo tÃ¹y chá»�n Ä‘á»‹nh dáº¡ng
		$logWriter->setFormatter ( New Zend_Log_Formatter_Simple ( $logFormat ) );
		
		// Khá»Ÿi táº¡o Ä‘á»‘i tÆ°á»£ng Ä‘iá»ƒu khiá»ƒn log
		$logController = new Zend_Log ();
		
		// ThÃªm bá»™ lá»�c lá»—i [TÃ¹y Chá»�n]
		//$logController->addFilter(new Zend_Log_Filter_Priority(Zend_Log::DEBUG));		

		// ThÃªm Ä‘á»‹nh dáº¡ng cho Ä‘á»‘i tÆ°á»£ng ghi logs             
		$logController->addWriter ( $logWriter );
		// Ghi logs theo Ä‘á»‹nh dáº¡ng trÃªn
		$logController->log ( $errorMessage, Zend_Log::DEBUG );*/
	}
	
	public function notify() {
		if (! in_array ( $this->_environment, array ('production', 'stage' ) )) {
			return false;
		}
		
		//$protocal = new Zend_Mail_Transport_Smtp('mail.ddd.com');
		//Zend_Mail::setDefaultTransport($protocal)		
		$this->_mailer->setFrom ( 'do-not-reply@domain.com' );
		$this->_mailer->setSubject ( "Exception on Application" );
		$this->_mailer->setBodyText ( $this->getFullErrorMessage () );
		$this->_mailer->addTo ( 'alerts@domain.com' );		
		return $this->_mailer->send ();
	}
}