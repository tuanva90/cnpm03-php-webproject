<?php
if (!defined('INIT_WEBSITE')) die("Hacking attempt");

class Modules_News_Plugins_Auto extends Gio_Core_Plugin
{
	public function run()
	{
		ini_set('memory_limit', '256M');
		require_once LIB_DIR . DS . 'simplehtmldom' . DS . 'simple_html_dom.php';
		
		$conn = Gio_Db_Connection::getConnection();
		$articleAutoDao = new Admin_Modules_News_Models_Mysql_Articleauto();
		$articleAutoDao->setConnection($conn);
		$numArticles = isset($this->_configs['auto_update_num_article'])
							? (int)$this->_configs['auto_update_num_article'] : 20;
		$articlesAuto = $articleAutoDao->find($numArticles);

		$articleDao = new Admin_Modules_News_Models_Mysql_Article();
		$articleDao->setConnection($conn);
		
		/**
		 * Auto Tags
		 */
		$autoTag = (isset($this->_configs['auto_tag']) && $this->_configs['auto_tag'] == true) 
								? true : false;
		$allTags = array();
		if ($autoTag) {
			$tagDao = new Admin_Modules_News_Models_Mysql_Tag();
			$tagDao->setConnection($conn);
			$allTags = $tagDao->getAllTags();
		}
		if ($articlesAuto) {
			foreach ($articlesAuto as $index => $articleAuto) {
				$categories = explode('-', $articleAuto['category_ids']);
				
				$article = array(
					'title' => $articleAuto['title'],
					'slug' => $articleAuto['slug'],
					'created_date' => $articleAuto['created_date'],
					'category_id' => $categories[0],
					'status' => 'active',
					'description' => $articleAuto['description'],
					'article_hot' => ($index % 2 == 0) ? 1 : 0,
					'article_sticky' => ($index % 2 != 0) ? 1 : 0,
					'link_source' => $articleAuto['link_source'],
					'image_url' => $articleAuto['image_url'],
					'web_id' => $articleAuto['website'],
					'article_photo' => $articleAuto['article_photo'],
					'article_video' => $articleAuto['article_video'],
				);
				
				switch ($articleAuto['website']) {
					case 'vtc':
						$article = $this->_vtc($article);
						break;
					case 'vnexpress':
						$article = $this->_vnexpress($article);
						break;
					case 'dantri':
						$article = $this->_dantri($article);
						break;
					case 'thethaovanhoa':
						$article = $this->_thethaovanhoa($article);
						break;
					case 'zing':
						$article = $this->_zing($article);
						break;
					case 'megafun':
						$article = $this->_megafun($article);
						break;
				}
				
				if ($article['title'] && $article['description'] && $article['content']) {
					$articleId = $articleDao->add($article);
					if ($articleId) {
						/**
						 * Add to article category assoc
						 */
						foreach ($categories as $key => $categoryId) {
							$sql = 'INSERT INTO ' . $conn->_tablePrefix . 'news_article_category_assoc 
										(article_id, category_id) VALUES("%s", "%s")';
							$sql = sprintf($sql, $articleId, $categoryId);
							$rs = $conn->query($sql);
							$conn->freeResult($rs);
						}
					}
					
					/**
					 * Add Tag For this article
					 */
					if ($autoTag && count($allTags) > 0) {
						$sql = 'DELETE FROM ' . $conn->_tablePrefix . 'news_tag_assoc WHERE article_id = ' . $articleId;
						$rs = $conn->query($sql);
						$conn->freeResult($rs);
								
						foreach ($allTags as $index => $tag) {
							if (strpos($article['title'], $tag['tag_text']) !== false
									|| strpos($article['description'], $tag['tag_text']) !== false
									|| strpos($article['content'], $tag['tag_text']) !== false) 
							{
								$sql = 'INSERT INTO ' . $conn->_tablePrefix . 'news_tag_assoc 
								(article_id, tag_id) VALUES("%s", "%s")';
								$sql = sprintf($sql, $articleId, $tag['tag_id']);
								$rs = $conn->query($sql);
								$conn->freeResult($rs);
							}
						}	
					}
				}
				/**
				 * Delete article auto
				 */
				$articleAutoDao->delete($articleAuto['auto_id']);
			}
		}
	}
	
