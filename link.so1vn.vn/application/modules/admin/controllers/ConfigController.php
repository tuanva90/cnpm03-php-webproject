<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */

class Admin_ConfigController extends Honey_Controller_Action {
	
	/**
	 * Available date time formats
	 * TODO: Use Zend_Locale to show the available formats based on the language
	 * @since 2.0.3
	 */
	private static $_DATE_FORMATS = array ('m-d-Y', 'd-m-Y', 'm.d.Y', 'Y-m-d', 'm/d/Y', 'm/d/y', 'F d, Y', 'M. d, y', 'd F Y', 'd-M-y', 'l, F d, Y' );
	
	private static $_DATETIME_FORMATS = array ('m-d-Y H:i:s', 'm-d-Y h:i:s A', 'd-m-Y H:i:s', 'd-m-Y h:i:s A', 'm.d.Y H:i:s', 'm.d.Y h:i:s A', 'Y-m-d H:i:s', 'Y-m-d h:i:s A', 'm/d/Y H:i:s', 'm/d/Y h:i:s A', 'm/d/y H:i:s', 'm/d/y h:i:s A', 'F d, Y H:i:s', 'F d, Y h:i:s A', 'M. d, y H:i:s', 'M. d, y h:i:s A', 'd F Y H:i:s', 'd F Y h:i:s A', 'd-M-y H:i:s', 'd-M-y h:i:s A', 'l, F d, Y H:i:s', 'l, F d, Y h:i:s A' );
	
	/**
	 * Supported caching systems
	 * @since 2.0.5
	 */
	private static $_CACHES = array ('file' => array ('name' => 'File', 'extensions' => null ), 'memcache' => array ('name' => 'Memcache', 'extensions' => array ('memcache' ) ) );
	
	/**
	 * Default charset
	 */
	private static $_DEFAULT_CHARSET = 'utf-8';
	
	/**
	 * Charsets
	 */
	private static $_CHARSETS = array ('Arabic (ISO-8859-6)' => 'iso-8859-6', 'Arabic (Windows-1256)' => 'windows-1256', 'Baltic (ISO-8859-4)' => 'iso-8859-4', 'Baltic (ISO-8859-13)' => 'iso-8859-13', 'Baltic (Windows-1257)' => 'windows-1257', 'Celtic (ISO-8859-14)' => 'iso-8859-14', 'Central European (ISO-8859-2)' => 'iso-8859-2', 'Central European (Windows-1250)' => 'windows-1250', 'Chinese Simplified (GBK)' => 'x-gbk', 'Chinese Simplified (gb18030)' => 'gb18030', 'Chinese Traditional (Big5)' => 'big5', 'Chinese Traditional (Big5-HKSCS)' => 'big5-hkscs', 'Cyrillic (ISO-8859-5)' => 'iso-8859-5', 'Cyrillic (Windows-1251)' => 'windows-1251', 'Cyrillic (KOI8-R)' => 'koi8-r', 'Cyrillic (KOI8-U)' => 'koi8-u', 'Greek (ISO-8859-7)' => 'iso-8859-7', 'Greek (Windows-1253)' => 'windows-1253', 'Hebrew (ISO-8859-8)' => 'iso-8859-8', 'Hebrew (ISO-8859-8-I)' => 'iso-8859-8-i', 'Hebrew (Windows-1255)' => 'windows-1255', 'Japanese (EUC)' => 'euc-jp', 'Japanese (ISO-2022-JP)' => 'iso-2022-jp', 'Japanese (Shift-JIS)' => 'shift-jis', 'Korean (EUC)' => 'euc-kr', 'Nordic (ISO-8859-10)' => 'iso-8859-10', 'Romanian (ISO-8859-16)' => 'iso-8859-16', 'South European (ISO-8859-3)' => 'iso-8859-3', 'Thai (ISO-8859-11)' => 'iso-8859-11', 'Thai (Windows-874)' => 'windows-874', 'Turkish (ISO-8859-9)' => 'iso-8859-9', 'Turkish (Windows-1254)' => 'windows-1254', 'Unicode (UTF-8)' => 'utf-8', 'Unicode (UTF-16LE)' => 'utf-16le', 'Vietnamese (Windows-1258)' => 'windows-1258', 'Western (ISO-8859-1)' => 'iso-8859-1', 'Western (ISO-8859-15)' => 'iso-8859-15', 'Western (Macintosh)' => 'macintosh', 'Western (Windows-1252)' => 'windows-1252' );
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	public function init() {
		$this->_arrParam = $this->_request->getParams ();
		
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
		
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout = 'index';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
		/** Set the initial stylesheet: */
		$this->view->headLink ( array ('rel' => 'shortcut icon', 'href' => HTTP_IMAGES . '/logo/favicon.png' ), 'PREPEND' );
	
	}
	
