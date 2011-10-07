<?php
/**
 * Check PHP version
 * @since 2.0.1
 */
if (version_compare(phpversion(), '5.2.0', '<') === true) {
    die('ERROR: Your PHP version is ' . phpversion() . '. Honey CMS requires PHP 5.2.0 or newer.');
}

include_once 'config.php';

/*================== Define application environment ================================================*/
defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV',
			(getenv(APPLICATION_ENV) ? getenv(APPLICATION_ENV)
									: 'development'));

/*================== Trypically, you will also want to add your library/ direactory ================*/
/*================== to the include_path, particularly if it contains you ZF installed =============*/
set_include_path(implode(PS, array(
	WEB_ROOT . DS . 'library',
	get_include_path(),
)));

/*================== Zend Application ==============================================================*/
require_once 'Zend/Application.php';
$environment = APPLICATION_ENV;
$options = APPLICATION_PATH . DS . 'configs' . DS . 'application.ini';
$application = new Zend_Application($environment, $options);
$application->bootstrap()->run();