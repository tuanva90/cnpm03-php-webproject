-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 16, 2012 at 06:47 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_sites`
--

CREATE TABLE IF NOT EXISTS `cms_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cms_sites`
--

INSERT INTO `cms_sites` (`id`, `name`, `content`) VALUES
(1, 'Home Page', '<img alt="s" src="http://static.adzerk.net/Advertisers/3604.jpg" style="width: 123px; height: 123px; border-width: px; border-style: solid; margin: px px; float: right;">			<h3 style="text-align: center;"><font face="Impact" color="#ff0000">Welcome to Home Page</font></h3>																																	'),
(2, 'Introduction', '			<h3>Introduction Page</h3>			'),
(3, 'Giới thiệu', 'ádjkhaskjdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `cms_sites_module`
--

CREATE TABLE IF NOT EXISTS `cms_sites_module` (
  `site_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `sort_order` tinyint(4) NOT NULL,
  PRIMARY KEY (`site_id`,`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cms_sites_module`
--

INSERT INTO `cms_sites_module` (`site_id`, `module_id`, `sort_order`) VALUES
(1, 9, 0),
(2, 8, 0),
(2, 9, 1),
(3, 9, 0);
