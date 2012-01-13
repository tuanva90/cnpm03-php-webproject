<?php
/**
 * Get link and save to database
 * 
 * @author HUYPRO
 * @mail: huydang1920@gmail.com
 * 
 * @see simple_html_dom.php
 */
require_once 'Honey/simple_html_dom.php';

class Honey_Plugin_Cron extends Zend_Controller_Plugin_Abstract {
	
	protected $_method = 'get';
	
	public function __construct()
	{
		ini_set('memory_limit', '256M');		
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		
		$moduleName = $this->_request->getModuleName ();
		
		$controllerName = $this->_request->getControllerName ();

		$ationName = $this->_request->getActionName ();
		
		if($moduleName == 'link' && $controllerName == 'index' && $ationName == 'index'){
			//$this->thethaovanhoa();
			//$this->megafun();
			//$this->dantri();
			//$this->vtc();
			//$this->zing();
			//$this->vnexpress();	
			//$this->kenh14();
		}
	}
	
	public function vtc()
	{
		/*
		 * Các dữ liệu cần thiết
		 */		
		$db = Zend_Registry::get('connectDB');
		$prefix = Honey_Config::getConfig ()->db->prefix;		
		$view = new Honey_View_Helper_CmsSeoStr();
		
		$select = 'SELECT * FROM ' . $prefix . 'link_cron lc LEFT JOIN '
				   . $prefix . 'link_web lw ON (lc.link_web_id = lw.link_web_id) 
				   WHERE lc.status = 1 AND TIMESTAMPDIFF(SECOND, lc.last_update, NOW()) > lc.frequency 
				   		AND lw.function = "vtc" 
				   ORDER BY lc.priority 
				   LIMIT 1';
		
		$addLinks = array();
		$addCategories = array();
		
		foreach($db->fetchAll($select) as $row) {			
			/**
			 * Check time
			 */
			if (($htmlString = @file_get_contents($row['source'])) === false) {
				continue;	
			}
			
			$categories = explode('-', $row['category_ids']);
			
			$html = str_get_html($htmlString);
			
			$container = $html->find('div.new_detail', 0);
			$topLink = $container->find('div.cat_hotnew', 0);
			
			if ($topLink != null) {
				$linkSource = $topLink->find('a', 0)->href;
				$link = $row['website_url'] . $linkSource;
				
				$title = $topLink->find('h2 a', 0)->plaintext;
				/**
				 * Check link exists
				 */
				//$existsLink = $linkDao->getlinkByTitle($title);
				//if (count($existsLink) == 0) {
					$image = $topLink->find('img', 0);
					$description = $topLink->find('span', 0)->plaintext;
					$link = array(
							'title' 		=> $title,
							'slug' 			=> $view->CmsSeoStr($title),
							'description' 	=> trim($description),
							'method'		=> $this->_method,
							'link_source' 	=> $link,
							'link_web_id'	=> $row['link_web_id'],
							'image' 		=> (isset($image->src)) ? $image->src : null,
							'category_ids'	=> $row['category_ids'],
							'date_added' 	=> date('Y-m-d H:i:s'),
						);
					$addLinks[] = $link;
					$addCategories[] = $categories;
				//}
			}
			
			$links = $container->find('div.cat_box_col');
			foreach ($links as $index => $item) {
				$linkSource = $item->find('a', 0)->href;
				$link = $row['website_url'] . $linkSource;
				$title = $item->find('span a', 0)->plaintext;
				/**
				 * Check link exists
				 */
				//$existsLink = $linkDao->getlinkByTitle($title);
				//if (null == $existsLink) {
					$image = $item->find('img', 0);
					$description = $item->find('span', 0)->plaintext;
					$link = array(
							'title' 		=> trim($title),
							'slug' 			=> $view->CmsSeoStr($title),
							'description' 	=> trim($description),
							'method'		=> $this->_method,
							'link_source' 	=> $link,
							'link_web_id'	=> $row['link_web_id'],
							'image' 		=> (isset($image->src)) ? $image->src : null,
							'category_ids'	=> $row['category_ids'],
							'date_added' 	=> date('Y-m-d H:i:s'),
						);
					$addLinks[] = $link;
					$addCategories[] = $categories;
				//}				
			}
			/**
			 * Update time for cron
			 */
			$db->update($prefix . 'link_cron', array('last_update' => date('Y-m-d H:i:s')), 'link_cron_id = ' . (int)$row['link_cron_id']);
		}
		/**
		 * Add links
		 */
		if (!empty($addLinks)) {
			foreach ($addLinks as $index => $link) {
								
				$select = $db->select()
							 ->from($prefix . 'link')
							 ->where('slug = ?', $link['slug']);				
				$existsLink = $db->fetchRow($select);
			if (!$existsLink) {
										
				$link_data = array(
						'title' 		=> $link['title'],
						'slug' 			=> $link['slug'],
						'description' 	=> $link['description'],
						'method'		=> $this->_method,
						'link_source' 	=> $link['link_source'],
						'image' 		=> $link['image'],
						'link_web_id'	=> $link['link_web_id'],
						'date_added' 	=> $link['date_added'],
					);
					$db->insert($prefix . 'link', $link_data);
					
					$link_id = $db->lastInsertId();
															
					/**
					 * Add to link_to_category
					 *
					 * Delete
					 */						
					$db->delete($prefix . 'link_to_category', 'link_id = ' . $link_id);
					
					$category_ids = explode('-', $link['category_ids']);
					
					foreach ($category_ids as $key => $category_id) {
						/**
						 * Insert
						 */
						if($category_id){
							$db->insert($prefix . 'link_to_category', array('link_id'=>(int)$link_id, 'category_id'=>(int)$category_id));
						}
					}
				} else {					
					
				}
			}
		}
	}
	
