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

	protected function _initPlugins() {

	}
 	


}