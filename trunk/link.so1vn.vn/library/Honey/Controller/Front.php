<?php
class Honey_Controller_Front{
	
	public function loadModule(){
		$front = Honey_Controller_Front::getInstance();
		echo '<pre>';
		print_r($front);
		echo '</pre>';
	}
}
