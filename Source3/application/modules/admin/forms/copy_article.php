<?php
require_once APPLICATION_PATH.'/forms/formNote.php';
class CopyArticleForm extends Zend_Form{
	private $catearray = array();
	private $articlearray = array();
	private $options = array();
	public function init(){
		$this->setMethod('post')->setAction('index');
	}
	public function start_form($var1,$var2){
		
	
		if(gettype($var1)=="array"){
			$this->catearray = $var1;
		//	$this->flag1 = true;
		}
		
		if (gettype($var2)=="array"){
			$this->articlearray = $var2;
			//$this->flag2 = true;
		}
		
		while(key($this->catearray) != null){
			$sect = key($this->catearray);
			foreach($this->catearray[$sect] as $cate){
				$sect_cate = $sect.'/'.$cate;
				$this->options[] = $sect_cate;
			}
			next($this->catearray);
		}
		$catelist = new Zend_Form_Element_Select('catelist');
		$catelist->setAttrib('size', '6')->setLabel('List category/section: ')
		->setMultiOptions($this->options)
		->setDecorators(array('ViewHelper','Label'));
				
		$values = "<ol>";
		foreach($this->articlearray as $article){
			$values = $values."<li>".$article['title']."</li>";
		}
		$values = $values."</ol>";
		
		$articlelist = new Application_Form_Element_Note('articlelist',array('value'=>$values,'label'=>'List articles to being copied:'));
		$articlelist->setDecorators(array('ViewHelper','Label'));
		
		$this->addElements(array($catelist,$articlelist));
	}
	public function echocatearray(){
		echo "<pre>";
		print_r($this->catearray);
		print_r($this->articlearray);
		echo "option<br>";
		print_r($this->options);
		echo "/option<br>";
		print_r($this->catearray['Section 1']);
		print_r($this->getSubForm('cates'));
		echo "</pre>";
		
	}
}