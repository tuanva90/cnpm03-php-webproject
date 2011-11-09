<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */
class Honey_Db_Table extends Zend_Db_Table {
	/**
	 * Database table name
	 * 
	 * @var string
	 */
	protected $_name;
	
	/**
	 * Database table primary
	 * 
	 * @var string
	 */
	protected $_primary;
	
	/**
	 * Database table prefix
	 * 
	 * @var string
	 */
	protected $_prefix = '';
	
	/**
	 * The language content
	 * @var string
	 */
	protected $_lang = 'vi_VN';
	
	/**
	 * @return void
	 */
	public function __construct() {
		$this->_prefix = Honey_Config::getConfig ()->db->prefix;
		$this->_lang = Honey_Config::getConfig ()->localization->languages->default;
		parent::__construct ();
	}
	
	/**
	 * @param string $name
	 * @return Honey_Db_Table
	 */
	public function setName($name) {
		$this->_name = $this->_prefix . $name;
		return $this;
	}
	
	/**
	 * @param string $primary
	 * @return Honey_Db_Table
	 */
	public function setPrimary($primary) {
		$this->_primary = $primary;
		return $this;
	}
	
	/**
	 * @param string $lang
	 * @return Honey_Db_Table
	 */
	public function setLang($lang) {
		$this->_lang = $lang;
		return $this;
	}
	
	/**
	 * @return $lang
	 */
	public function getLang() {
		return $this->_lang;
	}
	
	/**
	 * @return $lang
	 */
	public function getPrefix() {
		return $this->_prefix;
	}
}