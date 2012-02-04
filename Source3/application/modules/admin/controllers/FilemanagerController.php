<?php
/**
 * @author HUYPRO
 */
class Admin_FilemanagerController extends Honey_Controller_Action {
	
	//Parameter array received in any Action
	protected $_arrParam;
	
	//The path of the Controller
	protected $_currentController;
	
	//The path of the Action
	protected $_actionMain;
	
	protected $_namespace;
	
	public function init() {
		//Mang tham so nhan duoc o moi Action
		$this->_arrParam = $this->_request->getParams ();
		
		//Duong dan cua Controller
		$this->_currentController = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'];
		
		//Duong dan cua Action chinh		
		$this->_actionMain = '/' . $this->_arrParam ['module'] . '/' . $this->_arrParam ['controller'] . '/index';
				
		/** View */
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$layout = 'filemanager';
		$layoutPath = APPLICATION_PATH . '/templates/admin/default';
		$this->loadTemplate ( $layout, $layoutPath, 'template.ini', 'template' );
		
	}
	
	public function indexAction() {
		
		$this->view->directory = HTTP_IMAGES . '/data/';
		
		if (isset($this->_arrParam['field'])) {
			$this->view->field = $this->_arrParam['field'];
		} else {
			$this->view->field = '';
		}
		
		if (isset($this->_arrParam['CKEditorFuncNum'])) {
			$this->view->fckeditor = $this->_arrParam['CKEditorFuncNum'];
		} else {
			$this->view->fckeditor = false;
		}
	}	
	