	public function vnexpress() {
		/*
		 * Các dữ liệu cần thiết
		 */		
		$db = Zend_Registry::get('connectDB');
		$prefix = Honey_Config::getConfig ()->db->prefix;		
		$view = new Honey_View_Helper_CmsSeoStr();
		
		$select = 'SELECT * FROM ' . $prefix . 'link_cron lc LEFT JOIN '
				   . $prefix . 'link_web lw ON (lc.link_web_id = lw.link_web_id) 
				   WHERE lc.status = 1 AND TIMESTAMPDIFF(SECOND, lc.last_update, NOW()) > lc.frequency 
				   		AND lw.function = "vnexpress" 
				   ORDER BY lc.priority 
				   LIMIT 1';
		
		$addLinks = array();
		$addCategories = array();
		
		foreach($db->fetchAll($select) as $row) {
			/**
			 * Check time
			 */
			if (($htmlString = @file_get_contents($row['source'])) === false) {
				continue;
			}
			
			$html = str_get_html($htmlString);
			$container = $html->find('div.content-center', 0);
			$topLink = $container->find('div.folder-top', 0);
			$categories = explode('-', $row['category_ids']);
			
			if ($topLink != null) {
				$linkSource = $topLink->find('a', 0)->href;				
				/**
				 * Check exist
				 */
				$link = $row['website_url'] . $linkSource;
				$pTitle = $topLink->find('p', 0);
				/**
				 * link Icon 
				 */
				$photo = 0;
				$video = 0;
				$linkIcons = $pTitle->find('img');
				if (count($linkIcons) > 0) {
					foreach ($linkIcons as $icon) {
						if (strpos($icon->src, 'video') !== false) {
							$video = 1;
						}
						if (strpos($icon->src, 'photo') !== false) {
							$photo = 1;
						}
					}
				}
				
				$title = $topLink->find('a.link-topnews', 0)->plaintext;
				/**
				 * Check link exists
				 */
				//$existsLink = $linkDao->getlinkByTitle($title);
				//if (count($existsLink) == 0) {
					$itemTime = $topLink->find('label.item-time', 0)->plaintext;
					$itemTime = trim($itemTime);
					
					$itemDate = $topLink->find('label.item-date', 0)->plaintext;
					$itemDate = str_replace('|', '', trim($itemDate));
					$itemDate = str_replace('&nbsp;', '', trim($itemDate));
					$itemDate = str_replace('/', '-', trim($itemDate));
					
					$createdDate = date('Y-m-d H:i:s', strtotime($itemDate . ' ' . $itemTime));
					
					$image = $topLink->find('img.img-topsubject', 0);
					$description = $topLink->find('p', 1)->plaintext;
					$link = array(
							'title' 		=> $title,
							'slug' 			=> $view->CmsSeoStr($title),
							'description' 	=> trim($description),
							'method'		=> $this->_method,
							'link_source' 	=> $link,
							'image' 		=> (isset($image->src)) ? $row['website_url'] . $image->src : null,
							'category_ids'	=> $row['category_ids'],
							'link_web_id'	=> $row['link_web_id'],
							'photo' 		=> $photo,
							'video' 		=> $video,
							'date_added' 	=> ($createdDate) ? $createdDate : date('Y-m-d H:i:s'),
						);
					$addLinks[] = $link;
					$addCategories[] = $categories;
				//}
			}
			
			$links = $container->find('div.folder-news');
			foreach ($links as $index => $item) {
				if ($index < count($links) - 2) {
					$linkSource = $item->find('a', 0)->href;
					$link = $row['website_url'] . $linkSource;
					$title = $item->find('a.link-title', 0)->plaintext;
					
					$pTitle = $item->find('p', 0);
					/**
					 * link Icon 
					 */
					$photo = 0;
					$video = 0;
					$linkIcons = $pTitle->find('img');
					if (count($linkIcons) > 0) {
						foreach ($linkIcons as $icon) {
							if (strpos($icon->src, 'video') !== false) {
								$video = 1;
							}
							if (strpos($icon->src, 'photo') !== false) {
								$photo = 1;
							}
						}
					}
					
					/**
					 * Check link exists
					 */
					//$existsLink = $linkDao->getlinkByTitle($title);
					//if (null == $existsLink) {
						$itemTime = $item->find('label.item-time', 0)->plaintext;
						$itemTime = trim($itemTime);
						
						$itemDate = $item->find('label.item-date', 0)->plaintext;
						$itemDate = str_replace('|', '', trim($itemDate));
						$itemDate = str_replace('&nbsp;', '', trim($itemDate));
						$itemDate = str_replace('/', '-', trim($itemDate));
						
						$createdDate = date('Y-m-d H:i:s', strtotime($itemDate . ' ' . $itemTime));
					
						$image = $item->find('img.img-subject', 0);
						$description = $item->find('p', 1)->innertext;
						$link = array(
								'title' 		=> trim($title),
								'slug' 			=> $view->CmsSeoStr($title),
								'description' 	=> trim($description),
								'method'		=> $this->_method,
								'link_source' 	=> $link,
								'image' 		=> (isset($image->src)) ? $row['website_url'] . $image->src : null,
								'category_ids'	=> $row['category_ids'],
								'link_web_id'	=> $row['link_web_id'],
								'photo' 		=> $photo,
								'video' 		=> $video,
								'date_added' 	=> ($createdDate) ? $createdDate : date('Y-m-d H:i:s'),
						);
						$addLinks[] = $link;
						$addCategories[] = $categories;
					//}
				}
			}
			/**
			 * Update time for cron
			 */
			$db->update($prefix . 'link_cron', array('last_update' => date('Y-m-d H:i:s')), 'link_cron_id = ' . (int)$row['link_cron_id']);
		}
		
		/**
		 * Add links
		 */		
		if (!empty($addLinks)) {
			foreach ($addLinks as $index => $link) {
								
				$select = $db->select()
							 ->from($prefix . 'link')
							 ->where('slug = ?', $link['slug']);				
				$existsLink = $db->fetchRow($select);
				
			if (!$existsLink) {
										
					$link_data = array(
						'title' 		=> $link['title'],
						'slug' 			=> $link['slug'],
						'description' 	=> $link['description'],
						'method'		=> $this->_method,
						'link_source' 	=> $link['link_source'],
						'image' 		=> $link['image'],
						'link_web_id'	=> $link['link_web_id'],
						'date_added' 	=> $link['date_added'],
					);
					$db->insert($prefix . 'link', $link_data);
					
					$link_id = $db->lastInsertId();
															
					/**
					 * Add to link_to_category
					 *
					 * Delete
					 */						
					$db->delete($prefix . 'link_to_category', 'link_id = ' . $link_id);
					
					$category_ids = explode('-', $link['category_ids']);
					
					foreach ($category_ids as $key => $category_id) {
						/**
						 * Insert
						 */
						if($category_id){
							$db->insert($prefix . 'link_to_category', array('link_id'=>(int)$link_id, 'category_id'=>(int)$category_id));
						}
					}
				} else {					
					
				}
			}
		}
	}
	
