<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initDb() {
		// Set database configuration parameters
		$dbOption = Honey_Config::getConfig ()->db->toArray ();
		// Initialize database
		$db = Zend_Db::factory ( $dbOption ['adapter'], $dbOption ['params'] );
		$db->setFetchMode ( Zend_Db::FETCH_ASSOC );
		$db->query ( "SET NAMES 'utf8'" );
		$db->query ( "SET CHARACTER SET 'utf8'" );
		// Set database as default
		Zend_Db_Table::setDefaultAdapter ( $db );
		// Save database object in Zend_Registry
		Zend_Registry::set ( 'connectDB', $db );
		// Return it, so that it can be stored by the bootstrap
		return $db;
	}
	
	/**
	 * Init session
	 * 
	 * @return void
	 */
	protected function _initSession() {
		
		//Zend_Session::start ();
		
		/** 
		 * Registry session handler 
		 */
		//Zend_Session::setSaveHandler(Core_Services_SessionHandler::getInstance());
		

		/**
		 * Allow user to set more session settings in application.ini
		 * For example:
		 * session.cookie_lifetime = "3600"
		 * session.cookie_domain   = ".domain.ext"
		 * @since 2.0.9
		 */
		/*Zend_Session::setOptions ( Honey_Config::getConfig ()->web->session->toArray () );
		
		if (isset ( $_GET ['PHPSESSID'] )) {
			session_id ( $_GET ['PHPSESSID'] );
		} else if (isset ( $_POST ['PHPSESSID'] )) {
			session_id ( $_POST ['PHPSESSID'] );
		}*/
	}
	
	/**
	 * Register plugins
	 * 
	 * @return void
	 */
	protected function _initPlugins() {
		
	
	}
 	
	protected function _initLoadRouter(){
		/*
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/routers.ini','routers');
		$objRouter = new Zend_Controller_Router_Rewrite();
		//new Zend_Controller_Router_Route_Regex()
		$router = $objRouter->addConfig($config,'routers');
		
		$front = Zend_Controller_Front::getInstance();
		$front->setRouter($router);
		return $front;
		*/
	}

}