<?php
class Admin_ArticleController extends Honey_Controller_Action
{
    public function init ()
    {
        /* Layout */
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
        /* Get Params*/
        $this->_arrParam = $this->_request->getParams();
        $this->_module = $this->_arrParam['module'];
        $this->_controller = $this->_arrParam['controller'];
        $this->_action = $this->_arrParam['action'];
        $this->view->curent = $this->_module . '/' . $this->_controller . '/' .
        $this->_action;
    }
	
	public function indexAction()
    {
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
    	
  		$form = new ArticleListForm();
    	
    	$form->set_list_section($sectionlist);
    	$form->set_list_category($categorylist);
    	$form->set_list_author($authorlist);
    	$form->set_list_state($statelist);
    	$form->start_form($articlelist,$numberofpage);
    	
    	$this->view->form = $form;
    }

    public function moveAction(){
    	$listcate = array('Section 1'=>array('Category 1','Category 2','Category 3','Category 4'),
    	'Section 2'=>array('Category 1','Category 2','Category 3','Category 4'),
    	'Section 3'=>array('Category 1','Category 2','Category 3','Category 4'),
    	'Section 4'=>array('Category 1','Category 2','Category 3','Category 4'));
    	$listarticle = array(
    				array(
    				'title'=>'Article Title 1'),
    				array(
    				'title'=>'Article Title 2'),
    				array(
    				'title'=>'Article Title 3'),
    				array(
    				'title'=>'Article Title 4'),
    				array(
    				'title'=>'Article Title 5'));
    	
    	$form = new MoveArticleForm();
    	$form->ParseArticleList($listarticle);
    	$form->ParseCateList($listcate);
		$form->start_form();
		$this->view->form = $form;
    }
    
	public function copyAction(){
    	$listcate = array('Section 1'=>array('Category 1','Category 2','Category 3','Category 4'),
    	'Section 2'=>array('Category 1','Category 2','Category 3','Category 4'),
    	'Section 3'=>array('Category 1','Category 2','Category 3','Category 4'),
    	'Section 4'=>array('Category 1','Category 2','Category 3','Category 4'));
    	$listarticle = array(
    				array(
    				'title'=>'Article Title 1'),
    				array(
    				'title'=>'Article Title 2'),
    				array(
    				'title'=>'Article Title 3'),
    				array(
    				'title'=>'Article Title 4'),
    				array(
    				'title'=>'Article Title 5'));
    	
    	$form = new CopyArticleForm();
		$form->start_form($listcate,$listarticle);
		$this->view->form = $form;
    }
	
	public function configAction(){
		$initarray = array(
					'1'=>0,
					'2'=>1,
					'3'=>0,
					'4'=>0,
					'5'=>1,
					'6'=>1,
					'7'=>1,
					'8'=>0,
					'9'=>0,
					'10'=>0,
					'11'=>1,
					'12'=>0,
					'13'=>1,
					'14'=>1,
					'15'=>1);
		$form = new ArticleConfigForm();
		$form->parse_bin_array($initarray);
		$form->start_form();
		$this->view->form = $form;
	}
    public function sectionnewAction ()
    {}
    public function articlemoveAction ()
    {}
    public function sectioneditAction ()
    {}
}