<?php
require_once APPLICATION_PATH.'/forms/formNote.php';
class ArticleConfigForm extends Zend_Form{
	private $binarray;
	
	public function parse_bin_array($var){
		$this->binarray = $var; 
	}
	
	public function init(){
		$this->setAction('index')->setMethod('post');
		//$this->clearDecorators();
		//$this->addDecorator('HtmlTag',array('tag'=>'table'))
		//->addDecorator('Form');
		/**
		 * Add theo kieu tren thi se duoc table trong form
		 * Add theo kieu addDecorators(array('Form','FormElements',array('HtmlTag',array('tag'=>'table'))))
		 * se duoc form nam trong table
		 */
	}
	
	public function start_form(){
		/**
		 * Nhóm button
		 */
		$btnsave = new Zend_Form_Element_Button('Save');
		$btnsave->setDecorators(array('ViewHelper'));
		$btncancel = new Zend_Form_Element_Button('Cancel');
		$btncancel->setDecorators(array('ViewHelper'));
		
		/**
		 * Tiêu đề
		 */
		$title = new Application_Form_Element_Note('title',array('value'=>'Articles'));
		$title->setDecorators(array('ViewHelper'));
		
		/**
		 * Add vao form
		 */
		$this->addElements(array($btnsave,$btncancel,$title));
		
		/**
		 * Table chua cac lua chon(radio button)
		 */
		
		/**
		 * 
		 * Show authorized links radio button
		 * @var Zend_Form_Element_Radio
		 */
		$show_authorized_links  = new Zend_Form_Element_Radio('showauthorizedlink');
		$show_authorized_links->setMultiOptions(array('0'=>'No','1'=>'Yes'))
		->setSeparator('')
		->setValue($this->binarray['1'])
		->setDecorators(array('ViewHelper'));
        
        /**
         * 
         * Show article title radio button
         * @var Zend_Form_Element_Radio
         */
        $show_article_title = new Zend_Form_Element_Radio('showarticletitle');
		$show_article_title->setMultiOptions(array('0'=>'No','1'=>'Yes'))
		->setSeparator('')
		->setValue($this->binarray['2'])
		->setDecorators(array('ViewHelper'));
        
		/**
		 * 
		 * Title Linkable
		 * @var unknown_type
		 */
		$title_linkable = new Zend_Form_Element_Radio('titlelinkable');
		$title_linkable->setMultiOptions(array('0'=>'No','1'=>'Yes'))
		->setSeparator('')
		->setValue($this->binarray['3'])
		->setDecorators(array('ViewHelper'));
        
		/**
		 * 
		 * Show Nevigation
		 * @var unknown_type
		 */
      	$show_nevigation = new Zend_Form_Element_Radio('shownevigation');
		$show_nevigation->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['4'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Show Read more link
		 * @var unknown_type
		 */
      	$show_read_more = new Zend_Form_Element_Radio('showreadmore');
		$show_read_more->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['5'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Show intro text
		 * @var unknown_type
		 */
      	$show_intro = new Zend_Form_Element_Radio('showintro');
		$show_intro->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['6'])
		->setDecorators(array('ViewHelper'));
        /**
         * 
         * Show a separator
         * @var Application_Form_Element_Note
         */
      	$separator = new Application_Form_Element_Note('separator',array('value'=>'<hr>'));
      	$separator->setDecorators(array('ViewHelper'));

      	/**
		 * 
		 * Show section name in an article
		 * @var unknown_type
		 */
      	$show_section_name = new Zend_Form_Element_Radio('showsection');
		$show_section_name->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['7'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Is section title linkable
		 * @var unknown_type
		 */
      	$section_title_linkable = new Zend_Form_Element_Radio('sectionlinkable');
		$section_title_linkable->setMultiOptions(array('0'=>'No','1'=>'Yes'))
		->setSeparator('')
		->setValue($this->binarray['8'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Show category name in an article
		 * @var unknown_type
		 */
      	$show_category_name = new Zend_Form_Element_Radio('showcategory');
		$show_category_name->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['9'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Is category title linkable
		 * @var unknown_type
		 */
      	$category_title_linkable = new Zend_Form_Element_Radio('categorylinkable');
		$category_title_linkable->setMultiOptions(array('0'=>'No','1'=>'Yes'))
		->setSeparator('')
		->setValue($this->binarray['10'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Show author name in an article
		 * @var unknown_type
		 */
      	$show_author_name = new Zend_Form_Element_Radio('showauthor');
		$show_author_name->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['11'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Is author name linkable
		 * @var unknown_type
		 */
      	$author_name_linkable = new Zend_Form_Element_Radio('authorlinkable');
		$author_name_linkable->setMultiOptions(array('0'=>'No','1'=>'Yes'))
		->setSeparator('')
		->setValue($this->binarray['12'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Show created date of an article
		 * @var unknown_type
		 */
      	$show_created_date = new Zend_Form_Element_Radio('showcreatedate');
		$show_created_date->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['13'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Show modified date of an article
		 * @var unknown_type
		 */
      	$show_modified_date = new Zend_Form_Element_Radio('showmodifydate');
		$show_modified_date->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['14'])
		->setDecorators(array('ViewHelper'));
		
		/**
		 * 
		 * Show number of hit of an article
		 * @var unknown_type
		 */
      	$show_hits = new Zend_Form_Element_Radio('showhits');
		$show_hits->setMultiOptions(array('0'=>'Hide','1'=>'Show'))
		->setSeparator('')
		->setValue($this->binarray['15'])
		->setDecorators(array('ViewHelper'));
      	/**
      	 * Add elements to form
      	 */
		$this->addElements(array($show_authorized_links,
		$show_article_title,
		$title_linkable,
		$show_nevigation,
		$show_read_more,
		$show_intro,
		$separator,
		$show_section_name,
		$section_title_linkable,
		$show_category_name,
		$category_title_linkable,
		$show_author_name,
		$author_name_linkable,
		$show_created_date,
		$show_modified_date,
		$show_hits));
	}
}