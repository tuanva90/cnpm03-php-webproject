<?php
class Honey_View_Helper_CmsButton extends Zend_View_Helper_Abstract{
	
	public function cmsButton($name, $link = '#',$imgLink, $type = 'link'){
		
		if($type == 'link'){
			$aTag = 'href="' . $link . '"';
		} else if($type == 'submit'){
			$aTag = 'onclick="OnSubmitForm(\'' . $link . '\')"';
		}
		
		$xhtml = '<div><a ' . $aTag . '><img src="' . $imgLink . '"><br>' . $name . '</a></div>';
		return $xhtml;
	}
}