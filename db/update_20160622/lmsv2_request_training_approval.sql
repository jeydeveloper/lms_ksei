-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 23, 2016 at 03:40 AM
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
-- Table structure for table `lmsv2_request_training_approval`
--

DROP TABLE IF EXISTS `lmsv2_request_training_approval`;
CREATE TABLE IF NOT EXISTS `lmsv2_request_training_approval` (
  `trap_id` int(11) NOT NULL AUTO_INCREMENT,
  `trap_rqtr_id` int(11) NOT NULL,
  `trap_user_id` int(11) NOT NULL,
  `trap_status_approval` tinyint(4) NOT NULL,
  `trap_reason_approval` text NOT NULL,
  `trap_entryuser` varchar(200) NOT NULL,
  `trap_entrytime` datetime NOT NULL,
  `trap_updateuser` varchar(200) NOT NULL,
  `trap_updatetime` datetime NOT NULL,
  PRIMARY KEY (`trap_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
