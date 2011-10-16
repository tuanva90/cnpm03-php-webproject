<?php
class Honey_Plugin_Permission_Auth {
	
	protected $_messageError = null;
	
	public function login($arrParam, $options = null) {
		
		/**
		 * 1. Goi ket noi voi Zend Db
		 */
		$db = Zend_Registry::get ( 'connectDB' );
		
		/**
		 * 2. Khoi tao Zend Autho
		 */
		$auth = Zend_Auth::getInstance ();
		
		/**
		 * 3. Lay gia tri duoc gui qua tu FORM
		 */
		$encode = new Honey_Encode ();
		$username = $arrParam ['username'];
		$password = $encode->password ( $arrParam ['password'] );
		
		/**
		 * 4. Khai bao bang va 2 cot se su dung so sanh trong qua trong login
		 */
		$authAdapter = new Zend_Auth_Adapter_DbTable ( $db );
		$authAdapter->setTableName ( 'user' )
					->setIdentityColumn ( 'username' )
					->setIdentity ( $username )
					->setCredentialColumn ( 'password' )
					->setCredential ( $password )
					->setCredentialTreatment ( '? AND status = 1' );
		
		/**
		 * 7. Lay ket qua truy van
		 */
		$result = $auth->authenticate ( $authAdapter );
		
		$flag = false;
		if (! $result->isValid ()) {
			$error = $result->getMessages ();
			$this->_messageError = current ( $error );
		} else {
			/**
			 * 8. Lay nhung du lieu can thiet trong bang users neu login thanh cong
			 */
			$data = $authAdapter->getResultRowObject ( null, array ('password' ) );
			
			/**
			 * 9. Luu nhung du lieu cua member vao session
			 */
			$auth->getStorage ()->write ( $data );
			$flag = true;
		}
		
		return $flag;
	}
	
	public function getError() {
		return $this->_messageError;
	}
	
	public function logout($arrParam = null, $options = null) {
		$auth = Zend_Auth::getInstance ();
		$auth->clearIdentity ();
	}
}