	public function thethaovanhoa()
	{
		/*
		 * Các dữ liệu cần thiết
		 */		
		$db = Zend_Registry::get('connectDB');
		$prefix = Honey_Config::getConfig ()->db->prefix;		
		$view = new Honey_View_Helper_CmsSeoStr();
		
		$select = 'SELECT * FROM ' . $prefix . 'link_cron lc LEFT JOIN '
				   . $prefix . 'link_web lw ON (lc.link_web_id = lw.link_web_id) 
				   WHERE lc.status = 1 AND TIMESTAMPDIFF(SECOND, lc.last_update, NOW()) > lc.frequency 
				   		AND lw.function = "thethaovanhoa" 
				   ORDER BY lc.priority 
				   LIMIT 1';
		
		$addLinks = array();
		$addCategories = array();
		
		foreach($db->fetchAll($select) as $row) {
			/**
			 * Check time
			 */
			if (($htmlString = @file_get_contents($row['source'])) === false) {
				continue;	
			}
			$html = str_get_html($htmlString);
			
			$categories = explode('-', $row['category_ids']);
				
			$container = $html->find('div.box4361', 0);
			$links = $container->find('div.box4362');
			
			foreach ($links as $index => $item) {
				if($index > 9) break;
				
				$linkSource = $item->find('a', 0)->href;
				$link = $row['website_url'] . $linkSource;
				
				$title = $item->find('a', 0)->plaintext;
				
				$image = $item->find('img', 0);
				$description = $item->find('p', 0)->innertext;

				$link = array(
						'title' 		=> trim($title),
						'slug' 			=> $view->CmsSeoStr($title),
						'description' 	=> trim($description),
						'method'		=> $this->_method,
						'link_source' 	=> $link,
						'image' 		=> (isset($image->src)) ? $image->src : null,
						'category_ids'	=> $row['category_ids'],
						'link_web_id'	=> $row['link_web_id'],						
						'date_added' 	=> date('Y-m-d H:i:s'),
				);
					
				$addLinks[] = $link;
				$addCategories[] = $categories;
			}
			
			/**
			 * Update time for cron
			 */			
			$db->update($prefix . 'link_cron', array('last_update' => date('Y-m-d H:i:s')), 'link_cron_id = ' . (int)$row['link_cron_id']);
		}
		
		/**
		 * Add links
		 */
		if (!empty($addLinks)) {
			foreach ($addLinks as $index => $link) {
				$select = $db->select()
							 ->from($prefix . 'link')
							 ->where('slug = ?', $link['slug']);				
				$existsLink = $db->fetchRow($select);
			if (!$existsLink) {
				
				$link_data = array(
						'title' 		=> $link['title'],
						'slug' 			=> $link['slug'],
						'description' 	=> $link['description'],
						'method'		=> $link['method'],
						'link_source' 	=> $link['link_source'],
						'image' 		=> $link['image'],
						'link_web_id'	=> $link['link_web_id'],
						'date_added' 	=> $link['date_added'],
					);
					$db->insert($prefix . 'link', $link_data);
					$link_id = $db->lastInsertId();									
					/**
					 * Add to link_to_category
					 *
					 * Delete
					 */						
					$db->delete($prefix . 'link_to_category', 'link_id = ' . $link_id);
					
					$category_ids = explode('-', $link['category_ids']);
					
					foreach ($category_ids as $key => $category_id) {						
						/**
						 * Insert
						 */
						if($category_id){
							$db->insert($prefix . 'link_to_category', array('link_id'=>(int)$link_id, 'category_id'=>(int)$category_id));
						}
					}
				} else {
					
				}
			}
		}
	}
	
