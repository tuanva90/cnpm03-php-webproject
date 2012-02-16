-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 16, 2012 at 01:08 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `source3`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `cms_hotnews`
-- 

CREATE TABLE `cms_hotnews` (
  `id` int(11) NOT NULL auto_increment,
  `news_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `cms_hotnews`
-- 

INSERT INTO `cms_hotnews` VALUES (1, 770, '2012-02-16 01:20:42');
INSERT INTO `cms_hotnews` VALUES (2, 769, '2012-02-16 12:29:59');
INSERT INTO `cms_hotnews` VALUES (3, 768, '2012-02-16 12:30:07');
INSERT INTO `cms_hotnews` VALUES (4, 767, '2012-02-16 12:30:15');
