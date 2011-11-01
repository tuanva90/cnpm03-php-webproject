<?php
/**
 * Check PHP version
 */
if (version_compare(phpversion(), '5.2.0', '<') === true) {
    die('ERROR: Your PHP version is ' . phpversion() . '. Honey CMS requires PHP 5.2.0 or newer.');
}

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

include_once 'config.php';

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
		
/*================== Define application environment ================================================*/
defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV',
			(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
									: 'development'));

/*================== Trypically, you will also want to add your library/ direactory ================*/
/*================== to the include_path, particularly if it contains you ZF installed =============*/
set_include_path(implode(PS, array(
	WEB_ROOT . DS . 'library',
	get_include_path(),
)));

/*================== Zend Application ==============================================================*/

/**
 * Run the application
 * Use Zend_Application
 */
require_once 'Zend/Application.php';
$environment = APPLICATION_ENV;
$application = new Zend_Application(
    $environment,
    APPLICATION_PATH . DS . 'configs'. DS . 'application.ini'
);


/**
 * Don't store following options to application.ini, because when user try to install,
 * the installer can not save these options to application.ini
 * (it replaces APPLICATION_PATH with real path)
 */
$options = array(
	'bootstrap' => array(
    	'path' 	=> APPLICATION_PATH . DS . 'Bootstrap.php',
		'class' => 'Bootstrap',
    ),
    'autoloadernamespaces' => array(
    	'honey' => 'Honey_',
    ),
	'resources' => array(
		'frontController' => array(
			'moduleDirectory'				=> APPLICATION_PATH . DS . 'modules',
			'moduleControllerDirectoryName'	=> 'controllers',
    		'defaultModule'		  			=> 'front',
    		/*'throwExceptions'	  			=> 1,*/
    		'params'	=> array(
    			'displayExceptions'	=> 1,
    		),  		
		),
		'layout' => array(
			'layoutPath'	=> APPLICATION_PATH . DS . 'templates' . DS . 'front' . DS . 'default',
			'layout'		=> 'index'
		),
		'view' => array(
			'helperPath' => array(
				'Honey_View_Helper'	=> 'Honey' . DS . 'View' . DS . 'Helper',
				'Block'				=> APPLICATION_PATH . DS . 'blocks',
			),
		),
		'modules' => array(
		),
	),
);
$options = $application->mergeOptions($application->getOptions(), $options);
$application->setOptions($options)
			->bootstrap()
			->run();