<?php
class Admin_ConfigController extends Honey_Controller_Action
{
    public function init ()
    {
        /* Layout */
        $layout = 'index';
        $layoutPath = APPLICATION_PATH . '/templates/admin/default';
        $this->loadTemplate($layout, $layoutPath, 'template.ini', 'template');
        /* Get Params */
    
        $this->_arrParam = $this->_request->getParams();
        $this->_module = $this->_arrParam['module'];
        $this->_controller = $this->_arrParam['controller'];
        $this->_action = $this->_arrParam['action'];
        $this->view->curent = $this->_module . '/' . $this->_controller . '/' .
        $this->_action;
        
    }
    public function indexAction ()
    {}
    public function siteAction ()
    {
    	$pathConfig=APPLICATION_PATH.'/configs/application.ini';
    	 $siteForm=new Admin_Form_ConfigSite();
    	 $siteForm->setAction($this->view->baseUrl() . '/config/site');
    	 $siteForm->setMethod('post');
    	if($this->getRequest()->isPost()){
			if($siteForm->isValid($_POST)){
				$option = array('allowModifications'=>true,
								'nestSeparator'=>'.');
				$data = $siteForm->getValues();

				$config = new Zend_Config_Ini($pathConfig,null,$option);
				$config->web->name=$data['sitename'];
				$config->web->meta->description=$data['sitedecription'];
				$config->web->offline->message=$data['message'];
				$config->web->offline->enable=$data['status'];
				$config->web->editor=$data['editor'];
				$config->web->session->cookie_lifetime=$data['defaultlimit'];
				
				$writeConfig = new Zend_Config_Writer_Ini(array('config'=>$config,
														'filename'=>$pathConfig));
  				$writeConfig->write();
			}
		}
		$this->view->form = $siteForm;
    }
    public function systemAction ()
    {
    	$pathConfig=APPLICATION_PATH.'/configs/application.ini';
    	 $siteForm=new Admin_Form_ConfigSystem();
    	 $siteForm->setAction($this->view->baseURL(). '/config/system');
    	 $siteForm->setMethod("post");
    	if($this->getRequest()->isPost()){
			if($siteForm->isValid($_POST)){
				$option = array('allowModifications'=>true,
								'nestSeparator'=>'.');
				$data = $siteForm->getValues();
				$config = new Zend_Config_Ini($pathConfig, null,$option);
				$config->web->datetime->timezone=$data['timezone'];
				$config->web->fpt->enable=$data['enableFTP'];
				$config->web->fpt->host=$data['ftphost'];
				$config->web->fpt->username=$data['ftpusername'];
				$config->web->fpt->password=$data['ftppassword'];
				$config->db->adapter = $data['database'];
				$config->db->prefix = $data['dbprefix'];
				$config->db->params->host = $data['host'];
				$config->db->dbname	=$data['dbname'];	
				$writeConfig = new Zend_Config_Writer_Ini(array('config'=>$config,
														'filename'=>$pathConfig));
  				$writeConfig->write();		
			}
		}
		$this->view->form = $siteForm;
    }
	public function mediacomponentAction ()
    {}
}