	public function indexAction() {
		$this->_redirect ( '/admin/config/app/' );
	
	}
	
	/**
	 * Configure application
	 * 
	 */
	public function appAction() {
		
		/**
		 * Increase execution time
		 */
		@ini_set ( 'execution_time', 0 );
		
		$sections = array ();
		$config = Honey_Config::getConfig ();
		foreach ( $config->toArray () as $section => $data ) {
			$sections [$section] = $data;
		}
		
		/**
		 * Web
		 */
		$siteName = isset ( $sections ['web'] ['name'] ) ? $sections ['web'] ['name'] : null;
		$defaultTitle = isset ( $sections ['web'] ['title'] ) ? $sections ['web'] ['title'] : null;
		$metaKeyword = isset ( $sections ['web'] ['meta'] ['keyword'] ) ? $sections ['web'] ['meta'] ['keyword'] : null;
		$metaDescription = isset ( $sections ['web'] ['meta'] ['description'] ) ? $sections ['web'] ['meta'] ['description'] : null;
		$currentTemplate = isset ( $sections ['web'] ['template'] ) ? $sections ['web'] ['template'] : null;
		$skin = isset ( $sections ['web'] ['skin'] ) ? $sections ['web'] ['skin'] : null;
		$currentCharset = isset ( $sections ['web'] ['charset'] ) ? $sections ['web'] ['charset'] : self::$_DEFAULT_CHARSET;
		
		$lang = isset ( $sections ['web'] ['language'] ['code'] ) ? $sections ['web'] ['language'] ['code'] : null;
		$langDirection = isset ( $sections ['web'] ['language'] ['direction'] ) ? $sections ['web'] ['language'] ['direction'] : 'ltr';
		$languages = isset ( $sections ['localization'] ['languages'] ['details'] ) ? $sections ['localization'] ['languages'] ['details'] : null;
		$itemCountPerPage = isset ( $sections ['web'] ['admin'] ['itemCountPerPage'] ) ? $sections ['web'] ['admin'] ['itemCountPerPage'] : '5';
		$pageRange = isset ( $sections ['web'] ['admin'] ['pageRange'] ) ? $sections ['web'] ['admin'] ['pageRange'] : '3';
		$currentTimeZone = isset ( $sections ['web'] ['datetime'] ['timezone'] ) ? $sections ['web'] ['datetime'] ['timezone'] : null;
		$dateTimeFormat = isset ( $sections ['web'] ['datetime'] ['format'] ['datetime'] ) ? $sections ['web'] ['datetime'] ['format'] ['datetime'] : null;
		$dateFormat = isset ( $sections ['web'] ['datetime'] ['format'] ['date'] ) ? $sections ['web'] ['datetime'] ['format'] ['date'] : null;
		$offline = isset ( $sections ['web'] ['offline'] ['enable'] ) ? $sections ['web'] ['offline'] ['enable'] : null;
		$offlineMessage = isset ( $sections ['web'] ['offline'] ['message'] ) ? $sections ['web'] ['offline'] ['message'] : null;
		$sessionLifetime = $sections ['web'] ['session'] ['cookie_lifetime'];
		$debugMode = $sections ['web'] ['debug'];
		
		/**
		 * 
		 */
		$siteUrl = $this->_request->getScheme () . '://' . $this->_request->getHttpHost ();
		$basePath = $this->_request->getBasePath ();
		if ($basePath != '') {
			$basePath = ltrim ( $basePath, '/' );
			$basePath = rtrim ( $basePath, '/' );
		}
		$url = ($basePath == '') ? $siteUrl : $siteUrl . '/' . $basePath;
		$staticUrl = ($basePath == '') ? $siteUrl : $siteUrl . '/' . $basePath;
		
		/**
		 * List of all available web
		 */
		$this->view->assign ( 'siteName', $siteName );
		$this->view->assign ( 'defaultTitle', $defaultTitle );
		$this->view->assign ( 'metaKeyword', $metaKeyword );
		$this->view->assign ( 'metaDescription', $metaDescription );
		$this->view->assign ( 'url', $url );
		
		$this->view->assign ( 'currentTemplate', $currentTemplate );
		
		$this->view->assign ( 'templates', array ($currentTemplate => 0 ) );
		
		$this->view->assign ( 'skin', $skin );
		$this->view->assign ( 'charsets', self::$_CHARSETS );
		$this->view->assign ( 'currentCharset', $currentCharset );
		$this->view->assign ( 'languages', $languages );
		$this->view->assign ( 'lang', $lang );
		$this->view->assign ( 'langDirection', $langDirection );
		$this->view->assign ( 'itemCountPerPage', $itemCountPerPage );
		$this->view->assign ( 'pageRange', $pageRange );
		$this->view->assign ( 'offline', $offline );
		$this->view->assign ( 'offlineMessage', $offlineMessage );
		$this->view->assign ( 'sessionLifetime', $sessionLifetime );
		$this->view->assign ( 'debugMode', $debugMode );
		
		/**
		 * Use Zend_Locale to populate the available timezones based on the language
		 * @see http://www.php.net/manual/en/timezones.php
		 * @see http://unicode.org/repos/cldr/trunk/docs/design/formatting/zone_log.html#windows_ids
		 * @since 2.0.7
		 */
		Zend_Locale::disableCache ( true );
		$timeZones = Zend_Locale::getTranslationList ( 'WindowsToTimezone', $lang );
		ksort ( $timeZones );
		$this->view->assign ( 'timeZones', $timeZones );
		
		$this->view->assign ( 'availableDateTimeFormats', self::$_DATETIME_FORMATS );
		$this->view->assign ( 'availableDateFormats', self::$_DATE_FORMATS );
		
		$this->view->assign ( 'currentTimeZone', $currentTimeZone );
		$this->view->assign ( 'dateTimeFormat', $dateTimeFormat );
		$this->view->assign ( 'dateFormat', $dateFormat );
		
		/**
		 * Cache settings
		 * @since 2.0.5
		 */
		$cacheTypes = array ();
		foreach ( self::$_CACHES as $cache => $info ) {
			$ok = true;
			if (is_array ( $info ['extensions'] )) {
				foreach ( $info ['extensions'] as $ext ) {
					if (! extension_loaded ( $ext )) {
						$ok = false;
						break;
					}
				}
			}
			if ($ok) {
				$cacheTypes [] = $info ['name'];
			}
		}
		
		$currCacheType = isset ( $sections ['cache'] ['backend'] ['name'] ) ? $sections ['cache'] ['backend'] ['name'] : null;
		$memcacheHost = isset ( $sections ['cache'] ['backend'] ['options'] ['servers'] ['server1'] ['host'] ) ? $sections ['cache'] ['backend'] ['options'] ['servers'] ['server1'] ['host'] : null;
		$memcachePort = isset ( $sections ['cache'] ['backend'] ['options'] ['servers'] ['server1'] ['port'] ) ? $sections ['cache'] ['backend'] ['options'] ['servers'] ['server1'] ['port'] : null;
		$cacheLifetime = isset ( $sections ['cache'] ['frontend'] ['options'] ['lifetime'] ) ? $sections ['cache'] ['frontend'] ['options'] ['lifetime'] : null;
		$cachePrefix = isset ( $sections ['cache'] ['frontend'] ['options'] ['cache_id_prefix'] ) ? $sections ['cache'] ['frontend'] ['options'] ['cache_id_prefix'] : null;
		
		$this->view->assign ( 'cacheTypes', $cacheTypes );
		$this->view->assign ( 'currCacheType', $currCacheType );
		$this->view->assign ( 'memcacheHost', $memcacheHost );
		$this->view->assign ( 'memcachePort', $memcachePort );
		$this->view->assign ( 'cacheLifetime', $cacheLifetime );
		$this->view->assign ( 'cachePrefix', $cachePrefix );
		
		if ($this->_request->isPost ()) {
			$url = $this->_request->getPost ( 'url' );
			$url = rtrim ( $url, '/' );
			
			$file = APPLICATION_PATH . DS . 'configs' . DS . 'application.ini';
			$config = new Zend_Config_Ini ( $file, null, array ('allowModifications' => true ) );
			$config = $config->toArray ();
			
			$config ['web'] ['name'] = $this->_request->getPost ( 'siteName' );
			$config ['web'] ['title'] = $this->_request->getPost ( 'title' );
			$config ['web'] ['url'] ['base'] = $url;
			$config ['web'] ['url'] ['static'] = $staticUrl;
			$config ['web'] ['template'] = $this->_request->getPost ( 'template' );
			$config ['web'] ['skin'] = $this->_request->getPost ( 'skin' );
			
			/**
			 * Allows user to set charset
			 * @since 2.0.6
			 */
			$config ['web'] ['charset'] = $this->_request->getPost ( 'charset' );
			
			$config ['web'] ['language'] ['code'] = $this->_request->getPost ( 'lang' );
			$config ['web'] ['language'] ['direction'] = $this->_request->getPost ( 'langDirection' );
			$config ['web'] ['admin'] ['itemCountPerPage'] = $this->_request->getPost ( 'itemCountPerPage' );
			$config ['web'] ['admin'] ['pageRange'] = $this->_request->getPost ( 'pageRange' );
			$config ['web'] ['meta'] ['keyword'] = preg_replace ( "/\s+/", ' ', strip_tags ( $this->_request->getPost ( 'metaKeyword' ) ) );
			$config ['web'] ['meta'] ['description'] = $this->_request->getPost ( 'metaDescription' );
			
			/**
			 * Set baseURL
			 * @since 2.0.3
			 */
			//if ('' != $basePath) {
			////	$config['production']['resources']['frontController']['baseUrl'] = '/' . $basePath . '/index.php';
			//} else {
			//	$config['production']['resources']['frontController']['baseUrl'] = '';	
			//}
			

			/**
			 * Allows user to set website in offline message
			 * @since 2.0.3
			 */
			if (( int ) $this->_request->getPost ( 'offline' ) == 1) {
				$config ['web'] ['offline'] ['enable'] = 'true';
			
			//$config['production']['resources']['frontController']['plugins']['offlineMessage'] = 'Core_Controllers_Plugin_OfflineMessage';
			} else {
				$config ['web'] ['offline'] ['enable'] = 'false';
			
			//if (isset($config['production']['resources']['frontController']['plugins']['offlineMessage'])) {
			//unset($config['production']['resources']['frontController']['plugins']['offlineMessage']);			
			//} 	
			}
			$config ['web'] ['offline'] ['message'] = $this->_request->getPost ( 'offlineMessage' );
			
			/**
			 * Allows user to set session lifetime and debug mode
			 * @since 2.0.5
			 */
			$config ['web'] ['session'] ['cookie_lifetime'] = $this->_request->getPost ( 'sessionLifetime' );
			$config ['web'] ['debug'] = ( int ) $this->_request->getPost ( 'debugMode' ) == 1 ? 'true' : 'false';
			
			$config ['web'] ['datetime'] ['timezone'] = $this->_request->getPost ( 'timezone' );
			$config ['web'] ['datetime'] ['format'] ['datetime'] = $this->_request->getPost ( 'datetimeFormat' );
			$config ['web'] ['datetime'] ['format'] ['date'] = $this->_request->getPost ( 'dateFormat' );
			
			/**
			 * Cache settings
			 */
			if ($this->_request->getPost ( 'cacheType' ) != '') {
				$config ['cache'] ['frontend'] ['name'] = 'Admin';
				$config ['cache'] ['frontend'] ['options'] ['lifetime'] = $this->_request->getPost ( 'cacheLifetime' );
				$config ['cache'] ['frontend'] ['options'] ['cache_id_prefix'] = $this->_request->getPost ( 'cachePrefix' );
				$config ['cache'] ['frontend'] ['options'] ['automatic_serialization'] = 'true';
				
				$config ['cache'] ['backend'] ['name'] = $this->_request->getPost ( 'cacheType' );
				switch (strtolower ( $this->_request->getPost ( 'cacheType' ) )) {
					case 'file' :
						$config ['cache'] ['backend'] ['options'] ['cache_dir'] = '{TEMP_PATH}{DS}cache';
						break;
					case 'memcache' :
						$config ['cache'] ['backend'] ['options'] ['servers'] ['server1'] ['host'] = $this->_request->getPost ( 'memcacheHost' );
						$config ['cache'] ['backend'] ['options'] ['servers'] ['server1'] ['port'] = $this->_request->getPost ( 'memcachePort' );
						break;
				}
			}
			
			/**
			 * Turn on MagicQuote plugin which disable magic quote setting if there is
			 * @since 2.0.3
			 */
			if (get_magic_quotes_gpc ()) {
				//$config['production']['resources']['frontController']['plugins']['magicQuote'] = 'Honey_Controller_Plugin_MagicQuote';	
			} else {
				//unset($config['production']['resources']['frontController']['plugins']['magicQuote']);
			}
			
			/**
			 * Write configuration to file
			 */
			$writer = new Zend_Config_Writer_Ini ();
			$writer->write ( $file, new Zend_Config ( $config ) );
			
			$this->_helper->getHelper ( 'FlashMessenger' )->addMessage ( $this->view->cmsTranslator ( 'install_config_success' ) );
			$this->_redirect ( '/admin/config/app/' );
		}
	}
	
