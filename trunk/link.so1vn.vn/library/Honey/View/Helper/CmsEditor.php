<?php
class Honey_View_Helper_CmsEditor extends Zend_View_Helper_Abstract {
	
	public function cmsEditor($arrParam = null, $options = null) {
		$this->view->headScript ()->appendFile ( HTTP_PUBLIC . '/scripts/ckeditor/ckeditor.js', 'text/javascript' );
		
		$xhtml = '';
		if(count($arrParam)>0){
			foreach ($arrParam as $key => $val) {
				$xhtml .=			
				'<script type="text/javascript">
				CKEDITOR.replace(\'' . $val . '\', {
					language : \'vi\',
					filebrowserBrowseUrl: \'' . HTTP_SERVER . '/admin/filemanager' . '\',
					filebrowserImageBrowseUrl: \'' . HTTP_SERVER . '/admin/filemanager' . '\',
					filebrowserFlashBrowseUrl: \'' . HTTP_SERVER . '/admin/filemanager' . '\',
					filebrowserUploadUrl: \'' . HTTP_SERVER . '/admin/filemanager' . '\',
					filebrowserImageUploadUrl: \'' . HTTP_SERVER . '/admin/filemanager' . '\',
					filebrowserFlashUploadUrl: \'' . HTTP_SERVER . '/admin/filemanager' . '\',
					filebrowserWindowWidth : \'800\',
					filebrowserWindowHeight : \'500\'
					
				});
				</script>';
				/*
				$xhtml .=			
				'<script type="text/javascript">
				CKEDITOR.replace(\'' . $val . '\', {
					language : \'vi\',
					filebrowserBrowseUrl: \'' . HTTP_PUBLIC . '/scripts/kcfinder/browse.php?type=files' . '\',
					filebrowserImageBrowseUrl: \'' . HTTP_PUBLIC . '/scripts/kcfinder/browse.php?type=images' . '\',
					filebrowserFlashBrowseUrl: \'' . HTTP_PUBLIC . '/scripts/kcfinder/browse.php?type=flash' . '\',
					filebrowserUploadUrl: \'' . HTTP_PUBLIC . '/scripts/kcfinder/upload.php?type=files' . '\',
					filebrowserImageUploadUrl: \'' . HTTP_PUBLIC . '/scripts/kcfinder/upload.php?type=images' . '\',
					filebrowserFlashUploadUrl: \'' . HTTP_PUBLIC . '/scripts/kcfinder/upload.php?type=flash' . '\',
					filebrowserWindowWidth : \'800\',
					filebrowserWindowHeight : \'500\'
					
				});
				</script>';
				*/			
			}
		}
		
		return $xhtml;
	}
}