-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 建立日期: 2015 年 06 月 16 日 11:41
-- 伺服器版本: 5.5.43-0ubuntu0.14.04.1-log
-- PHP 版本: 5.6.10-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `buysomething`
--

-- --------------------------------------------------------

--
-- 資料表結構 `buyList`
--

CREATE TABLE IF NOT EXISTS `buyList` (
  `buy_id` int(11) NOT NULL AUTO_INCREMENT,
  `buy_name` varchar(10) NOT NULL,
  `num` int(11) NOT NULL,
  `context` text NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`buy_id`),
  UNIQUE KEY `buy_id` (`buy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 資料表的匯出資料 `buyList`
--

INSERT INTO `buyList` (`buy_id`, `buy_name`, `num`, `context`, `price`) VALUES
(3, '遊戲王卡', 0, '超好玩', 120);

-- --------------------------------------------------------

--
-- 資料表結構 `orderList`
--

CREATE TABLE IF NOT EXISTS `orderList` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `buy_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 資料表的匯出資料 `orderList`
--

INSERT INTO `orderList` (`order_id`, `user_id`, `buy_id`, `num`, `price`) VALUES
(1, 13, 3, 2, 240),
(2, 13, 3, 1, 120),
(3, 13, 3, 1, 120),
(4, 13, 3, 1, 120),
(5, 13, 3, 1, 120),
(6, 13, 3, 1, 120),
(8, 16, 3, 1, 120);

-- --------------------------------------------------------

--
-- 資料表結構 `userList`
--

CREATE TABLE IF NOT EXISTS `userList` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(10) NOT NULL COMMENT '帳號',
  `password` varchar(10) NOT NULL COMMENT '密碼',
  `power` varchar(2) NOT NULL COMMENT '權限',
  `money` int(11) NOT NULL COMMENT '額度',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`,`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 資料表的匯出資料 `userList`
--

INSERT INTO `userList` (`user_id`, `user_name`, `password`, `power`, `money`) VALUES
(1, 'root', '1234', '99', 999999),
(2, 'user1', '12345', '1', 100),
(3, 'user2', '12345', '1', 100),
(13, 'user3', '1234', '1', 9160),
(16, '1234', '1234', '1', 50000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;