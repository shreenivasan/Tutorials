-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `project`;
CREATE DATABASE `project` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `project`;

DROP TABLE IF EXISTS `client_master`;
CREATE TABLE `client_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `alternate_mobile` varchar(10) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `vat_no` varchar(10) NOT NULL,
  `contact_person_name` varchar(30) NOT NULL,
  `contact_person_mobile` varchar(10) NOT NULL,
  `type` enum('S','P') DEFAULT NULL COMMENT 'S- Seller , P - Purchaser',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `client_master` (`id`, `name`, `address`, `mobile`, `alternate_mobile`, `email_id`, `vat_no`, `contact_person_name`, `contact_person_mobile`, `type`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	'ABC Ltd',	'Navi Mumbai',	'99999999',	'99999999',	'abc@ltd.com',	'2112212112',	'ABC',	'99999999',	'S',	'Y',	1,	'2016-12-07 17:12:43',	0,	'2016-12-07 11:42:43'),
(2,	'Shreenivas.',	'Navi Mumbai.',	'9999999899',	'9999999009',	'abc@ltd.comu',	'2112212111',	'ABCu',	'9999999906',	'P',	'Y',	1,	'2016-12-07 17:12:43',	0,	'2016-12-17 06:24:27'),
(3,	'Sandhya',	'Kopar kairahane',	'1221212112',	'',	'shreenivas.madagundi@gmail.com',	'2112212111',	'',	'1221212112',	'P',	'Y',	1,	'2016-12-17 12:01:37',	0,	'2016-12-17 06:43:21'),
(4,	'sir',	'sir',	'1111111111',	'9999999000',	'fsdfds@fdsfds.com',	'SHFD',	'ABCu',	'1111111111',	'P',	'Y',	1,	'2016-12-17 12:14:16',	0,	'2016-12-17 06:49:14'),
(5,	'sir1',	'sir',	'1111111111',	'9999999000',	'fsdfds@fdsfds.com',	'SHFD',	'ABCu',	'1111111111',	'P',	'Y',	1,	'2016-12-17 12:14:16',	0,	'2016-12-17 07:11:05'),
(6,	'sir',	'sir',	'1111111111',	'9999999000',	'fsdfds@fdsfds.com',	'SHFD',	'ABCu',	'1111111111',	'P',	'Y',	1,	'2016-12-17 12:14:16',	0,	'2016-12-17 06:49:14'),
(7,	'sir',	'sir',	'1111111111',	'9999999000',	'fsdfds@fdsfds.com',	'SHFD',	'ABCu',	'1111111111',	'P',	'Y',	1,	'2016-12-17 12:14:16',	0,	'2016-12-17 06:49:14'),
(8,	'ABC Ltd',	'Navi Mumbai',	'99999999',	'99999999',	'abc@ltd.com',	'2112212112',	'ABC',	'99999999',	'P',	'N',	1,	'2016-12-07 17:12:43',	0,	'2016-12-17 06:55:34');

DROP TABLE IF EXISTS `menu_master`;
CREATE TABLE `menu_master` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `link_url` varchar(100) NOT NULL,
  `menu_name` varchar(40) NOT NULL,
  `seq` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `menu_master` (`menu_id`, `parent_id`, `link_url`, `menu_name`, `seq`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	0,	'',	'Masters',	1,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:04:51'),
(2,	1,	'menu',	'Menu Master',	1,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:08:07'),
(3,	2,	'menu/add',	'Add Menu',	1,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:21:18'),
(4,	2,	'menu/edit',	'Edit Menu',	2,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:19:05'),
(5,	2,	'menu/delete',	'Edit Menu',	3,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:19:15'),
(6,	1,	'role',	'Role Master',	2,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:19:30'),
(7,	6,	'role/add',	'Add Role',	1,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:21:18'),
(8,	6,	'role/edit',	'Edit Role',	2,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:21:18'),
(9,	6,	'role/delete',	'Delete Role',	3,	'1',	1,	'2016-05-25 18:34:51',	0,	'2016-05-25 13:23:27');

DROP TABLE IF EXISTS `product_client_datewise_price`;
CREATE TABLE `product_client_datewise_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `date` int(11) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `product_client_datewise_price` (`id`, `product_id`, `client_id`, `price`, `date`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	1,	1,	1,	2016,	'Y',	1,	'2016-12-17 21:28:54',	0,	'2016-12-17 16:29:13'),
(2,	1,	2,	222,	2016,	'Y',	1,	'2016-12-17 21:32:20',	0,	'2016-12-17 16:29:21'),
(3,	1,	2,	222,	2017,	'Y',	1,	'2016-12-17 21:56:25',	0,	'2016-12-17 16:26:25');

