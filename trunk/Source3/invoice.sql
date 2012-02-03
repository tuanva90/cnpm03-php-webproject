-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 03, 2012 at 03:00 PM
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
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`invoice_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `cms_invoice`
-- 

INSERT INTO `cms_invoice` VALUES (1, 'Pham Vu Khanh', 'vukhanh2212@gmail.com', '0908893326', 'So 1 - Le Duan - Q.1 - TP.HCM', 'So 1 - Le Duan - Q.1 - TP.HCM', 'Chuyen sach gap nhe. Thanks', '0000-00-00 00:00:00', 0);
INSERT INTO `cms_invoice` VALUES (2, 'Pham Vu Khanh', 'vukhanh2212@yahoo.com', '123452235435', 'sadhasd asdlkjas dsalkklda laslkdklas', 'asdasld askdlasd l;askdkasd', 'sadhasd asdlkjas dsalkklda laslkdklas', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `cms_invoice_detail`
-- 

CREATE TABLE `cms_invoice_detail` (
  `invoice_detail_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL default '1',
  `price` float NOT NULL default '0',
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY  (`invoice_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `cms_invoice_detail`
-- 

INSERT INTO `cms_invoice_detail` VALUES (1, 10, 2, 54.5, 1);
INSERT INTO `cms_invoice_detail` VALUES (2, 13, 3, 42.99, 1);
INSERT INTO `cms_invoice_detail` VALUES (3, 18, 4, 34.99, 1);
INSERT INTO `cms_invoice_detail` VALUES (4, 16, 4, 49.99, 2);
INSERT INTO `cms_invoice_detail` VALUES (5, 20, 5, 182, 2);
INSERT INTO `cms_invoice_detail` VALUES (6, 24, 6, 49.99, 2);