	public function dantri() {
		/*
		 * Các dữ liệu cần thiết
		 */		
		$db = Zend_Registry::get('connectDB');
		$prefix = Honey_Config::getConfig ()->db->prefix;		
		$view = new Honey_View_Helper_CmsSeoStr();
		
		$select = 'SELECT * FROM ' . $prefix . 'link_cron lc LEFT JOIN '
				   . $prefix . 'link_web lw ON (lc.link_web_id = lw.link_web_id) 
				   WHERE lc.status = 1 AND TIMESTAMPDIFF(SECOND, lc.last_update, NOW()) > lc.frequency 
				   		AND lw.function = "dantri" 
				   ORDER BY lc.priority 
				   LIMIT 1';
		
		$addLinks = array();
		$addCategories = array();
		
		foreach($db->fetchAll($select) as $row) {
			/**
			 * Check time
			 */
			if (($htmlString = @file_get_contents($row['source'])) === false) {
				continue;	
			}
			$html = str_get_html($htmlString);
			$container = $html->find('div.fl', 0);
			$categories = explode('-', $row['category_ids']);

			$links = $container->find('div.mt3');
			foreach ($links as $index => $item) {
				if($index == 0) {					
					if (!isset($item->find('a', 0)->href)) continue;
					$linkSource = $item->find('a', 0)->href;
					$link = $row['website_url'] . $linkSource;
					$title = $item->find('a.fon44', 0)->plaintext;
					$image = $item->find('img.img195', 0);
					$description = $item->find('div.wid255', 0)->innertext;
					
					$link = array(
							'title' 		=> trim($title),
							'slug' 			=> $view->CmsSeoStr($title),
							'description' 	=> trim($description),
							'method'		=> $this->_method,
							'link_source' 	=> $link,
							'image' 		=> (isset($image->src)) ? $image->src : null,
							'category_ids'	=> $row['category_ids'],
							'link_web_id'	=> $row['link_web_id'],			
							'date_added'	=> date('Y-m-d H:i:s'),
					);
					$addLinks[] = $link;
					$addCategories[] = $categories;
					continue;
				} else {
					if (!isset($item->find('a', 0)->href)) continue;
					$linkSource = $item->find('a', 0)->href;
					$link = $row['website_url'] . $linkSource;
					$title = $item->find('a.fon6', 0)->plaintext;
					$image = $item->find('img.img130', 0);
					$description = $item->find('div.wid324', 0)->innertext;
					
					$link = array(
							'title' 		=> trim($title),
							'slug' 			=> $view->CmsSeoStr($title),
							'description' 	=> trim($description),
							'method'		=> $this->_method,
							'link_source' 	=> $link,
							'image' 		=> (isset($image->src)) ? $image->src : null,
							'category_ids'	=> $row['category_ids'],
							'link_web_id'	=> $row['link_web_id'],			
							'date_added'	=> date('Y-m-d H:i:s'),
					);
					$addLinks[] = $link;
					$addCategories[] = $categories;
				}
			}
			/**
			 * Update time for cron
			 */
			$db->update($prefix . 'link_cron', array('last_update' => date('Y-m-d H:i:s')), 'link_cron_id = ' . (int)$row['link_cron_id']);
		}
		
		/**
		 * Add links
		 */
		if (!empty($addLinks)) {
			foreach ($addLinks as $index => $link) {
								
				$select = $db->select()
							 ->from($prefix . 'link')
							 ->where('slug = ?', $link['slug']);				
				$existsLink = $db->fetchRow($select);
				if (!$existsLink) {
										
					$link_data = array(
						'title' 		=> $link['title'],
						'slug' 			=> $link['slug'],
						'description' 	=> $link['description'],
						'method'		=> $this->_method,
						'link_source' 	=> $link['link_source'],
						'image' 		=> $link['image'],
						'link_web_id'	=> $link['link_web_id'],
						'date_added' 	=> $link['date_added'],
					);
					$db->insert($prefix . 'link', $link_data);
					
					$link_id = $db->lastInsertId();
															
					/**
					 * Add to link_to_category
					 *
					 * Delete
					 */						
					$db->delete($prefix . 'link_to_category', 'link_id = ' . $link_id);
					
					$category_ids = explode('-', $link['category_ids']);
					
					foreach ($category_ids as $key => $category_id) {						
						/**
						 * Insert
						 */
						if($category_id){
							$db->insert($prefix . 'link_to_category', array('link_id'=>(int)$link_id, 'category_id'=>(int)$category_id));
						}
					}
				} else {
					
				}
			}
		}
	}
	