DROP TABLE IF EXISTS `product_master`;
CREATE TABLE `product_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `product_master` (`id`, `name`, `unit_id`, `seller_id`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	'COFFEE BEEN',	1,	1,	'Y',	1,	'0000-00-00 00:00:00',	1,	'2016-12-13 12:28:01'),
(2,	'Assam Tea Bag',	2,	1,	'Y',	1,	'0000-00-00 00:00:00',	1,	'2016-12-09 16:10:44'),
(3,	'Masala Tea Bag',	2,	1,	'Y',	1,	'0000-00-00 00:00:00',	1,	'2016-12-09 16:11:03'),
(4,	'Ginger Tea bag',	2,	1,	'Y',	1,	'0000-00-00 00:00:00',	1,	'2016-12-09 16:11:19'),
(5,	'Cardoman Tea Bag',	2,	1,	'Y',	0,	'0000-00-00 00:00:00',	0,	'2016-12-09 16:11:35'),
(6,	'Green Tea Bag',	2,	1,	'Y',	0,	'0000-00-00 00:00:00',	0,	'2016-12-09 16:21:05'),
(7,	'Lemon Tea Bag',	2,	1,	'Y',	0,	'0000-00-00 00:00:00',	0,	'2016-12-09 16:21:18'),
(8,	'dfs',	3,	1,	'N',	1,	'2016-12-12 19:16:06',	0,	'2016-12-13 13:04:02'),
(9,	'COFFEE BEEN',	2,	1,	'Y',	1,	'2016-12-13 17:35:22',	0,	'2016-12-13 12:05:22');

DROP TABLE IF EXISTS `purchase_orders`;
CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inward_date` date NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `cur_date` date NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_orders` (`id`, `inward_date`, `invoice_no`, `client_id`, `cur_date`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	'2016-12-05',	'ddfd',	1,	'2016-12-04',	'Y',	1,	'2016-12-31 14:52:00',	1,	'2017-01-07 08:48:43'),
(2,	'2016-12-29',	'11',	1,	'2016-12-26',	'Y',	1,	'2017-01-07 13:25:06',	1,	'2017-01-07 09:28:01'),
(3,	'2017-01-03',	'gggg',	1,	'2017-01-09',	'Y',	1,	'2017-01-07 13:27:00',	1,	'2017-01-07 08:48:04');

DROP TABLE IF EXISTS `purchase_order_details`;
CREATE TABLE `purchase_order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `materials_vat_price` int(11) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_order_details` (`id`, `po_id`, `product_id`, `price`, `qty`, `materials_vat_price`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	1,	6,	0,	6,	6,	'N',	1,	'2016-12-31 14:52:00',	0,	'2017-01-07 08:48:43'),
(2,	1,	7,	0,	9,	9,	'N',	1,	'2016-12-31 14:52:00',	0,	'2017-01-07 08:48:43'),
(3,	1,	4,	0,	8,	8,	'N',	1,	'2016-12-31 14:52:00',	0,	'2017-01-07 08:48:43'),
(4,	2,	2,	0,	1,	1,	'N',	1,	'2017-01-07 13:25:06',	0,	'2017-01-07 09:00:14'),
(5,	2,	3,	0,	2,	2,	'N',	1,	'2017-01-07 13:25:06',	0,	'2017-01-07 09:00:14'),
(6,	3,	5,	1,	2,	3,	'N',	1,	'2017-01-07 13:27:00',	0,	'2017-01-07 08:47:45'),
(7,	3,	7,	4,	5,	6,	'N',	1,	'2017-01-07 13:27:00',	0,	'2017-01-07 08:47:45'),
(8,	3,	5,	1,	2,	3,	'N',	1,	'2017-01-07 14:17:45',	0,	'2017-01-07 08:48:04'),
(9,	3,	7,	4,	5,	6,	'N',	1,	'2017-01-07 14:17:45',	0,	'2017-01-07 08:48:04'),
(10,	3,	5,	1,	2,	3,	'Y',	1,	'2017-01-07 14:18:04',	0,	'2017-01-07 08:48:04'),
(11,	3,	7,	4,	5,	6,	'Y',	1,	'2017-01-07 14:18:04',	0,	'2017-01-07 08:48:04'),
(12,	1,	6,	1,	2,	3,	'Y',	1,	'2017-01-07 14:18:43',	0,	'2017-01-07 08:48:43'),
(13,	1,	7,	4,	5,	6,	'Y',	1,	'2017-01-07 14:18:43',	0,	'2017-01-07 08:48:43'),
(14,	1,	4,	7,	8,	9,	'Y',	1,	'2017-01-07 14:18:43',	0,	'2017-01-07 08:48:43'),
(15,	2,	2,	1,	2,	3,	'N',	1,	'2017-01-07 14:30:14',	0,	'2017-01-07 09:28:01'),
(16,	2,	3,	4,	5,	6,	'N',	1,	'2017-01-07 14:30:14',	0,	'2017-01-07 09:28:01'),
(17,	2,	2,	1,	2,	3,	'Y',	1,	'2017-01-07 14:58:01',	0,	'2017-01-07 09:28:01');

DROP TABLE IF EXISTS `role_master`;
CREATE TABLE `role_master` (
  `role_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'primary key of the table',
  `parent_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'foriegn key of role_master default is zero',
  `role_name` varchar(30) NOT NULL COMMENT 'name to display',
  `role_code` varchar(10) NOT NULL COMMENT 'code for menu',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1-Active , 0-Inactive',
  `inserted_by` int(11) NOT NULL COMMENT 'id of inserted user',
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL COMMENT 'id of updated user',
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `role_master` (`role_id`, `parent_id`, `role_name`, `role_code`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	0,	'Admin',	'ADMIN',	'1',	1,	'2016-11-30 11:13:44',	0,	'2016-11-30 05:43:44');

DROP TABLE IF EXISTS `unit_master`;
CREATE TABLE `unit_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `unit_master` (`id`, `code`, `name`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	'KG.',	'Kilo Grams',	'Y',	1,	'2016-12-09 21:33:28',	0,	'2016-12-09 16:03:28'),
(2,	'Box',	'Box',	'Y',	1,	'2016-12-09 21:33:28',	0,	'2016-12-09 16:03:28'),
(3,	'Nos.',	'Numbers',	'Y',	1,	'2016-12-09 21:33:28',	0,	'2016-12-09 16:03:28');

DROP TABLE IF EXISTS `user_master`;
CREATE TABLE `user_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `alternate_mobile_no` varchar(10) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `role_id` tinyint(4) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_master_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role_master` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user_master` (`id`, `first_name`, `last_name`, `username`, `password`, `email_id`, `mobile_no`, `alternate_mobile_no`, `emp_id`, `role_id`, `status`, `inserted_by`, `inserted_datetime`, `updated_by`, `updated_datetime`) VALUES
(1,	'Shreenivas',	'Madagundi',	's',	'c4ca4238a0b923820dcc509a6f75849b',	'shreenivas.madagundi@gmail.com',	'9665419470',	'9503515533',	'1',	1,	'Y',	1,	'2016-11-30 12:02:14',	0,	'2016-12-01 09:30:09');

-- 2017-01-12 10:03:54
