-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- �D��: localhost
-- �إߤ��: 2015 �~ 06 �� 16 �� 11:41
-- ���A������: 5.5.43-0ubuntu0.14.04.1-log
-- PHP ����: 5.6.10-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- ��Ʈw: `buysomething`
--

-- --------------------------------------------------------

--
-- ��ƪ��c `buyList`
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
-- ��ƪ��ץX��� `buyList`
--

INSERT INTO `buyList` (`buy_id`, `buy_name`, `num`, `context`, `price`) VALUES
(3, '�C�����d', 0, '�W�n��', 120);

-- --------------------------------------------------------

--
-- ��ƪ��c `orderList`
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
-- ��ƪ��ץX��� `orderList`
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
-- ��ƪ��c `userList`
--

CREATE TABLE IF NOT EXISTS `userList` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(10) NOT NULL COMMENT '�b��',
  `password` varchar(10) NOT NULL COMMENT '�K�X',
  `power` varchar(2) NOT NULL COMMENT '�v��',
  `money` int(11) NOT NULL COMMENT '�B��',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`,`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- ��ƪ��ץX��� `userList`
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