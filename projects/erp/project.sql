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
(1,	'AROMAA (AMBIANCE DECOR)',	'VASHI',	'9999999899',	'',	'shreenivas.madagundi@gmail.com',	'21325',	'',	'9999999899',	'P',	'Y',	1,	'2017-01-20 14:18:35',	0,	'2017-01-20 08:48:35'),
(2,	'Shreenivas Enterprizes',	'Navi Mumbai',	'9665419470',	'',	'shreenivas.madagundi@gmail.com',	'',	'',	'9999999899',	'S',	'Y',	1,	'2017-01-20 14:18:35',	0,	'2017-01-20 08:48:35');

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
(1,	'COFFEE BEEN',	1,	2,	'Y',	1,	'2017-01-20 14:22:23',	0,	'2017-01-20 08:52:23'),
(2,	'Assam Tea Bag',	2,	2,	'Y',	1,	'2017-01-20 14:27:49',	0,	'2017-01-20 08:57:49'),
(3,	'Masala Tea Bag',	2,	2,	'Y',	1,	'2017-01-20 14:29:41',	0,	'2017-01-20 08:59:41'),
(4,	'Ginger Tea bag',	2,	2,	'Y',	1,	'2017-01-20 14:30:37',	0,	'2017-01-20 09:00:37'),
(5,	'Cardoman tea bag',	2,	2,	'Y',	1,	'2017-01-20 14:31:11',	0,	'2017-01-20 09:11:49'),
(6,	'Green Tea Bag',	2,	2,	'Y',	1,	'2017-01-20 14:31:29',	0,	'2017-01-20 09:01:29'),
(7,	'Lemon Tea Bag',	2,	2,	'Y',	1,	'2017-01-20 14:31:48',	0,	'2017-01-20 09:01:48'),
(8,	'CUP 150 ML Branded',	3,	2,	'Y',	1,	'2017-01-20 14:33:00',	0,	'2017-01-20 09:03:30'),
(9,	'HOT CHOTLATE',	3,	2,	'Y',	1,	'2017-01-20 14:33:53',	0,	'2017-01-20 09:03:53'),
(10,	'BADAM DRINK',	3,	2,	'Y',	1,	'2017-01-20 14:34:33',	0,	'2017-01-20 09:04:33'),
(11,	'SUGAR Sachets',	1,	2,	'Y',	1,	'2017-01-20 14:35:03',	0,	'2017-01-20 09:05:03'),
(12,	'SUGAR Cubes',	1,	2,	'Y',	1,	'2017-01-20 14:35:19',	0,	'2017-01-20 09:05:19'),
(13,	'Milk T.P.Coffee Day',	4,	2,	'Y',	1,	'2017-01-20 14:35:54',	0,	'2017-01-20 09:05:54'),
(14,	'STERRER',	3,	2,	'Y',	1,	'2017-01-20 14:36:14',	0,	'2017-01-20 09:06:14'),
(15,	'HOT N SOUP',	3,	2,	'Y',	1,	'2017-01-20 14:36:27',	0,	'2017-01-20 09:06:27'),
(16,	'CUP 150 ml PLAIN',	3,	2,	'Y',	1,	'2017-01-20 14:37:02',	0,	'2017-01-20 09:07:02'),
(17,	'SUGAR NORMAL',	1,	2,	'Y',	1,	'2017-01-20 14:37:50',	0,	'2017-01-20 09:07:50'),
(18,	'CUP 200ml',	3,	2,	'Y',	1,	'2017-01-20 14:38:08',	0,	'2017-01-20 09:08:08'),
(19,	'GREEN and LEMAN Tea Bag',	2,	2,	'Y',	1,	'2017-01-20 14:38:34',	0,	'2017-01-20 09:08:34'),
(20,	'LREEN and LEMAN and HONEY Tea ',	2,	2,	'Y',	1,	'2017-01-20 14:39:15',	0,	'2017-01-20 09:09:15'),
(21,	'GREEN MINT Tea Bag',	2,	2,	'Y',	1,	'2017-01-20 14:39:35',	0,	'2017-01-20 09:09:35'),
(22,	'Wrnong',	3,	2,	'N',	1,	'2017-01-20 14:40:03',	0,	'2017-01-20 09:10:14');

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
(1,	'2017-01-20',	'123456',	2,	'2017-01-20',	'Y',	1,	'2017-01-20 14:44:13',	0,	'2017-01-20 09:14:13');

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
(1,	1,	0,	0,	0,	0,	'Y',	1,	'2017-01-20 14:44:13',	0,	'2017-01-20 09:14:13');

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


DROP TABLE IF EXISTS `sales_orders`;
CREATE TABLE `sales_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `sales_date` date NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sales_orders_details`;
CREATE TABLE `sales_orders_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `si_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `qty` float NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `inserted_by` int(11) NOT NULL,
  `inserted_datetime` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
(1,	'KG.',	'Kilo Grams',	'Y',	1,	'2016-12-09 21:33:28',	0,	'2016-12-09 10:33:28'),
(2,	'Box',	'Box',	'Y',	1,	'2016-12-09 21:33:28',	0,	'2016-12-09 10:33:28'),
(3,	'Nos.',	'Numbers',	'Y',	1,	'2016-12-09 21:33:28',	0,	'2016-12-09 10:33:28'),
(4,	'Ltrs.',	'Liters',	'Y',	1,	'2016-12-09 21:33:28',	0,	'2016-12-09 10:33:28');

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

-- 2017-01-20 13:20:44
