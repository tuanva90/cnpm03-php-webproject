<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */

class Admin_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract {
	public function flashMessenger() {
		$flashMsgHelper = Zend_Controller_Action_HelperBroker::getStaticHelper ( 'FlashMessenger' );
		$this->view->assign ( 'messages', $flashMsgHelper->getMessages () );
		return $this->view->render ( '_partial/_messages.phtml' );
	}
}