	public function imageAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		if (isset($this->view->arrParam['image'])) {
			$this->getResponse()->setBody($this->view->cmsImageResize(html_entity_decode($this->view->arrParam['image'], ENT_QUOTES, 'UTF-8'), 100, 100));
		}
	}
	
	public function directoryAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		$utf8 = new Honey_Utf8();
		
		if (isset($this->_arrParam['directory'])) {
			$directories = glob(rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', $this->_arrParam['directory']), '/') . '/*', GLOB_ONLYDIR); 
			
			if ($directories) {
				$i = 0;
			
				foreach ($directories as $directory) {
					$json[$i]['data'] = basename($directory);
					$json[$i]['attributes']['directory'] = $utf8->utf8_substr($directory, strlen(PUBLIC_PATH . '/images/data/'));
					
					$children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);
					
					if ($children)  {
						$json[$i]['children'] = ' ';
					}
					
					$i++;
				}
			}		
		}
		$this->getResponse()->setBody(Zend_Json::encode($json));		
	}
	
	public function filesAction() {		
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		if (!empty($this->_arrParam['directory'])) {
			$directory = PUBLIC_PATH . '/images/data/' . str_replace('../', '', $this->_arrParam['directory']);
		} else {
			$directory = PUBLIC_PATH . '/images/data/';
		}
		
		$allowed = array(
			'.jpg',
			'.jpeg',
			'.png',
			'.gif'
		);
		
		$files = glob(rtrim($directory, '/') . '/*');
		
		$utf8 = new Honey_Utf8();
		
		if ($files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					$ext = strrchr($file, '.');
				} else {
					$ext = '';
				}	
				
				if (in_array(strtolower($ext), $allowed)) {
					$size = filesize($file);
		
					$i = 0;
		
					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);
		
					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}
						
					$json[] = array(
						'file'     => $utf8->utf8_substr($file, strlen(PUBLIC_PATH . '/images/data/')),
						'filename' => basename($file),
						'size'     => round($utf8->utf8_substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						'thumb'    => $this->view->cmsImageResize($utf8->utf8_substr($file, strlen(PUBLIC_PATH . '/images/')), 100, 100)
					);
				}
			}
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}	
	
	public function createAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
				
		$json = array();
		
		if (isset($this->_arrParam['directory'])) {
			if (isset($this->_arrParam['name']) || $this->_arrParam['name']) {
				$directory = rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', $this->_arrParam['directory']), '/');							   
				
				if (!is_dir($directory)) {
					$json['error'] = 'Warning: Please select a directory!';
				}
				
				if (file_exists($directory . '/' . str_replace('../', '', $this->_arrParam['name']))) {
					$json['error'] = 'Warning: A file or directory with the same name already exists!';
				}
			} else {
				$json['error'] = 'Warning: Please enter a new name!';
			}
		} else {
			$json['error'] = 'Warning: Please select a directory!';
		}
		
		if (!isset($json['error'])) {	
			mkdir($directory . '/' . str_replace('../', '', $this->_arrParam['name']), 0777);
			
			$json['success'] = 'Success: Directory created!';
		}	
		
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}
	
	public function deleteAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		if (isset($this->_arrParam['path'])) {
			$path = rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', html_entity_decode($this->_arrParam['path'], ENT_QUOTES, 'UTF-8')), '/');
			 
			if (!file_exists($path)) {
				$json['error'] = 'Warning: Please select a directory or file!';
			}
			
			if ($path == rtrim(PUBLIC_PATH . '/images/data/', '/')) {
				$json['error'] = 'Warning: You can not delete this directory!';
			}
		} else {
			$json['error'] = 'Warning: Please select a directory or file!';
		}
		
		if (!isset($json['error'])) {
			if (is_file($path)) {
				unlink($path);
			} elseif (is_dir($path)) {
				$this->recursiveDelete($path);
			}
			
			$json['success'] = 'Success: Your file or directory has been deleted!';
		}				
		
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}

	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}
		
		if (!$handle) {
			return false;
		}
		
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}
		
		closedir($handle);
		
		rmdir($directory);
		
		return true;
	}

	public function moveAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		if (isset($this->_arrParam['from']) && isset($this->_arrParam['to'])) {
			$from = rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', html_entity_decode($this->_arrParam['from'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($from)) {
				$json['error'] = 'Warning: File or directory does not exist!';
			}
			
			if ($from == PUBLIC_PATH . '/images/data') {
				$json['error'] = 'Warning: Can not alter your default directory!';
			}
			
			$to = rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', html_entity_decode($this->_arrParam['to'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($to)) {
				$json['error'] = 'Warning: Move to directory does not exists!';
			}	
			
			if (file_exists($to . '/' . basename($from))) {
				$json['error'] = 'Warning: A file or directory with the same name already exists!';
			}
		} else {
			$json['error'] = 'Warning: Please select a directory!';
		}
		
		if (!isset($json['error'])) {
			rename($from, $to . '/' . basename($from));
			
			$json['success'] = 'Success: Your file or directory has been moved!';
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}	
	
	public function copyAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		$utf8 = new Honey_Utf8();
		
		if (isset($this->_arrParam['path']) && isset($this->_arrParam['name'])) {
			if (($utf8->utf8_strlen($this->_arrParam['name']) < 3) || ($utf8->utf8_strlen($this->_arrParam['name']) > 255)) {
				$json['error'] = 'Warning: Filename must be a between 3 and 255!';
			}
				
			$old_name = rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', html_entity_decode($this->_arrParam['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == PUBLIC_PATH . '/data') {
				$json['error'] = 'Warning: Can not copy this file or directory!';
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->_arrParam['name'], ENT_QUOTES, 'UTF-8') . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = 'Warning: A file or directory with the same name already exists!';
			}			
		} else {
			$json['error'] = 'Warning: Please select a directory or file!';
		}
		
		if (!isset($json['error'])) {
			if (is_file($old_name)) {
				copy($old_name, $new_name);
			} else {
				$this->recursiveCopy($old_name, $new_name);
			}
			
			$json['success'] = 'Success: Your file or directory has been copied!';
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}

	function recursiveCopy($source, $destination) { 
		$directory = opendir($source); 
		
		@mkdir($destination); 
		
		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) { 
				if (is_dir($source . '/' . $file)) { 
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file); 
				} else { 
					copy($source . '/' . $file, $destination . '/' . $file); 
				} 
			} 
		} 
		
		closedir($directory); 
	} 

	public function foldersAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		$this->getResponse()->setBody($this->recursiveFolders(PUBLIC_PATH . '/images/data/'));
	}
	
	protected function recursiveFolders($directory) {
		$output = '';
		
		$utf8 = new Honey_Utf8();
		
		$output .= '<option value="' . $utf8->utf8_substr($directory, strlen(PUBLIC_PATH . '/images/data/')) . '">' . $utf8->utf8_substr($directory, strlen(PUBLIC_PATH . '/images/data/')) . '</option>';
		
		$directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);
		
		foreach ($directories  as $directory) {
			$output .= $this->recursiveFolders($directory);
		}
		
		return $output;
	}
	
	public function renameAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		$utf8 = new Honey_Utf8();
		
		if (isset($this->_arrParam['path']) && isset($this->_arrParam['name'])) {
			if (($utf8->utf8_strlen($this->_arrParam['name']) < 3) || ($utf8->utf8_strlen($this->_arrParam['name']) > 255)) {
				$json['error'] = 'Warning: Filename must be a between 3 and 255!';
			}
				
			$old_name = rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', html_entity_decode($this->_arrParam['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == PUBLIC_PATH . '/data') {
				$json['error'] = 'Warning: Can not rename this directory!';
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->_arrParam['name'], ENT_QUOTES, 'UTF-8') . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = 'Warning: A file or directory with the same name already exists!';
			}			
		}
		
		if (!isset($json['error'])) {
			rename($old_name, $new_name);
			
			$json['success'] = 'Success: Your file or directory has been renamed!';
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}
	
	public function uploadAction() {
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$json = array();
		
		$utf8 = new Honey_Utf8();
		
		if (isset($this->_arrParam['directory'])) {
			if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
				$filename = basename(html_entity_decode($_FILES['image']['name'], ENT_QUOTES, 'UTF-8'));
				
				if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
					$json['error'] = 'Warning: Filename must be a between 3 and 255!';
				}
					
				$directory = rtrim(PUBLIC_PATH . '/images/data/' . str_replace('../', '', $this->_arrParam['directory']), '/');
				
				if (!is_dir($directory)) {
					$json['error'] = 'Warning: Please select a directory!';
				}
				
				if ($_FILES['image']['size'] > 500000) {
					$json['error'] = 'Warning: File to big please keep below 300kb and no more than 1000px height or width!';
				}
				
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
					'application/x-shockwave-flash'
				);
						
				if (!in_array($_FILES['image']['type'], $allowed)) {
					$json['error'] = 'Warning: Incorrect file type!';
				}
				
				$allowed = array(
					'.jpg',
					'.jpeg',
					'.gif',
					'.png',
					'.flv'
				);
						
				if (!in_array(strtolower(strrchr($filename, '.')), $allowed)) {
					$json['error'] = 'Warning: Incorrect file type!';
				}

				if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'error_upload_' . $_FILES['image']['error'];
				}			
			} else {
				$json['error'] = 'Warning: Please select a file!';
			}
		} else {
			$json['error'] = 'Warning: Please select a directory!';
		}
		
		if (!isset($json['error'])) {	
			if (@move_uploaded_file($_FILES['image']['tmp_name'], $directory . '/' . $filename)) {		
				$json['success'] = 'Success: Your file has been uploaded!';
			} else {
				$json['error'] = 'Warning: File could not be uploaded for an unknown reason!';
			}
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($json));
	}
} 
?>