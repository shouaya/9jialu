-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2013 年 06 月 08 日 16:47
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_weiadmin`
--

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `keyword` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `wid` varchar(50) NOT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `image`
--

INSERT INTO `image` (`keyword`, `title`, `id`, `img`, `content`, `wid`, `ctime`) VALUES
('m3', '梦之蓝--M3', 2, 'http://weiadmin-img.stor.sinaapp.com/mm3.jpg', '梦之蓝', 'gh_0509aa3d69ac', NULL),
('m9', '梦之蓝--M9', 3, 'http://weiadmin-img.stor.sinaapp.com/mm9.jpg', '梦之蓝之m9', 'gh_0509aa3d69ac', NULL);
-- --------------------------------------------------------

--
-- 表的结构 `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `keyword` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `wid` varchar(50) NOT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`keyword`,`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `keyword`
--

INSERT INTO `keyword` (`keyword`, `content`, `type`, `wid`, `ctime`) VALUES
('m3', '', 'image', 'gh_0509aa3d69ac', NULL),
('m9', '', 'image', 'gh_0509aa3d69ac', NULL);
-- --------------------------------------------------------

--
-- 表的结构 `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` varchar(50) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `Location_X` varchar(50) NOT NULL,
  `Location_Y` varchar(50) NOT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `location`
--

INSERT INTO `location` (`id`, `wid`, `title`, `content`, `Location_X`, `Location_Y`, `ctime`) VALUES
(1, 'gh_0509aa3d69ac', '合浦威腾酒业', '合浦威腾酒业', '21.660351', '109.205254', NULL),
(3, 'gh_0509aa3d69ac', '酒家路', '', '33.779509', '118.388443', NULL);
-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `wid` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `ctime` datetime NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `uid` varchar(50) NOT NULL,
  PRIMARY KEY (`wid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`wid`, `pass`, `ctime`, `email`, `uid`) VALUES
('admin', 'admin', '2013-05-27 12:52:12', 'admin@9jialu.com', 'oPBUGj4EIXVo1c54-x0Zyf9pvW3E');
