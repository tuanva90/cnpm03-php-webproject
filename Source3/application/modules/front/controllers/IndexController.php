<?php
class IndexController extends Honey_Controller_Action
{
    //Parameter array received in any Action
    protected $_arrParam;
    //The path of the Controller
    protected $_currentController;
    //The path of the Action
    protected $_actionMain;
    public function init ()
    {
        $this->_arrParam = $this->_request->getParams();
        $this->_currentController = '/' . $this->_arrParam['module'] . '/' .
         $this->_arrParam['controller'];
        $this->_actionMain = '/' . $this->_arrParam['module'] . '/' .
         $this->_arrParam['controller'] . '/index';
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/front/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
    }
    public function indexAction () {
    	$site_model = new Front_Model_Sites();
		$module_model = new Front_Model_Module();
		$this->view->item = $site_model->getItemByName("Home Page");
		$this->view->modules = $module_model->getItemBySite($this->view->item['id']);
    }
    
    public function saveblockAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        try {
            $info = array("module_id" => $_POST['module_id'], 
            "name" => $_POST['name'], "file_name" => $_POST['file_name'], 
            "is_showed" => $_POST['is_showed'], "position" => $_POST['position'], 
            "sort_order" => $_POST['sort_order'], "option" => $_POST['option']);
            $modules = new Front_Model_Module();
            $modules->updateItem($info);
            //echo $info['is_showed'];
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //////////////////ThaoNX///////////////////////
 	public function saveblock2Action ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if (isset($_POST['is_showed']) && isset($_POST['module_id']) ) {
            $info = array("module_id" => $_POST['module_id'],             
            "is_showed" => $_POST['is_showed']);
            $modules = new Front_Model_Module();
            $result = $modules->updateItemToShow($info);
            echo $result;
        }
          
    }
    
 	public function moremodulesAction ()
    {
        $this->_helper->layout()->disableLayout();
        $model_module = new Front_Model_Module();
		$items = $model_module->listItemsNotShowed(Array('is_showed'=>0));
		$this->view->items = $items;           
    }
    
 	public function impressiveproductsAction ()
    {
    	try {
        $this->_helper->layout()->disableLayout();        
        $product_model = new Front_Model_Product();
		$arrParam['order_mode'] = "viewed DESC";
		$arrParam['paginator'] = array(
			'itemCountPerPage' => isset($_POST['num_rows'])?$_POST['num_rows']:5,
			'currentPage' => 1,
		);
		$items = $product_model->listItem($arrParam,array('task'=>'list'));		
		$this->view->items = $items;
    	} catch (Exception $e) {
            echo $e->getMessage();
        } 
    }
    
 	public function mostviewedAction ()
    {
    	try {
        $this->_helper->layout()->disableLayout();        
        $news_model = new Front_Model_News();
		$arrParam['order_mode'] = "viewed DESC";
		$arrParam['paginator'] = array(
			'itemCountPerPage' => isset($_POST['num_rows'])?$_POST['num_rows']:5,
			'currentPage' => 1,
		);
		$items = $news_model->listItem($arrParam,array('task'=>'list'));		
		$this->view->items = $items;
    	} catch (Exception $e) {
            echo $e->getMessage();
        } 
    }
    
     public function newestproductsAction ()
    {
    	try {
        $this->_helper->layout()->disableLayout();        
        $news_model = new Front_Model_Product();
		$arrParam['order_mode'] = "date_added DESC";
		$arrParam['paginator'] = array(
			'itemCountPerPage' => isset($_POST['num_rows'])?$_POST['num_rows']:5,
			'currentPage' => 1,
		);
		$items = $news_model->listItem($arrParam,array('task'=>'list'));		
		$this->view->items = $items;
    	} catch (Exception $e) {
            echo $e->getMessage();
        } 
    }
    
    ////////////////////////////////////////////
    public function savelayoutAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        try {
            $layout = $_POST['currentLayout'];
            $config = new Zend_Config_Ini(
            APPLICATION_PATH . DS . "configs/application.ini", null, 
            array('allowModifications' => true));
            $config->layout->currentLayout = $layout;
            $writer = new Zend_Config_Writer_Ini(
            array("config" => $config, 
            "filename" => APPLICATION_PATH . DS . "configs/application.ini"));
            $writer->write();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function savethemeAction() {
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        try {
            $theme = $_POST['currentTheme'];
            $config = new Zend_Config_Ini(
            APPLICATION_PATH . DS . "configs/application.ini", null, 
            array('allowModifications' => true));
            $config->theme->currentTheme = $theme;
            $writer = new Zend_Config_Writer_Ini(
            array("config" => $config, 
            "filename" => APPLICATION_PATH . DS . "configs/application.ini"));
            $writer->write();
        } catch (Exception $e) {
            echo $e->getMessage();
        }	
    }
    
    public function savepositionAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        try {
            if (isset($_POST['col_1'])) {
                $col1 = $_POST['col_1'];
                Front_Model_Module::savePosition(COL_1_POSITION, $col1);
            }
            if (isset($_POST['col_2'])) {
                $col2 = $_POST['col_2'];
                Front_Model_Module::savePosition(COL_2_POSITION, $col2);
            }
            if (isset($_POST['col_main'])) {
                $col_main = $_POST['col_main'];
                Front_Model_Module::savePosition(COL_MAIN_POSITION, $col_main);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function sendcontactAction ()
    {
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    	try {
	        if (array_key_exists('send', $_POST)) {
	            $to = 'huynvk@gmail.com';
	
	            //go ahead only if all required fields OK
	            //if ($_SESSION['security_code'] == $_POST['security_code']) {
	            if (true) {
	                //build the message 
	                $message = "Name: ".$_POST['name']."\n\n";
	                $message .= "Email: ".$_POST['email']."\n\n";
	                $message .= "Comments: ".$_POST['comments'];
	                //limit line lenght to 200 chars
	                $message = wordwrap($message, 200);
	                //Send it
	                $mailSent = mail($to, $_POST['subject'], $message);
	                if (!$mailSent) {
	                    echo "Error sending mail";
	                }
	            }
	        }
    	} catch(Exception $e) {
    		echo "Error:" + $e->getMessage();
    	}
    	echo "Error dzmnaskdjhasd";
    }
	public function searchAction()
    {
    	$this->_helper->layout()->disableLayout();
    	try{    		
	    	$TuKhoa= $_POST['tukhoa'];
	    	$db = Zend_Registry::get('connectDB');
			$query = "select * from cms_product where model like '%".$TuKhoa."%'";
			$result = $db->fetchAll($query);
		     $this->view->results = $result;
    	}catch(Exception $e) {
    		echo "Error:" + $e->getMessage();
    	}
    }
}