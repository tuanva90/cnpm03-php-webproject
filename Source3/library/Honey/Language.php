<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */

class Honey_Language {
	/**
	 * List of supported languages in order of alphabet
	 * @var array
	 */
	public static $LANGUAGES = array (
		'en_US' => array ('englishName' => 'English', 'localName' => 'English' ),
		'vi_VN' => array ('englishName' => 'Vietnamese', 'localName' => 'Tiếng Việt' )
	);
	
	/**
	 * Get available languages
	 * 
	 * @return array
	 */
	public static function getAvailableLanguages() {
						
		return self::$LANGUAGES;
	}
}
