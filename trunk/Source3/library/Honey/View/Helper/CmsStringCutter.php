<?php
/**
 * Takes a string and optionally a maximum length and 'cut' the string to match that length, based on words and not on characters.
 * @author huydang1920@gmail.com
 * 
 * @param string  $pStr    The string to be cutted
 * @param intefer $pMaxLen The maximum length to be used to cut the string
 * Note that: '/\b/u' include: b->space character | u->Unicode support
 * @return string
 */

class Honey_View_Helper_CmsStringCutter extends Zend_View_Helper_Abstract {
	public function cmsStringCutter($pStr, $pMaxLen = 40) {
		if (strlen ( $pStr ) > $pMaxLen) {
			$returnStr = '';
			$pieces = preg_split ( '/\b/u', $pStr );
			
			foreach ( $pieces as $piece ) {
				if (strlen ( $returnStr . $piece ) < $pMaxLen) {
					$returnStr .= $piece;
				}
			}
			
			$returnStr .= '...';
		} else {
			$returnStr = $pStr;
		}
		return $returnStr;
	}
}