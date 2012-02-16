CREATE TABLE `cms_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) collate utf8_unicode_ci NOT NULL,
  `avatar` varchar(45) collate utf8_unicode_ci default NULL,
  `password` varchar(32) collate utf8_unicode_ci NOT NULL,
  `firstname` varchar(32) collate utf8_unicode_ci NOT NULL,
  `lastname` varchar(32) collate utf8_unicode_ci NOT NULL,
  `birthday` datetime NOT NULL default '0000-00-00 00:00:00',
  `email` varchar(96) collate utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `ip` varchar(15) collate utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `visited_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `active_code` varchar(45) collate utf8_unicode_ci default NULL,
  `sign` text collate utf8_unicode_ci,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;


INSERT INTO `cms_user` VALUES (1, 1, 'admin', '/Zend/public/files/images/A12-(9).JPG', 'c4ca4238a0b923820dcc509a6f75849b', 'Ð?ng Vãn', 'Huy', '2011-09-10 00:00:00', 'huydang1920@gmail.com', 1, '127.0.0.1', '2011-10-06 21:26:11', '0000-00-00 00:00:00', NULL, '<p>\r\n	ðá</p>\r\n');
INSERT INTO `cms_user` VALUES (6, 2, 'member', '/Zend/public/files/images/A12-(9).JPG', 'c4ca4238a0b923820dcc509a6f75849b', 'member', 'member', '2011-08-01 00:00:00', 'member', 1, '127.0.0.1', '2011-10-08 15:35:51', '0000-00-00 00:00:00', NULL, '<p>\r\n	cxcx</p>\r\n');


CREATE TABLE `cms_user_group` (
  `user_group_id` int(11) NOT NULL auto_increment,
  `name` varchar(64) collate utf8_unicode_ci NOT NULL,
  `avatar` varchar(45) collate utf8_unicode_ci default NULL,
  `permission` text collate utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `sort_order` int(11) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`user_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `cms_user_group` VALUES (1, 'Administrator', NULL, 'Full Access', '0000-00-00 00:00:00', '2011-10-10 10:36:45', 1, 1);
INSERT INTO `cms_user_group` VALUES (2, 'Member', NULL, 'no-acces', '0000-00-00 00:00:00', '2011-10-04 13:08:05', 2, 1);