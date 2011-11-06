<?php
require_once APPLICATION_PATH.'\modules\admin\forms\formNote.php';
class Admin_Form_ArticleList extends Zend_Form{
	private $myVar;
	private $list_section;
	private $list_category;
	private $list_author;
	private $list_state;
	
	public function set_list_section($var)
	{
		$this->list_section = $var;
	}
	public function set_list_category($var)
	{
		$this->list_category = $var;
	}
	public function set_list_author($var)
	{
		$this->list_author = $var;
	}
	public function set_list_state($var)
	{
		$this->list_state = $var;
	}
	public function init(){
		$this->setAction('index')->setMethod('post');
		$numberofpage = 5;
    	$articlelist = array(
    				array(
    				'title'=>'Article Title 1',
    				'published'=>'published',
    				'order'=>'2',
    				'accesslvl'=>'public',
    				'section'=>'Section 1',
    				'category'=>'Category 1',
    				'Author'=>'Administrator',
    				'date'=>'27.09.11',
    				'hits'=>'1',
    				'id'=>'13'),
    				array(
    				'title'=>'Article Title 2',
    				'published'=>'unpublished',
    				'order'=>'2',
    				'accesslvl'=>'private',
    				'section'=>'Section 2',
    				'category'=>'Category 2',
    				'Author'=>'Administrator',
    				'date'=>'27.09.11',
    				'hits'=>'2',
    				'id'=>'11'),
    				array(
    				'title'=>'Article Title 3',
    				'published'=>'published',
    				'order'=>'5',
    				'accesslvl'=>'public',
    				'section'=>'Section 3',
    				'category'=>'Category 3',
    				'Author'=>'Administrator',
    				'date'=>'27.09.11',
    				'hits'=>'1',
    				'id'=>'31'),
    				array(
    				'title'=>'Article Title 3',
    				'published'=>'published',
    				'order'=>'5',
    				'accesslvl'=>'public',
    				'section'=>'Section 3',
    				'category'=>'Category 3',
    				'Author'=>'Administrator',
    				'date'=>'27.09.11',
    				'hits'=>'1',
    				'id'=>'31'),
    				array(
    				'title'=>'Article Title 3',
    				'published'=>'published',
    				'order'=>'5',
    				'accesslvl'=>'public',
    				'section'=>'Section 3',
    				'category'=>'Category 3',
    				'Author'=>'Administrator',
    				'date'=>'27.09.11',
    				'hits'=>'1',
    				'id'=>'31'));
  		$sectionlist = array('Section 1','Section 2','Section 3','Section 4');
  		$categorylist = array('Category 1','Category 2','Category 3','Category 4');
  		$authorlist = array('Author 1','Author 2','Author 3','Author 4');
  		$statelist = array('State 1','State 2','State 3','State 4');
    	
  		
    	
    	$this->set_list_section($sectionlist);
    	$this->set_list_category($categorylist);
    	$this->set_list_author($authorlist);
    	$this->set_list_state($statelist);
    	$this->start_form($articlelist,$numberofpage);
	}
	public function start_form($articles,$numberofpage){
		
		//------------------------------------------add table cho nhom filter--------------------------------//
		$filterBox = new Zend_Form_Element_Text('filter');
		$filterBox->setDecorators(array('ViewHelper','Label'))->setLabel('Filter: ');
		
		$goButton = new Zend_Form_Element_Button('Go');
		$goButton->setDecorators(array('ViewHelper'));
		
		$resetButton = new Zend_Form_Element_Button('Reset');
		$resetButton->setDecorators(array('ViewHelper'));
		
		$this->addElements(array($filterBox,$goButton,$resetButton));
		
		$sectCombo = new Zend_Form_Element_Select('sectionSelect');
		$sectCombo->setDecorators(array('ViewHelper'))
		->setMultiOptions($this->list_section);
		
		$cateCombo = new Zend_Form_Element_Select('categorySelect');
		$cateCombo->setDecorators(array('ViewHelper'))
		->setMultiOptions($this->list_category);
		
		$authCombo = new Zend_Form_Element_Select('authorSelect');
		$authCombo->setDecorators(array('ViewHelper'))
		->setMultiOptions($this->list_author);
		
		$stateCombo = new Zend_Form_Element_Select('stateSelect');
		$stateCombo->setDecorators(array('ViewHelper'))
		->setMultiOptions($this->list_state);
		
		$testcheckbox = new Zend_Form_Element_Checkbox('testcheckbox');
		$testcheckbox->setDecorators(array('ViewHelper'));
		
		$this->addElements(array($testcheckbox,$sectCombo,$cateCombo,$authCombo,$stateCombo));
		
		//---------------------------Table & Table Header-------------------------------------//
		$table_header = new Zend_Form_SubForm();
		
		$indexheader = new Application_Form_Element_Note('indexheader',array('value'=>'#'));
		$indexheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'5'))));
		
		$checkboxCol = new Zend_Form_Element_Checkbox('checkboxCol');
		$checkboxCol->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'5'))));
		
		$titleheader = new Application_Form_Element_Note('titleheader',array('value'=>'Title'));
		$titleheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th'))));
		
		$publishedheader = new Application_Form_Element_Note('publishedheader',array('value'=>'Published'));
		$publishedheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','nowrap'=>'nowrap','width'=>'8%'))));
		
		$orderheader = new Application_Form_Element_Note('orderheader',array('value'=>'Order'));
		$orderheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'8%'))));
		
		$accesslevelheader = new Application_Form_Element_Note('accesslevelheader',array('value'=>'Access Level'));
		$accesslevelheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'7%'))));
		
		$sectionheader = new Application_Form_Element_Note('sectionheader',array('value'=>'Section'));
		$sectionheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'8%','nowrap'=>'nowrap'))));
		
		$categoryheader = new Application_Form_Element_Note('categoryheader',array('value'=>'Category'));
		$categoryheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'8%','nowrap'=>'nowrap'))));
		
		$authorheader = new Application_Form_Element_Note('authorheader',array('value'=>'Author'));
		$authorheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'8%','nowrap'=>'nowrap'))));
		
		$dateheader = new Application_Form_Element_Note('dateheader',array('value'=>'Date'));
		$dateheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'10'))));
		
		$hitsheader = new Application_Form_Element_Note('hitsheader',array('value'=>'Hits'));
		$hitsheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'10'))));
		
		$idheader = new Application_Form_Element_Note('idheader',array('value'=>'ID'));
		$idheader->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'th','width'=>'1%'))));
		
		//-----------------------------------------------Add element------------------------------------//
		$table_header->addElements(array($indexheader,$checkboxCol,$titleheader,$publishedheader,$orderheader,$accesslevelheader,$sectionheader,$categoryheader,$authorheader,$dateheader,$hitsheader,$idheader));
		$table_header->setDecorators(array('FormElements',array('HtmlTag',array('tag'=>'tr'))));
		
		//$table_header_index = count($this->_subForms)+1;
		$table_header->setElementsBelongTo($table_header);
		$this->addSubform($table_header, 'fuckingname');
		//-----------------------------add rows - Moi bai viet them vao 1 row-------------------------------//
		$index=0;
		foreach($articles as $rowdata)
		{
			$index++;
			$this->addrow($rowdata,$index);
		}
		//-------------------------------------phan duoi-------------------------------------------------------//
		/**
		 * 
		 * Subform cho phan nevigation duoi
		 * @var unknown_type
		 */
		$nevBar = new Zend_Form_SubForm();
		$nevBar->setDecorators(array('FormElements',array('HtmlTag',array('tag'=>'div','class'=>'nevigationbar'))));
		
		$displayperpage = new Zend_Form_Element_Select('displayperpage');
		$option = array(5,10,15,20,25,30);
		$displayperpage->setMultiOptions($option)->setLabel('#Display ')->setDecorators(array('ViewHelper','Label'));
		
		$nevBar->addElements(array($displayperpage));
		
		if($numberofpage > 1){
			$startbutton = new Zend_Form_Element_Button('Start');
			$startbutton->setDecorators(array('ViewHelper'));
			
			$prevbutton = new Zend_Form_Element_Button('Previous');
			$prevbutton->setDecorators(array('ViewHelper'));
			
			$nevBar->addElements(array($startbutton,$prevbutton));
			
			//$pages = array();
			for($i = 1; $i <= $numberofpage; $i++)
			{
				$page = new Application_Form_Element_Note('page'.$i);
				$page->setDisableLoadDefaultDecorators(true);
				$page->setValue('<a href=\'#\'>'.$i.'</a>');
				//if ($i == 1)
				//	$page->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'div','openOnly'=>true,'class'=>'mypages'))));
				//elseif($i == $numberofpage)
					//$page->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'div','closeOnly'=>true))));
				$page->setDecorators(array('ViewHelper'));
				
				// add elements to array of element
				//$pages[] = $page;
				$nevBar->addElement($page);
			}
			//
			
			$endbutton = new Zend_Form_Element_Button('End');
			$endbutton->setDecorators(array('ViewHelper'));
			
			$nextbutton = new Zend_Form_Element_Button('Next');
			$nextbutton->setDecorators(array('ViewHelper'));
			
			$nevBar->addElements(array($nextbutton,$endbutton));
		}
		
		$nevBar->setElementsBelongTo($nevBar);
		$this->addSubForm($nevBar, 'nevigationbar');
		
		//---------------------------------image test-----------------------------------------------------//
		$image = new Zend_Form_Element_Image('myimage');
		$image->setDecorators(array(
							    'ViewHelper',
							    array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
							    array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
							    array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
							    ))
		->setValue("http://weierophinney.net/matthew/img/icon.jpg");
		$this->addElement($image);
	}
	public function addrow($rowdata,$index)
	{		
		$index = (string)$index;
		
		$row = new Zend_Form_SubForm();
		
		$index = new Application_Form_Element_Note('index',array('value'=>$index));
		$index->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td'))));
		
		$checkbox = new Zend_Form_Element_Checkbox('checkbox');
		$checkbox->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$title = new Application_Form_Element_Note('title',array('value'=>$rowdata['title']));
		$title->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td'))));
		
		
		//if($rowdata['published']=='published')
		//	$option = array('name'=>'publisedimage','label'=>'','src'=>'http://i665.photobucket.com/albums/vv15/hoangduc17t/publish_g.png');
		//else $option = array('name'=>'publishedimage','label'=>'','src'=>'http://i665.photobucket.com/albums/vv15/hoangduc17t/publish_x.png');
		$publishicon = new Zend_Form_Element_Image('publishicon');
		$publishicon->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		if($rowdata['published']=='published')
			$publishicon->setImage('/articlemanager/public/images/publish_g.png');
		else $publishicon->setImage('/articlemanager/public/images/publish_x.png');

		//Du phong
		/*
		$publishicon2 = new Application_Form_Element_Note('publishicon2');
		$publishicon2->setValue('<img src=\'http://i665.photobucket.com/albums/vv15/hoangduc17t/publish_g.png\'>')
		->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		*/
		$orderbox2 = new Zend_Form_Element_Text('orderbox');
		$orderbox2->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$accesslvl = new Application_Form_Element_Note('accesslvl',array('value'=>$rowdata['accesslvl']));
		$accesslvl->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$section = new Application_Form_Element_Note('section',array('value'=>$rowdata['section']));
		$section->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$category = new Application_Form_Element_Note('category',array('value'=>$rowdata['category']));
		$category->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$author = new Application_Form_Element_Note('author',array('value'=>$rowdata['Author']));
		$author->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$date = new Application_Form_Element_Note('date',array('value'=>$rowdata['date']));
		$date->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$hits = new Application_Form_Element_Note('hits',array('value'=>$rowdata['hits']));
		$hits->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$articleid = new Application_Form_Element_Note('id',array('value'=>$rowdata['id']));
		$articleid->setDecorators(array('ViewHelper',array('HtmlTag',array('tag'=>'td','align'=>'center'))));
		
		$row->addElements(array($index,$checkbox,$title,$publishicon,$orderbox2,$accesslvl,$section,$category,
		$author,$date,$hits,$articleid));
		
		$row->setDecorators(array('FormElements',array('HtmlTag',array('tag'=>'tr'))));
		
		
		$row_index = count($this->_subForms)+1;
		$row->setElementsBelongTo($row);
		$this->addSubform($row, 'row'.$index);
	}
	public function getSubFormName()
	{
		foreach($this->getSubForms() as $subform)
		{
			echo $subform->getName();
			echo "<br>";
		}
	}
	public function echoarticles(){
		foreach($this->getSubForms() as $subform)
		{
			if($subform->getName()!='fuckingname')
			{
				if($subform->getName() != 'nevigationbar')
					echo $subform;
			}
		}
	}
}