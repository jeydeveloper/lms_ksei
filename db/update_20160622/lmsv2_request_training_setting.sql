-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 23, 2016 at 03:41 AM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ncclp2_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training_setting`
--

DROP TABLE IF EXISTS `lmsv2_request_training_setting`;
CREATE TABLE IF NOT EXISTS `lmsv2_request_training_setting` (
  `trse_id` int(11) NOT NULL AUTO_INCREMENT,
  `trse_rqtr_id` int(11) NOT NULL,
  `trse_user_approval` text NOT NULL,
  `trse_total_user_approval` tinyint(4) NOT NULL,
  `trse_one_approval_status` int(11) NOT NULL,
  `trse_entryuser` varchar(100) NOT NULL,
  `trse_entrytime` datetime NOT NULL,
  `trse_changeuser` varchar(100) NOT NULL,
  `trse_changetime` datetime NOT NULL,
  PRIMARY KEY (`trse_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
