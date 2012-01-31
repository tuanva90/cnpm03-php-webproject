<?php
class IndexController extends Honey_Controller_Action {
	
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

		$layout =  'index';
		$layoutPath = APPLICATION_PATH . '/templates/front/default';
		$this->loadTemplate ($layout, $layoutPath, 'template.ini', 'template' );
		
	}
	
	public function indexAction() {
		

	}

	public function saveblockAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		try {
  		$info = array(	"module_id" => $_POST['module_id'], 
						"name" 		=> $_POST['name'],
						"file_name" => $_POST['file_name'],
  						"is_showed"	=> $_POST['is_showed'],
  						"position"	=> $_POST['position'],
  						"sort_order"=> $_POST['sort_order'],
  						"option"	=> $_POST['option']
  		);
  		
  		$modules = new Front_Model_Module();
  		$modules->updateItem($info);
  		} catch (Exception $e) {
  			echo $e->getMessage();
  		}
	}
	
	public function savelayoutAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		try {
  		$layout = $_POST['currentLayout'];
  		$config = new Zend_Config_Ini(APPLICATION_PATH.DS."configs/application.ini",
  										null,
			                            array('allowModifications' => true));
  		$config->currentLayout = $layout;
  		
  		$writer = new Zend_Config_Writer_Ini(array("config" => $config,
                                           "filename" => APPLICATION_PATH .DS. "configs/application.ini"));
  		$writer->write();
  		} catch (Exception $e) {
  			echo $e->getMessage();
  		}
	}
	
	public function savepositionAction() {
		$this->_helper->layout()->disableLayout();
  		$this->_helper->viewRenderer->setNoRender(true);
  		try {
  			if(isset($_POST['col_1'])) {
  				$col1 = $_POST['col_1'];
  				Front_Model_Module::savePosition(COL_1_POSITION, $col1);
  			}
  			if(isset($_POST['col_2'])) {
  				$col2 = $_POST['col_2'];
  				Front_Model_Module::savePosition(COL_2_POSITION, $col2);
  			}
  			if(isset($_POST['col_main'])) {
  				$col_main = $_POST['col_main'];
  				Front_Model_Module::savePosition(COL_MAIN_POSITION, $col_main);
  			}
  		} catch (Exception $e) {
  			echo "Error: " . $e->getMessage();
  		}
	}
}