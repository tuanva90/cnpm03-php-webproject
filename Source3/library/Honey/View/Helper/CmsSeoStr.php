<?php
/**
 * @author HUYPRO
 * huydang1920@gmail.com
 */

class Honey_View_Helper_CmsSeoStr extends Zend_View_Helper_Abstract {
	
	public function utf8_to_ascii($str) {
				
		if (! $str)
			return false;
		$unicode = array (
				'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ', 
				'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ', 
				'D' => 'Đ', 
				'd' => 'đ', 
				'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ', 
				'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 
				'I' => 'Í|Ì|Ỉ|Ĩ|Ị', 
				'i' => 'í|ì|ỉ|ĩ|ị', 
				'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ', 
				'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
				'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự', 
				'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 
				'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ', 
				'y' => 'ý|ỳ|ỷ|ỹ|ỵ', 
				'' => '́|̉|̀|̣|̃' 
		);
		
		foreach ( $unicode as $nonUnicode => $uni )
			$str = preg_replace ( "/($uni)/i", $nonUnicode, $str );
			
		return strtolower ( $str );
	}
	
	public function TrimAll($str) {
		$cach = false;
		$returnstr = "";
		
		$str = trim ( $str );
		$strlen = strlen ( $str );
		for($i = 0; $i < $strlen; $i ++) {
			if ($str [$i] == " ") {
				if (! $cach) {
					$returnstr .= " ";
					$cach = true;
				}
			} else {
				$returnstr .= $str [$i];
				$cach = false;
			}
		}
		return $returnstr;
	}
	
	public function CmsSeoStr($str) {
		$str = $this->TrimAll ( $this->utf8_to_ascii ( $str ) );
		$strt = "";
		$str = str_split ( $str, 1 );
		//echo ord('a') . "--";//97
		//echo ord('z'). "--";//122
		//echo ord('A'). "--";//65
		//echo ord('Z'). "--";//90
		//echo ord('0'). "--";//48
		//echo ord('9'). "--";//57
		$i = 0;
		$dacach = true;
		foreach ( $str as $char ) {
			$i = ord ( $char );
			if ($i == 46) {
				$strt .= '-';
				$dacach = false;
			} else if (($i >= 97 && $i <= 122) || ($i >= 48 && $i <= 57) || ($i == 45)) {
				$strt .= $char;
				$dacach = false;
			} else if ($char == ' ' && $dacach == false) {
				$strt .= '-';
				$dacach = true;
			}
		}
		return $strt;
	}
}