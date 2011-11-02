<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    const KEY = 'CMS_Config';
    protected function _initDb ()
    {
        if (! Zend_Registry::isRegistered($key)) {
            $file = APPLICATION_PATH . DS . 'configs' . DS . 'application.ini';
            $config = new Zend_Config_Ini($file);
            Zend_Registry::set ( self::KEY , $config );
        }
       $host = $config->db->host;
       $adapter = $config->db->adaptert;
       $prefix = $config->db->params->prefix;
       $username = $config->db->params->username;
       $password = $config->db->params->password;
       $dbname = $config->db->params->dbname;
    }
}

