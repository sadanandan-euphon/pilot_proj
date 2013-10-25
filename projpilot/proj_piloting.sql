-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2013 at 08:51 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `proj_piloting`
--

-- --------------------------------------------------------

--
-- Table structure for table `pp_permission`
--

CREATE TABLE IF NOT EXISTS `pp_permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(100) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pp_permission`
--

INSERT INTO `pp_permission` (`permission_id`, `permission_name`) VALUES
(1, 'add user details'),
(2, 'edit user details'),
(3, 'delete user details'),
(4, 'edit user name'),
(5, 'edit password'),
(6, 'add user name'),
(7, 'add password');

-- --------------------------------------------------------

--
-- Table structure for table `pp_province`
--

CREATE TABLE IF NOT EXISTS `pp_province` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_code` varchar(2) NOT NULL,
  `province_name` varchar(100) NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `pp_province`
--

INSERT INTO `pp_province` (`province_id`, `province_code`, `province_name`) VALUES
(1, 'AB', 'Alberta'),
(2, 'BC', 'British Columbia'),
(3, 'MB', 'Manitoba'),
(4, 'NB', 'Newfoundland Labrador'),
(5, 'NS', 'Nova Scotia'),
(6, 'NT', 'Northwest Territories'),
(7, 'NU', 'Nunavut'),
(8, 'ON', 'Ontario'),
(9, 'PE', 'Price Edward Island'),
(10, 'QC', 'Quebec'),
(11, 'SK', 'Saskatchewan'),
(12, 'YT', 'Yukon');

-- --------------------------------------------------------

--
-- Table structure for table `pp_users`
--

CREATE TABLE IF NOT EXISTS `pp_users` (
  `user_id` int(15) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_role_id` int(11) NOT NULL COMMENT 'FK of pp_user_role table',
  `status` int(11) NOT NULL COMMENT '1-Active,0-Nonactive',
  `created_date` date NOT NULL,
  `last_login` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `userName` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pp_users`
--

INSERT INTO `pp_users` (`user_id`, `user_name`, `password`, `user_role_id`, `status`, `created_date`, `last_login`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '2013-10-01', '2013-10-16 7:58:06 7'),
(6, 'sadanandan', 'e10adc3949ba59abbe56e057f20f883e', 3, 1, '2013-10-16', '2013-10-16 9:09:13 7');

-- --------------------------------------------------------

--
-- Table structure for table `pp_user_details`
--

CREATE TABLE IF NOT EXISTS `pp_user_details` (
  `user_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `province` varchar(2) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birth_date` date NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_details_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pp_user_details`
--

INSERT INTO `pp_user_details` (`user_details_id`, `user_id`, `first_name`, `last_name`, `email`, `address`, `city`, `province`, `post_code`, `phone`, `birth_date`, `last_modified`) VALUES
(2, 1, 'admin user', 'super', 'admin@gmail.com', 'admin, admin', 'tvm-1', 'NS', '3213', '213', '1990-01-02', '2013-10-08 02:03:43'),
(6, 6, 'sadanandan', 'admin', 'sadanandan@euphontec.com', '', '', 'AB', '', '', '2013-10-02', '2013-10-16 03:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `pp_user_role`
--

CREATE TABLE IF NOT EXISTS `pp_user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pp_user_role`
--

INSERT INTO `pp_user_role` (`user_role_id`, `user_role_name`) VALUES
(1, 'Administrator'),
(2, 'Standared User'),
(3, 'Viewer');

-- --------------------------------------------------------

--
-- Table structure for table `pp_user_role_permissions`
--

CREATE TABLE IF NOT EXISTS `pp_user_role_permissions` (
  `user_role_permissions_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL COMMENT 'FK of pp_user_role table',
  `permission_id` int(11) NOT NULL COMMENT 'FK of pp_permission table',
  PRIMARY KEY (`user_role_permissions_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pp_user_role_permissions`
--

INSERT INTO `pp_user_role_permissions` (`user_role_permissions_id`, `user_role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 2, 1),
(9, 2, 2),
(10, 2, 6),
(11, 2, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
