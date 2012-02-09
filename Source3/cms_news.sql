-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 08, 2012 at 12:40 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `source3`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `cms_news`
-- 

CREATE TABLE `cms_news` (
  `news_id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `author` varchar(64) collate utf8_unicode_ci NOT NULL,
  `image` varchar(255) collate utf8_unicode_ci NOT NULL,
  `viewed` int(11) NOT NULL default '0',
  `sort_order` int(3) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=762 ;

-- 
-- Dumping data for table `cms_news`
-- 

INSERT INTO `cms_news` VALUES (722, 1, 'Vangel', 'http://i665.photobucket.com/albums/vv15/hoangduc17t/testwebcam.png', 2, 0, 1, '2011-10-22 11:09:05', '2011-10-22 11:09:05');
INSERT INTO `cms_news` VALUES (723, 1, 'Vangel', 'http://i665.photobucket.com/albums/vv15/hoangduc17t/testwebcam.png', 14, 0, 1, '2011-10-22 11:18:00', '2011-10-22 11:18:00');
INSERT INTO `cms_news` VALUES (724, 1, 'Vangel', 'http://i665.photobucket.com/albums/vv15/hoangduc17t/testwebcam.png', 3, 0, 1, '2011-10-22 11:26:03', '2011-10-22 11:26:03');
INSERT INTO `cms_news` VALUES (725, 1, 'Vangel', 'http://i665.photobucket.com/albums/vv15/hoangduc17t/testwebcam.png', 12, 0, 1, '2011-10-22 11:35:37', '2011-10-22 11:35:37');
INSERT INTO `cms_news` VALUES (726, 1, 'Vangel', 'http://i665.photobucket.com/albums/vv15/hoangduc17t/testwebcam.png', 4, 0, 1, '2011-10-22 11:44:21', '2011-10-22 11:44:21');
INSERT INTO `cms_news` VALUES (727, 13, 'Vangel', 'data/news_images/201110/20111022/huyenthoaibattu60a1.jpg', 3, 0, 1, '2011-10-22 11:49:08', '2011-10-22 11:49:08');
INSERT INTO `cms_news` VALUES (728, 13, 'Vangel', 'data/news_images/201110/20111022/DucTho8_450.jpg', 12, 0, 1, '2011-10-22 11:56:35', '2011-10-22 11:56:35');
INSERT INTO `cms_news` VALUES (731, 13, 'Vũ Lê', 'data/news_images/201110/20111023/a-tb-1-can-ho-hang-sang-tp-.jpg', 5, 0, 1, '2011-10-23 11:02:48', '2011-10-23 11:02:48');
INSERT INTO `cms_news` VALUES (732, 13, 'vangel', 'data/news_images/201110/20111023/GS Le 1 (2).JPG', 2, 0, 1, '2011-10-23 11:09:29', '2011-10-23 11:09:29');
INSERT INTO `cms_news` VALUES (733, 13, 'Vangel', 'data/news_images/201110/20111023/2_41_1319276273_3_22101_89eb5.JPG', 6, 0, 1, '2011-10-23 11:10:39', '2011-10-23 11:10:39');
INSERT INTO `cms_news` VALUES (737, 16, 'vangel', 'data/news_images/201110/20111024/nhutcorp_61360189260_huyen002_thumb.jpg.gif', 13, 0, 1, '2011-10-24 09:15:15', '2011-10-24 11:17:10');
INSERT INTO `cms_news` VALUES (738, 16, 'vangel', 'data/news_images/201110/20111024/nhutcorp_61359189258_dh1_thumb.jpg', 13, 0, 1, '2011-10-24 09:21:34', '2011-10-24 11:17:00');
INSERT INTO `cms_news` VALUES (739, 16, 'vangel', 'data/news_images/201110/20111024/1319422311_ty gia.png', 0, 0, 1, '2011-10-24 09:23:57', '2011-10-24 11:16:45');
INSERT INTO `cms_news` VALUES (740, 16, 'vangel', 'data/news_images/201110/20111024/1319421998_ngan hang 1.png', 1, 0, 1, '2011-10-24 09:26:38', '2011-10-24 11:16:33');
INSERT INTO `cms_news` VALUES (741, 16, 'vangel', 'data/news_images/201110/20111024/a5.jpg', 4, 0, 1, '2011-10-24 09:37:29', '2011-10-24 11:16:17');
INSERT INTO `cms_news` VALUES (742, 2, 'vangel', 'data/news_images/201110/20111024/GE.jpg', 10, 0, 1, '2011-10-24 09:53:00', '2011-10-24 11:16:01');
INSERT INTO `cms_news` VALUES (743, 2, 'vangel', 'data/news_images/201110/20111024/SinhThaijpg084317.jpg', 3, 0, 1, '2011-10-24 10:12:47', '2011-10-24 11:15:50');
INSERT INTO `cms_news` VALUES (744, 2, 'vangel', 'data/news_images/201110/20111024/thi truong dia oc ha noi.jpg', 6, 0, 1, '2011-10-24 10:16:27', '2011-10-24 11:15:40');
INSERT INTO `cms_news` VALUES (745, 2, 'vangel', 'data/news_images/201110/20111024/image_gallery34634634_200_200.jpg', 7, 0, 1, '2011-10-24 10:22:13', '2011-10-24 11:15:29');
INSERT INTO `cms_news` VALUES (759, 2, 'ducnh', 'upload/images/myimage.jpg', 0, 6, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `cms_news` VALUES (753, 2, 'ducnh', 'wwwwwwwwwwwwww', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `cms_news` VALUES (756, 17, 'ducnh', '', 0, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `cms_news` VALUES (757, 17, 'ducnh', 'upload/images/myimage2.jpg', 0, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `cms_news` VALUES (749, 17, 'vangel', 'data/news_images/201110/20111024/groupon1-1.jpg', 4, 0, 1, '2011-10-24 12:36:04', '2011-10-24 12:36:04');
INSERT INTO `cms_news` VALUES (750, 17, 'Vangel', 'data/news_images/201110/20111024/TD 1 (1).jpg', 24, 0, 1, '2011-10-24 16:01:29', '2011-10-24 16:03:55');
INSERT INTO `cms_news` VALUES (734, 18, 'vangel', 'data/news_images/201110/20111024/1319417712_ck.png', 0, 0, 1, '2011-10-24 08:55:32', '2011-10-24 11:17:48');
INSERT INTO `cms_news` VALUES (729, 18, 'Việt Thắng', 'data/news_images/201110/20111023/1319332468_ck.png', 0, 0, 1, '2011-10-23 10:38:00', '2011-10-23 10:38:00');
INSERT INTO `cms_news` VALUES (730, 18, 'Nhật Hường', 'data/news_images/201110/20111023/chung-khoan.jpg', 0, 0, 1, '2011-10-23 10:47:02', '2011-10-23 10:47:02');
INSERT INTO `cms_news` VALUES (736, 18, 'vangel', 'data/news_images/201110/20111024/SingViet.jpg', 0, 0, 1, '2011-10-24 09:03:41', '2011-10-24 11:17:23');
INSERT INTO `cms_news` VALUES (735, 18, 'vangel', 'data/news_images/201110/20111024/1319414161_vang binh on.png', 0, 0, 1, '2011-10-24 08:56:49', '2011-10-24 16:29:54');
INSERT INTO `cms_news` VALUES (761, 0, 'ducnh', 'upload/images/myimage2.jpg', 0, 23, 1, '2012-02-01 14:01:23', '0000-00-00 00:00:00');
