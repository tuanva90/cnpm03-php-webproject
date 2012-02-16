-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 13, 2012 at 02:21 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `zendcms_db3`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `cms_invoice`
-- 

CREATE TABLE `cms_invoice` (
  `invoice_id` int(11) NOT NULL auto_increment,
  `full_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `shipping` text NOT NULL,
  `comment` text,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`invoice_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `cms_invoice`
-- 

INSERT INTO `cms_invoice` VALUES (1, 'full_name', 'email', '123224324', 'address', 'comment', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);
INSERT INTO `cms_invoice` VALUES (2, 'full_name', 'email', '123224324', 'address', 'comment', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `cms_invoice_detail`
-- 

CREATE TABLE `cms_invoice_detail` (
  `invoice_detail_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL default '1',
  `price` double(15,4) NOT NULL default '0.0000',
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY  (`invoice_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `cms_invoice_detail`
-- 

INSERT INTO `cms_invoice_detail` VALUES (1, 42, 2, 350000.0000, 1);
INSERT INTO `cms_invoice_detail` VALUES (2, 43, 1, 800000.0000, 1);
INSERT INTO `cms_invoice_detail` VALUES (3, 32, 1, 1250000.0000, 2);
INSERT INTO `cms_invoice_detail` VALUES (4, 40, 2, 450000.0000, 2);