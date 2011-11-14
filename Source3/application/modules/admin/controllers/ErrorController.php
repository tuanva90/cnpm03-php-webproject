<?php
/**
 * WDS Project - WDS
 * @name ErrorController.php
 * @package application/modules/front/controllers
 * @author Đặng Văn Huy
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
		 * Chứa phần đầu - thông tin website - thời gian và hệ thống
		 * Phần thân chưa thông tin lỗi
		 * @var $errorMessage String
		 */
		// Khởi tạo đối tượng thông tin lỗi
		$exp = $this->_error->exception;
		$errorMessage = get_class ( $exp );
		
		// Thông tin bắt đầu bằng mã lỗi nếu có
		if ($exp->getCode ()) {
			$errorMessage .= ' (' . $exp->getCode () . ') ';
		}
		// Thông tin được ghi thành từng dòng
		$errorMessage .= PHP_EOL . 'Message: ' . $exp->getMessage () . PHP_EOL . 'Stack trace: ' . count ( $exp->getTrace () ) . PHP_EOL;
		$numTrace = 0;
		foreach ( $exp->getTrace () as $trace ) {
			$errorMessage .= '#' . $numTrace ++ . PHP_EOL . '-- File: ' . $trace ['file'] . PHP_EOL . '-- Line: ' . $trace ['line'] . PHP_EOL . '-- Function: ' . $trace ['function'] . PHP_EOL . '-- Class: ' . $trace ['class'] . PHP_EOL . PHP_EOL;
		}
		$errorMessage .= PHP_EOL;
		
		// Tạo định dạng phần đầu cho files log [Tùy Chọn]
		$logFormat = 'WDS CMS - %timestamp%' . PHP_EOL . '%priorityName% [%priority%]: %message%' . PHP_EOL;
		
		// Đường dẫn và tên của file logs
		$logFile = TEMP_PATH . DS . 'logs' . DS . date ( 'd-m-Y' ) . '.log';
		
		// Mở file logs
		$stream = @fopen ( $logFile, 'a', false );
		// Nếu như không mở được hay file log chưa được tạo
		if (! $stream) {
			// Tạo file logs mới
			$stream = @fopen ( $logFile, 'w', false );
		}
		// Khởi tạo đối tượng ghi log vào files
		$logWriter = new Zend_Log_Writer_Stream ( $stream );
		// Thiết lập định dạng file log theo tùy chọn định dạng
		$logWriter->setFormatter ( New Zend_Log_Formatter_Simple ( $logFormat ) );
		
		// Khởi tạo đối tượng điểu khiển log
		$logController = new Zend_Log ();
		
		// Thêm bộ lọc lỗi [Tùy Chọn]
		//$logController->addFilter(new Zend_Log_Filter_Priority(Zend_Log::DEBUG));		

		// Thêm định dạng cho đối tượng ghi logs             
		$logController->addWriter ( $logWriter );
		// Ghi logs theo định dạng trên
		$logController->log ( $errorMessage, Zend_Log::DEBUG );
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