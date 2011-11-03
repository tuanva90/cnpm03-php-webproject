<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
//    const KEY = 'CMS_Config';
//    protected function _initDb ()
//    {
//        if (! Zend_Registry::isRegistered(self::KEY)) {
//            $file = APPLICATION_PATH . DS . 'configs' . DS . 'application.ini';
//            $config = new Zend_Config_Ini($file);
//           Zend_Registry::set(self::KEY, $config);
//       }
//       $host = $config->db->host;
//       $adapter = $config->db->adaptert;
//       $prefix = $config->db->params->prefix;
//       $username = $config->db->params->username;
//       $password = $config->db->params->password;
//       $dbname = $config->db->params->dbname;
//        $dbOption = $config->db->toArray();
//        // Initialize database
//        $db = Zend_Db::factory($dbOption['adapter'], 
//        $dbOption['params']);
//        $db->setFetchMode(Zend_Db::FETCH_ASSOC);
//        $db->query("SET NAMES 'utf8'");
//        $db->query("SET CHARACTER SET 'utf8'");
//        // Set database as default
//        Zend_Db_Table::setDefaultAdapter($db);
//        // Save database object in Zend_Registry
//        Zend_Registry::set('connectDB', $db);
//        // Return it, so that it can be stored by the bootstrap
//        return $db;
//    }
}

