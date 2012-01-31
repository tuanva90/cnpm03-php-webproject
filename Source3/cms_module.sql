-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2012 at 08:56 AM
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
-- Table structure for table `cms_module`
--

CREATE TABLE IF NOT EXISTS `cms_module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `file_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `is_showed` bit(1) NOT NULL,
  `position` tinyint(2) DEFAULT NULL,
  `sort_order` tinyint(2) DEFAULT NULL,
  `option` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `cms_module`
--

INSERT INTO `cms_module` (`module_id`, `name`, `file_name`, `is_showed`, `position`, `sort_order`, `option`) VALUES
(1, 'Login', 'BlkLogin', '1', 1, 0, '$use_forgot_password_link=1;$use_keep_signed_in=1;'),
(2, 'Newest Product', 'BlkNewestProduct', '1', 1, 1, '$amount_items=5;'),
(3, 'Impressive Product', 'BlkImpressiveProduct', '1', 2, 1, '$amount_items=10;'),
(5, 'Header', '', '1', 0, 0, '$banner=''header_1.jpg'';$title=''Click and Change'';$welcome_text=''Bring you the easiest way to own websites.'';'),
(6, 'Module_1', 'BlkModuleDefault', '1', 1, 2, ''),
(7, 'Module_2', 'BlkModuleDefault', '1', 1, 3, ''),
(8, 'Module_3', 'BlkModuleDefault', '1', 2, 0, ''),
(9, 'Main', '', '1', 3, 1, '');
