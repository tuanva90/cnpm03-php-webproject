-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2012 at 01:35 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `source3_full`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_module`
--

CREATE TABLE IF NOT EXISTS `cms_module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `desc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `is_showed` int(1) NOT NULL,
  `position` tinyint(2) DEFAULT NULL,
  `sort_order` tinyint(2) DEFAULT NULL,
  `option` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `cms_module`
--

INSERT INTO `cms_module` (`module_id`, `name`, `desc`, `file_name`, `is_showed`, `position`, `sort_order`, `option`) VALUES
(1, 'Login', '', 'BlkLogin', 1, 1, 0, '$use_forgot_password_link=1;$use_keep_signed_in=1;'),
(2, 'Newest Product', 'Những sản phẩm mới nhất', 'BlkNewestProduct', 1, 1, 1, '$amount_items=5;'),
(3, 'Impressive Product', '', 'BlkImpressiveProduct', 1, 2, 2, '$amount_items=10;'),
(5, 'Header', '', '', 1, 0, 0, '$banner=''header_1.jpg'';$title=''Click and Change'';$welcome_text=''Bring you the easiest way to own websites.'';'),
(6, 'Module_1', '', 'BlkModuleDefault', 1, 1, 3, ''),
(7, 'Module_2', '', 'BlkModuleDefault', 1, 1, 4, ''),
(8, 'Module_3', '', 'BlkModuleDefault', 1, 2, 0, ''),
(9, 'Main', '', '', 1, 3, 1, ''),
(10, 'Contact', '', 'BlkContact', 1, 2, 1, ''),
(16, 'Most Viewed ', 'Bài viết được xem nhiều nhất', 'BlkMostViewed', 1, 1, 2, '$amount_items=5;');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
