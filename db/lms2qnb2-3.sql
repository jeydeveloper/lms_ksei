-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 11, 2014 at 05:27 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lms2qnb2`
--

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal`
--

CREATE TABLE `lmsv2_banksoal` (
  `banksoal_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_name` varchar(100) DEFAULT NULL,
  `banksoal_created` int(11) DEFAULT NULL,
  `banksoal_creator` int(11) DEFAULT NULL,
  `banksoal_type` int(11) DEFAULT '1' COMMENT '1=exam/preexam, 2=certificate',
  `banksoal_status` int(11) DEFAULT '1' COMMENT '1=aktif,2=inaktif',
  PRIMARY KEY (`banksoal_id`),
  UNIQUE KEY `NewIndex1` (`banksoal_name`,`banksoal_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_answer`
--

CREATE TABLE `lmsv2_banksoal_answer` (
  `banksoal_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_answer_text` text,
  `banksoal_answer_question` int(11) DEFAULT NULL,
  `banksoal_answer_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`banksoal_answer_id`),
  KEY `NewIndex1` (`banksoal_answer_question`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal_answer`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_answer_archive`
--

CREATE TABLE `lmsv2_banksoal_answer_archive` (
  `banksoal_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_answer_text` text,
  `banksoal_answer_question` int(11) DEFAULT NULL,
  `banksoal_answer_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`banksoal_answer_id`),
  KEY `NewIndex1` (`banksoal_answer_question`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal_answer_archive`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_jabatan`
--

CREATE TABLE `lmsv2_banksoal_jabatan` (
  `banksoal_jabatan_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_jabatan_unit` int(11) DEFAULT NULL,
  `banksoal_jabatan_jabatan` int(11) DEFAULT NULL,
  `banksoal_jabatan_jmlsoal` int(11) DEFAULT NULL,
  `banksoal_jabatan_bobotmudah` int(11) DEFAULT NULL,
  `banksoal_jabatan_bobotsedang` int(11) DEFAULT NULL,
  `banksoal_jabatan_bobotsulit` int(11) DEFAULT NULL,
  `banksoal_jabatan_training` int(11) NOT NULL,
  PRIMARY KEY (`banksoal_jabatan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal_jabatan`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_question`
--

CREATE TABLE `lmsv2_banksoal_question` (
  `banksoal_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_question_quest` text,
  `banksoal_question_answer` int(11) DEFAULT NULL,
  `banksoal_question_banksoal` int(11) DEFAULT NULL,
  `banksoal_question_order` int(11) DEFAULT NULL,
  `banksoal_question_status` int(11) DEFAULT '1',
  `banksoal_question_packet` varchar(10) DEFAULT NULL,
  `banksoal_question_jabatan` int(11) DEFAULT NULL,
  `banksoal_question_bobot` varchar(100) DEFAULT NULL,
  `banksoal_question_alljabatan` int(11) DEFAULT '0',
  PRIMARY KEY (`banksoal_question_id`),
  KEY `NewIndex1` (`banksoal_question_banksoal`),
  KEY `idx_banksoal_packet` (`banksoal_question_packet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal_question`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_question_archive`
--

CREATE TABLE `lmsv2_banksoal_question_archive` (
  `banksoal_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_question_quest` text,
  `banksoal_question_answer` int(11) DEFAULT NULL,
  `banksoal_question_banksoal` int(11) DEFAULT NULL,
  `banksoal_question_order` int(11) DEFAULT NULL,
  `banksoal_question_status` int(11) DEFAULT '1',
  `banksoal_question_packet` varchar(10) DEFAULT NULL,
  `banksoal_question_jabatan` int(11) DEFAULT NULL,
  `banksoal_question_bobot` varchar(100) DEFAULT NULL,
  `banksoal_question_alljabatan` int(11) DEFAULT '0',
  PRIMARY KEY (`banksoal_question_id`),
  KEY `NewIndex1` (`banksoal_question_banksoal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal_question_archive`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_unit`
--

CREATE TABLE `lmsv2_banksoal_unit` (
  `banksoal_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_unit_name` varchar(100) DEFAULT NULL,
  `banksoal_unit_banksoal` int(11) DEFAULT NULL,
  `banksoal_unit_status` int(11) DEFAULT '1',
  PRIMARY KEY (`banksoal_unit_id`),
  UNIQUE KEY `NewIndex1` (`banksoal_unit_name`,`banksoal_unit_banksoal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal_unit`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_unit_setting`
--

CREATE TABLE `lmsv2_banksoal_unit_setting` (
  `banksoal_unit_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `banksoal_unit_setting_unit` int(11) DEFAULT NULL,
  `banksoal_unit_setting_training` int(11) DEFAULT NULL,
  `banksoal_unit_setting_jmlsoal` int(11) DEFAULT NULL,
  `banksoal_unit_setting_mudah` int(11) DEFAULT NULL,
  `banksoal_unit_setting_sedang` int(11) DEFAULT NULL,
  `banksoal_unit_setting_sulit` int(11) DEFAULT NULL,
  PRIMARY KEY (`banksoal_unit_setting_id`),
  UNIQUE KEY `NewIndex1` (`banksoal_unit_setting_unit`,`banksoal_unit_setting_training`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_banksoal_unit_setting`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_catalog_grade`
--

CREATE TABLE `lmsv2_catalog_grade` (
  `catalog_grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_catalog_id` int(11) DEFAULT NULL,
  `catalog_grade_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`catalog_grade_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='1-n, katalog - grade' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_catalog_grade`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_category`
--

CREATE TABLE `lmsv2_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  `category_desc` varchar(255) DEFAULT NULL,
  `category_parent` int(11) DEFAULT '0',
  `category_created` int(11) DEFAULT NULL,
  `category_creator` int(11) DEFAULT NULL,
  `category_status` int(11) DEFAULT '1',
  `category_code` varchar(30) DEFAULT NULL,
  `category_type` int(11) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `NewIndex1` (`category_name`,`category_parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lmsv2_category`
--

INSERT INTO `lmsv2_category` VALUES(1, 'MANDATORY', '', 0, 20141111, 1, 1, NULL, 0);
INSERT INTO `lmsv2_category` VALUES(2, 'Compliance', '', 1, 20141111, 1, 1, NULL, 0);
INSERT INTO `lmsv2_category` VALUES(3, 'APU-PPT', 'Anti Pencucian Uang - Pencegahan Pendanaan Terorisme', 2, 20141111, 1, 1, 'APUPPT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_catjabatan`
--

CREATE TABLE `lmsv2_catjabatan` (
  `catjabatan_id` int(11) NOT NULL AUTO_INCREMENT,
  `catjabatan_name` varchar(100) DEFAULT NULL,
  `catjabatan_parent` int(11) DEFAULT NULL,
  `catjabatan_created` int(11) DEFAULT NULL,
  `catjabatan_creator` int(11) DEFAULT NULL,
  `catjabatan_status` int(11) DEFAULT '0',
  PRIMARY KEY (`catjabatan_id`),
  UNIQUE KEY `NewIndex1` (`catjabatan_name`,`catjabatan_parent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_catjabatan`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_certificate_template`
--

CREATE TABLE `lmsv2_certificate_template` (
  `certificate_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_template_training` int(11) NOT NULL,
  `certificate_template_uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `certificate_template_uploader` int(11) NOT NULL,
  `certificate_template_status` int(11) NOT NULL DEFAULT '1' COMMENT '1=aktif, 2=deleted/tidak aktif',
  PRIMARY KEY (`certificate_template_id`),
  UNIQUE KEY `certificate_template_index` (`certificate_template_training`,`certificate_template_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_certificate_template`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_cron`
--

CREATE TABLE `lmsv2_cron` (
  `cron_id` int(11) NOT NULL AUTO_INCREMENT,
  `cron_action` int(11) NOT NULL COMMENT '1=arsip banksoal,2=restore banksoal',
  `cron_data` text NOT NULL,
  `cron_status` int(11) NOT NULL COMMENT '1=baru;2=processed',
  `cron_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cron_started` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cron_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_cron`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_delegetion`
--

CREATE TABLE `lmsv2_delegetion` (
  `delegetion_id` int(11) NOT NULL AUTO_INCREMENT,
  `delegetion_training` int(11) DEFAULT NULL,
  `delegetion_user` int(11) DEFAULT NULL,
  `delegetion_creator` int(11) DEFAULT NULL,
  `delegetion_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`delegetion_id`),
  UNIQUE KEY `NewIndex1` (`delegetion_training`,`delegetion_user`,`delegetion_creator`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_delegetion`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_delegetion_ildp`
--

CREATE TABLE `lmsv2_delegetion_ildp` (
  `delegetion_ildp_id` int(11) NOT NULL AUTO_INCREMENT,
  `delegetion_ildp_user` int(11) DEFAULT NULL,
  `delegetion_ildp_delegator` int(11) DEFAULT NULL,
  `delegetion_ildp_status` int(11) DEFAULT NULL COMMENT '1=aktif; 2=inaktif',
  `delegetion_ildp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`delegetion_ildp_id`),
  UNIQUE KEY `NewIndex1` (`delegetion_ildp_user`,`delegetion_ildp_delegator`),
  KEY `NewIndex2` (`delegetion_ildp_status`),
  KEY `NewIndex3` (`delegetion_ildp_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_delegetion_ildp`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_function`
--

CREATE TABLE `lmsv2_function` (
  `function_id` int(11) NOT NULL AUTO_INCREMENT,
  `function_desc` varchar(255) DEFAULT NULL,
  `function_jabatan` int(11) DEFAULT NULL,
  `function_status` int(11) DEFAULT NULL,
  `function_created` int(11) DEFAULT NULL,
  `function_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`function_id`),
  UNIQUE KEY `NewIndex1` (`function_desc`,`function_jabatan`),
  KEY `NewIndex2` (`function_creator`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lmsv2_function`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_general_setting`
--

CREATE TABLE `lmsv2_general_setting` (
  `general_setting_code` varchar(100) DEFAULT NULL,
  `general_setting_value` varchar(255) DEFAULT NULL,
  `general_setting_lastupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `general_setting_updatedby` int(11) NOT NULL,
  KEY `general_setting_code` (`general_setting_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_general_setting`
--

INSERT INTO `lmsv2_general_setting` VALUES('multiplelogin', '1', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('remindermailsubject', 'Learning Reminder', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('remindersendername', 'Learning Development', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('remindermailsender', '999999', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('notice_per', '7', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('day_interval', '30', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('smtppass', 'P@ssword', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('smtpuser', 'noreply@smart-tbk.com', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('smtpport', '25', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('smtphost', '10.88.60.8', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('mailcontenttype', 'html', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('showcertificationprint', '1', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('showildp', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('resourcetype', 'a:11:{i:0;s:4:"text";i:1;s:5:"audio";i:2;s:5:"video";i:3;s:11:"application";i:4;s:5:"image";i:5;s:4:".pps";i:6;s:0:"";i:7;s:0:"";i:8;s:0:"";i:9;s:0:"";i:10;s:0:"";}', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('mailtype', 'localhost', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('resourcemaxsize', '1048576', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('certificatesign', 'Head, Organization Learning', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('maxtaken', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('errorlogin', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('changepass1st', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('maxchangepassword', '1', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('passchar', 'free', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('maxpasslen', '12', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('minpasslen', '4', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('expiredpassword', '365', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('inactiveperiod', '10', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('sessiontimeout', '1800', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('recordperpage', '20', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('concurrentuser', '100', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('websitetitle', 'QNB INDONESIA LEARNING PLATFORM', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('defaultlang', 'en', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('changelang', '1', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('showtraininingprint', '1', '2012-04-10 11:01:27', 1);
INSERT INTO `lmsv2_general_setting` VALUES('personalreportmateri', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('showtrainingprint', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('showtrainingminlulus', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('showcertificationminlulus', '0', '2014-11-11 17:16:14', 1);
INSERT INTO `lmsv2_general_setting` VALUES('websitelogo', 'webpoleqnb_new.png', '2014-11-11 17:15:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_grade`
--

CREATE TABLE `lmsv2_grade` (
  `grade_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grade_code` int(11) NOT NULL,
  `grade_description` text,
  PRIMARY KEY (`grade_id`),
  UNIQUE KEY `NewIndex1` (`grade_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_grade`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_history_answer`
--

CREATE TABLE `lmsv2_history_answer` (
  `history_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `history_answer_question` int(11) DEFAULT NULL,
  `history_answer_answer` int(11) DEFAULT NULL,
  `history_answer_history_exam` int(11) DEFAULT NULL,
  `history_answer_order` int(1) DEFAULT NULL,
  PRIMARY KEY (`history_answer_id`),
  KEY `NewIndex1` (`history_answer_question`),
  KEY `NewIndex2` (`history_answer_answer`),
  KEY `NewIndex3` (`history_answer_history_exam`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_history_answer`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_history_exam`
--

CREATE TABLE `lmsv2_history_exam` (
  `history_exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `history_exam_training` int(11) DEFAULT NULL,
  `history_exam_date` int(11) DEFAULT NULL,
  `history_exam_time` int(11) DEFAULT NULL,
  `history_exam_score` float DEFAULT NULL,
  `history_exam_user` int(11) DEFAULT NULL,
  `history_exam_ip` varchar(30) DEFAULT NULL,
  `history_exam_status` int(11) DEFAULT NULL COMMENT '0=gak lulus; 1=lulus',
  `history_exam_minscore` int(11) DEFAULT NULL COMMENT 'score kelulusan',
  `history_exam_type` int(11) DEFAULT NULL COMMENT '1=praexam; 2=exam/certificate',
  `history_exam_startdate` int(11) DEFAULT NULL,
  `history_exam_starttime` int(11) DEFAULT NULL,
  `history_exam_no` int(11) NOT NULL,
  `history_exam_reset` int(11) DEFAULT '0',
  `history_exam_lokasi` int(11) DEFAULT '0',
  `history_exam_isexport` int(11) DEFAULT '0',
  `history_exam_refreshment` int(11) NOT NULL,
  PRIMARY KEY (`history_exam_id`),
  KEY `NewIndex1` (`history_exam_training`),
  KEY `NewIndex2` (`history_exam_user`),
  KEY `NewIndex3` (`history_exam_lokasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_history_exam`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_history_reference`
--

CREATE TABLE `lmsv2_history_reference` (
  `history_reference_id` int(11) NOT NULL AUTO_INCREMENT,
  `history_reference_reference` int(11) DEFAULT NULL,
  `history_reference_user` int(11) DEFAULT NULL,
  `history_reference_date` int(11) DEFAULT NULL,
  `history_reference_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`history_reference_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_history_reference`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_hrld`
--

CREATE TABLE `lmsv2_hrld` (
  `hrld_id` int(11) NOT NULL AUTO_INCREMENT,
  `hrld_npk` int(11) DEFAULT NULL,
  `hrld_category` int(11) DEFAULT NULL,
  `hrld_status` int(11) DEFAULT NULL,
  `hrld_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hrld_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`hrld_id`),
  UNIQUE KEY `NewIndex1` (`hrld_npk`,`hrld_category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_hrld`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_hrrm`
--

CREATE TABLE `lmsv2_hrrm` (
  `hrrm_id` int(11) NOT NULL AUTO_INCREMENT,
  `hrrm_npk` int(11) DEFAULT NULL,
  `hrrm_group` int(11) DEFAULT NULL,
  `hrrm_status` int(11) DEFAULT NULL,
  `hrrm_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hrrm_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`hrrm_id`),
  UNIQUE KEY `NewIndex1` (`hrrm_npk`,`hrrm_group`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_hrrm`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildpsetting`
--

CREATE TABLE `lmsv2_ildpsetting` (
  `ildpsetting_key` varchar(100) DEFAULT NULL,
  `ildpsetting_val` text,
  `ildpsetting_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ildpsetting_lastmodifier` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_ildpsetting`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_catalog`
--

CREATE TABLE `lmsv2_ildp_catalog` (
  `ildp_catalog_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_catalog_course_abb` text NOT NULL,
  `ildp_catalog_category` int(11) DEFAULT NULL,
  `ildp_catalog_training` varchar(100) DEFAULT NULL,
  `ildp_catalog_status` tinyint(4) DEFAULT NULL,
  `ildp_catalog_created_by` int(11) DEFAULT NULL,
  `ildp_catalog_created_time` datetime DEFAULT NULL,
  `ildp_catalog_modified_by` int(11) DEFAULT NULL,
  `ildp_catalog_modified_time` datetime DEFAULT NULL,
  `ildp_catalog_grade` varchar(100) NOT NULL,
  PRIMARY KEY (`ildp_catalog_id`),
  UNIQUE KEY `abb_unique` (`ildp_catalog_course_abb`(6))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_catalog`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_catalog_method`
--

CREATE TABLE `lmsv2_ildp_catalog_method` (
  `ildp_catalog_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_catalog_method_catalog` int(11) NOT NULL,
  `ildp_catalog_method_method` int(11) NOT NULL,
  PRIMARY KEY (`ildp_catalog_method_id`),
  UNIQUE KEY `ildp_catalog_method_unique` (`ildp_catalog_method_catalog`,`ildp_catalog_method_method`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_catalog_method`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_category`
--

CREATE TABLE `lmsv2_ildp_category` (
  `ildp_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_category_name` varchar(100) NOT NULL,
  `ildp_category_parent` int(11) NOT NULL,
  `ildp_category_creator` int(11) NOT NULL,
  `ildp_category_created` timestamp NULL DEFAULT NULL,
  `ildp_category_status` int(11) NOT NULL,
  `ildp_category_modified_by` int(11) DEFAULT NULL,
  `ildp_category_modified_time` timestamp NULL DEFAULT NULL,
  `ildp_category_desc` text,
  `ildp_category_maxline` int(11) NOT NULL,
  `ildp_category_order` int(11) DEFAULT NULL COMMENT 'urutan tampil di front end',
  `ildp_category_areadev_type` int(11) NOT NULL DEFAULT '2' COMMENT '1=free text, 2=dropbox',
  PRIMARY KEY (`ildp_category_id`),
  UNIQUE KEY `ildp_category_unique` (`ildp_category_name`,`ildp_category_parent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_category`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_detail`
--

CREATE TABLE `lmsv2_ildp_detail` (
  `ildp_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_detail_ildp_id` int(11) NOT NULL COMMENT 'fk table ildp_form',
  `ildp_detail_category_id` int(11) DEFAULT NULL COMMENT 'fk training_category',
  `ildp_detail_method_id` int(11) DEFAULT NULL COMMENT 'fk training_method',
  `ildp_detail_budget` int(10) unsigned DEFAULT NULL,
  `ildp_detail_others` text COMMENT 'sasaran others',
  `ildp_detail_created_by` int(11) DEFAULT NULL,
  `ildp_detail_created_time` datetime DEFAULT NULL,
  `ildp_detail_status` int(11) NOT NULL DEFAULT '0',
  `ildp_detail_timeline` varchar(100) NOT NULL,
  `ildp_detail_devarea` text NOT NULL,
  PRIMARY KEY (`ildp_detail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_detail_trail`
--

CREATE TABLE `lmsv2_ildp_detail_trail` (
  `ildp_detail_trail_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_detail_trail_ildp_id` int(11) NOT NULL COMMENT 'fk table ildp_form',
  `ildp_detail_trail_category_id` int(11) DEFAULT NULL COMMENT 'fk training_category',
  `ildp_detail_trail_method_id` int(11) DEFAULT NULL COMMENT 'fk training_method',
  `ildp_detail_trail_budget` int(10) unsigned DEFAULT NULL,
  `ildp_detail_others` text COMMENT 'sasaran others',
  `ildp_detail_trail_created_by` int(11) DEFAULT NULL,
  `ildp_detail_created_time` datetime DEFAULT NULL,
  `ildp_detail_status` int(11) NOT NULL,
  `ildp_detail_timeline` varchar(100) NOT NULL,
  `ildp_detail_devarea` text NOT NULL,
  PRIMARY KEY (`ildp_detail_trail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_detail_trail`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_development_area`
--

CREATE TABLE `lmsv2_ildp_development_area` (
  `dev_area_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dev_area_catalog_id` int(11) NOT NULL COMMENT 'fk to ildp_catalog',
  `dev_area_title` text NOT NULL,
  `dev_area_created` datetime NOT NULL,
  `dev_area_creator` int(11) NOT NULL COMMENT 'fk to table user',
  PRIMARY KEY (`dev_area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_development_area`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_form`
--

CREATE TABLE `lmsv2_ildp_form` (
  `ildp_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_period_start` timestamp NULL DEFAULT NULL,
  `ildp_period_end` timestamp NULL DEFAULT NULL,
  `ildp_user_id` int(11) DEFAULT NULL,
  `ildp_user_npk` varchar(10) DEFAULT NULL,
  `ildp_user_jabatan_id` int(11) DEFAULT NULL,
  `ildp_user_direktorat` int(11) DEFAULT NULL,
  `ildp_user_group` int(11) DEFAULT NULL,
  `ildp_user_dept` int(11) DEFAULT NULL,
  `ildp_user_unit` int(11) DEFAULT NULL,
  `ildp_user_grade_code` varchar(10) DEFAULT NULL,
  `ildp_comments` text COMMENT 'last action comments (approve or reject)',
  `ildp_status` tinyint(4) DEFAULT NULL COMMENT '0=draft,1=submitted, 2=rejected, 3=approved',
  `ildp_approval_id` int(11) DEFAULT NULL COMMENT 'user is eligible npk u/ meng-approve',
  `ildp_created_by` int(11) DEFAULT NULL,
  `ildp_created_time` timestamp NULL DEFAULT NULL,
  `ildp_modified_by` int(11) DEFAULT NULL,
  `ildp_modified_time` timestamp NULL DEFAULT NULL,
  `ildp_approved_by` int(11) DEFAULT NULL,
  `ildp_approved_time` timestamp NULL DEFAULT NULL,
  `ildp_form_ildp_period` int(11) NOT NULL,
  `ildp_form_rejector` int(11) NOT NULL,
  `ildp_form_rejected` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ildp_form_rejected_reason` text NOT NULL,
  `ildp_form_short_term` text,
  `ildp_form_long_term` text,
  PRIMARY KEY (`ildp_id`),
  UNIQUE KEY `ild_form_unique` (`ildp_form_ildp_period`,`ildp_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_form`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_form_trail`
--

CREATE TABLE `lmsv2_ildp_form_trail` (
  `ildp_trail_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_trail_user` int(11) DEFAULT NULL COMMENT 'fk to table user',
  `ildp_trail_ildp_id` int(11) DEFAULT NULL COMMENT 'fk to table ildp form',
  `ildp_trail_status` int(11) DEFAULT NULL COMMENT 'approve/reject/submit',
  `ildp_trail_created_time` datetime DEFAULT NULL,
  `ildp_trail_comments` text,
  PRIMARY KEY (`ildp_trail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_form_trail`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_method`
--

CREATE TABLE `lmsv2_ildp_method` (
  `ildp_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_method_name` varchar(100) NOT NULL,
  `ildp_method_created` timestamp NULL DEFAULT NULL,
  `ildp_method_creator` int(11) NOT NULL,
  `ildp_method_status` int(11) NOT NULL,
  `ildp_method_modified` timestamp NULL DEFAULT NULL,
  `ildp_method_modifier` int(11) DEFAULT NULL,
  PRIMARY KEY (`ildp_method_id`),
  UNIQUE KEY `ildp_method_name` (`ildp_method_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_method`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_registration_period`
--

CREATE TABLE `lmsv2_ildp_registration_period` (
  `ildp_registration_period_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_registration_period_start` timestamp NULL DEFAULT NULL,
  `ildp_registration_period_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ildp_registration_period_creator` int(11) NOT NULL,
  `ildp_registration_period_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ildp_registration_period_modifier` int(11) NOT NULL,
  `ildp_registration_period_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ildp_registration_period_status` int(11) NOT NULL,
  `ildp_registration_period_ildp` int(11) NOT NULL,
  PRIMARY KEY (`ildp_registration_period_id`),
  UNIQUE KEY `ildp_registration_period_unique` (`ildp_registration_period_start`,`ildp_registration_period_end`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_registration_period`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_trail_old`
--

CREATE TABLE `lmsv2_ildp_trail_old` (
  `ildp_trail_id` int(11) NOT NULL AUTO_INCREMENT,
  `ildp_trail_order` int(11) DEFAULT NULL,
  `ildp_trail_user` int(11) DEFAULT NULL,
  `ildp_trail_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ildp_trail_act` varchar(255) DEFAULT NULL,
  `ildp_trail_data` text,
  PRIMARY KEY (`ildp_trail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_ildp_trail_old`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_import`
--

CREATE TABLE `lmsv2_import` (
  `import_id` int(11) NOT NULL AUTO_INCREMENT,
  `import_date` int(11) DEFAULT NULL,
  `import_time` int(11) DEFAULT NULL,
  `import_nrecords` int(11) DEFAULT NULL,
  `import_nactive` int(11) DEFAULT NULL,
  `import_nnoactive` int(11) DEFAULT NULL,
  `import_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`import_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lmsv2_import`
--

INSERT INTO `lmsv2_import` VALUES(1, 20141111, 171108, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_jabatan`
--

CREATE TABLE `lmsv2_jabatan` (
  `jabatan_id` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan_name` varchar(100) DEFAULT NULL,
  `jabatan_status` int(11) DEFAULT NULL,
  `jabatan_created` int(11) DEFAULT NULL,
  `jabatan_creator` int(11) DEFAULT NULL,
  `jabatan_level_group` int(11) DEFAULT NULL,
  `jabatan_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`jabatan_id`),
  UNIQUE KEY `NewIndex1` (`jabatan_name`,`jabatan_level_group`),
  KEY `NewIndex6` (`jabatan_creator`),
  KEY `NewIndex7` (`jabatan_level_group`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lmsv2_jabatan`
--

INSERT INTO `lmsv2_jabatan` VALUES(1, '', 1, 20141111, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_level`
--

CREATE TABLE `lmsv2_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(100) DEFAULT NULL,
  `level_parent` int(11) DEFAULT NULL,
  `level_status` int(11) DEFAULT NULL,
  `level_nth` int(11) DEFAULT NULL,
  `level_description` varchar(255) DEFAULT NULL,
  `level_created` int(11) DEFAULT NULL,
  `level_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`level_id`),
  UNIQUE KEY `NewIndex1` (`level_name`,`level_parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;

--
-- Dumping data for table `lmsv2_level`
--

INSERT INTO `lmsv2_level` VALUES(1001, 'Direktorat', 0, 1, 1, '', 20120125, 1);
INSERT INTO `lmsv2_level` VALUES(2, 'Division', 1001, 1, 2, '', 20120125, 1);
INSERT INTO `lmsv2_level` VALUES(3, 'Sub-Division', 2, 1, 3, '', 20120125, 1);
INSERT INTO `lmsv2_level` VALUES(4, 'Unit', 3, 1, 4, '', 20120125, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_level_group`
--

CREATE TABLE `lmsv2_level_group` (
  `level_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_group_name` varchar(100) DEFAULT NULL,
  `level_group_parent` int(11) DEFAULT NULL,
  `level_group_status` int(11) DEFAULT NULL,
  `level_group_nth` int(11) DEFAULT NULL,
  `level_group_created` int(11) DEFAULT NULL,
  `level_group_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`level_group_id`),
  UNIQUE KEY `NewIndex2` (`level_group_name`,`level_group_parent`),
  KEY `NewIndex1` (`level_group_parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lmsv2_level_group`
--

INSERT INTO `lmsv2_level_group` VALUES(1, 'POSITION 1', 0, 1, 1, 20141111, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_log`
--

CREATE TABLE `lmsv2_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type` varchar(100) DEFAULT NULL,
  `log_user` int(11) DEFAULT NULL COMMENT 'u/ kasus type=reminder, user adalah tujuan reminder ',
  `log_status` int(11) NOT NULL DEFAULT '1' COMMENT 'belum dipakai',
  `log_desc` text,
  `log_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_param1` int(11) DEFAULT NULL COMMENT 'untuk kasus scheduling diisi reminder id',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_logs`
--

CREATE TABLE `lmsv2_logs` (
  `logs_id` int(11) NOT NULL AUTO_INCREMENT,
  `logs_table_name` varchar(50) NOT NULL,
  `logs_container_id` int(11) NOT NULL,
  `logs_action` varchar(10) NOT NULL,
  `logs_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logs_action_by` int(11) NOT NULL,
  `logs_sql_string` text,
  PRIMARY KEY (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=453 ;

--
-- Dumping data for table `lmsv2_logs`
--

INSERT INTO `lmsv2_logs` VALUES(1, 'user', 1, 'update', '2013-03-18 09:39:25', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20130318'', `user_lastlogin_time` = ''93925'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(2, 'user', 1, 'update', '2013-03-18 09:39:42', 1, 'UPDATE `lmsv2_user` SET `user_pass` = ''7c6a180b36896a0a8c02787eeafb0e4c'', `user_lastmodifiedpassword` = ''20130318'' WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(3, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(4, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(5, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''SMART eLearning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(6, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(7, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(8, 'general_setting', 0, 'insert', '2013-03-18 09:40:03', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (''showildp'', ''0'', ''1'', ''2013-03-18 09:40:03'')');
INSERT INTO `lmsv2_logs` VALUES(9, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(10, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(11, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''2'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(12, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(13, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(14, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(15, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(16, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(17, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(18, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(19, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(20, 'general_setting', 0, 'insert', '2013-03-18 09:40:03', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (''personalreportmateri'', ''0'', ''1'', ''2013-03-18 09:40:03'')');
INSERT INTO `lmsv2_logs` VALUES(21, 'general_setting', 0, 'insert', '2013-03-18 09:40:03', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (''showtrainingprint'', ''0'', ''1'', ''2013-03-18 09:40:03'')');
INSERT INTO `lmsv2_logs` VALUES(22, 'general_setting', 0, 'insert', '2013-03-18 09:40:03', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (''showtrainingminlulus'', ''0'', ''1'', ''2013-03-18 09:40:03'')');
INSERT INTO `lmsv2_logs` VALUES(23, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(24, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(25, 'general_setting', 0, 'insert', '2013-03-18 09:40:03', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (''showcertificationminlulus'', ''0'', ''1'', ''2013-03-18 09:40:03'')');
INSERT INTO `lmsv2_logs` VALUES(26, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(27, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(28, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(29, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(30, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(31, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(32, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(33, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''12345'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(34, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(35, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(36, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(37, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(38, 'general_setting', 0, 'update', '2013-03-18 09:40:03', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-03-18 09:40:03'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(39, 'user', 1, 'update', '2013-03-18 09:40:23', 1, 'UPDATE `lmsv2_user` SET `user_pass` = ''5f4dcc3b5aa765d61d8327deb882cf99'', `user_lastmodifiedpassword` = ''20130318'' WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(40, 'user', 1, 'update', '2013-03-20 16:31:33', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20130320'', `user_lastlogin_time` = ''163132'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(41, 'user', 1, 'update', '2013-10-09 19:46:32', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(42, 'user', 1, 'update', '2013-10-09 19:46:35', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20131009'', `user_lastlogin_time` = ''194635'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(43, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(44, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(45, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''SMART eLearning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(46, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(47, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(48, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(49, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(50, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(51, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''2'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(52, 'general_setting', 0, 'update', '2013-10-09 19:46:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:46:59'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(53, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(54, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(55, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(56, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(57, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(58, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(59, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(60, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(61, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(62, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(63, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(64, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(65, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(66, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(67, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(68, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(69, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(70, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(71, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(72, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(73, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''12345'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(74, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(75, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(76, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(77, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(78, 'general_setting', 0, 'update', '2013-10-09 19:47:00', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:00'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(79, 'general_setting', 0, 'insert', '2013-10-09 19:47:00', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (''websitelogo'', ''web-pole.gif'', ''1'', ''2013-10-09 19:47:00'')');
INSERT INTO `lmsv2_logs` VALUES(80, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(81, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(82, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''LKPP eLearning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(83, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(84, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(85, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(86, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(87, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(88, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''2'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(89, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(90, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(91, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(92, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(93, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(94, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(95, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(96, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(97, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(98, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(99, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(100, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(101, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(102, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(103, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(104, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(105, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(106, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(107, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(108, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(109, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(110, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''12345'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(111, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(112, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(113, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(114, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(115, 'general_setting', 0, 'update', '2013-10-09 19:47:15', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2013-10-09 19:47:15'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(116, 'user', 1, 'update', '2014-11-11 10:04:55', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(117, 'user', 1, 'update', '2014-11-11 10:05:15', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(118, 'user', 1, 'update', '2014-11-11 10:05:21', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(119, 'user', 1, 'update', '2014-11-11 10:05:25', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''100525'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(120, 'user', 1, 'update', '2014-11-11 10:05:37', 1, 'UPDATE `lmsv2_user` SET `user_pass` = ''382e0360e4eb7b70034fbaa69bec5786'', `user_lastmodifiedpassword` = ''20141111'' WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(121, 'level', 8, 'delete', '2014-11-11 10:05:42', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415675115'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:55:\\"http://localhost:8888/lmsv2qnb/index.php/level/remove/8\\";s:8:\\"lms_sess\\";s:1010:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"5f4dcc3b5aa765d61d8327deb882cf99\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20131009\\";s:19:\\"user_lastlogin_time\\";s:6:\\"194635\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:18:\\"dedy@localhost.com\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20130318\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''ddd6a76f152c59b3fe26dfdf994f5668''');
INSERT INTO `lmsv2_logs` VALUES(122, 'level', 7, 'delete', '2014-11-11 10:05:44', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415675115'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:55:\\"http://localhost:8888/lmsv2qnb/index.php/level/remove/7\\";s:8:\\"lms_sess\\";s:1010:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"5f4dcc3b5aa765d61d8327deb882cf99\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20131009\\";s:19:\\"user_lastlogin_time\\";s:6:\\"194635\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:18:\\"dedy@localhost.com\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20130318\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''ddd6a76f152c59b3fe26dfdf994f5668''');
INSERT INTO `lmsv2_logs` VALUES(123, 'level', 6, 'delete', '2014-11-11 10:05:46', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415675115'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:55:\\"http://localhost:8888/lmsv2qnb/index.php/level/remove/6\\";s:8:\\"lms_sess\\";s:1010:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"5f4dcc3b5aa765d61d8327deb882cf99\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20131009\\";s:19:\\"user_lastlogin_time\\";s:6:\\"194635\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:18:\\"dedy@localhost.com\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20130318\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''ddd6a76f152c59b3fe26dfdf994f5668''');
INSERT INTO `lmsv2_logs` VALUES(124, 'level', 5, 'delete', '2014-11-11 10:05:48', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415675115'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:55:\\"http://localhost:8888/lmsv2qnb/index.php/level/remove/5\\";s:8:\\"lms_sess\\";s:1010:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"5f4dcc3b5aa765d61d8327deb882cf99\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20131009\\";s:19:\\"user_lastlogin_time\\";s:6:\\"194635\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:18:\\"dedy@localhost.com\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20130318\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''ddd6a76f152c59b3fe26dfdf994f5668''');
INSERT INTO `lmsv2_logs` VALUES(125, 'user', 1, 'update', '2014-11-11 10:06:56', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(126, 'user', 1, 'update', '2014-11-11 10:06:59', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(127, 'user', 1, 'update', '2014-11-11 10:07:08', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''100708'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(128, 'general_setting', 0, 'update', '2014-11-11 10:07:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:29'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(129, 'general_setting', 0, 'update', '2014-11-11 10:07:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:29'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(130, 'general_setting', 0, 'update', '2014-11-11 10:07:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''LKPP eLearning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:29'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(131, 'general_setting', 0, 'update', '2014-11-11 10:07:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:29'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(132, 'general_setting', 0, 'update', '2014-11-11 10:07:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:29'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(133, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(134, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(135, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(136, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(137, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(138, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(139, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(140, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(141, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(142, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(143, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(144, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(145, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(146, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(147, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(148, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(149, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(150, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(151, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(152, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(153, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(154, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(155, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(156, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(157, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(158, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''P@ssword'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(159, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(160, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(161, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''999999'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(162, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(163, 'general_setting', 0, 'update', '2014-11-11 10:07:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:07:30'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(164, 'user', 1, 'update', '2014-11-11 10:07:37', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''100737'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(165, 'user', 1, 'update', '2014-11-11 10:08:07', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''100807'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(166, 'level', 1001, 'update', '2014-11-11 10:08:31', 1, 'UPDATE `lmsv2_level` SET `level_name` = ''Directorate'', `level_description` = '''', `level_status` = 1 WHERE `level_id` = ''1001''');
INSERT INTO `lmsv2_logs` VALUES(167, 'level', 2, 'update', '2014-11-11 10:08:37', 1, 'UPDATE `lmsv2_level` SET `level_name` = ''Group'', `level_description` = '''', `level_status` = 1 WHERE `level_id` = ''2''');
INSERT INTO `lmsv2_logs` VALUES(168, 'level', 4, 'update', '2014-11-11 10:08:45', 1, 'UPDATE `lmsv2_level` SET `level_name` = ''Unit'', `level_description` = '''', `level_status` = 1 WHERE `level_id` = ''4''');
INSERT INTO `lmsv2_logs` VALUES(169, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(170, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(171, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''QNB KESAWAN LEARNING PLATFORM'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(172, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(173, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(174, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(175, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(176, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(177, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(178, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(179, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(180, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(181, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(182, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(183, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(184, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(185, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(186, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(187, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(188, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(189, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(190, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(191, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(192, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(193, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(194, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(195, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(196, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(197, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(198, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(199, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''P@ssword'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(200, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(201, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(202, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''999999'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(203, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(204, 'general_setting', 0, 'update', '2014-11-11 10:17:27', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:27'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(205, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(206, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(207, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''QNB KESAWAN LEARNING PLATFORM'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(208, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(209, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(210, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(211, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(212, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(213, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(214, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(215, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(216, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(217, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(218, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(219, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(220, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(221, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(222, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(223, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(224, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(225, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(226, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(227, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(228, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(229, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(230, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(231, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(232, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(233, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(234, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(235, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''P@ssword'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(236, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(237, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(238, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''999999'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(239, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(240, 'general_setting', 0, 'update', '2014-11-11 10:17:30', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:17:30'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(241, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(242, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(243, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''QNB KESAWAN LEARNING PLATFORM'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(244, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(245, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(246, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(247, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(248, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(249, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(250, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(251, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(252, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(253, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(254, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(255, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(256, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(257, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(258, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(259, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(260, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(261, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(262, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(263, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(264, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(265, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(266, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(267, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(268, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(269, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(270, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(271, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''P@ssword'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(272, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(273, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(274, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''999999'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(275, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(276, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(277, 'general_setting', 0, 'update', '2014-11-11 10:46:05', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitelogo'', `general_setting_value` = ''webpoleqnb.png'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 10:46:05'' WHERE `general_setting_code` = ''websitelogo''');
INSERT INTO `lmsv2_logs` VALUES(278, 'user', 1, 'update', '2014-11-11 10:53:56', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''105356'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(279, 'user', 1, 'update', '2014-11-11 17:06:32', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''170632'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(280, 'category', 1, 'insert', '2014-11-11 17:06:44', 1, 'INSERT INTO `lmsv2_category` (`category_name`, `category_desc`, `category_status`, `category_parent`, `category_type`, `category_created`, `category_creator`) VALUES (''MANDATORY'', '''', ''1'', ''0'', 0, ''20141111'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(281, 'level', 1001, 'update', '2014-11-11 17:06:53', 1, 'UPDATE `lmsv2_level` SET `level_name` = ''Direktorat'', `level_description` = '''', `level_status` = 1 WHERE `level_id` = ''1001''');
INSERT INTO `lmsv2_logs` VALUES(282, 'level', 2, 'update', '2014-11-11 17:07:04', 1, 'UPDATE `lmsv2_level` SET `level_name` = ''Division'', `level_description` = '''', `level_status` = 1 WHERE `level_id` = ''2''');
INSERT INTO `lmsv2_logs` VALUES(283, 'level', 3, 'update', '2014-11-11 17:07:15', 1, 'UPDATE `lmsv2_level` SET `level_name` = ''Sub-Division'', `level_description` = '''', `level_status` = 1 WHERE `level_id` = ''3''');
INSERT INTO `lmsv2_logs` VALUES(284, 'category', 2, 'insert', '2014-11-11 17:07:29', 1, 'INSERT INTO `lmsv2_category` (`category_name`, `category_desc`, `category_status`, `category_parent`, `category_type`, `category_created`, `category_creator`) VALUES (''Compliance'', '''', ''1'', ''1'', 0, ''20141111'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(285, 'category', 3, 'insert', '2014-11-11 17:08:04', 1, 'INSERT INTO `lmsv2_category` (`category_name`, `category_desc`, `category_parent`, `category_code`, `category_status`, `category_type`, `category_created`, `category_creator`) VALUES (''APU-PPT'', ''Anti Pencucian Uang - Pencegahan Pendanaan Terorisme'', ''2'', ''APUPPT'', ''1'', 1, ''20141111'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(286, 'training', 1, 'insert', '2014-11-11 17:08:33', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES ('''', ''3'', ''APU-PPT 1 Pendahuluan'', '''', ''admin'', ''lms'', '''', ''admin@learning.co.id'', 1, ''1'', '''', 0, ''2014-11-11 17:08:33'', ''1'', 1500, ''TRN-000001'', ''1'', ''20141111'', ''1'', 1)');
INSERT INTO `lmsv2_logs` VALUES(287, 'training', 1, 'update', '2014-11-11 17:08:33', 1, 'UPDATE `lmsv2_training` SET `training_material` = ''TRN-000001'', `training_modified` = ''2014-11-11 17:08:33'', `training_modifier` = ''1'' WHERE `training_id` = 1');
INSERT INTO `lmsv2_logs` VALUES(288, 'training', 1, 'update', '2014-11-11 17:08:33', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 1');
INSERT INTO `lmsv2_logs` VALUES(289, 'training_time', 1, 'delete', '2014-11-11 17:08:33', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 1');
INSERT INTO `lmsv2_logs` VALUES(290, 'training_npk', 1, 'delete', '2014-11-11 17:08:41', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415700390'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:65:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveparticipant\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''737b1ab2161644dd869a75b75a834cfe''');
INSERT INTO `lmsv2_logs` VALUES(291, 'training', 1, 'update', '2014-11-11 17:08:41', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = ''1'', `training_modified` = ''2014-11-11 17:08:41'', `training_modifier` = ''1'' WHERE `training_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(292, 'training_npk', 1, 'insert', '2014-11-11 17:08:41', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''1'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(293, 'training', 1, 'update', '2014-11-11 17:09:40', 1, 'UPDATE `lmsv2_training` SET `training_data` = '''', `training_topic` = ''3'', `training_name` = ''APU-PPT 1 Pendahuluan'', `training_desc` = '''', `training_author_firstname` = ''admin'', `training_author_lastname` = ''lms'', `training_author_inital` = '''', `training_author_email` = ''admin@learning.co.id'', `training_status` = 1, `training_material_type` = ''1'', `training_cost` = '''', `training_refreshment` = 0, `training_modified` = ''2014-11-11 17:09:40'', `training_modifier` = ''1'', `training_duration` = 1500 WHERE `training_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(294, 'training', 1, 'update', '2014-11-11 17:09:40', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(295, 'training_time', 1, 'delete', '2014-11-11 17:09:40', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(296, 'training', 2, 'insert', '2014-11-11 17:10:48', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES ('''', ''3'', ''APU-PPT 2 Penerimaan Nasabah'', '''', ''admin'', ''lms'', '''', ''admin@learning.co.id'', 1, ''1'', '''', 0, ''2014-11-11 17:10:48'', ''1'', 2400, ''TRN-000002'', ''1'', ''20141111'', ''1'', 1)');
INSERT INTO `lmsv2_logs` VALUES(297, 'training', 2, 'update', '2014-11-11 17:10:48', 1, 'UPDATE `lmsv2_training` SET `training_material` = ''TRN-000002'', `training_modified` = ''2014-11-11 17:10:48'', `training_modifier` = ''1'' WHERE `training_id` = 2');
INSERT INTO `lmsv2_logs` VALUES(298, 'training', 2, 'update', '2014-11-11 17:10:48', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 2');
INSERT INTO `lmsv2_logs` VALUES(299, 'training_time', 2, 'delete', '2014-11-11 17:10:48', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 2');
INSERT INTO `lmsv2_logs` VALUES(300, 'training_npk', 2, 'delete', '2014-11-11 17:10:53', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415700390'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:65:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveparticipant\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''737b1ab2161644dd869a75b75a834cfe''');
INSERT INTO `lmsv2_logs` VALUES(301, 'training', 2, 'update', '2014-11-11 17:10:53', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = ''1'', `training_modified` = ''2014-11-11 17:10:53'', `training_modifier` = ''1'' WHERE `training_id` = ''2''');
INSERT INTO `lmsv2_logs` VALUES(302, 'training_npk', 2, 'insert', '2014-11-11 17:10:53', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''1'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(303, 'level_group', 1, 'insert', '2014-11-11 17:11:08', 1, 'INSERT INTO `lmsv2_level_group` (`level_group_name`, `level_group_parent`, `level_group_status`, `level_group_nth`, `level_group_created`, `level_group_creator`) VALUES (''POSITION 1'', 0, 1, 1, ''20141111'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(304, 'jabatan', 1, 'insert', '2014-11-11 17:11:08', 1, 'INSERT INTO `lmsv2_jabatan` (`jabatan_name`, `jabatan_status`, `jabatan_created`, `jabatan_creator`, `jabatan_level_group`) VALUES ('''', 1, ''20141111'', ''1'', 1)');
INSERT INTO `lmsv2_logs` VALUES(305, 'user', 71, 'insert', '2014-11-11 17:11:08', 1, 'INSERT INTO `lmsv2_user` (`user_npk`, `user_first_name`, `user_last_name`, `user_join_date`, `user_birthdate`, `user_location`, `user_email`, `user_jabatan`, `user_status`, `user_emp`, `user_import`, `user_pass`, `user_description`, `user_lastlogin_date`, `user_lastlogin_time`, `user_creator`, `user_created_date`, `user_created_time`, `user_function`, `user_forgotpass_confirm`, `user_forgotpass_date`, `user_lastmodifiedpassword`, `user_loginerror`, `user_type`) VALUES (''123'', ''Tester Trainee'', '''', ''19700101'', ''19700101'', 0, ''123'', 1, 1, 1, 1, ''202cb962ac59075b964b07152d234b70'', '''', ''20141111'', ''171108'', ''1'', ''20141111'', ''171108'', 0, '''', 0, 0, 0, ''2'')');
INSERT INTO `lmsv2_logs` VALUES(306, 'training', 3, 'insert', '2014-11-11 17:13:07', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES ('''', ''3'', ''APU-PPT 3 Area Berisiko Tinggi dan PEP'', '''', ''admin'', ''lms'', '''', ''admin@learning.co.id'', 1, ''1'', '''', 0, ''2014-11-11 17:13:07'', ''1'', 1500, ''TRN-000003'', ''1'', ''20141111'', ''1'', 1)');
INSERT INTO `lmsv2_logs` VALUES(307, 'training', 3, 'update', '2014-11-11 17:13:07', 1, 'UPDATE `lmsv2_training` SET `training_material` = ''TRN-000003'', `training_modified` = ''2014-11-11 17:13:07'', `training_modifier` = ''1'' WHERE `training_id` = 3');
INSERT INTO `lmsv2_logs` VALUES(308, 'training', 3, 'update', '2014-11-11 17:13:07', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 3');
INSERT INTO `lmsv2_logs` VALUES(309, 'training_time', 3, 'delete', '2014-11-11 17:13:07', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 3');
INSERT INTO `lmsv2_logs` VALUES(310, 'training_npk', 3, 'delete', '2014-11-11 17:13:28', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415700707'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:65:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveparticipant\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''4cc68fa64e29647ee5ce9e8e1ef92319''');
INSERT INTO `lmsv2_logs` VALUES(311, 'training', 3, 'update', '2014-11-11 17:13:28', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = ''1'', `training_modified` = ''2014-11-11 17:13:28'', `training_modifier` = ''1'' WHERE `training_id` = ''3''');
INSERT INTO `lmsv2_logs` VALUES(312, 'training_npk', 3, 'insert', '2014-11-11 17:13:28', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''1'', ''3'')');
INSERT INTO `lmsv2_logs` VALUES(313, 'training_npk', 4, 'insert', '2014-11-11 17:13:28', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''71'', ''3'')');
INSERT INTO `lmsv2_logs` VALUES(314, 'training', 4, 'insert', '2014-11-11 17:15:29', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES ('''', ''3'', ''APU-PPT 4 Pelaporan dan Perlindungan Hukum'', '''', ''admin'', ''lms'', '''', ''admin@learning.co.id'', 1, ''1'', '''', 0, ''2014-11-11 17:15:29'', ''1'', 1800, ''TRN-000004'', ''1'', ''20141111'', ''1'', 1)');
INSERT INTO `lmsv2_logs` VALUES(315, 'training', 4, 'update', '2014-11-11 17:15:29', 1, 'UPDATE `lmsv2_training` SET `training_material` = ''TRN-000004'', `training_modified` = ''2014-11-11 17:15:29'', `training_modifier` = ''1'' WHERE `training_id` = 4');
INSERT INTO `lmsv2_logs` VALUES(316, 'training', 4, 'update', '2014-11-11 17:15:29', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 4');
INSERT INTO `lmsv2_logs` VALUES(317, 'training_time', 4, 'delete', '2014-11-11 17:15:29', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 4');
INSERT INTO `lmsv2_logs` VALUES(318, 'training_npk', 4, 'delete', '2014-11-11 17:15:34', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415700707'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:65:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveparticipant\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''4cc68fa64e29647ee5ce9e8e1ef92319''');
INSERT INTO `lmsv2_logs` VALUES(319, 'training', 4, 'update', '2014-11-11 17:15:34', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = ''1'', `training_modified` = ''2014-11-11 17:15:34'', `training_modifier` = ''1'' WHERE `training_id` = ''4''');
INSERT INTO `lmsv2_logs` VALUES(320, 'training_npk', 5, 'insert', '2014-11-11 17:15:34', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''1'', ''4'')');
INSERT INTO `lmsv2_logs` VALUES(321, 'training_npk', 6, 'insert', '2014-11-11 17:15:34', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''71'', ''4'')');
INSERT INTO `lmsv2_logs` VALUES(322, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(323, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(324, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''QNB KESAWAN LEARNING PLATFORM'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(325, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(326, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(327, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(328, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(329, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(330, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(331, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(332, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(333, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(334, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(335, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(336, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(337, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(338, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(339, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(340, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(341, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(342, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(343, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(344, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(345, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(346, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(347, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(348, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(349, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(350, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(351, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(352, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''P@ssword'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(353, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(354, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(355, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''999999'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(356, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(357, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(358, 'general_setting', 0, 'update', '2014-11-11 17:15:59', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitelogo'', `general_setting_value` = ''webpoleqnb_new.png'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:15:59'' WHERE `general_setting_code` = ''websitelogo''');
INSERT INTO `lmsv2_logs` VALUES(359, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''defaultlang'', `general_setting_value` = ''en'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''defaultlang''');
INSERT INTO `lmsv2_logs` VALUES(360, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changelang'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''changelang''');
INSERT INTO `lmsv2_logs` VALUES(361, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''websitetitle'', `general_setting_value` = ''QNB INDONESIA LEARNING PLATFORM'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''websitetitle''');
INSERT INTO `lmsv2_logs` VALUES(362, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''concurrentuser'', `general_setting_value` = ''100'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''concurrentuser''');
INSERT INTO `lmsv2_logs` VALUES(363, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''recordperpage'', `general_setting_value` = ''20'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''recordperpage''');
INSERT INTO `lmsv2_logs` VALUES(364, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showildp'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''showildp''');
INSERT INTO `lmsv2_logs` VALUES(365, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''sessiontimeout'', `general_setting_value` = ''1800'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''sessiontimeout''');
INSERT INTO `lmsv2_logs` VALUES(366, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''inactiveperiod'', `general_setting_value` = ''10'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''inactiveperiod''');
INSERT INTO `lmsv2_logs` VALUES(367, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''multiplelogin'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''multiplelogin''');
INSERT INTO `lmsv2_logs` VALUES(368, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''expiredpassword'', `general_setting_value` = ''365'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''expiredpassword''');
INSERT INTO `lmsv2_logs` VALUES(369, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''minpasslen'', `general_setting_value` = ''4'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''minpasslen''');
INSERT INTO `lmsv2_logs` VALUES(370, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxpasslen'', `general_setting_value` = ''12'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''maxpasslen''');
INSERT INTO `lmsv2_logs` VALUES(371, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''passchar'', `general_setting_value` = ''free'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''passchar''');
INSERT INTO `lmsv2_logs` VALUES(372, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxchangepassword'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''maxchangepassword''');
INSERT INTO `lmsv2_logs` VALUES(373, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''changepass1st'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''changepass1st''');
INSERT INTO `lmsv2_logs` VALUES(374, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''errorlogin'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''errorlogin''');
INSERT INTO `lmsv2_logs` VALUES(375, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''maxtaken'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''maxtaken''');
INSERT INTO `lmsv2_logs` VALUES(376, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''personalreportmateri'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''personalreportmateri''');
INSERT INTO `lmsv2_logs` VALUES(377, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingprint'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''showtrainingprint''');
INSERT INTO `lmsv2_logs` VALUES(378, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showtrainingminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''showtrainingminlulus''');
INSERT INTO `lmsv2_logs` VALUES(379, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''certificatesign'', `general_setting_value` = ''Head, Organization Learning'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''certificatesign''');
INSERT INTO `lmsv2_logs` VALUES(380, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationprint'', `general_setting_value` = ''1'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''showcertificationprint''');
INSERT INTO `lmsv2_logs` VALUES(381, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''showcertificationminlulus'', `general_setting_value` = ''0'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''showcertificationminlulus''');
INSERT INTO `lmsv2_logs` VALUES(382, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcemaxsize'', `general_setting_value` = ''1048576'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''resourcemaxsize''');
INSERT INTO `lmsv2_logs` VALUES(383, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''resourcetype'', `general_setting_value` = ''a:11:{i:0;s:4:\\"text\\";i:1;s:5:\\"audio\\";i:2;s:5:\\"video\\";i:3;s:11:\\"application\\";i:4;s:5:\\"image\\";i:5;s:4:\\".pps\\";i:6;s:0:\\"\\";i:7;s:0:\\"\\";i:8;s:0:\\"\\";i:9;s:0:\\"\\";i:10;s:0:\\"\\";}'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''resourcetype''');
INSERT INTO `lmsv2_logs` VALUES(384, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailtype'', `general_setting_value` = ''localhost'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''mailtype''');
INSERT INTO `lmsv2_logs` VALUES(385, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''mailcontenttype'', `general_setting_value` = ''html'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''mailcontenttype''');
INSERT INTO `lmsv2_logs` VALUES(386, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtphost'', `general_setting_value` = ''10.88.60.8'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''smtphost''');
INSERT INTO `lmsv2_logs` VALUES(387, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpport'', `general_setting_value` = ''25'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''smtpport''');
INSERT INTO `lmsv2_logs` VALUES(388, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtpuser'', `general_setting_value` = ''noreply@smart-tbk.com'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''smtpuser''');
INSERT INTO `lmsv2_logs` VALUES(389, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''smtppass'', `general_setting_value` = ''P@ssword'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''smtppass''');
INSERT INTO `lmsv2_logs` VALUES(390, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''day_interval'', `general_setting_value` = ''30'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''day_interval''');
INSERT INTO `lmsv2_logs` VALUES(391, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''notice_per'', `general_setting_value` = ''7'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''notice_per''');
INSERT INTO `lmsv2_logs` VALUES(392, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsender'', `general_setting_value` = ''999999'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''remindermailsender''');
INSERT INTO `lmsv2_logs` VALUES(393, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindersendername'', `general_setting_value` = ''Learning Development'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''remindersendername''');
INSERT INTO `lmsv2_logs` VALUES(394, 'general_setting', 0, 'update', '2014-11-11 17:16:14', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = ''remindermailsubject'', `general_setting_value` = ''Learning Reminder'', `general_setting_updatedby` = ''1'', `general_setting_lastupdated` = ''2014-11-11 17:16:14'' WHERE `general_setting_code` = ''remindermailsubject''');
INSERT INTO `lmsv2_logs` VALUES(395, 'training', 5, 'insert', '2014-11-11 17:18:44', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES ('''', ''3'', ''APU-PPT 5 SDM dan Pelatihan Karyawan'', '''', ''admin'', ''lms'', '''', ''admin@learning.co.id'', 1, ''1'', '''', 0, ''2014-11-11 17:18:44'', ''1'', 1200, ''TRN-000005'', ''1'', ''20141111'', ''1'', 1)');
INSERT INTO `lmsv2_logs` VALUES(396, 'training', 5, 'update', '2014-11-11 17:18:44', 1, 'UPDATE `lmsv2_training` SET `training_material` = ''TRN-000005'', `training_modified` = ''2014-11-11 17:18:44'', `training_modifier` = ''1'' WHERE `training_id` = 5');
INSERT INTO `lmsv2_logs` VALUES(397, 'training', 5, 'update', '2014-11-11 17:18:44', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 5');
INSERT INTO `lmsv2_logs` VALUES(398, 'training_time', 5, 'delete', '2014-11-11 17:18:44', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 5');
INSERT INTO `lmsv2_logs` VALUES(399, 'training_npk', 5, 'delete', '2014-11-11 17:18:50', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:65:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveparticipant\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(400, 'training', 5, 'update', '2014-11-11 17:18:50', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = ''1'', `training_modified` = ''2014-11-11 17:18:50'', `training_modifier` = ''1'' WHERE `training_id` = ''5''');
INSERT INTO `lmsv2_logs` VALUES(401, 'training_npk', 7, 'insert', '2014-11-11 17:18:50', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''1'', ''5'')');
INSERT INTO `lmsv2_logs` VALUES(402, 'training_npk', 8, 'insert', '2014-11-11 17:18:50', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''71'', ''5'')');
INSERT INTO `lmsv2_logs` VALUES(403, 'training', 6, 'insert', '2014-11-11 17:21:35', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES ('''', ''3'', ''APU-PPT 6 Penatausahaan Dokumen dan Pengkinian Data'', '''', ''admin'', ''lms'', '''', ''admin@learning.co.id'', 1, ''1'', '''', 0, ''2014-11-11 17:21:35'', ''1'', 1800, ''TRN-000006'', ''1'', ''20141111'', ''1'', 1)');
INSERT INTO `lmsv2_logs` VALUES(404, 'training', 6, 'update', '2014-11-11 17:21:35', 1, 'UPDATE `lmsv2_training` SET `training_material` = ''TRN-000006'', `training_modified` = ''2014-11-11 17:21:35'', `training_modifier` = ''1'' WHERE `training_id` = 6');
INSERT INTO `lmsv2_logs` VALUES(405, 'training', 6, 'update', '2014-11-11 17:21:35', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 6');
INSERT INTO `lmsv2_logs` VALUES(406, 'training_time', 6, 'delete', '2014-11-11 17:21:35', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = '''' WHERE `training_id` = 6');
INSERT INTO `lmsv2_logs` VALUES(407, 'training_npk', 6, 'delete', '2014-11-11 17:21:41', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:65:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveparticipant\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(408, 'training', 6, 'update', '2014-11-11 17:21:41', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = ''1'', `training_modified` = ''2014-11-11 17:21:41'', `training_modifier` = ''1'' WHERE `training_id` = ''6''');
INSERT INTO `lmsv2_logs` VALUES(409, 'training_npk', 9, 'insert', '2014-11-11 17:21:41', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''1'', ''6'')');
INSERT INTO `lmsv2_logs` VALUES(410, 'training_npk', 10, 'insert', '2014-11-11 17:21:41', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`) VALUES (''71'', ''6'')');
INSERT INTO `lmsv2_logs` VALUES(411, 'training_prequisite', 2, 'delete', '2014-11-11 17:22:20', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(412, 'training_prequisite', 1, 'insert', '2014-11-11 17:22:20', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''2'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(413, 'training_prequisite', 3, 'delete', '2014-11-11 17:22:45', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(414, 'training_prequisite', 2, 'insert', '2014-11-11 17:22:45', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''3'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(415, 'training_prequisite', 3, 'delete', '2014-11-11 17:22:50', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(416, 'training_prequisite', 3, 'insert', '2014-11-11 17:22:50', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''3'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(417, 'training_prequisite', 3, 'delete', '2014-11-11 17:22:57', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(418, 'training_prequisite', 4, 'insert', '2014-11-11 17:22:57', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''3'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(419, 'training_prequisite', 4, 'delete', '2014-11-11 17:23:07', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(420, 'training_prequisite', 5, 'insert', '2014-11-11 17:23:07', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''4'', ''3'')');
INSERT INTO `lmsv2_logs` VALUES(421, 'training_prequisite', 5, 'delete', '2014-11-11 17:23:22', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(422, 'training_prequisite', 6, 'insert', '2014-11-11 17:23:22', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''4'')');
INSERT INTO `lmsv2_logs` VALUES(423, 'training_prequisite', 6, 'delete', '2014-11-11 17:23:36', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701124'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"105356\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''23722dceb50bf36d371ff871eb1152f4''');
INSERT INTO `lmsv2_logs` VALUES(424, 'training_prequisite', 7, 'insert', '2014-11-11 17:23:36', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''6'', ''5'')');
INSERT INTO `lmsv2_logs` VALUES(425, 'user', 1, 'update', '2014-11-11 17:24:03', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''172403'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(426, 'user', 71, 'update', '2014-11-11 17:24:14', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''172414'', `user_loginerror` = 0 WHERE `user_id` = ''71''');
INSERT INTO `lmsv2_logs` VALUES(427, 'user', 1, 'update', '2014-11-11 17:24:42', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''172442'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(428, 'training_prequisite', 6, 'delete', '2014-11-11 17:24:59', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701480'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"172403\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''69c9873b1cb83df348d7f410efddfcec''');
INSERT INTO `lmsv2_logs` VALUES(429, 'training_prequisite', 8, 'insert', '2014-11-11 17:24:59', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''6'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(430, 'training_prequisite', 9, 'insert', '2014-11-11 17:24:59', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''6'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(431, 'training_prequisite', 10, 'insert', '2014-11-11 17:24:59', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''6'', ''3'')');
INSERT INTO `lmsv2_logs` VALUES(432, 'training_prequisite', 11, 'insert', '2014-11-11 17:24:59', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''6'', ''4'')');
INSERT INTO `lmsv2_logs` VALUES(433, 'training_prequisite', 12, 'insert', '2014-11-11 17:24:59', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''6'', ''5'')');
INSERT INTO `lmsv2_logs` VALUES(434, 'user', 71, 'update', '2014-11-11 17:25:07', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''172507'', `user_loginerror` = 0 WHERE `user_id` = ''71''');
INSERT INTO `lmsv2_logs` VALUES(435, 'user', 1, 'update', '2014-11-11 17:25:32', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20141111'', `user_lastlogin_time` = ''172532'', `user_loginerror` = 0 WHERE `user_id` = ''1''');
INSERT INTO `lmsv2_logs` VALUES(436, 'training_prequisite', 3, 'delete', '2014-11-11 17:26:03', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701528'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"172442\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''158047b8127ac017f8f3c2f496a332ea''');
INSERT INTO `lmsv2_logs` VALUES(437, 'training_prequisite', 13, 'insert', '2014-11-11 17:26:03', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''3'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(438, 'training_prequisite', 14, 'insert', '2014-11-11 17:26:03', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''3'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(439, 'training_prequisite', 4, 'delete', '2014-11-11 17:26:22', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701528'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"172442\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''158047b8127ac017f8f3c2f496a332ea''');
INSERT INTO `lmsv2_logs` VALUES(440, 'training_prequisite', 15, 'insert', '2014-11-11 17:26:22', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''4'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(441, 'training_prequisite', 16, 'insert', '2014-11-11 17:26:22', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''4'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(442, 'training_prequisite', 17, 'insert', '2014-11-11 17:26:22', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''4'', ''3'')');
INSERT INTO `lmsv2_logs` VALUES(443, 'training_prequisite', 5, 'delete', '2014-11-11 17:26:33', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701528'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"172442\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''158047b8127ac017f8f3c2f496a332ea''');
INSERT INTO `lmsv2_logs` VALUES(444, 'training_prequisite', 18, 'insert', '2014-11-11 17:26:33', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(445, 'training_prequisite', 19, 'insert', '2014-11-11 17:26:33', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(446, 'training_prequisite', 20, 'insert', '2014-11-11 17:26:33', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''3'')');
INSERT INTO `lmsv2_logs` VALUES(447, 'training_prequisite', 21, 'insert', '2014-11-11 17:26:33', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''4'')');
INSERT INTO `lmsv2_logs` VALUES(448, 'training_prequisite', 5, 'delete', '2014-11-11 17:27:08', 1, 'UPDATE `lmsv2_sessions` SET `last_activity` = ''1415701528'', `user_data` = ''a:2:{s:8:\\"referrer\\";s:68:\\"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre\\";s:8:\\"lms_sess\\";s:1012:\\"a:33:{s:7:\\"user_id\\";s:1:\\"1\\";s:8:\\"user_npk\\";s:6:\\"999999\\";s:9:\\"user_pass\\";s:32:\\"382e0360e4eb7b70034fbaa69bec5786\\";s:15:\\"user_first_name\\";s:5:\\"admin\\";s:14:\\"user_last_name\\";s:3:\\"lms\\";s:14:\\"user_join_date\\";s:8:\\"20100219\\";s:14:\\"user_birthdate\\";s:8:\\"19760104\\";s:16:\\"user_description\\";s:9:\\"developer\\";s:13:\\"user_location\\";s:1:\\"0\\";s:9:\\"user_type\\";s:1:\\"0\\";s:19:\\"user_lastlogin_date\\";s:8:\\"20141111\\";s:19:\\"user_lastlogin_time\\";s:6:\\"172442\\";s:12:\\"user_creator\\";s:1:\\"0\\";s:17:\\"user_created_date\\";s:1:\\"0\\";s:17:\\"user_created_time\\";s:1:\\"0\\";s:10:\\"user_email\\";s:20:\\"admin@learning.co.id\\";s:13:\\"user_function\\";s:1:\\"0\\";s:12:\\"user_jabatan\\";s:1:\\"0\\";s:11:\\"user_status\\";s:1:\\"1\\";s:8:\\"user_emp\\";s:1:\\"0\\";s:23:\\"user_forgotpass_confirm\\";N;s:20:\\"user_forgotpass_date\\";N;s:25:\\"user_lastmodifiedpassword\\";s:8:\\"20141111\\";s:15:\\"user_loginerror\\";s:1:\\"0\\";s:11:\\"user_import\\";N;s:15:\\"user_grade_code\\";N;s:15:\\"user_npk_atasan\\";N;s:8:\\"right_id\\";N;s:10:\\"right_name\\";N;s:13:\\"right_creator\\";N;s:13:\\"right_created\\";N;s:12:\\"right_status\\";N;s:7:\\"asadmin\\";i:1;}\\";}'' WHERE `session_id` = ''158047b8127ac017f8f3c2f496a332ea''');
INSERT INTO `lmsv2_logs` VALUES(449, 'training_prequisite', 22, 'insert', '2014-11-11 17:27:08', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''1'')');
INSERT INTO `lmsv2_logs` VALUES(450, 'training_prequisite', 23, 'insert', '2014-11-11 17:27:08', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''2'')');
INSERT INTO `lmsv2_logs` VALUES(451, 'training_prequisite', 24, 'insert', '2014-11-11 17:27:08', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''3'')');
INSERT INTO `lmsv2_logs` VALUES(452, 'training_prequisite', 25, 'insert', '2014-11-11 17:27:08', 1, 'INSERT INTO `lmsv2_training_prequisite` (`training_prequisite_training`, `training_prequisite_prequisite`) VALUES (''5'', ''4'')');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_lokasi`
--

CREATE TABLE `lmsv2_lokasi` (
  `lokasi_id` int(11) NOT NULL AUTO_INCREMENT,
  `lokasi_kota` varchar(100) DEFAULT NULL,
  `lokasi_alamat` varchar(255) DEFAULT NULL,
  `lokasi_creator` int(11) DEFAULT NULL,
  `lokasi_created` int(11) DEFAULT NULL,
  `lokasi_status` int(11) DEFAULT '1',
  PRIMARY KEY (`lokasi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_lokasi`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_module`
--

CREATE TABLE `lmsv2_module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) DEFAULT NULL,
  `module_desc` varchar(255) DEFAULT NULL,
  `module_status` int(11) DEFAULT '1',
  `module_order` int(11) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `NewIndex1` (`module_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `lmsv2_module`
--

INSERT INTO `lmsv2_module` VALUES(1, 'category', 'Category', 1, 10);
INSERT INTO `lmsv2_module` VALUES(2, 'topic', 'Topic', 1, 20);
INSERT INTO `lmsv2_module` VALUES(3, 'training', 'Training Admin', 1, 30);
INSERT INTO `lmsv2_module` VALUES(4, 'certificate', 'Certificate Admin', 1, 50);
INSERT INTO `lmsv2_module` VALUES(5, 'user', 'User Admin', 1, 60);
INSERT INTO `lmsv2_module` VALUES(6, 'right', 'User Group Right', 1, 70);
INSERT INTO `lmsv2_module` VALUES(7, 'master', 'Settings', 1, 80);
INSERT INTO `lmsv2_module` VALUES(8, 'banksoal_training', 'create banksoal', 0, 0);
INSERT INTO `lmsv2_module` VALUES(9, 'banksoal_certificate', 'create banksoal untuk certificate', 0, 0);
INSERT INTO `lmsv2_module` VALUES(10, 'classroom', 'Classroom', 1, 90);
INSERT INTO `lmsv2_module` VALUES(11, 'resources', 'Elibrary / Ereferences', 1, 100);
INSERT INTO `lmsv2_module` VALUES(12, 'trainee', 'Trainee Access', 1, 110);
INSERT INTO `lmsv2_module` VALUES(13, 'report', 'report privilege', 1, 120);
INSERT INTO `lmsv2_module` VALUES(14, 'ildpadmin', 'ILDP Administrator', 1, 130);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order`
--

CREATE TABLE `lmsv2_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status` int(11) DEFAULT '1' COMMENT '1=baru',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_user` int(11) DEFAULT NULL,
  `order_user_job` int(11) DEFAULT NULL,
  `order_user_grade` varchar(5) DEFAULT NULL,
  `order_group` int(11) DEFAULT NULL,
  `order_location` int(11) DEFAULT NULL,
  `order_hrrm` int(11) DEFAULT NULL,
  `order_hrrm_date` timestamp NULL DEFAULT NULL,
  `order_hrld` int(11) DEFAULT NULL,
  `order_hrld_date` timestamp NULL DEFAULT NULL,
  `order_phone` varchar(32) DEFAULT NULL,
  `order_mobile` varchar(32) DEFAULT NULL,
  `order_rejected` int(11) DEFAULT NULL,
  `order_rejected_date` timestamp NULL DEFAULT NULL,
  `order_rejected_comment` text,
  `order_resetted` int(11) DEFAULT NULL,
  `order_resetted_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_order`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order_catalog`
--

CREATE TABLE `lmsv2_order_catalog` (
  `order_catalog_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_catalog_order` int(11) DEFAULT NULL COMMENT 'FK table order',
  `order_catalog_catalog` int(11) DEFAULT NULL,
  `order_catalog_period` int(11) DEFAULT NULL,
  `order_catalog_status` int(11) DEFAULT '1' COMMENT '1=baru',
  `order_catalog_rejected` int(11) DEFAULT NULL,
  `order_catalog_rejected_date` timestamp NULL DEFAULT NULL,
  `order_catalog_rejected_comment` text,
  `order_catalog_repropose` int(11) DEFAULT '0' COMMENT '1=catalog direpropose',
  PRIMARY KEY (`order_catalog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_order_catalog`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order_catalog_report`
--

CREATE TABLE `lmsv2_order_catalog_report` (
  `order_catalog_report_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_catalog_report_catalog` int(11) DEFAULT NULL,
  `order_catalog_report_user` int(11) DEFAULT NULL,
  `order_catalog_report_order` int(11) DEFAULT NULL,
  `order_catalog_report_status` int(11) DEFAULT '0',
  `order_catalog_report_approved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_catalog_report_approver` int(11) DEFAULT NULL COMMENT 'yang mengapprove',
  PRIMARY KEY (`order_catalog_report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_order_catalog_report`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order_externaldata`
--

CREATE TABLE `lmsv2_order_externaldata` (
  `externaldata_id` int(11) NOT NULL AUTO_INCREMENT,
  `externaldata_order` int(11) DEFAULT NULL,
  `externaldata_title` varchar(255) DEFAULT NULL,
  `externaldata_tag` varchar(255) DEFAULT NULL,
  `externaldata_status` int(11) DEFAULT NULL,
  `externaldata_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `externaldata_creator` int(11) DEFAULT NULL,
  `externaldata_objective` text,
  `externaldata_rejected` timestamp NULL DEFAULT NULL,
  `externaldata_rejector` int(11) DEFAULT NULL,
  `externaldata_reason` text,
  `externaldata_repropose` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`externaldata_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_order_externaldata`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_password_hist`
--

CREATE TABLE `lmsv2_password_hist` (
  `pass_hist_id` int(11) NOT NULL AUTO_INCREMENT,
  `pass_hist_user_id` int(11) NOT NULL,
  `pass_hist_user_npk` varchar(10) NOT NULL,
  `pass_hist_user_pass` varchar(100) NOT NULL,
  `pass_hist_created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pass_hist_id`),
  KEY `past_hist_user_id_index` (`pass_hist_user_id`),
  KEY `hist_order_index` (`pass_hist_user_id`,`pass_hist_created`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lmsv2_password_hist`
--

INSERT INTO `lmsv2_password_hist` VALUES(1, 1, '999999', '5f4dcc3b5aa765d61d8327deb882cf99', '2013-03-18 09:39:36');
INSERT INTO `lmsv2_password_hist` VALUES(2, 1, '999999', '7c6a180b36896a0a8c02787eeafb0e4c', '2013-03-18 09:39:42');
INSERT INTO `lmsv2_password_hist` VALUES(3, 1, '999999', '5f4dcc3b5aa765d61d8327deb882cf99', '2013-03-18 09:40:23');
INSERT INTO `lmsv2_password_hist` VALUES(4, 1, '999999', '382e0360e4eb7b70034fbaa69bec5786', '2014-11-11 10:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference`
--

CREATE TABLE `lmsv2_reference` (
  `reference_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_name` varchar(100) DEFAULT NULL,
  `reference_desc` text,
  `reference_topic` int(11) DEFAULT NULL,
  `reference_created` int(11) DEFAULT NULL,
  `reference_creator` int(11) DEFAULT NULL,
  `reference_filename` varchar(100) DEFAULT NULL,
  `reference_filetype` varchar(100) DEFAULT NULL,
  `reference_filesize` int(11) DEFAULT NULL,
  `reference_filetupname` varchar(100) DEFAULT NULL,
  `reference_status` int(11) DEFAULT '1',
  `reference_allstaff` int(11) DEFAULT NULL,
  PRIMARY KEY (`reference_id`),
  UNIQUE KEY `NewIndex1` (`reference_name`,`reference_topic`),
  KEY `NewIndex2` (`reference_creator`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reference`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_function`
--

CREATE TABLE `lmsv2_reference_function` (
  `reference_function_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_function_reference` int(11) DEFAULT NULL,
  `reference_function_function` int(11) DEFAULT NULL,
  PRIMARY KEY (`reference_function_id`),
  KEY `NewIndex1` (`reference_function_reference`),
  KEY `NewIndex2` (`reference_function_function`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reference_function`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_jabatan`
--

CREATE TABLE `lmsv2_reference_jabatan` (
  `reference_jabatan_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_jabatan_jabatan` int(11) DEFAULT NULL,
  `reference_jabatan_reference` int(11) DEFAULT NULL,
  PRIMARY KEY (`reference_jabatan_id`),
  KEY `NewIndex1` (`reference_jabatan_jabatan`),
  KEY `NewIndex2` (`reference_jabatan_reference`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reference_jabatan`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_levelgroup`
--

CREATE TABLE `lmsv2_reference_levelgroup` (
  `reference_levelgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_levelgroup_reference` int(11) DEFAULT NULL,
  `reference_levelgroup_levelgroup` int(11) DEFAULT NULL,
  PRIMARY KEY (`reference_levelgroup_id`),
  KEY `NewIndex1` (`reference_levelgroup_reference`),
  KEY `NewIndex2` (`reference_levelgroup_levelgroup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reference_levelgroup`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_npk`
--

CREATE TABLE `lmsv2_reference_npk` (
  `reference_npk_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_npk_npk` int(11) DEFAULT NULL,
  `reference_npk_reference` int(11) DEFAULT NULL,
  PRIMARY KEY (`reference_npk_id`),
  KEY `NewIndex1` (`reference_npk_npk`),
  KEY `NewIndex2` (`reference_npk_reference`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reference_npk`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reminder`
--

CREATE TABLE `lmsv2_reminder` (
  `reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `reminder_date` int(11) DEFAULT NULL,
  `reminder_from` varchar(255) DEFAULT NULL,
  `reminder_user` int(11) DEFAULT NULL,
  `reminder_message` text,
  `reminder_training` int(11) DEFAULT NULL,
  PRIMARY KEY (`reminder_id`),
  KEY `NewIndex1` (`reminder_training`),
  KEY `NewIndex2` (`reminder_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reminder`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reminderext`
--

CREATE TABLE `lmsv2_reminderext` (
  `reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `reminder_training_id` int(11) DEFAULT NULL COMMENT 'training, classroom, certificate',
  `reminder_schedule` int(11) DEFAULT NULL COMMENT 'dalam hari',
  `reminder_condition` int(11) DEFAULT NULL COMMENT '-1=all period,0=tidak ada,>0 n hari',
  `reminder_status` int(11) DEFAULT '1' COMMENT '1=aktif',
  `reminder_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reminder_creator` int(11) DEFAULT NULL,
  `reminder_type` varchar(32) DEFAULT NULL,
  `reminder_deadline_date` varchar(100) NOT NULL,
  `reminder_deadline_month` int(11) NOT NULL,
  `reminder_deadline_year` int(11) NOT NULL,
  PRIMARY KEY (`reminder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reminderext`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reminderuser`
--

CREATE TABLE `lmsv2_reminderuser` (
  `reminderuser_id` int(11) NOT NULL AUTO_INCREMENT,
  `reminderuser_user` int(11) DEFAULT NULL,
  `reminderuser_email` varchar(100) DEFAULT NULL,
  `reminderuser_status` int(11) DEFAULT '1' COMMENT '1=aktif',
  `reminderuser_reminder` int(11) DEFAULT NULL,
  PRIMARY KEY (`reminderuser_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_reminderuser`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_right`
--

CREATE TABLE `lmsv2_right` (
  `right_id` int(11) NOT NULL AUTO_INCREMENT,
  `right_name` varchar(100) DEFAULT NULL,
  `right_creator` int(11) DEFAULT NULL,
  `right_created` int(11) DEFAULT NULL,
  `right_status` int(11) DEFAULT '1',
  PRIMARY KEY (`right_id`),
  UNIQUE KEY `NewIndex1` (`right_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `lmsv2_right`
--

INSERT INTO `lmsv2_right` VALUES(2, 'Admin', 1, 20100314, 1);
INSERT INTO `lmsv2_right` VALUES(4, 'All Module', 1, 20100327, 1);
INSERT INTO `lmsv2_right` VALUES(5, 'Training Operator', 1, 20100327, 1);
INSERT INTO `lmsv2_right` VALUES(6, 'Trainee Access', 1, 20100405, 1);
INSERT INTO `lmsv2_right` VALUES(7, 'Trainee', 1, 20100405, 1);
INSERT INTO `lmsv2_right` VALUES(8, 'Certification Operator', 1, 20100411, 1);
INSERT INTO `lmsv2_right` VALUES(9, 'Trainee SMART', 1, 20120105, 1);
INSERT INTO `lmsv2_right` VALUES(10, 'Admin for User', 1, 20120113, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_right_module`
--

CREATE TABLE `lmsv2_right_module` (
  `right_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `right_module_module` int(11) DEFAULT NULL,
  `right_module_right` int(11) DEFAULT NULL,
  PRIMARY KEY (`right_module_id`),
  UNIQUE KEY `NewIndex1` (`right_module_module`,`right_module_right`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

--
-- Dumping data for table `lmsv2_right_module`
--

INSERT INTO `lmsv2_right_module` VALUES(97, 12, 2);
INSERT INTO `lmsv2_right_module` VALUES(96, 11, 2);
INSERT INTO `lmsv2_right_module` VALUES(95, 10, 2);
INSERT INTO `lmsv2_right_module` VALUES(94, 7, 2);
INSERT INTO `lmsv2_right_module` VALUES(93, 6, 2);
INSERT INTO `lmsv2_right_module` VALUES(92, 5, 2);
INSERT INTO `lmsv2_right_module` VALUES(91, 4, 2);
INSERT INTO `lmsv2_right_module` VALUES(90, 3, 2);
INSERT INTO `lmsv2_right_module` VALUES(72, 4, 3);
INSERT INTO `lmsv2_right_module` VALUES(107, 7, 4);
INSERT INTO `lmsv2_right_module` VALUES(106, 6, 4);
INSERT INTO `lmsv2_right_module` VALUES(105, 5, 4);
INSERT INTO `lmsv2_right_module` VALUES(104, 4, 4);
INSERT INTO `lmsv2_right_module` VALUES(103, 3, 4);
INSERT INTO `lmsv2_right_module` VALUES(102, 2, 4);
INSERT INTO `lmsv2_right_module` VALUES(101, 1, 4);
INSERT INTO `lmsv2_right_module` VALUES(55, 12, 6);
INSERT INTO `lmsv2_right_module` VALUES(82, 3, 5);
INSERT INTO `lmsv2_right_module` VALUES(89, 2, 2);
INSERT INTO `lmsv2_right_module` VALUES(88, 1, 2);
INSERT INTO `lmsv2_right_module` VALUES(83, 12, 5);
INSERT INTO `lmsv2_right_module` VALUES(71, 12, 7);
INSERT INTO `lmsv2_right_module` VALUES(85, 2, 8);
INSERT INTO `lmsv2_right_module` VALUES(84, 1, 8);
INSERT INTO `lmsv2_right_module` VALUES(86, 4, 8);
INSERT INTO `lmsv2_right_module` VALUES(87, 12, 8);
INSERT INTO `lmsv2_right_module` VALUES(98, 13, 2);
INSERT INTO `lmsv2_right_module` VALUES(99, 14, 2);
INSERT INTO `lmsv2_right_module` VALUES(100, 12, 9);
INSERT INTO `lmsv2_right_module` VALUES(108, 10, 4);
INSERT INTO `lmsv2_right_module` VALUES(109, 11, 4);
INSERT INTO `lmsv2_right_module` VALUES(110, 12, 4);
INSERT INTO `lmsv2_right_module` VALUES(111, 13, 4);
INSERT INTO `lmsv2_right_module` VALUES(112, 14, 4);
INSERT INTO `lmsv2_right_module` VALUES(126, 11, 10);
INSERT INTO `lmsv2_right_module` VALUES(125, 10, 10);
INSERT INTO `lmsv2_right_module` VALUES(124, 5, 10);
INSERT INTO `lmsv2_right_module` VALUES(123, 4, 10);
INSERT INTO `lmsv2_right_module` VALUES(122, 3, 10);
INSERT INTO `lmsv2_right_module` VALUES(121, 2, 10);
INSERT INTO `lmsv2_right_module` VALUES(120, 1, 10);
INSERT INTO `lmsv2_right_module` VALUES(127, 12, 10);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_sessions`
--

CREATE TABLE `lmsv2_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_sessions`
--

INSERT INTO `lmsv2_sessions` VALUES('158047b8127ac017f8f3c2f496a332ea', '0.0.0.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) App', 1415701528, 'a:2:{s:8:"referrer";s:68:"http://localhost:8888/lmsv2qnb/index.php/training/saveprequisite/pre";s:8:"lms_sess";s:1012:"a:33:{s:7:"user_id";s:1:"1";s:8:"user_npk";s:6:"999999";s:9:"user_pass";s:32:"382e0360e4eb7b70034fbaa69bec5786";s:15:"user_first_name";s:5:"admin";s:14:"user_last_name";s:3:"lms";s:14:"user_join_date";s:8:"20100219";s:14:"user_birthdate";s:8:"19760104";s:16:"user_description";s:9:"developer";s:13:"user_location";s:1:"0";s:9:"user_type";s:1:"0";s:19:"user_lastlogin_date";s:8:"20141111";s:19:"user_lastlogin_time";s:6:"172442";s:12:"user_creator";s:1:"0";s:17:"user_created_date";s:1:"0";s:17:"user_created_time";s:1:"0";s:10:"user_email";s:20:"admin@learning.co.id";s:13:"user_function";s:1:"0";s:12:"user_jabatan";s:1:"0";s:11:"user_status";s:1:"1";s:8:"user_emp";s:1:"0";s:23:"user_forgotpass_confirm";N;s:20:"user_forgotpass_date";N;s:25:"user_lastmodifiedpassword";s:8:"20141111";s:15:"user_loginerror";s:1:"0";s:11:"user_import";N;s:15:"user_grade_code";N;s:15:"user_npk_atasan";N;s:8:"right_id";N;s:10:"right_name";N;s:13:"right_creator";N;s:13:"right_created";N;s:12:"right_status";N;s:7:"asadmin";i:1;}";}');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training`
--

CREATE TABLE `lmsv2_training` (
  `training_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_topic` int(11) DEFAULT NULL,
  `training_name` varchar(100) DEFAULT NULL,
  `training_desc` varchar(255) DEFAULT NULL,
  `training_author_firstname` varchar(100) DEFAULT NULL,
  `training_author_lastname` varchar(100) DEFAULT NULL,
  `training_author_inital` varchar(30) DEFAULT NULL,
  `training_author_email` varchar(100) DEFAULT NULL,
  `training_author_id` int(11) DEFAULT NULL,
  `training_created_date` int(11) DEFAULT NULL,
  `training_creator` int(11) DEFAULT NULL,
  `training_status` int(11) DEFAULT NULL,
  `training_material` varchar(100) DEFAULT NULL,
  `training_all_staff` int(11) DEFAULT '0',
  `training_max` int(11) DEFAULT NULL COMMENT 'maksimum ambil training',
  `training_material_type` int(11) DEFAULT '1',
  `training_type` int(11) DEFAULT '1' COMMENT '1=training;2=certificate',
  `training_pass` float DEFAULT NULL COMMENT 'minimal nilai kelulusan',
  `training_duration` int(11) DEFAULT NULL COMMENT 'lama ujian',
  `training_total_question` int(11) DEFAULT NULL,
  `training_setting_jmlsoal` int(11) NOT NULL,
  `training_setting_bobotmudah` int(11) NOT NULL,
  `training_setting_bobotsedang` int(11) NOT NULL,
  `training_setting_bobotsulit` int(11) NOT NULL,
  `training_durationperquestion` int(11) NOT NULL,
  `training_banksoal` int(11) NOT NULL,
  `training_code` varchar(30) DEFAULT NULL,
  `training_cost` bigint(20) NOT NULL,
  `training_intro` text,
  `training_refreshment` int(11) DEFAULT '0',
  `training_kelompok` text,
  `training_grade` varchar(10) DEFAULT NULL,
  `training_learning_method` text,
  `training_instructor` text,
  `training_organization` text,
  `training_address` text,
  `training_objective` text,
  `training_tag` text,
  `training_catalog_status` int(11) DEFAULT NULL,
  `training_created_time` int(11) DEFAULT NULL,
  `training_modified` timestamp NULL DEFAULT NULL,
  `training_modifier` int(11) DEFAULT NULL,
  `training_cert_tpl` varchar(255) NOT NULL,
  `training_data` text,
  PRIMARY KEY (`training_id`),
  UNIQUE KEY `NewIndex1` (`training_topic`,`training_name`),
  UNIQUE KEY `NewIndex4` (`training_code`,`training_type`),
  KEY `NewIndex2` (`training_author_id`),
  KEY `NewIndex3` (`training_creator`),
  KEY `idx_training_banksoal` (`training_banksoal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `lmsv2_training`
--

INSERT INTO `lmsv2_training` VALUES(1, 3, 'APU-PPT 1 Pendahuluan', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20141111, 1, 1, 'TRN-000001', 1, NULL, 1, 1, NULL, 1500, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000001', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-11 17:09:40', 1, '', '');
INSERT INTO `lmsv2_training` VALUES(2, 3, 'APU-PPT 2 Penerimaan Nasabah', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20141111, 1, 1, 'TRN-000002', 1, NULL, 1, 1, NULL, 2400, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000002', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-11 17:10:53', 1, '', '');
INSERT INTO `lmsv2_training` VALUES(3, 3, 'APU-PPT 3 Area Berisiko Tinggi dan PEP', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20141111, 1, 1, 'TRN-000003', 1, NULL, 1, 1, NULL, 1500, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000003', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-11 17:13:28', 1, '', '');
INSERT INTO `lmsv2_training` VALUES(4, 3, 'APU-PPT 4 Pelaporan dan Perlindungan Hukum', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20141111, 1, 1, 'TRN-000004', 1, NULL, 1, 1, NULL, 1800, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000004', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-11 17:15:34', 1, '', '');
INSERT INTO `lmsv2_training` VALUES(5, 3, 'APU-PPT 5 SDM dan Pelatihan Karyawan', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20141111, 1, 1, 'TRN-000005', 1, NULL, 1, 1, NULL, 1200, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000005', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-11 17:18:50', 1, '', '');
INSERT INTO `lmsv2_training` VALUES(6, 3, 'APU-PPT 6 Penatausahaan Dokumen dan Pengkinian Data', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20141111, 1, 1, 'TRN-000006', 1, NULL, 1, 1, NULL, 1800, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000006', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-11 17:21:41', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_catalog`
--

CREATE TABLE `lmsv2_training_catalog` (
  `catalog_id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_category_id` int(11) DEFAULT NULL,
  `catalog_training_type` varchar(100) DEFAULT NULL,
  `catalog_status` tinyint(4) DEFAULT NULL,
  `catalog_created_by` int(11) DEFAULT NULL,
  `catalog_created_time` datetime DEFAULT NULL,
  `catalog_modified_by` datetime DEFAULT NULL,
  PRIMARY KEY (`catalog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_catalog`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_catjabatan`
--

CREATE TABLE `lmsv2_training_catjabatan` (
  `training_catjabatan_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_catjabatan_training` int(11) DEFAULT NULL,
  `training_catjabatan_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_catjabatan_id`),
  UNIQUE KEY `NewIndex1` (`training_catjabatan_training`,`training_catjabatan_category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_catjabatan`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_exam`
--

CREATE TABLE `lmsv2_training_exam` (
  `training_exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_exam_training` int(11) DEFAULT NULL,
  `training_exam_banksoal` int(11) DEFAULT NULL,
  `training_exam_type` int(11) DEFAULT '1' COMMENT '1=praexam;2=exam',
  `training_exam_max` int(11) DEFAULT NULL,
  `training_exam_pass` float DEFAULT NULL,
  `training_exam_jmlsoal` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_exam_id`),
  KEY `NewIndex1` (`training_exam_training`),
  KEY `NewIndex2` (`training_exam_banksoal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_exam`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_function`
--

CREATE TABLE `lmsv2_training_function` (
  `training_function_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_function_training` int(11) DEFAULT NULL,
  `training_function_function` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_function_id`),
  UNIQUE KEY `NewIndex1` (`training_function_training`,`training_function_function`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lmsv2_training_function`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_jabatan`
--

CREATE TABLE `lmsv2_training_jabatan` (
  `training_jabatan_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_jabatan_training` int(11) DEFAULT NULL,
  `training_jabatan_jabatan` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_jabatan_id`),
  UNIQUE KEY `NewIndex1` (`training_jabatan_training`,`training_jabatan_jabatan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_jabatan`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_levelgroup`
--

CREATE TABLE `lmsv2_training_levelgroup` (
  `training_levelgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_levelgroup_training` int(11) DEFAULT NULL,
  `training_levelgroup_levelgroup` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_levelgroup_id`),
  KEY `NewIndex1` (`training_levelgroup_training`),
  KEY `NewIndex2` (`training_levelgroup_levelgroup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_levelgroup`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_lokasi`
--

CREATE TABLE `lmsv2_training_lokasi` (
  `training_lokasi_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_lokasi_lokasi` int(11) DEFAULT NULL,
  `training_lokasi_training` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_lokasi_id`),
  KEY `NewIndex1` (`training_lokasi_lokasi`),
  KEY `NewIndex2` (`training_lokasi_training`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_lokasi`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_npk`
--

CREATE TABLE `lmsv2_training_npk` (
  `training_npk_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_npk_npk` int(11) DEFAULT NULL,
  `training_npk_training` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_npk_id`),
  KEY `NewIndex1` (`training_npk_training`),
  KEY `NewIndex2` (`training_npk_npk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `lmsv2_training_npk`
--

INSERT INTO `lmsv2_training_npk` VALUES(1, 1, 1);
INSERT INTO `lmsv2_training_npk` VALUES(2, 1, 2);
INSERT INTO `lmsv2_training_npk` VALUES(3, 1, 3);
INSERT INTO `lmsv2_training_npk` VALUES(4, 71, 3);
INSERT INTO `lmsv2_training_npk` VALUES(5, 1, 4);
INSERT INTO `lmsv2_training_npk` VALUES(6, 71, 4);
INSERT INTO `lmsv2_training_npk` VALUES(7, 1, 5);
INSERT INTO `lmsv2_training_npk` VALUES(8, 71, 5);
INSERT INTO `lmsv2_training_npk` VALUES(9, 1, 6);
INSERT INTO `lmsv2_training_npk` VALUES(10, 71, 6);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_postrequisite`
--

CREATE TABLE `lmsv2_training_postrequisite` (
  `training_postrequisite_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_postrequisite_training` int(11) DEFAULT NULL,
  `training_postrequisite_postrequisite` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_postrequisite_id`),
  UNIQUE KEY `NewIndex1` (`training_postrequisite_training`,`training_postrequisite_postrequisite`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_postrequisite`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_prequisite`
--

CREATE TABLE `lmsv2_training_prequisite` (
  `training_prequisite_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_prequisite_training` int(11) DEFAULT NULL,
  `training_prequisite_prequisite` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_prequisite_id`),
  UNIQUE KEY `NewIndex1` (`training_prequisite_training`,`training_prequisite_prequisite`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `lmsv2_training_prequisite`
--

INSERT INTO `lmsv2_training_prequisite` VALUES(1, 2, 1);
INSERT INTO `lmsv2_training_prequisite` VALUES(13, 3, 1);
INSERT INTO `lmsv2_training_prequisite` VALUES(15, 4, 1);
INSERT INTO `lmsv2_training_prequisite` VALUES(25, 5, 4);
INSERT INTO `lmsv2_training_prequisite` VALUES(8, 6, 1);
INSERT INTO `lmsv2_training_prequisite` VALUES(9, 6, 2);
INSERT INTO `lmsv2_training_prequisite` VALUES(10, 6, 3);
INSERT INTO `lmsv2_training_prequisite` VALUES(11, 6, 4);
INSERT INTO `lmsv2_training_prequisite` VALUES(12, 6, 5);
INSERT INTO `lmsv2_training_prequisite` VALUES(14, 3, 2);
INSERT INTO `lmsv2_training_prequisite` VALUES(16, 4, 2);
INSERT INTO `lmsv2_training_prequisite` VALUES(17, 4, 3);
INSERT INTO `lmsv2_training_prequisite` VALUES(24, 5, 3);
INSERT INTO `lmsv2_training_prequisite` VALUES(23, 5, 2);
INSERT INTO `lmsv2_training_prequisite` VALUES(22, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_time`
--

CREATE TABLE `lmsv2_training_time` (
  `training_time_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_time_date1` int(11) DEFAULT NULL,
  `training_time_date2` int(11) DEFAULT NULL,
  `training_time_period` int(11) DEFAULT NULL,
  `training_time_training` int(11) DEFAULT NULL,
  `training_time_parent` int(11) DEFAULT '0',
  `training_time_refreshed` int(11) DEFAULT '0' COMMENT 'apakah sudah direfresh',
  PRIMARY KEY (`training_time_id`),
  KEY `NewIndex1` (`training_time_training`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_time`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_user`
--

CREATE TABLE `lmsv2_training_user` (
  `training_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_user_training` int(11) DEFAULT NULL,
  `training_user_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_user_id`),
  UNIQUE KEY `NewIndex1` (`training_user_training`,`training_user_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_user`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_user`
--

CREATE TABLE `lmsv2_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_npk` varchar(10) DEFAULT NULL,
  `user_pass` varchar(100) DEFAULT NULL COMMENT 'md5',
  `user_first_name` varchar(100) DEFAULT NULL,
  `user_last_name` varchar(100) DEFAULT NULL,
  `user_join_date` int(11) DEFAULT NULL COMMENT 'YYYYMMDD',
  `user_birthdate` int(11) DEFAULT NULL COMMENT 'YYYYMMDD',
  `user_description` text,
  `user_location` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL COMMENT '0=SUPERADMIN;OTHER GROUP',
  `user_lastlogin_date` int(11) DEFAULT NULL COMMENT 'YYYYMMDD',
  `user_lastlogin_time` int(11) DEFAULT NULL COMMENT 'HHMMSS',
  `user_creator` int(11) DEFAULT NULL,
  `user_created_date` int(11) DEFAULT NULL COMMENT 'YYYYMMDD',
  `user_created_time` int(11) DEFAULT NULL COMMENT 'HHMMSS',
  `user_email` varchar(100) DEFAULT NULL,
  `user_function` int(11) DEFAULT NULL,
  `user_jabatan` int(11) DEFAULT NULL,
  `user_status` int(1) DEFAULT NULL COMMENT '1=aktif;2=in aktif',
  `user_emp` int(1) DEFAULT NULL COMMENT '1=staff;2=outsource',
  `user_forgotpass_confirm` varchar(100) DEFAULT NULL,
  `user_forgotpass_date` int(11) DEFAULT NULL,
  `user_lastmodifiedpassword` int(11) NOT NULL,
  `user_loginerror` int(11) NOT NULL,
  `user_import` int(11) DEFAULT NULL,
  `user_grade_code` int(11) DEFAULT NULL,
  `user_npk_atasan` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `NewIndex1` (`user_npk`),
  KEY `NewIndex6` (`user_type`),
  KEY `NewIndex7` (`user_creator`),
  KEY `NewIndex9` (`user_function`),
  KEY `NewIndex10` (`user_jabatan`),
  KEY `NewIndex2` (`user_location`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `lmsv2_user`
--

INSERT INTO `lmsv2_user` VALUES(1, '999999', '382e0360e4eb7b70034fbaa69bec5786', 'admin', 'lms', 20100219, 19760104, 'developer', 0, 0, 20141111, 172532, 0, 0, 0, 'admin@learning.co.id', 0, 0, 1, 0, NULL, NULL, 20141111, 0, NULL, NULL, NULL);
INSERT INTO `lmsv2_user` VALUES(71, '123', '202cb962ac59075b964b07152d234b70', 'Tester Trainee', '', 19700101, 19700101, '', 0, 2, 20141111, 172507, 1, 20141111, 171108, '123', 0, 1, 1, 1, '', 0, 0, 0, 1, NULL, NULL);