	private function _vtc($article)
	{
		if (isset($article['link_source']) && $article['link_source']) {
			$html = null;
			if (($htmlString = @file_get_contents($article['link_source'])) === false) {
				return $article;	
			}
			$html = str_get_html($htmlString);
			$pageContent = $html->find('div.desc', 0);
			if ($pageContent) {
				$date = $html->find('span.date', 0)->plaintext;
				$image = $pageContent->find('img');
				$article['content'] = $pageContent->innertext;
				$article['image_url'] = (count($image) > 1) ? $image[0]->src : $article['image_url'];
				$article['created_date'] = ($date) 
												? date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date))) 
												: $article['created_date'];
			} 
		}
		return $article;
	}
	
	private function _dantri($article)
	{
		if (isset($article['link_source']) && $article['link_source']) {
			$html = null;
			if (($htmlString = @file_get_contents($article['link_source'])) === false) {
				return $article;	
			}
			$html = str_get_html($htmlString);
			$pageContent = $html->find('div[id=ctl00_IDContent_ctl00_divContent]', 0);
			if ($pageContent) {
				$dateTimeContainer = $pageContent->find('span.mr2', 0);
				if (!isset($dateTimeContainer->innertext) || !$dateTimeContainer->innertext) {
					return $article;
				}

				$dateTime = $dateTimeContainer->innertext;
				$dateTime = explode(',', $dateTime);
				$dateTime = str_replace('-', '', $dateTime[1]);
				$dateTime = explode('/', $dateTime);
				$dateTime = trim($dateTime[1]) . '/' . trim($dateTime[0]) . '/' . trim($dateTime[2]);

				$article['created_date'] = date('Y-m-d H:i:s', strtotime($dateTime));

				$description = $pageContent->find('div.mt1', 1)->innertext;
				
				$contentContainer = $pageContent->find('div.mt3', 0);
				
				$table = $contentContainer->find('table.MsoNormalTable');
				
				$content = $contentContainer->innertext;
				if (isset($table[count($table) - 1])) {
					$content = str_replace($table[count($table) - 1]->outertext, '', $content);
				}
				
				$content = '<p><b>' . $description . '</b></p>' . Gio_Core_String::stripTags($content, array('a')); 
				
				$image = $contentContainer->find('img', 0);
				$article['content'] = $content;
				$article['image_url'] = (isset($image->src)) ? $image->src : $article['image_url'];
				$article['description'] = ($article['description']) ? $article['description'] : $description;
			} 
		}
		return $article;
	}
	
	private function _thethaovanhoa($article)
	{
		if (isset($article['link_source']) && $article['link_source']) {
			$html = null;
			if (($htmlString = @file_get_contents($article['link_source'])) === false) {
				return $article;	
			}
			$html = str_get_html($htmlString);
			$pageContent = $html->find('div[id=ctl00_ContentPlaceHolder1_divDetailNews]', 0);
			if ($pageContent) {
				$contentContainer = $pageContent->find('div[id=divDetail]', 0);
				$content = $contentContainer->innertext; 
				$content = Gio_Core_String::stripTags($content, array('a'));
				
				$image = $contentContainer->find('img', 0);
				$article['content'] = $content;
				$article['image_url'] = (isset($image->src)) ? $image->src : $article['image_url'];
			} 
		}
		return $article;
	}
	
	private function _vnexpress($article)
	{
		$website = 'http://vnexpress.net';
		
		if (isset($article['link_source']) && $article['link_source']) {
			$html = null;
			if (($htmlString = @file_get_contents($article['link_source'])) === false) {
				return $article;	
			}
			$html = str_get_html($htmlString);
			$pageContent = $html->find('div.content', 0);
			$container = ($pageContent) ? $pageContent->find('div', 0) : null;
			if ($container) {
				$title = $container->find('p.Title', 0)->outertext;
				$content = str_replace($title, '', $container->innertext);
				$content = preg_replace('/(img|src)(\"|\'|\=\"|\=\')(.*)/i',"$1$2".$website."$3",$content);
				$content = str_replace('href="', 'href="'.$website.'', $content);
				$content = Gio_Core_String::stripTags($content, array('a'));
				
				$image = $container->find('img');
				$article['content'] = $content;
				$article['image_url'] = (count($image) > 0) ? $website . $image[0]->src : $article['image_url'];
			} 
		}
		return $article;
	}
	
	private function _zing($article)
	{		
		if (isset($article['link_source']) && $article['link_source']) {
			$html = null;
			if (($htmlString = @file_get_contents($article['link_source'])) === false) {
				return $article;	
			}
			
			$html = str_get_html($htmlString);
			$dateTime = trim($html->find('div.datetime', 0)->innertext);
			$dateTmp = explode(' ', $dateTime);
			$dateTime = $dateTmp[2] . ' ' . $dateTmp[3];
			$dateTime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $dateTime)));
			
			$pageContent = $html->find('div[id=content_document]', 0);
			$container = $pageContent;
			if ($container) {
				$title = $container->find('h1.pTitle', 0)->outertext;
				$content = str_replace($title, '', $container->innertext);
				$content = Gio_Core_String::stripTags($content, array('a'));
				
				$image = $container->find('img');
				$article['content'] = $content;
				$article['image_url'] = (count($image) > 0) ? $website . $image[0]->src : $article['image_url'];
				$article['created_date'] = $dateTime;
			} 
		}
		return $article;
	}
	
	private function _megafun($article)
	{		
		$website = 'http://megafun.vn';
		if (isset($article['link_source']) && $article['link_source']) {
			$html = null;
			if (($htmlString = @file_get_contents($article['link_source'])) === false) {
				return $article;	
			}
			
			$html = str_get_html($htmlString);
			
			$date = $html->find('div[id=date]', 0);
			$date = preg_replace('/(.*)([0-9\:]{5})(.*)([0-9\/]{10})(.*)/i', '$2 $4', $date->innertext);
			$date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date)));
			
			$pageContent = $html->find('div[id=content]', 0);
			$container = $pageContent;
			if ($container) {
				$content = $container->innertext;
				$content = Gio_Core_String::stripTags($content, array('a'));
				$content = preg_replace('/(img|src)(\"|\'|\=\"|\=\')(.*)/i',"$1$2".$website."$3",$content);
				
				$image = $container->find('img');
				$article['content'] = $content;
				$article['image_url'] = (count($image) > 0) ? $website . $image[0]->src : $article['image_url'];
				$article['created_date'] = $date;
			} 
		}
		return $article;
	}
}