	/**
	 * Configure mail server
	 * 
	 * @return void
	 */
	public function mailAction() {
		/**
		 * Increase execution time
		 */
		@ini_set ( 'execution_time', 0 );
		
		$sections = array ();
		$config = Honey_Config::getConfig ();
		foreach ( $config->toArray () as $section => $data ) {
			$sections [$section] = $data;
		}
		
		/**
		 * Mail
		 */
		
		$this->view->assign ( 'protocol', (isset ( $sections ['mail'] ['protocol'] )) ? $sections ['mail'] ['protocol'] : 'mail' );
		$this->view->assign ( 'host', (isset ( $sections ['mail'] ['smtp'] ['host'] )) ? $sections ['mail'] ['smtp'] ['host'] : null );
		$this->view->assign ( 'port', (isset ( $sections ['mail'] ['smtp'] ['port'] )) ? $sections ['mail'] ['smtp'] ['port'] : null );
		$this->view->assign ( 'username', (isset ( $sections ['mail'] ['smtp'] ['username'] )) ? $sections ['mail'] ['smtp'] ['username'] : null );
		$this->view->assign ( 'password', (isset ( $sections ['mail'] ['smtp'] ['password'] )) ? $sections ['mail'] ['smtp'] ['password'] : null );
		$this->view->assign ( 'security', (isset ( $sections ['mail'] ['smtp'] ['security'] )) ? $sections ['mail'] ['smtp'] ['security'] : null );
		
		if ($this->_request->isPost ()) {
			
			$file = APPLICATION_PATH . DS . 'configs' . DS . 'application.ini';
			$config = new Zend_Config_Ini ( $file, null, array ('allowModifications' => true ) );
			$config = $config->toArray ();
			
			$protocol = $this->_request->getPost ( 'protocol' );
			$config ['mail'] ['protocol'] = $protocol;
			switch ($protocol) {
				case 'mail' :
					if (isset ( $config ['mail'] ['smtp'] )) {
						unset ( $config ['mail'] ['smtp'] );
					}
					break;
				case 'smtp' :
					$config ['mail'] ['smtp'] ['host'] = $this->_request->getPost ( 'host' );
					
					$port = $this->_request->getPost ( 'port' );
					if ($port == null || $port == '') {
						unset ( $config ['mail'] ['smtp'] ['port'] );
					} else {
						$config ['mail'] ['smtp'] ['port'] = $port;
					}
					
					if ($this->_request->getPost ( 'authentication' ) == 'true') {
						$config ['mail'] ['smtp'] ['username'] = $this->_request->getPost ( 'username' );
						$config ['mail'] ['smtp'] ['password'] = $this->_request->getPost ( 'password' );
					} else {
						unset ( $config ['mail'] ['smtp'] ['username'] );
						unset ( $config ['mail'] ['smtp'] ['password'] );
					}
					
					$security = $this->_request->getPost ( 'security' );
					if ($security != 'none') {
						$config ['mail'] ['smtp'] ['security'] = $security;
					}
					break;
			}
			
			/**
			 * Write file
			 */
			$writer = new Zend_Config_Writer_Ini ();
			$writer->write ( $file, new Zend_Config ( $config ) );
			
			$this->_helper->getHelper ( 'FlashMessenger' )->addMessage ( $this->view->cmsTranslator ( 'config_server_success' ) );
			$this->_redirect ( '/admin/config/mail/' );
		}
	}

/**
	 * Configure localization settings
	 * 
	 * @return void
	 */
	public function localeAction()
	{
		/**
		 * Increase execution time
		 */
		@ini_set ( 'execution_time', 0 );
		
		$availableLocales = new Zend_Config_Ini(APPLICATION_PATH . DS . 'configs'  .DS . 'locales.ini', 'locales');
		$availableLocales = $availableLocales->languages->toArray();
		
		$locales = array();
		foreach ($availableLocales as $language) {
			$arr = explode('|', $language);
			$locales[$arr[0]] = array(
				'code'		  => $arr[0],
				'localName'   => $arr[1],
				'englishName' => $arr[2],
			);
		}
		
		/**
		 * Determine the default language
		 */
		$file      = APPLICATION_PATH . DS . 'configs' . DS . 'application.ini';
		$config    = new Zend_Config_Ini($file, null, array('allowModifications' => true));
		$config    = $config->toArray();
		$enable    = isset($config['localization']['enable'])
						? ('true' == $config['localization']['enable'])
						: false;
		$default   = isset($config['localization']['languages']['default'])
						? $config['localization']['languages']['default']
						: $config['web']['lang'];
		$available = isset($config['localization']['languages']['list'])
						? explode(',', $config['localization']['languages']['list'])
						: array($default);
						
		if ($this->_request->isPost ()) {
			$config['localization']['enable'] = ($this->_request->getPost('localizeEnable') != null)
												? 'true' : 'false';
			
			$default   = $this->_request->getPost('defaultLanguage');
			$available = $this->_request->getPost('supportedLanguages');
			$listLangs = array($default);
			if ($available != null) {
				foreach ($available as $index => $locale) {
					if ($locale != $default) {
						$listLangs[] = $locale;
					}
				}
			}
			
			$config['localization']['languages']['default'] = $default;
			$config['localization']['languages']['list']    = implode(',', $listLangs);
			$config['localization']['languages']['details'] = array();
			
			foreach ($listLangs as $lang) {
				$config['localization']['languages']['details'][$lang] = implode('|', array($locales[$lang]['code'], $locales[$lang]['localName'], $locales[$lang]['englishName'])); 
			}
			
			/**
			 * Translator service settings
			 */
			$config['localization']['translate']['auto']                           
					= ($this->_request->getPost('autoTranslate') != null) ? 'true' : 'false';
			$config['localization']['translate']['service']['using']			   
					= $this->_request->getPost('service', 'google');
			$config['localization']['translate']['service']['google']['apikey']    
					=  $this->_request->getPost('googleApiKey');
			$config['localization']['translate']['service']['microsoft']['apikey'] 
					=  $this->_request->getPost('microsoftApiKey');
			
			$writer = new Zend_Config_Writer_Ini();
			$writer->write($file, new Zend_Config($config));
			
			$this->_helper->getHelper('FlashMessenger')
					->addMessage($this->view->cmsTranslator('locale_config_updated_success'));
			
			$this->_redirect ( '/admin/config/locale/' );
		}
		
		$this->view->assign('enable', $enable);
		$this->view->assign('defaultLanguage', $default);
		$this->view->assign('availableLanguages', $available);
		$this->view->assign('config', $config['localization']);
		$this->view->assign('locales', $locales);
	}
}