	public function zing() {
		/*
		 * Các dữ liệu cần thiết
		 */		
		$db = Zend_Registry::get('connectDB');
		$prefix = Honey_Config::getConfig ()->db->prefix;		
		$view = new Honey_View_Helper_CmsSeoStr();
		
		$select = 'SELECT * FROM ' . $prefix . 'link_cron lc LEFT JOIN '
				   . $prefix . 'link_web lw ON (lc.link_web_id = lw.link_web_id) 
				   WHERE lc.status = 1 AND TIMESTAMPDIFF(SECOND, lc.last_update, NOW()) > lc.frequency 
				   		AND lw.function = "zing" 
				   ORDER BY lc.priority 
				   LIMIT 1';
		
		$addLinks = array();
		$addCategories = array();
		
		foreach($db->fetchAll($select) as $row) {
			/**
			 * Get html from link
			 */
			if (($htmlString = @file_get_contents($row['source'])) === false) {
				continue;	
			}
			
			$html = str_get_html($htmlString);
			/**
			 * Get main container
			 */
			$container = $html->find('div[id=channelList]', 0);
			
			$categories = explode('-', $row['category_ids']);

			/**
			 * Get links by div with css class is cont09
			 */
			$links = $container->find('div.cont09');
			foreach ($links as $index => $item) {
				$linkSource = $item->find('a', 0)->href;
				$link = $linkSource;
				/**
				 * Get link title
				 */
				$title = $item->find('a.lnk02', 0)->plaintext;
				
				$imageContainer = $item->find('div.cont09im', 0);
				$image = (isset($imageContainer->innertext)) ? $imageContainer->find('img', 0) : null;
				$description = $item->find('p.cont09txt', 0)->innertext;
				$link = array(
						'title' 		=> trim($title),
						'slug' 			=> $view->CmsSeoStr($title),
						'description' 	=> trim($description),
						'method'		=> $this->_method,
						'link_source' 	=> $link,
						'image' 		=> (isset($image->src)) ? $image->src : null,
						'category_ids'	=> $row['category_ids'],
						'link_web_id'	=> $row['link_web_id'],
						'date_added' 	=> date('Y-m-d H:i:s'),
				);
				$addLinks[] = $link;
				$addCategories[] = $categories;
			}
			/**
			 * Update time for cron
			 */
			$db->update($prefix . 'link_cron', array('last_update' => date('Y-m-d H:i:s')), 'link_cron_id = ' . (int)$row['link_cron_id']);
		}
		/**
		 * Add links
		 */
		if (!empty($addLinks)) {
			foreach ($addLinks as $index => $link) {
				$select = $db->select()
							 ->from($prefix . 'link')
							 ->where('slug = ?', $link['slug']);				
				$existsLink = $db->fetchRow($select);
				if (!$existsLink) {
										
					$link_data = array(
						'title' 		=> $link['title'],
						'slug' 			=> $link['slug'],
						'description' 	=> $link['description'],
						'method'		=> $this->_method,
						'link_source' 	=> $link['link_source'],
						'image' 		=> $link['image'],
						'link_web_id'	=> $link['link_web_id'],
						'date_added' 	=> $link['date_added'],
					);
					$db->insert($prefix . 'link', $link_data);
					
					$link_id = $db->lastInsertId();
															
					/**
					 * Add to link_to_category
					 *
					 * Delete
					 */						
					$db->delete($prefix . 'link_to_category', 'link_id = ' . $link_id);
					
					$category_ids = explode('-', $link['category_ids']);
					
					foreach ($category_ids as $key => $category_id) {						
						/**
						 * Insert
						 */
						if($category_id){
							$db->insert($prefix . 'link_to_category', array('link_id'=>(int)$link_id, 'category_id'=>(int)$category_id));
						}
					}
				} else {
					
				}
			}
		}
	}
	
