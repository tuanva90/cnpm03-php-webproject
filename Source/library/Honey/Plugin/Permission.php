<?php
class Honey_Plugin_Permission extends Zend_Controller_Plugin_Abstract {
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		
		$auth = Zend_Auth::getInstance ();
		
		$moduleName = $this->_request->getModuleName ();
		
		$controllerName = $this->_request->getControllerName ();
		
		//----------START-KIEM TRA QUYEN TRUY CAP VAO ADMIN -------------
		$flagAdmin = false;
		if ($moduleName == 'admin') {
			$flagAdmin = true;
		}
		
		$flagPage = 'none';
		if ($flagAdmin == true) {
			if ($auth->hasIdentity () == false) {
				$flagPage = 'login';
			} else {
				$info = new Honey_Plugin_Permission_Info ();
				$permission = $info->getGroupInfo ( 'permission' );
				if ($permission != 'Full Access') {
					$flagPage = 'no-access';
				}
			}
		}
		
		//----------END-KIEM TRA QUYEN TRUY CAP VAO ADMIN -------------
		if ($flagPage != 'none') {
			if ($flagPage == 'login') {
				$this->_request->setModuleName ( 'admin' );
				$this->_request->setControllerName ( 'auth' );
				$this->_request->setActionName ( 'login' );
			}
			
			if ($flagPage == 'no-access') {
				$this->_request->setModuleName ( 'admin' );
				$this->_request->setControllerName ( 'auth' );
				$this->_request->setActionName ( 'deny' );
			}
		}
	}
}