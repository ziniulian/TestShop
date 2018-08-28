-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 07 月 19 日 14:30
-- 服务器版本: 5.5.40
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `shop`
--

-- --------------------------------------------------------

--
-- 表的结构 `tsp_users`
--

CREATE TABLE IF NOT EXISTS `tsp_users` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '',
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` varchar(255) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `frozen_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_points` int(10) unsigned NOT NULL DEFAULT '0',
  `rank_points` int(10) unsigned NOT NULL DEFAULT '0',
  `address_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_rank` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_special` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ec_salt` varchar(10) DEFAULT NULL,
  `salt` varchar(10) NOT NULL DEFAULT '0',
  `parent_id` mediumint(9) NOT NULL DEFAULT '0',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(60) NOT NULL,
  `msn` varchar(60) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `office_phone` varchar(20) NOT NULL,
  `home_phone` varchar(20) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `is_validated` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `credit_line` decimal(10,2) unsigned NOT NULL,
  `passwd_question` varchar(50) DEFAULT NULL,
  `passwd_answer` varchar(255) DEFAULT NULL,
  `true_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `email` (`email`),
  KEY `parent_id` (`parent_id`),
  KEY `flag` (`flag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `tsp_users`
--

INSERT INTO `tsp_users` (`user_id`, `email`, `user_name`, `password`, `question`, `answer`, `sex`, `birthday`, `user_money`, `frozen_money`, `pay_points`, `rank_points`, `address_id`, `reg_time`, `last_login`, `last_time`, `last_ip`, `visit_count`, `user_rank`, `is_special`, `ec_salt`, `salt`, `parent_id`, `flag`, `alias`, `msn`, `qq`, `office_phone`, `home_phone`, `mobile_phone`, `is_validated`, `credit_line`, `passwd_question`, `passwd_answer`, `true_name`) VALUES
(7, 'ziniulian@163.com', 'ziniulian', '5e767d23ef1c0367008c0b8e4395118c', '', '', 1, '1985-06-17', '0.00', '0.00', 0, 0, 0, 1467432109, 1467703670, '0000-00-00 00:00:00', '0.0.0.0', 4, 0, 0, '293', '0', 0, 0, '', '', '', '', '', '', 0, '0.00', NULL, NULL, NULL),
(8, 'test1@qq.com', 'SHMILYBEN819', '6ae05d4ebfb9f72d824ad0ba8e0446b6', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '18693051611', 0, '0.00', NULL, NULL, '陈国'),
(9, '2500620419@qq.com', '18394185118', 'f53727b557d14eab54c033887c5338ef', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '18394185118', 0, '0.00', NULL, NULL, '刘丽娜'),
(10, 'kelvinwu.hk@gmail.com', 'kelvin', 'a9aae3081462f6784c3242c726b8cb0c', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '15017612001', 0, '0.00', NULL, NULL, '胡锦文'),
(11, 'test2@qq.com', '13893233177', '7cf73918957a1b687fbbac198cdd46c3', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '13893233177', 0, '0.00', NULL, NULL, '孙通武'),
(12, 'test3@qq.com', '13809318108', 'ffc3680678a1e5a4d4b0b0a96118f2a4', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '13809318108', 0, '0.00', NULL, NULL, '苏本山'),
(13, 'test4@qq.com', '133', 'dfc0c46d476dd7126c64b06f3083f5e1', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '13399310088', 0, '0.00', NULL, NULL, '李源'),
(14, 'test5@qq.com', '13919324284', '2dbc6573f9c17bdd67c725f898d5a053', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '13919324284', 0, '0.00', NULL, NULL, '白娅玲'),
(15, 'test6@qq.com', '15117271017', '8ffa1d217e43b89651daab19bd39ae22', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '15117271017', 0, '0.00', NULL, NULL, '丁琦'),
(16, 'test7@qq.com', '18919952158', '75dec1550155f7c088a4ded5da4a4145', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '18919952158', 0, '0.00', NULL, NULL, '吴国光'),
(17, 'test9@qq.com', '13399310088', 'dfc0c46d476dd7126c64b06f3083f5e1', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '13399310088', 0, '0.00', NULL, NULL, '李主任'),
(18, '0', 'xinshan', '8204e5db2e51879e65f7754d7fc2417e', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '2', 0, '0.00', NULL, NULL, '管理员'),
(19, '119275679@qq.com', '2', 'a8a00f1250724bd45f0cb1887f043bc9', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '13893375804', 0, '0.00', NULL, NULL, '肋条'),
(20, '0', '1', '131ca30468f283101dbf800d41de5eda', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '222', 0, '0.00', NULL, NULL, '测试'),
(21, '119275679@qq.com', 'test', '131ca30468f283101dbf800d41de5eda', '', '', 0, '0000-00-00', '0.00', '0.00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '719', '0', 0, 0, '', '', '', '', '', '1', 0, '0.00', NULL, NULL, '三疯');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