	public function megafun() {
		/*
		 * Các dữ liệu cần thiết
		 */		
		$db = Zend_Registry::get('connectDB');
		$prefix = Honey_Config::getConfig ()->db->prefix;		
		$view = new Honey_View_Helper_CmsSeoStr();
		
		$select = 'SELECT * FROM ' . $prefix . 'link_cron lc LEFT JOIN '
				   . $prefix . 'link_web lw ON (lc.link_web_id = lw.link_web_id) 
				   WHERE lc.status = 1 AND TIMESTAMPDIFF(SECOND, lc.last_update, NOW()) > lc.frequency 
				   		AND lw.function = "megafun" 
				   ORDER BY lc.priority 
				   LIMIT 1';
		
		$addLinks = array();
		$addCategories = array();
		
		foreach($db->fetchAll($select) as $row) {
			/**
			 * Get html from link
			 */
			if (($htmlString = @file_get_contents($row['source'])) === false) {
				continue;	
			}
			$html = str_get_html($htmlString);
			/**
			 * Get main container
			 */
			$categories = explode('-', $row['category_ids']);
			
			$container = $html->find('div.row', 0);
			/**
			 * Get links by li
			 */
			$links = $container->find('li');
			foreach ($links as $index => $item) {
				
				$linkSource = $item->find('a', 0)->href;
				$link = $row['website_url'] . $linkSource;
				
				/**
				 * Get link title
				 */
				$title = $item->find('h4', 0)->innertext;				
				$title = strip_tags($title);				
				$image = $item->find('img', 0);
				$description = $item->find('div.lead', 0)->innertext;
				$link = array(
						'title' => trim($title),
						'slug' => $view->CmsSeoStr($title),
						'description' 	=> trim($description),
						'method'		=> $this->_method,
						'link_source' 	=> $link,
						'image' 		=> (isset($image->src)) ? $row['website_url'] . $image->src : null,
						'category_ids'	=> $row['category_ids'],
						'link_web_id'	=> $row['link_web_id'],
						'date_added' 	=> date('Y-m-d H:i:s'),
				);
				
				$addLinks[] = $link;
				$addCategories[] = $categories;
			}
			/**
			 * Update time for cron
			 */
			$db->update($prefix . 'link_cron', array('last_update' => date('Y-m-d H:i:s')), 'link_cron_id = ' . (int)$row['link_cron_id']);
		}
		/**
		 * Add links
		 */
		if (!empty($addLinks)) {
			foreach ($addLinks as $index => $link) {
				$select = $db->select()
							 ->from($prefix . 'link')
							 ->where('slug = ?', $link['slug']);				
				$existsLink = $db->fetchRow($select);
				
			if (!$existsLink) {
										
					$link_data = array(
						'title' 		=> $link['title'],
						'slug' 			=> $link['slug'],
						'description' 	=> $link['description'],
						'method'		=> $this->_method,
						'link_source' 	=> $link['link_source'],
						'image' 		=> $link['image'],
						'link_web_id'	=> $link['link_web_id'],
						'date_added' 	=> $link['date_added'],
					);
					$db->insert($prefix . 'link', $link_data);
					
					$link_id = $db->lastInsertId();
															
					/**
					 * Add to link_to_category
					 *
					 * Delete
					 */						
					$db->delete($prefix . 'link_to_category', 'link_id = ' . $link_id);
					
					$category_ids = explode('-', $link['category_ids']);
					
					foreach ($category_ids as $key => $category_id) {						
						/**
						 * Insert
						 */
						if($category_id){
							$db->insert($prefix . 'link_to_category', array('link_id'=>(int)$link_id, 'category_id'=>(int)$category_id));
						}
					}
				} else {	
					
				}
			}
		}
	}
	
