-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 09, 2016 at 05:36 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lms2_fresh`
--

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal`
--

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal_answer` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal_answer_archive` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal_jabatan` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal_question` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal_question_archive` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal_unit` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_banksoal_unit_setting` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_catalog_grade` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_category` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_category`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_catjabatan`
--

CREATE TABLE IF NOT EXISTS `lmsv2_catjabatan` (
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
-- Table structure for table `lmsv2_cms_news`
--

CREATE TABLE IF NOT EXISTS `lmsv2_cms_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(200) NOT NULL,
  `news_desc` text NOT NULL,
  `news_image` varchar(200) NOT NULL,
  `news_entrydate` int(11) NOT NULL,
  `news_entryuser` varchar(100) NOT NULL,
  `news_void` tinyint(4) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_cms_news`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_cron`
--

CREATE TABLE IF NOT EXISTS `lmsv2_cron` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_delegetion` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_delegetion_ildp` (
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
-- Table structure for table `lmsv2_events`
--

CREATE TABLE IF NOT EXISTS `lmsv2_events` (
  `evnt_id` int(11) NOT NULL AUTO_INCREMENT,
  `evnt_title` varchar(200) NOT NULL,
  `evnt_desc` text NOT NULL,
  `evnt_date` date NOT NULL,
  `evnt_entrydate` date NOT NULL,
  `evnt_entryuser` varchar(100) NOT NULL,
  `evnt_void` tinyint(4) NOT NULL,
  PRIMARY KEY (`evnt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_events`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_function`
--

CREATE TABLE IF NOT EXISTS `lmsv2_function` (
  `function_id` int(11) NOT NULL AUTO_INCREMENT,
  `function_desc` varchar(255) DEFAULT NULL,
  `function_jabatan` int(11) DEFAULT NULL,
  `function_status` int(11) DEFAULT NULL,
  `function_created` int(11) DEFAULT NULL,
  `function_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`function_id`),
  UNIQUE KEY `NewIndex1` (`function_desc`,`function_jabatan`),
  KEY `NewIndex2` (`function_creator`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_function`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_general_setting`
--

CREATE TABLE IF NOT EXISTS `lmsv2_general_setting` (
  `general_setting_code` varchar(100) DEFAULT NULL,
  `general_setting_value` varchar(255) DEFAULT NULL,
  `general_setting_lastupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `general_setting_updatedby` int(11) NOT NULL,
  KEY `general_setting_code` (`general_setting_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_general_setting`
--

INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_lastupdated`, `general_setting_updatedby`) VALUES
('multiplelogin', '1', '2016-04-21 16:12:06', 1),
('remindermailsubject', 'Learning Reminder', '2016-04-21 16:12:07', 1),
('remindersendername', 'Learning Development', '2016-04-21 16:12:07', 1),
('remindermailsender', '999999', '2016-04-21 16:12:07', 1),
('notice_per', '7', '2016-04-21 16:12:07', 1),
('day_interval', '30', '2016-04-21 16:12:07', 1),
('smtppass', 'W1ndu2015', '2016-04-21 16:12:07', 1),
('smtpuser', 'elearning', '2016-04-21 16:12:07', 1),
('smtpport', '587', '2016-04-21 16:12:07', 1),
('smtphost', 'mail.bankwindu.com', '2016-04-21 16:12:07', 1),
('mailcontenttype', 'html', '2016-04-21 16:12:07', 1),
('showcertificationprint', '1', '2016-04-21 16:12:07', 1),
('showildp', '0', '2016-04-21 16:12:06', 1),
('resourcetype', 'a:11:{i:0;s:4:"text";i:1;s:5:"audio";i:2;s:5:"video";i:3;s:11:"application";i:4;s:5:"image";i:5;s:4:".pps";i:6;s:0:"";i:7;s:0:"";i:8;s:0:"";i:9;s:0:"";i:10;s:0:"";}', '2016-04-21 16:12:07', 1),
('mailtype', 'localhost', '2016-04-21 16:12:07', 1),
('resourcemaxsize', '1048576', '2016-04-21 16:12:07', 1),
('certificatesign', 'Head, Organization Learning', '2016-04-21 16:12:07', 1),
('maxtaken', '2', '2016-04-21 16:12:07', 1),
('errorlogin', '0', '2016-04-21 16:12:06', 1),
('changepass1st', '1', '2016-04-21 16:12:06', 1),
('maxchangepassword', '1', '2016-04-21 16:12:06', 1),
('passchar', 'free', '2016-04-21 16:12:06', 1),
('maxpasslen', '12', '2016-04-21 16:12:06', 1),
('minpasslen', '4', '2016-04-21 16:12:06', 1),
('expiredpassword', '365', '2016-04-21 16:12:06', 1),
('inactiveperiod', '365', '2016-04-21 16:12:06', 1),
('sessiontimeout', '3600', '2016-04-21 16:12:06', 1),
('recordperpage', '20', '2016-04-21 16:12:06', 1),
('concurrentuser', '100', '2016-04-21 16:12:06', 1),
('websitetitle', 'eLearning NETPOLITANTEAM', '2016-04-21 16:12:06', 1),
('defaultlang', 'en', '2016-04-21 16:12:06', 1),
('changelang', '1', '2016-04-21 16:12:06', 1),
('showtraininingprint', '1', '2012-04-10 11:01:27', 1),
('personalreportmateri', '1', '2016-04-21 16:12:07', 1),
('showtrainingprint', '0', '2016-04-21 16:12:07', 1),
('showtrainingminlulus', '1', '2016-04-21 16:12:07', 1),
('showcertificationminlulus', '0', '2016-04-21 16:12:07', 1),
('websitelogo', 'blank.gif', '2015-10-15 13:32:11', 1),
('reminderschedulefor1', '1445693934', '2015-10-24 20:38:54', 0),
('reminderschedule_counter_for1', '8', '2015-10-24 20:38:54', 0),
('loginbyemail', '0', '2016-04-21 16:12:06', 1),
('cms_activity_periodic', '90', '2016-04-21 16:12:07', 1),
('cms_news_per_page', '3', '2016-04-21 16:12:07', 1),
('cms_show_admin_news', '0', '2016-04-21 16:12:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_grade`
--

CREATE TABLE IF NOT EXISTS `lmsv2_grade` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_history_answer` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_history_exam` (
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
  `history_exam_nonpb` varchar(100) NOT NULL,
  `history_exam_kodeprog` varchar(100) NOT NULL,
  `history_exam_durhari` decimal(5,1) NOT NULL,
  `history_exam_durjam` decimal(5,1) NOT NULL,
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

CREATE TABLE IF NOT EXISTS `lmsv2_history_reference` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_hrld` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_hrrm` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildpsetting` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_catalog` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_catalog_method` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_category` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_detail` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_detail_trail` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_development_area` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_form` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_form_trail` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_method` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_registration_period` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_ildp_trail_old` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_import` (
  `import_id` int(11) NOT NULL AUTO_INCREMENT,
  `import_date` int(11) DEFAULT NULL,
  `import_time` int(11) DEFAULT NULL,
  `import_nrecords` int(11) DEFAULT NULL,
  `import_nactive` int(11) DEFAULT NULL,
  `import_nnoactive` int(11) DEFAULT NULL,
  `import_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`import_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_import`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_jabatan`
--

CREATE TABLE IF NOT EXISTS `lmsv2_jabatan` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_jabatan`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_level`
--

CREATE TABLE IF NOT EXISTS `lmsv2_level` (
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

INSERT INTO `lmsv2_level` (`level_id`, `level_name`, `level_parent`, `level_status`, `level_nth`, `level_description`, `level_created`, `level_creator`) VALUES
(1001, 'Direktorat', 0, 1, 1, '', 20120125, 1),
(2, 'Regional', 1001, 1, 2, '', 20120125, 1),
(3, 'Division', 2, 1, 3, '', 20120125, 1),
(4, 'Unit', 3, 1, 4, '', 20120125, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_level_group`
--

CREATE TABLE IF NOT EXISTS `lmsv2_level_group` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_level_group`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_log`
--

CREATE TABLE IF NOT EXISTS `lmsv2_log` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_logs` (
  `logs_id` int(11) NOT NULL AUTO_INCREMENT,
  `logs_table_name` varchar(50) NOT NULL,
  `logs_container_id` int(11) NOT NULL,
  `logs_action` varchar(10) NOT NULL,
  `logs_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logs_action_by` int(11) NOT NULL,
  `logs_sql_string` text,
  PRIMARY KEY (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lmsv2_logs`
--

INSERT INTO `lmsv2_logs` (`logs_id`, `logs_table_name`, `logs_container_id`, `logs_action`, `logs_timestamp`, `logs_action_by`, `logs_sql_string`) VALUES
(1, 'user', 1, 'update', '2016-09-11 16:08:05', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20160911'', `user_lastlogin_time` = ''160805'', `user_loginerror` = 0 WHERE `user_id` = ''1'''),
(2, 'user', 1, 'update', '2016-09-11 16:29:51', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20160911'', `user_lastlogin_time` = ''162951'', `user_loginerror` = 0 WHERE `user_id` = ''1'''),
(3, 'user', 1, 'update', '2016-10-09 17:35:31', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = ''20161009'', `user_lastlogin_time` = ''173531'', `user_loginerror` = 0 WHERE `user_id` = ''1''');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_lokasi`
--

CREATE TABLE IF NOT EXISTS `lmsv2_lokasi` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_module` (
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

INSERT INTO `lmsv2_module` (`module_id`, `module_name`, `module_desc`, `module_status`, `module_order`) VALUES
(1, 'category', 'Category', 1, 10),
(2, 'topic', 'Topic', 1, 20),
(3, 'training', 'Training Admin', 1, 30),
(4, 'certificate', 'Certificate Admin', 1, 50),
(5, 'user', 'User Admin', 1, 60),
(6, 'right', 'User Group Right', 1, 70),
(7, 'master', 'Settings', 1, 80),
(8, 'banksoal_training', 'create banksoal', 0, 0),
(9, 'banksoal_certificate', 'create banksoal untuk certificate', 0, 0),
(10, 'classroom', 'Classroom', 1, 90),
(11, 'resources', 'Elibrary / Ereferences', 1, 100),
(12, 'trainee', 'Trainee Access', 1, 110),
(13, 'report', 'report privilege', 1, 120),
(14, 'ildpadmin', 'ILDP Administrator', 1, 130);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order`
--

CREATE TABLE IF NOT EXISTS `lmsv2_order` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_order_catalog` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_order_catalog_report` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_order_externaldata` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_password_hist` (
  `phis_id` int(11) NOT NULL AUTO_INCREMENT,
  `pass_hist_user_id` int(11) NOT NULL,
  `pass_hist_user_npk` varchar(10) NOT NULL,
  `pass_hist_user_pass` varchar(100) NOT NULL,
  `pass_hist_created` datetime NOT NULL,
  PRIMARY KEY (`phis_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_password_hist`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference`
--

CREATE TABLE IF NOT EXISTS `lmsv2_reference` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_reference_function` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_reference_jabatan` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_reference_levelgroup` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_reference_npk` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_reminder` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_reminderext` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_reminderuser` (
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
-- Table structure for table `lmsv2_request_bi_category`
--

CREATE TABLE IF NOT EXISTS `lmsv2_request_bi_category` (
  `bict_id` int(11) NOT NULL AUTO_INCREMENT,
  `bict_name` varchar(100) NOT NULL,
  `bict_entryuser` varchar(100) NOT NULL,
  `bict_entrydate` datetime NOT NULL,
  `bict_changeuser` varchar(100) NOT NULL,
  `bict_changedate` datetime NOT NULL,
  PRIMARY KEY (`bict_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_request_bi_category`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_jenis_pendidikan`
--

CREATE TABLE IF NOT EXISTS `lmsv2_request_jenis_pendidikan` (
  `jepd_id` int(11) NOT NULL AUTO_INCREMENT,
  `jepd_name` varchar(100) NOT NULL,
  `jepd_entryuser` varchar(100) NOT NULL,
  `jepd_entrydate` datetime NOT NULL,
  `jepd_changeuser` varchar(100) NOT NULL,
  `jepd_changedate` datetime NOT NULL,
  PRIMARY KEY (`jepd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_request_jenis_pendidikan`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training`
--

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
  `rqtr_biaya_lain` text NOT NULL,
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
  `rqtr_attachment` text NOT NULL,
  `rqtr_jepd_id` int(11) NOT NULL,
  `rqtr_bict_id` int(11) NOT NULL,
  `rqtr_status_admin_approval` tinyint(4) NOT NULL,
  `rqtr_reason_admin_approval` text NOT NULL,
  `rqtr_entryuser` varchar(100) NOT NULL,
  `rqtr_entrytime` datetime NOT NULL,
  `rqtr_updateuser` varchar(100) NOT NULL,
  `rqtr_updatetime` datetime NOT NULL,
  PRIMARY KEY (`rqtr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_request_training`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training_approval`
--

CREATE TABLE IF NOT EXISTS `lmsv2_request_training_approval` (
  `trap_id` int(11) NOT NULL AUTO_INCREMENT,
  `trap_rqtr_id` int(11) NOT NULL,
  `trap_jabatan` varchar(100) DEFAULT NULL,
  `trap_step_order_no` int(11) NOT NULL,
  `trap_user_id` int(11) DEFAULT NULL,
  `trap_status_approval` tinyint(4) NOT NULL,
  `trap_reason_approval` text NOT NULL,
  `trap_entryuser` varchar(200) NOT NULL,
  `trap_entrytime` datetime NOT NULL,
  `trap_updateuser` varchar(200) NOT NULL,
  `trap_updatetime` datetime NOT NULL,
  PRIMARY KEY (`trap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_request_training_approval`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training_default`
--

CREATE TABLE IF NOT EXISTS `lmsv2_request_training_default` (
  `trdf_id` int(11) NOT NULL AUTO_INCREMENT,
  `trdf_jabatan_request` varchar(100) NOT NULL,
  `trdf_jabatan_approval` text NOT NULL,
  `trdf_entryuser` varchar(100) NOT NULL,
  `trdf_entrydate` datetime NOT NULL,
  PRIMARY KEY (`trdf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_request_training_default`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training_setting`
--

CREATE TABLE IF NOT EXISTS `lmsv2_request_training_setting` (
  `trse_id` int(11) NOT NULL AUTO_INCREMENT,
  `trse_rqtr_id` int(11) NOT NULL,
  `trse_user_step_approval` text NOT NULL,
  `trse_user_approval` text NOT NULL,
  `trse_total_user_approval` tinyint(4) NOT NULL,
  `trse_one_approval_status` int(11) NOT NULL,
  `trse_entryuser` varchar(100) NOT NULL,
  `trse_entrytime` datetime NOT NULL,
  `trse_changeuser` varchar(100) NOT NULL,
  `trse_changetime` datetime NOT NULL,
  PRIMARY KEY (`trse_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_request_training_setting`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_right`
--

CREATE TABLE IF NOT EXISTS `lmsv2_right` (
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

INSERT INTO `lmsv2_right` (`right_id`, `right_name`, `right_creator`, `right_created`, `right_status`) VALUES
(2, 'Admin', 1, 20100314, 1),
(4, 'All Module', 1, 20100327, 1),
(5, 'Training Operator', 1, 20100327, 1),
(6, 'Trainee Access', 1, 20100405, 1),
(7, 'Trainee', 1, 20100405, 1),
(8, 'Certification Operator', 1, 20100411, 1),
(9, 'Trainee SMART', 1, 20120105, 1),
(10, 'Admin for User', 1, 20120113, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_right_module`
--

CREATE TABLE IF NOT EXISTS `lmsv2_right_module` (
  `right_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `right_module_module` int(11) DEFAULT NULL,
  `right_module_right` int(11) DEFAULT NULL,
  PRIMARY KEY (`right_module_id`),
  UNIQUE KEY `NewIndex1` (`right_module_module`,`right_module_right`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

--
-- Dumping data for table `lmsv2_right_module`
--

INSERT INTO `lmsv2_right_module` (`right_module_id`, `right_module_module`, `right_module_right`) VALUES
(97, 12, 2),
(96, 11, 2),
(95, 10, 2),
(94, 7, 2),
(93, 6, 2),
(92, 5, 2),
(91, 4, 2),
(90, 3, 2),
(72, 4, 3),
(107, 7, 4),
(106, 6, 4),
(105, 5, 4),
(104, 4, 4),
(103, 3, 4),
(102, 2, 4),
(101, 1, 4),
(55, 12, 6),
(82, 3, 5),
(89, 2, 2),
(88, 1, 2),
(83, 12, 5),
(71, 12, 7),
(85, 2, 8),
(84, 1, 8),
(86, 4, 8),
(87, 12, 8),
(98, 13, 2),
(99, 14, 2),
(100, 12, 9),
(108, 10, 4),
(109, 11, 4),
(110, 12, 4),
(111, 13, 4),
(112, 14, 4),
(126, 11, 10),
(125, 10, 10),
(124, 5, 10),
(123, 4, 10),
(122, 3, 10),
(121, 2, 10),
(120, 1, 10),
(127, 12, 10);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_sessions`
--

CREATE TABLE IF NOT EXISTS `lmsv2_sessions` (
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

INSERT INTO `lmsv2_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('846df48bd3be4d0fcd28d240f6b33076', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/5', 1476005713, 'a:2:{s:8:"referrer";s:39:"http://localhost/NCCLP2/index.php/level";s:8:"lms_sess";s:1135:"a:38:{s:7:"user_id";s:1:"1";s:8:"user_npk";s:6:"999999";s:9:"user_pass";s:32:"382e0360e4eb7b70034fbaa69bec5786";s:15:"user_first_name";s:5:"admin";s:14:"user_last_name";s:3:"lms";s:14:"user_join_date";s:8:"20100219";s:14:"user_birthdate";s:8:"19760104";s:16:"user_description";s:9:"developer";s:13:"user_location";s:1:"0";s:9:"user_type";s:1:"0";s:19:"user_lastlogin_date";s:8:"20160911";s:19:"user_lastlogin_time";s:6:"162951";s:12:"user_creator";s:1:"0";s:17:"user_created_date";s:1:"0";s:17:"user_created_time";s:1:"0";s:10:"user_email";s:20:"admin@learning.co.id";s:13:"user_function";s:1:"0";s:12:"user_jabatan";s:1:"0";s:11:"user_status";s:1:"1";s:8:"user_emp";s:1:"0";s:23:"user_forgotpass_confirm";N;s:20:"user_forgotpass_date";N;s:25:"user_lastmodifiedpassword";s:8:"20141111";s:15:"user_loginerror";s:1:"0";s:11:"user_import";N;s:15:"user_grade_code";N;s:15:"user_npk_atasan";N;s:9:"user_telp";s:0:"";s:7:"user_fb";s:0:"";s:12:"user_twitter";s:0:"";s:14:"user_instagram";s:0:"";s:9:"user_city";s:0:"";s:8:"right_id";N;s:10:"right_name";N;s:13:"right_creator";N;s:13:"right_created";N;s:12:"right_status";N;s:7:"asadmin";i:1;}";}');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training`
--

CREATE TABLE IF NOT EXISTS `lmsv2_training` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_catalog`
--

CREATE TABLE IF NOT EXISTS `lmsv2_training_catalog` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_catjabatan` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_exam` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_function` (
  `training_function_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_function_training` int(11) DEFAULT NULL,
  `training_function_function` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_function_id`),
  UNIQUE KEY `NewIndex1` (`training_function_training`,`training_function_function`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_function`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_jabatan`
--

CREATE TABLE IF NOT EXISTS `lmsv2_training_jabatan` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_levelgroup` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_lokasi` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_npk` (
  `training_npk_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_npk_npk` int(11) DEFAULT NULL,
  `training_npk_training` int(11) DEFAULT NULL,
  `training_npk_time_id` int(11) NOT NULL,
  PRIMARY KEY (`training_npk_id`),
  KEY `NewIndex1` (`training_npk_training`),
  KEY `NewIndex2` (`training_npk_npk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_npk`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_postrequisite`
--

CREATE TABLE IF NOT EXISTS `lmsv2_training_postrequisite` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_prequisite` (
  `training_prequisite_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_prequisite_training` int(11) DEFAULT NULL,
  `training_prequisite_prequisite` int(11) DEFAULT NULL,
  PRIMARY KEY (`training_prequisite_id`),
  UNIQUE KEY `NewIndex1` (`training_prequisite_training`,`training_prequisite_prequisite`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lmsv2_training_prequisite`
--


-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_time`
--

CREATE TABLE IF NOT EXISTS `lmsv2_training_time` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_training_user` (
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

CREATE TABLE IF NOT EXISTS `lmsv2_user` (
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
  `user_telp` varchar(100) NOT NULL,
  `user_fb` varchar(100) NOT NULL,
  `user_twitter` varchar(100) NOT NULL,
  `user_instagram` varchar(100) NOT NULL,
  `user_city` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `NewIndex1` (`user_npk`),
  KEY `NewIndex6` (`user_type`),
  KEY `NewIndex7` (`user_creator`),
  KEY `NewIndex9` (`user_function`),
  KEY `NewIndex10` (`user_jabatan`),
  KEY `NewIndex2` (`user_location`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lmsv2_user`
--

INSERT INTO `lmsv2_user` (`user_id`, `user_npk`, `user_pass`, `user_first_name`, `user_last_name`, `user_join_date`, `user_birthdate`, `user_description`, `user_location`, `user_type`, `user_lastlogin_date`, `user_lastlogin_time`, `user_creator`, `user_created_date`, `user_created_time`, `user_email`, `user_function`, `user_jabatan`, `user_status`, `user_emp`, `user_forgotpass_confirm`, `user_forgotpass_date`, `user_lastmodifiedpassword`, `user_loginerror`, `user_import`, `user_grade_code`, `user_npk_atasan`, `user_telp`, `user_fb`, `user_twitter`, `user_instagram`, `user_city`) VALUES
(1, '999999', '382e0360e4eb7b70034fbaa69bec5786', 'admin', 'lms', 20100219, 19760104, 'developer', 0, 0, 20161009, 173531, 0, 0, 0, 'admin@learning.co.id', 0, 0, 1, 0, NULL, NULL, 20141111, 0, NULL, NULL, NULL, '', '', '', '', '');
