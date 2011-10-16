<?php
class Honey_Plugin_Permission_Info {
	
	//Ham khoi tao cua lop
	public function __construct() {
		$ns = new Zend_Session_Namespace ( 'info' );
	
		//$ns->setExpirationSeconds(1800);
	}
	
	//Tao thong cua nguoi dang nhap
	public function createInfo() {
		$auth = Zend_Auth::getInstance ();
		$infoAuth = $auth->getIdentity ();
		
		$this->setMemberInfo ( $infoAuth );
		$this->setGroupInfo ( $infoAuth );
	
	}
	
	//Huy thong tin nguoi khi logout
	public function destroyInfo() {
		$ns = new Zend_Session_Namespace ( 'info' );
		$ns->unsetAll ();
	}
	
	//Thiet lap thong tin cua User khi ho login
	public function setMemberInfo($infoAuth) {
		$db = Zend_Registry::get ( 'connectDB' );
		$select = $db->select ()->from ( 'user' )->where ( 'user_id = ? ', $infoAuth->user_id, INTEGER );
		$result = $db->fetchRow ( $select );
		
		$ns = new Zend_Session_Namespace ( 'info' );
		$ns->member = $result;
	
	}
	
	//Thiet lap thong tin cua nhom chua User khi ho login
	public function setGroupInfo($infoAuth) {
		$db = Zend_Registry::get ( 'connectDB' );
		$select = $db->select ()->from ( 'user_group' )->where ( 'user_group_id = ? ', $infoAuth->user_group_id, INTEGER );
		$result = $db->fetchRow ( $select );
		$ns = new Zend_Session_Namespace ( 'info' );
		$ns->group = $result;
	
	}
	
	//Lay thong tin cua user da su he thong
	public function getMemberInfo($part = null) {
		$ns = new Zend_Session_Namespace ( 'info' );
		$nsInfo = $ns->getIterator ();
		
		if ($part == null) {
			$info = $nsInfo ['member'];
		} else {
			$info = $nsInfo ['member'];
			$info = $info [$part];
		}
		
		return $info;
	}
	
	//Lay thong tin cua nhom
	public function getGroupInfo($part = null) {
		$ns = new Zend_Session_Namespace ( 'info' );
		$nsInfo = $ns->getIterator ();
		
		if ($part == null) {
			$info = $nsInfo ['group'];
		} else {
			$info = $nsInfo ['group'];
			$info = $info [$part];
		}
		
		return $info;
	
	}
	
	//Lay tat ca cac thong tin cua user da dang nhap
	public function getInfo() {
		$ns = new Zend_Session_Namespace ( 'info' );
		$info = $ns->getIterator ();
		return $info;
	}
}