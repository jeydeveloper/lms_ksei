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
-- Table structure for table `lmsv2_request_training`
--

DROP TABLE IF EXISTS `lmsv2_request_training`;
CREATE TABLE IF NOT EXISTS `lmsv2_request_training` (
  `rqtr_id` int(11) NOT NULL AUTO_INCREMENT,
  `rqtr_request_no` varchar(100) NOT NULL,
  `rqtr_request_code` int(11) NOT NULL,
  `rqtr_user_id` varchar(10) NOT NULL,
  `rqtr_type` tinyint(4) NOT NULL,
  `rqtr_penyelenggara` varchar(200) NOT NULL,
  `rqtr_tema` varchar(200) NOT NULL,
  `rqtr_judul` varchar(200) NOT NULL,
  `rqtr_tempat` varchar(200) NOT NULL,
  `rqtr_schedule` text NOT NULL,
  `rqtr_participant` text NOT NULL,
  `rqtr_pembicara` varchar(200) NOT NULL,
  `rqtr_pemohon` varchar(200) NOT NULL,
  `rqtr_divisi` varchar(200) DEFAULT NULL,
  `rqtr_handphone` varchar(200) NOT NULL,
  `rqtr_tujuan_pelatihan` text NOT NULL,
  `rqtr_rekomendasi_supervisor` text NOT NULL,
  `rqtr_biaya_program` int(11) NOT NULL,
  `rqtr_akomodasi` int(11) NOT NULL,
  `rqtr_transportasi` int(11) NOT NULL,
  `rqtr_uang_makan` int(11) NOT NULL,
  `rqtr_jumlah` int(11) NOT NULL,
  `rqtr_rekomendasi_development` text NOT NULL,
  `rqtr_jenis_pendidikan` tinyint(4) NOT NULL,
  `rqtr_status_approval` tinyint(4) NOT NULL,
  `rqtr_entryuser` varchar(100) NOT NULL,
  `rqtr_entrytime` datetime NOT NULL,
  `rqtr_updateuser` varchar(100) NOT NULL,
  `rqtr_updatetime` datetime NOT NULL,
  PRIMARY KEY (`rqtr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