	public function kenh14() {
		/*
		 * Các dữ liệu cần thiết
		 */
		$db = Zend_Registry::get ( 'connectDB' );
		$prefix = Honey_Config::getConfig ()->db->prefix;
		$view = new Honey_View_Helper_CmsSeoStr ();
		
		$select = 'SELECT * FROM ' . $prefix . 'link_cron lc LEFT JOIN ' . $prefix . 'link_web lw ON (lc.link_web_id = lw.link_web_id) 
				   WHERE lc.status = 1 AND TIMESTAMPDIFF(SECOND, lc.last_update, NOW()) > lc.frequency 
				   		AND lw.function = "kenh14" 
				   ORDER BY lc.priority 
				   LIMIT 1';
		
		$addLinks = array ();
		$addCategories = array ();
		
		foreach ( $db->fetchAll ( $select ) as $row ) {
			/**
			 * Get html from link
			 */
			if (($htmlString = @file_get_contents ( $row ['source'] )) === false) {
				continue;
			}
			
			$html = str_get_html ( $htmlString );
			/**
			 * Get main container
			 */
			$container = $html->find ( 'div.listnews', 0 );
			
			$categories = explode ( '-', $row ['category_ids'] );
			
			/**
			 * Get links by div with css class is item
			 */
			$links = $container->find ( 'div.item' );
			foreach ( $links as $index => $item ) {
				$linkSource = $item->find ( 'a', 0 )->href;
				$link = $row['website_url'] . $linkSource;
				/**
				 * Get link title
				 */
				$title = $item->find ( '.title a', 0 )->plaintext;
				
				$imageContainer = $item->find ( 'div.img', 0 );
				$image = (isset ( $imageContainer->innertext )) ? $imageContainer->find ( 'img', 0 ) : null;
				$description = $item->find ( 'div.sapo', 0 )->innertext;
				
				$link = array (
					'title' => trim ( $title ), 
					'slug' => $view->CmsSeoStr ( $title ), 
					'description' => trim ( $description ), 
					'method' => $this->_method, 
					'link_source' => $link, 
					'image' => (isset ( $image->src )) ? $image->src : null, 
					'category_ids' => $row ['category_ids'], 
					'link_web_id' => $row ['link_web_id'], 
					'date_added' => date ( 'Y-m-d H:i:s' ) 
				);
				
				$addLinks [] = $link;
				$addCategories [] = $categories;
			}
			/**
			 * Update time for cron
			 */
			$db->update ( $prefix . 'link_cron', array ('last_update' => date ( 'Y-m-d H:i:s' ) ), 'link_cron_id = ' . ( int ) $row ['link_cron_id'] );
		}
		/**
		 * Add links
		 */
		if (! empty ( $addLinks )) {
			foreach ( $addLinks as $index => $link ) {
				$select = $db->select ()->from ( $prefix . 'link' )->where ( 'slug = ?', $link ['slug'] );
				$existsLink = $db->fetchRow ( $select );
				if (! $existsLink) {
					
					$link_data = array (
						'title' => $link ['title'], 
						'slug' => $link ['slug'], 
						'description' => $link ['description'], 
						'method' => $this->_method, 
						'link_source' => $link ['link_source'], 
						'image' => $link ['image'], 
						'link_web_id' => $link ['link_web_id'], 
						'date_added' => $link ['date_added'] 
					);
					
					$db->insert ( $prefix . 'link', $link_data );
					
					$link_id = $db->lastInsertId ();
					
					/**
					 * Add to link_to_category
					 *
					 * Delete
					 */
					$db->delete ( $prefix . 'link_to_category', 'link_id = ' . $link_id );
					
					$category_ids = explode ( '-', $link ['category_ids'] );
					
					foreach ( $category_ids as $key => $category_id ) {
						/**
						 * Insert
						 */
						if ($category_id) {
							$db->insert ( $prefix . 'link_to_category', array ('link_id' => ( int ) $link_id, 'category_id' => ( int ) $category_id ) );
						}
					}
				} else {
				
				}
			}
		}
	}
}