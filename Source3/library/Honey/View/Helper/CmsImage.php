<?php
class Honey_View_Helper_CmsImage extends Zend_View_Helper_Abstract{
	
	public function cmsImage($name, $value = '', $attribs = null, $options = null){
		//alt title
		$strAttribs = '';
		if(count($attribs)>0){
			foreach ($attribs as $keyAttribs => $valueAttribs){
				$strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
			}
		}
		
		$xhtml = '<img id="' . $name . '" name="' . $name . '" 
					src="' . $value . '" ' . $strAttribs . '>';
		
		return $xhtml;
	}
}