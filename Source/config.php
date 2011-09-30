<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/Zend');
define('HTTP_PUBLIC', 'http://localhost/Zend/public');
define('HTTP_IMAGES', 'http://localhost/Zend/public/images');

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

/*================== Define path to root directory ================================================*/
defined('WEB_ROOT')
    || define('WEB_ROOT', 
    		realpath(dirname(__FILE__)));   

/*================== Define path to application directory ==========================================*/
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH',
			realpath(WEB_ROOT . DS . 'application'));
			
/*================== Define path to public directory ===============================================*/
defined('PUBLIC_PATH')
	|| define('PUBLIC_PATH',
			realpath(WEB_ROOT . DS . 'public'));
			
/*================== Define path to public directory ===============================================*/
defined('TEMP_PATH')
	|| define('TEMP_PATH',
			realpath(WEB_ROOT . DS . 'temp'));
