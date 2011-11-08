<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    const KEY = 'CMS_Config';
    protected function _initDb ()
    {
        if (! Zend_Registry::isRegistered(self::KEY)) {
            $file = APPLICATION_PATH . DS . 'configs' . DS . 'application.ini';
            $config = new Zend_Config_Ini($file);
            // Store Config to use for other Controller 
            Zend_Registry::set(self::KEY, $config);
        }
//        $dbOption = $config->db->toArray();
//      // Initialize database
//        $db = Zend_Db::factory($dbOption['adapter'], 
//        $dbOption['params']);
//        $db->setFetchMode(Zend_Db::FETCH_ASSOC);
//        $db->query("SET NAMES 'utf8'");
//        $db->query("SET CHARACTER SET 'utf8'");
//        // Set database as default
//        Zend_Db_Table::setDefaultAdapter($db);
//        // Save database object in Zend_Registry
//        Zend_Registry::set('connectDB', $db);// lấy kết nối:  Zend_Registry::get('connectDB');
//        // Return it, so that it can be stored by the bootstrap
//        return $db;
    }
}

