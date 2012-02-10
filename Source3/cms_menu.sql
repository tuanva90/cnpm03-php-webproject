-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2012 at 02:10 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zendcms_db3`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_menu`
--

CREATE TABLE IF NOT EXISTS `cms_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT '0',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_inside` bit(1) DEFAULT b'0',
  `link` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` tinyint(4) DEFAULT NULL,
  `is_showed` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cms_menu`
--

INSERT INTO `cms_menu` (`id`, `name`, `parent`, `description`, `is_inside`, `link`, `sort_order`, `is_showed`) VALUES
(1, 'Trang chủ', 0, 'Trang chủ', '1', 'front', 1, '1'),
(2, 'Tin tức', 0, 'Tin tức', '1', 'front/news', 2, '1'),
(3, 'Sản phẩm', 0, 'Sản phẩm', '1', 'front/product', 3, '1'),
(4, 'Liên kết', 0, 'Link các báo mạng', '0', '#', 4, '1'),
(9, 'VNExpress', 4, 'Link tới VNExpress', '0', 'http://vnexpress.net/', 1, '1'),
(10, 'Tuổi Trẻ', 4, 'Link tới Tuổi Trẻ', '0', 'http://tuoitre.vn/', 2, '1');
