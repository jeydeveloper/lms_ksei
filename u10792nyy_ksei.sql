-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 10, 2018 at 04:26 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u10792nyy_ksei`
--

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal`
--

CREATE TABLE `lmsv2_banksoal` (
  `banksoal_id` int(11) NOT NULL,
  `banksoal_name` varchar(100) DEFAULT NULL,
  `banksoal_created` int(11) DEFAULT NULL,
  `banksoal_creator` int(11) DEFAULT NULL,
  `banksoal_type` int(11) DEFAULT '1' COMMENT '1=exam/preexam, 2=certificate',
  `banksoal_status` int(11) DEFAULT '1' COMMENT '1=aktif,2=inaktif'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_answer`
--

CREATE TABLE `lmsv2_banksoal_answer` (
  `banksoal_answer_id` int(11) NOT NULL,
  `banksoal_answer_text` text,
  `banksoal_answer_question` int(11) DEFAULT NULL,
  `banksoal_answer_order` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_answer_archive`
--

CREATE TABLE `lmsv2_banksoal_answer_archive` (
  `banksoal_answer_id` int(11) NOT NULL,
  `banksoal_answer_text` text,
  `banksoal_answer_question` int(11) DEFAULT NULL,
  `banksoal_answer_order` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_jabatan`
--

CREATE TABLE `lmsv2_banksoal_jabatan` (
  `banksoal_jabatan_id` int(11) NOT NULL,
  `banksoal_jabatan_unit` int(11) DEFAULT NULL,
  `banksoal_jabatan_jabatan` int(11) DEFAULT NULL,
  `banksoal_jabatan_jmlsoal` int(11) DEFAULT NULL,
  `banksoal_jabatan_bobotmudah` int(11) DEFAULT NULL,
  `banksoal_jabatan_bobotsedang` int(11) DEFAULT NULL,
  `banksoal_jabatan_bobotsulit` int(11) DEFAULT NULL,
  `banksoal_jabatan_training` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_question`
--

CREATE TABLE `lmsv2_banksoal_question` (
  `banksoal_question_id` int(11) NOT NULL,
  `banksoal_question_quest` text,
  `banksoal_question_answer` int(11) DEFAULT NULL,
  `banksoal_question_banksoal` int(11) DEFAULT NULL,
  `banksoal_question_order` int(11) DEFAULT NULL,
  `banksoal_question_status` int(11) DEFAULT '1',
  `banksoal_question_packet` varchar(10) DEFAULT NULL,
  `banksoal_question_jabatan` int(11) DEFAULT NULL,
  `banksoal_question_bobot` varchar(100) DEFAULT NULL,
  `banksoal_question_alljabatan` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_question_archive`
--

CREATE TABLE `lmsv2_banksoal_question_archive` (
  `banksoal_question_id` int(11) NOT NULL,
  `banksoal_question_quest` text,
  `banksoal_question_answer` int(11) DEFAULT NULL,
  `banksoal_question_banksoal` int(11) DEFAULT NULL,
  `banksoal_question_order` int(11) DEFAULT NULL,
  `banksoal_question_status` int(11) DEFAULT '1',
  `banksoal_question_packet` varchar(10) DEFAULT NULL,
  `banksoal_question_jabatan` int(11) DEFAULT NULL,
  `banksoal_question_bobot` varchar(100) DEFAULT NULL,
  `banksoal_question_alljabatan` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_unit`
--

CREATE TABLE `lmsv2_banksoal_unit` (
  `banksoal_unit_id` int(11) NOT NULL,
  `banksoal_unit_name` varchar(100) DEFAULT NULL,
  `banksoal_unit_banksoal` int(11) DEFAULT NULL,
  `banksoal_unit_status` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_banksoal_unit_setting`
--

CREATE TABLE `lmsv2_banksoal_unit_setting` (
  `banksoal_unit_setting_id` int(11) NOT NULL,
  `banksoal_unit_setting_unit` int(11) DEFAULT NULL,
  `banksoal_unit_setting_training` int(11) DEFAULT NULL,
  `banksoal_unit_setting_jmlsoal` int(11) DEFAULT NULL,
  `banksoal_unit_setting_mudah` int(11) DEFAULT NULL,
  `banksoal_unit_setting_sedang` int(11) DEFAULT NULL,
  `banksoal_unit_setting_sulit` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_catalog_grade`
--

CREATE TABLE `lmsv2_catalog_grade` (
  `catalog_grade_id` int(11) NOT NULL,
  `catalog_catalog_id` int(11) DEFAULT NULL,
  `catalog_grade_code` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 CHECKSUM=1 COMMENT='1-n, katalog - grade' DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_category`
--

CREATE TABLE `lmsv2_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `category_desc` varchar(255) DEFAULT NULL,
  `category_parent` int(11) DEFAULT '0',
  `category_created` int(11) DEFAULT NULL,
  `category_creator` int(11) DEFAULT NULL,
  `category_status` int(11) DEFAULT '1',
  `category_code` varchar(30) DEFAULT NULL,
  `category_type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_category`
--

INSERT INTO `lmsv2_category` (`category_id`, `category_name`, `category_desc`, `category_parent`, `category_created`, `category_creator`, `category_status`, `category_code`, `category_type`) VALUES
(1, 'KSEi eLearning', '', 0, 20180321, 1, 1, NULL, 0),
(2, 'FAQ', '', 3, 20180321, 1, 1, 'OL0001', 1),
(3, 'External', '', 0, 20180419, 1, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_catjabatan`
--

CREATE TABLE `lmsv2_catjabatan` (
  `catjabatan_id` int(11) NOT NULL,
  `catjabatan_name` varchar(100) DEFAULT NULL,
  `catjabatan_parent` int(11) DEFAULT NULL,
  `catjabatan_created` int(11) DEFAULT NULL,
  `catjabatan_creator` int(11) DEFAULT NULL,
  `catjabatan_status` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_cms_news`
--

CREATE TABLE `lmsv2_cms_news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(200) NOT NULL,
  `news_desc` text NOT NULL,
  `news_image` varchar(200) NOT NULL,
  `news_entrydate` int(11) NOT NULL,
  `news_entryuser` varchar(100) NOT NULL,
  `news_void` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_cron`
--

CREATE TABLE `lmsv2_cron` (
  `cron_id` int(11) NOT NULL,
  `cron_action` int(11) NOT NULL COMMENT '1=arsip banksoal,2=restore banksoal',
  `cron_data` text NOT NULL,
  `cron_status` int(11) NOT NULL COMMENT '1=baru;2=processed',
  `cron_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cron_started` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_delegetion`
--

CREATE TABLE `lmsv2_delegetion` (
  `delegetion_id` int(11) NOT NULL,
  `delegetion_training` int(11) DEFAULT NULL,
  `delegetion_user` int(11) DEFAULT NULL,
  `delegetion_creator` int(11) DEFAULT NULL,
  `delegetion_created` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_delegetion_ildp`
--

CREATE TABLE `lmsv2_delegetion_ildp` (
  `delegetion_ildp_id` int(11) NOT NULL,
  `delegetion_ildp_user` int(11) DEFAULT NULL,
  `delegetion_ildp_delegator` int(11) DEFAULT NULL,
  `delegetion_ildp_status` int(11) DEFAULT NULL COMMENT '1=aktif; 2=inaktif',
  `delegetion_ildp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_events`
--

CREATE TABLE `lmsv2_events` (
  `evnt_id` int(11) NOT NULL,
  `evnt_title` varchar(200) NOT NULL,
  `evnt_desc` text NOT NULL,
  `evnt_date` date NOT NULL,
  `evnt_entrydate` date NOT NULL,
  `evnt_entryuser` varchar(100) NOT NULL,
  `evnt_void` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_function`
--

CREATE TABLE `lmsv2_function` (
  `function_id` int(11) NOT NULL,
  `function_desc` varchar(255) DEFAULT NULL,
  `function_jabatan` int(11) DEFAULT NULL,
  `function_status` int(11) DEFAULT NULL,
  `function_created` int(11) DEFAULT NULL,
  `function_creator` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_general_setting`
--

CREATE TABLE `lmsv2_general_setting` (
  `general_setting_code` varchar(100) DEFAULT NULL,
  `general_setting_value` varchar(255) DEFAULT NULL,
  `general_setting_lastupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `general_setting_updatedby` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_general_setting`
--

INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_lastupdated`, `general_setting_updatedby`) VALUES
('multiplelogin', '1', '2018-04-24 22:17:57', 1),
('remindermailsubject', 'Learning Reminder', '2018-04-24 22:17:57', 1),
('remindersendername', 'Learning Development', '2018-04-24 22:17:57', 1),
('remindermailsender', '999999', '2018-04-24 22:17:57', 1),
('notice_per', '7', '2018-04-24 22:17:57', 1),
('day_interval', '30', '2018-04-24 22:17:57', 1),
('smtppass', 'W1ndu2015', '2016-04-21 16:12:07', 1),
('smtpuser', 'elearning', '2016-04-21 16:12:07', 1),
('smtpport', '587', '2016-04-21 16:12:07', 1),
('smtphost', 'mail.bankwindu.com', '2016-04-21 16:12:07', 1),
('mailcontenttype', 'html', '2016-04-21 16:12:07', 1),
('showcertificationprint', '1', '2018-04-24 22:17:57', 1),
('showildp', '0', '2018-04-24 22:17:57', 1),
('resourcetype', 'a:11:{i:0;s:4:\"text\";i:1;s:5:\"audio\";i:2;s:5:\"video\";i:3;s:11:\"application\";i:4;s:5:\"image\";i:5;s:4:\".pps\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";}', '2018-04-24 22:17:57', 1),
('mailtype', 'localhost', '2016-04-21 16:12:07', 1),
('resourcemaxsize', '1048576', '2018-04-24 22:17:57', 1),
('certificatesign', 'Head, Organization Learning', '2018-04-24 22:17:57', 1),
('maxtaken', '2', '2018-04-24 22:17:57', 1),
('errorlogin', '0', '2018-04-24 22:17:57', 1),
('changepass1st', '1', '2018-04-24 22:17:57', 1),
('maxchangepassword', '1', '2018-04-24 22:17:57', 1),
('passchar', 'free', '2018-04-24 22:17:57', 1),
('maxpasslen', '12', '2018-04-24 22:17:57', 1),
('minpasslen', '4', '2018-04-24 22:17:57', 1),
('expiredpassword', '365', '2018-04-24 22:17:57', 1),
('inactiveperiod', '365', '2018-04-24 22:17:57', 1),
('sessiontimeout', '3600', '2018-04-24 22:17:57', 1),
('recordperpage', '20', '2018-04-24 22:17:57', 1),
('concurrentuser', '100', '2018-04-24 22:17:57', 1),
('websitetitle', '', '2018-04-24 22:17:57', 1),
('defaultlang', 'id', '2018-04-24 22:17:57', 1),
('changelang', '1', '2018-04-24 22:17:57', 1),
('showtraininingprint', '1', '2012-04-10 11:01:27', 1),
('personalreportmateri', '1', '2018-04-24 22:17:57', 1),
('showtrainingprint', '0', '2018-04-24 22:17:57', 1),
('showtrainingminlulus', '1', '2018-04-24 22:17:57', 1),
('showcertificationminlulus', '0', '2018-04-24 22:17:57', 1),
('websitelogo', 'logo@4x.png', '2018-03-09 10:44:54', 1),
('reminderschedulefor1', '1445693934', '2015-10-24 20:38:54', 0),
('reminderschedule_counter_for1', '8', '2015-10-24 20:38:54', 0),
('loginbyemail', '0', '2018-04-24 22:17:57', 1),
('cms_activity_periodic', '90', '2018-04-24 22:17:57', 1),
('cms_news_per_page', '3', '2018-04-24 22:17:57', 1),
('cms_show_admin_news', '0', '2018-04-24 22:17:57', 1),
('showtrainingquestionall', '0', '2018-04-24 22:17:57', 1),
('totallooptraining', '', '2018-04-24 22:17:57', 1),
('typelooptraining', '0', '2018-04-24 22:17:57', 1),
('showcertificationquestionall', '0', '2018-04-24 22:17:57', 1),
('totalloopcertification', '', '2018-04-24 22:17:57', 1),
('typeloopcertification', '0', '2018-04-24 22:17:57', 1),
('show_running_text_approval', '0', '2018-04-24 22:17:57', 1),
('notif_email_approval', '0', '2018-04-24 22:17:57', 1),
('notif_email_sender', '', '2018-04-24 22:17:57', 1),
('notif_email_name', '', '2018-04-24 22:17:57', 1),
('notif_email_subject', '', '2018-04-24 22:17:57', 1),
('notif_email_body', '', '2018-04-24 22:17:57', 1),
('show_learning_catalog', '0', '2018-04-24 22:17:57', 1),
('questionaire_anonim_user', '0', '2018-04-24 22:17:57', 1),
('submit', '', '2018-04-24 22:17:57', 1),
('user_minimal_approval_request_training', '0', '2018-04-24 22:17:57', 1),
('total_step_approval', '1', '2018-04-24 22:17:57', 1),
('websiteloginword1', '', '2018-04-24 22:17:57', 1),
('websiteloginword2', '', '2018-04-24 22:17:57', 1),
('showtrainingcounterpraexammateri', '0', '2018-04-24 22:17:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_grade`
--

CREATE TABLE `lmsv2_grade` (
  `grade_id` int(10) UNSIGNED NOT NULL,
  `grade_code` int(11) NOT NULL,
  `grade_description` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_history_answer`
--

CREATE TABLE `lmsv2_history_answer` (
  `history_answer_id` int(11) NOT NULL,
  `history_answer_question` int(11) DEFAULT NULL,
  `history_answer_answer` int(11) DEFAULT NULL,
  `history_answer_history_exam` int(11) DEFAULT NULL,
  `history_answer_order` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_history_exam`
--

CREATE TABLE `lmsv2_history_exam` (
  `history_exam_id` int(11) NOT NULL,
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
  `history_exam_durjam` decimal(5,1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_history_exam`
--

INSERT INTO `lmsv2_history_exam` (`history_exam_id`, `history_exam_training`, `history_exam_date`, `history_exam_time`, `history_exam_score`, `history_exam_user`, `history_exam_ip`, `history_exam_status`, `history_exam_minscore`, `history_exam_type`, `history_exam_startdate`, `history_exam_starttime`, `history_exam_no`, `history_exam_reset`, `history_exam_lokasi`, `history_exam_isexport`, `history_exam_refreshment`, `history_exam_nonpb`, `history_exam_kodeprog`, `history_exam_durhari`, `history_exam_durjam`) VALUES
(1, 1, 20180321, 63658, 0, 1, '103.47.135.166', 0, 0, 0, 20180321, 63658, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(2, 1, 20180321, 63706, 0, 1, '103.47.135.166', 0, 0, 0, 20180321, 63706, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(3, 1, 20180321, 63745, 0, 1, '103.47.135.166', 0, 0, 0, 20180321, 63745, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(4, 1, 20180813, 91410, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91410, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(5, 1, 20180813, 91412, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91412, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(6, 1, 20180813, 91413, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91413, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(7, 1, 20180813, 91415, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91415, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(8, 1, 20180813, 91416, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91416, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(9, 1, 20180813, 91416, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91416, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(10, 1, 20180813, 91417, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91417, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(11, 1, 20180813, 91417, 0, 1, '103.47.135.142', 0, 0, 0, 20180813, 91417, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(12, 1, 20180816, 94742, 0, 1, '103.47.135.142', 0, 0, 0, 20180816, 94742, 0, 0, 0, 0, 0, '', '', '0.0', '0.0'),
(13, 1, 20180816, 94757, 0, 1, '103.47.135.142', 0, 0, 0, 20180816, 94757, 0, 0, 0, 0, 0, '', '', '0.0', '0.0');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_history_reference`
--

CREATE TABLE `lmsv2_history_reference` (
  `history_reference_id` int(11) NOT NULL,
  `history_reference_reference` int(11) DEFAULT NULL,
  `history_reference_user` int(11) DEFAULT NULL,
  `history_reference_date` int(11) DEFAULT NULL,
  `history_reference_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_hrld`
--

CREATE TABLE `lmsv2_hrld` (
  `hrld_id` int(11) NOT NULL,
  `hrld_npk` int(11) DEFAULT NULL,
  `hrld_category` int(11) DEFAULT NULL,
  `hrld_status` int(11) DEFAULT NULL,
  `hrld_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hrld_creator` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_hrrm`
--

CREATE TABLE `lmsv2_hrrm` (
  `hrrm_id` int(11) NOT NULL,
  `hrrm_npk` int(11) DEFAULT NULL,
  `hrrm_group` int(11) DEFAULT NULL,
  `hrrm_status` int(11) DEFAULT NULL,
  `hrrm_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hrrm_creator` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_catalog`
--

CREATE TABLE `lmsv2_ildp_catalog` (
  `ildp_catalog_id` int(11) NOT NULL,
  `ildp_catalog_course_abb` text NOT NULL,
  `ildp_catalog_category` int(11) DEFAULT NULL,
  `ildp_catalog_training` varchar(100) DEFAULT NULL,
  `ildp_catalog_status` tinyint(4) DEFAULT NULL,
  `ildp_catalog_created_by` int(11) DEFAULT NULL,
  `ildp_catalog_created_time` datetime DEFAULT NULL,
  `ildp_catalog_modified_by` int(11) DEFAULT NULL,
  `ildp_catalog_modified_time` datetime DEFAULT NULL,
  `ildp_catalog_grade` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_catalog_method`
--

CREATE TABLE `lmsv2_ildp_catalog_method` (
  `ildp_catalog_method_id` int(11) NOT NULL,
  `ildp_catalog_method_catalog` int(11) NOT NULL,
  `ildp_catalog_method_method` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_category`
--

CREATE TABLE `lmsv2_ildp_category` (
  `ildp_category_id` int(11) NOT NULL,
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
  `ildp_category_areadev_type` int(11) NOT NULL DEFAULT '2' COMMENT '1=free text, 2=dropbox'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_detail`
--

CREATE TABLE `lmsv2_ildp_detail` (
  `ildp_detail_id` int(11) NOT NULL,
  `ildp_detail_ildp_id` int(11) NOT NULL COMMENT 'fk table ildp_form',
  `ildp_detail_category_id` int(11) DEFAULT NULL COMMENT 'fk training_category',
  `ildp_detail_method_id` int(11) DEFAULT NULL COMMENT 'fk training_method',
  `ildp_detail_budget` int(10) UNSIGNED DEFAULT NULL,
  `ildp_detail_others` text COMMENT 'sasaran others',
  `ildp_detail_created_by` int(11) DEFAULT NULL,
  `ildp_detail_created_time` datetime DEFAULT NULL,
  `ildp_detail_status` int(11) NOT NULL DEFAULT '0',
  `ildp_detail_timeline` varchar(100) NOT NULL,
  `ildp_detail_devarea` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_detail_trail`
--

CREATE TABLE `lmsv2_ildp_detail_trail` (
  `ildp_detail_trail_id` int(11) NOT NULL,
  `ildp_detail_trail_ildp_id` int(11) NOT NULL COMMENT 'fk table ildp_form',
  `ildp_detail_trail_category_id` int(11) DEFAULT NULL COMMENT 'fk training_category',
  `ildp_detail_trail_method_id` int(11) DEFAULT NULL COMMENT 'fk training_method',
  `ildp_detail_trail_budget` int(10) UNSIGNED DEFAULT NULL,
  `ildp_detail_others` text COMMENT 'sasaran others',
  `ildp_detail_trail_created_by` int(11) DEFAULT NULL,
  `ildp_detail_created_time` datetime DEFAULT NULL,
  `ildp_detail_status` int(11) NOT NULL,
  `ildp_detail_timeline` varchar(100) NOT NULL,
  `ildp_detail_devarea` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_development_area`
--

CREATE TABLE `lmsv2_ildp_development_area` (
  `dev_area_id` int(10) UNSIGNED NOT NULL,
  `dev_area_catalog_id` int(11) NOT NULL COMMENT 'fk to ildp_catalog',
  `dev_area_title` text NOT NULL,
  `dev_area_created` datetime NOT NULL,
  `dev_area_creator` int(11) NOT NULL COMMENT 'fk to table user'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_form`
--

CREATE TABLE `lmsv2_ildp_form` (
  `ildp_id` int(11) NOT NULL,
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
  `ildp_form_long_term` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_form_trail`
--

CREATE TABLE `lmsv2_ildp_form_trail` (
  `ildp_trail_id` int(11) NOT NULL,
  `ildp_trail_user` int(11) DEFAULT NULL COMMENT 'fk to table user',
  `ildp_trail_ildp_id` int(11) DEFAULT NULL COMMENT 'fk to table ildp form',
  `ildp_trail_status` int(11) DEFAULT NULL COMMENT 'approve/reject/submit',
  `ildp_trail_created_time` datetime DEFAULT NULL,
  `ildp_trail_comments` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_method`
--

CREATE TABLE `lmsv2_ildp_method` (
  `ildp_method_id` int(11) NOT NULL,
  `ildp_method_name` varchar(100) NOT NULL,
  `ildp_method_created` timestamp NULL DEFAULT NULL,
  `ildp_method_creator` int(11) NOT NULL,
  `ildp_method_status` int(11) NOT NULL,
  `ildp_method_modified` timestamp NULL DEFAULT NULL,
  `ildp_method_modifier` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_registration_period`
--

CREATE TABLE `lmsv2_ildp_registration_period` (
  `ildp_registration_period_id` int(11) NOT NULL,
  `ildp_registration_period_start` timestamp NULL DEFAULT NULL,
  `ildp_registration_period_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ildp_registration_period_creator` int(11) NOT NULL,
  `ildp_registration_period_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ildp_registration_period_modifier` int(11) NOT NULL,
  `ildp_registration_period_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ildp_registration_period_status` int(11) NOT NULL,
  `ildp_registration_period_ildp` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_ildp_trail_old`
--

CREATE TABLE `lmsv2_ildp_trail_old` (
  `ildp_trail_id` int(11) NOT NULL,
  `ildp_trail_order` int(11) DEFAULT NULL,
  `ildp_trail_user` int(11) DEFAULT NULL,
  `ildp_trail_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ildp_trail_act` varchar(255) DEFAULT NULL,
  `ildp_trail_data` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_import`
--

CREATE TABLE `lmsv2_import` (
  `import_id` int(11) NOT NULL,
  `import_date` int(11) DEFAULT NULL,
  `import_time` int(11) DEFAULT NULL,
  `import_nrecords` int(11) DEFAULT NULL,
  `import_nactive` int(11) DEFAULT NULL,
  `import_nnoactive` int(11) DEFAULT NULL,
  `import_creator` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_jabatan`
--

CREATE TABLE `lmsv2_jabatan` (
  `jabatan_id` int(11) NOT NULL,
  `jabatan_name` varchar(100) DEFAULT NULL,
  `jabatan_status` int(11) DEFAULT NULL,
  `jabatan_created` int(11) DEFAULT NULL,
  `jabatan_creator` int(11) DEFAULT NULL,
  `jabatan_level_group` int(11) DEFAULT NULL,
  `jabatan_category` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_level`
--

CREATE TABLE `lmsv2_level` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  `level_parent` int(11) DEFAULT NULL,
  `level_status` int(11) DEFAULT NULL,
  `level_nth` int(11) DEFAULT NULL,
  `level_description` varchar(255) DEFAULT NULL,
  `level_created` int(11) DEFAULT NULL,
  `level_creator` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `lmsv2_level_group` (
  `level_group_id` int(11) NOT NULL,
  `level_group_name` varchar(100) DEFAULT NULL,
  `level_group_parent` int(11) DEFAULT NULL,
  `level_group_status` int(11) DEFAULT NULL,
  `level_group_nth` int(11) DEFAULT NULL,
  `level_group_created` int(11) DEFAULT NULL,
  `level_group_creator` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_log`
--

CREATE TABLE `lmsv2_log` (
  `log_id` int(11) NOT NULL,
  `log_type` varchar(100) DEFAULT NULL,
  `log_user` int(11) DEFAULT NULL COMMENT 'u/ kasus type=reminder, user adalah tujuan reminder ',
  `log_status` int(11) NOT NULL DEFAULT '1' COMMENT 'belum dipakai',
  `log_desc` text,
  `log_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_param1` int(11) DEFAULT NULL COMMENT 'untuk kasus scheduling diisi reminder id'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_logs`
--

CREATE TABLE `lmsv2_logs` (
  `logs_id` int(11) NOT NULL,
  `logs_table_name` varchar(50) NOT NULL,
  `logs_container_id` int(11) NOT NULL,
  `logs_action` varchar(10) NOT NULL,
  `logs_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logs_action_by` int(11) NOT NULL,
  `logs_sql_string` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_logs`
--

INSERT INTO `lmsv2_logs` (`logs_id`, `logs_table_name`, `logs_container_id`, `logs_action`, `logs_timestamp`, `logs_action_by`, `logs_sql_string`) VALUES
(1, 'user', 1, 'update', '2016-09-11 16:08:05', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20160911\', `user_lastlogin_time` = \'160805\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(2, 'user', 1, 'update', '2016-09-11 16:29:51', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20160911\', `user_lastlogin_time` = \'162951\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(3, 'user', 1, 'update', '2016-10-09 17:35:31', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20161009\', `user_lastlogin_time` = \'173531\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(4, 'user', 1, 'update', '2018-03-09 10:44:01', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180309\', `user_lastlogin_time` = \'104401\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(5, 'user', 1, 'update', '2018-03-09 10:44:24', 1, 'UPDATE `lmsv2_user` SET `user_pass` = \'52c69e3a57331081823331c4e69d3f2e\', `user_lastmodifiedpassword` = \'20180309\' WHERE `user_id` = \'1\''),
(6, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'defaultlang\', `general_setting_value` = \'en\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'defaultlang\''),
(7, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changelang\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'changelang\''),
(8, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitetitle\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'websitetitle\''),
(9, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'concurrentuser\', `general_setting_value` = \'100\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'concurrentuser\''),
(10, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'recordperpage\', `general_setting_value` = \'20\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'recordperpage\''),
(11, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showildp\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'showildp\''),
(12, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'loginbyemail\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'loginbyemail\''),
(13, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'sessiontimeout\', `general_setting_value` = \'3600\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'sessiontimeout\''),
(14, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'inactiveperiod\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'inactiveperiod\''),
(15, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'multiplelogin\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'multiplelogin\''),
(16, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'expiredpassword\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'expiredpassword\''),
(17, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'minpasslen\', `general_setting_value` = \'4\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'minpasslen\''),
(18, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxpasslen\', `general_setting_value` = \'12\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'maxpasslen\''),
(19, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'passchar\', `general_setting_value` = \'free\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'passchar\''),
(20, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxchangepassword\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'maxchangepassword\''),
(21, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changepass1st\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'changepass1st\''),
(22, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'errorlogin\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'errorlogin\''),
(23, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxtaken\', `general_setting_value` = \'2\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'maxtaken\''),
(24, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'personalreportmateri\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'personalreportmateri\''),
(25, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingprint\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'showtrainingprint\''),
(26, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingminlulus\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'showtrainingminlulus\''),
(27, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'showtrainingquestionall\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(28, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'totallooptraining\', \'\', \'1\', \'2018-03-09 10:44:54\')'),
(29, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'typelooptraining\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(30, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'certificatesign\', `general_setting_value` = \'Head, Organization Learning\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'certificatesign\''),
(31, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationprint\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'showcertificationprint\''),
(32, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationminlulus\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'showcertificationminlulus\''),
(33, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'showcertificationquestionall\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(34, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'totalloopcertification\', \'\', \'1\', \'2018-03-09 10:44:54\')'),
(35, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'typeloopcertification\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(36, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcemaxsize\', `general_setting_value` = \'1048576\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'resourcemaxsize\''),
(37, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcetype\', `general_setting_value` = \'a:11:{i:0;s:4:\\\"text\\\";i:1;s:5:\\\"audio\\\";i:2;s:5:\\\"video\\\";i:3;s:11:\\\"application\\\";i:4;s:5:\\\"image\\\";i:5;s:4:\\\".pps\\\";i:6;s:0:\\\"\\\";i:7;s:0:\\\"\\\";i:8;s:0:\\\"\\\";i:9;s:0:\\\"\\\";i:10;s:0:\\\"\\\";}\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'resourcetype\''),
(38, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'day_interval\', `general_setting_value` = \'30\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'day_interval\''),
(39, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notice_per\', `general_setting_value` = \'7\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'notice_per\''),
(40, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsender\', `general_setting_value` = \'999999\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'remindermailsender\''),
(41, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindersendername\', `general_setting_value` = \'Learning Development\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'remindersendername\''),
(42, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsubject\', `general_setting_value` = \'Learning Reminder\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'remindermailsubject\''),
(43, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_activity_periodic\', `general_setting_value` = \'90\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'cms_activity_periodic\''),
(44, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_news_per_page\', `general_setting_value` = \'3\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'cms_news_per_page\''),
(45, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_show_admin_news\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'cms_show_admin_news\''),
(46, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'show_running_text_approval\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(47, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'notif_email_approval\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(48, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'notif_email_sender\', \'\', \'1\', \'2018-03-09 10:44:54\')'),
(49, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'notif_email_name\', \'\', \'1\', \'2018-03-09 10:44:54\')'),
(50, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'notif_email_subject\', \'\', \'1\', \'2018-03-09 10:44:54\')'),
(51, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'notif_email_body\', \'\', \'1\', \'2018-03-09 10:44:54\')'),
(52, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'show_learning_catalog\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(53, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'questionaire_anonim_user\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(54, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'submit\', \'\', \'1\', \'2018-03-09 10:44:54\')'),
(55, 'general_setting', 0, 'update', '2018-03-09 10:44:54', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitelogo\', `general_setting_value` = \'logo@4x.png\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-09 10:44:54\' WHERE `general_setting_code` = \'websitelogo\''),
(56, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'user_minimal_approval_request_training\', \'0\', \'1\', \'2018-03-09 10:44:54\')'),
(57, 'general_setting', 0, 'insert', '2018-03-09 10:44:54', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'total_step_approval\', \'1\', \'1\', \'2018-03-09 10:44:54\')'),
(58, 'user', 1, 'update', '2018-03-09 10:47:51', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180309\', `user_lastlogin_time` = \'104751\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(59, 'user', 1, 'update', '2018-03-09 11:04:19', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180309\', `user_lastlogin_time` = \'110419\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(60, 'user', 1, 'update', '2018-03-13 01:31:55', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180313\', `user_lastlogin_time` = \'13155\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(61, 'user', 1, 'update', '2018-03-15 02:53:56', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(62, 'user', 1, 'update', '2018-03-15 02:54:11', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(63, 'user', 1, 'update', '2018-03-15 02:54:12', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(64, 'user', 1, 'update', '2018-03-15 02:54:54', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(65, 'user', 1, 'update', '2018-03-15 02:55:10', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(66, 'user', 1, 'update', '2018-03-15 02:55:40', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180315\', `user_lastlogin_time` = \'25540\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(67, 'user', 1, 'update', '2018-03-15 03:14:09', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180315\', `user_lastlogin_time` = \'31409\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(68, 'user', 1, 'update', '2018-03-15 05:00:33', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180315\', `user_lastlogin_time` = \'50033\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(69, 'user', 1, 'update', '2018-03-15 05:01:49', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180315\', `user_lastlogin_time` = \'50149\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(70, 'user', 1, 'update', '2018-03-16 08:14:19', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180316\', `user_lastlogin_time` = \'81419\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(71, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'defaultlang\', `general_setting_value` = \'en\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'defaultlang\''),
(72, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changelang\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'changelang\''),
(73, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitetitle\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'websitetitle\''),
(74, 'general_setting', 0, 'insert', '2018-03-16 08:14:37', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'websiteloginword1\', \'\', \'1\', \'2018-03-16 08:14:37\')'),
(75, 'general_setting', 0, 'insert', '2018-03-16 08:14:37', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'websiteloginword2\', \'\', \'1\', \'2018-03-16 08:14:37\')'),
(76, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'concurrentuser\', `general_setting_value` = \'100\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'concurrentuser\''),
(77, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'recordperpage\', `general_setting_value` = \'20\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'recordperpage\''),
(78, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showildp\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'showildp\''),
(79, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'loginbyemail\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'loginbyemail\''),
(80, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'sessiontimeout\', `general_setting_value` = \'3600\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'sessiontimeout\''),
(81, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'inactiveperiod\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'inactiveperiod\''),
(82, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'multiplelogin\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'multiplelogin\''),
(83, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'expiredpassword\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'expiredpassword\''),
(84, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'minpasslen\', `general_setting_value` = \'4\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'minpasslen\''),
(85, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxpasslen\', `general_setting_value` = \'12\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'maxpasslen\''),
(86, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'passchar\', `general_setting_value` = \'free\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'passchar\''),
(87, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxchangepassword\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'maxchangepassword\''),
(88, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changepass1st\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'changepass1st\''),
(89, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'errorlogin\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'errorlogin\''),
(90, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxtaken\', `general_setting_value` = \'2\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'maxtaken\''),
(91, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'personalreportmateri\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'personalreportmateri\''),
(92, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingprint\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'showtrainingprint\''),
(93, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingminlulus\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'showtrainingminlulus\''),
(94, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'showtrainingquestionall\''),
(95, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totallooptraining\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'totallooptraining\''),
(96, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typelooptraining\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'typelooptraining\''),
(97, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'certificatesign\', `general_setting_value` = \'Head, Organization Learning\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'certificatesign\''),
(98, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationprint\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'showcertificationprint\''),
(99, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationminlulus\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'showcertificationminlulus\''),
(100, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'showcertificationquestionall\''),
(101, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totalloopcertification\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'totalloopcertification\''),
(102, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typeloopcertification\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'typeloopcertification\''),
(103, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcemaxsize\', `general_setting_value` = \'1048576\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'resourcemaxsize\''),
(104, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcetype\', `general_setting_value` = \'a:11:{i:0;s:4:\\\"text\\\";i:1;s:5:\\\"audio\\\";i:2;s:5:\\\"video\\\";i:3;s:11:\\\"application\\\";i:4;s:5:\\\"image\\\";i:5;s:4:\\\".pps\\\";i:6;s:0:\\\"\\\";i:7;s:0:\\\"\\\";i:8;s:0:\\\"\\\";i:9;s:0:\\\"\\\";i:10;s:0:\\\"\\\";}\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'resourcetype\''),
(105, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'day_interval\', `general_setting_value` = \'30\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'day_interval\''),
(106, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notice_per\', `general_setting_value` = \'7\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'notice_per\''),
(107, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsender\', `general_setting_value` = \'999999\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'remindermailsender\''),
(108, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindersendername\', `general_setting_value` = \'Learning Development\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'remindersendername\''),
(109, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsubject\', `general_setting_value` = \'Learning Reminder\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'remindermailsubject\''),
(110, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_activity_periodic\', `general_setting_value` = \'90\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'cms_activity_periodic\''),
(111, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_news_per_page\', `general_setting_value` = \'3\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'cms_news_per_page\''),
(112, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_show_admin_news\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'cms_show_admin_news\''),
(113, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_running_text_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'show_running_text_approval\''),
(114, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'notif_email_approval\''),
(115, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_sender\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'notif_email_sender\''),
(116, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_name\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'notif_email_name\''),
(117, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_subject\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'notif_email_subject\''),
(118, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_body\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'notif_email_body\''),
(119, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_learning_catalog\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'show_learning_catalog\''),
(120, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'questionaire_anonim_user\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'questionaire_anonim_user\''),
(121, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'submit\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'submit\''),
(122, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'user_minimal_approval_request_training\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'user_minimal_approval_request_training\''),
(123, 'general_setting', 0, 'update', '2018-03-16 08:14:37', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'total_step_approval\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:37\' WHERE `general_setting_code` = \'total_step_approval\''),
(124, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'defaultlang\', `general_setting_value` = \'en\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'defaultlang\''),
(125, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changelang\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'changelang\''),
(126, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitetitle\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'websitetitle\''),
(127, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword1\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'websiteloginword1\''),
(128, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword2\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'websiteloginword2\''),
(129, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'concurrentuser\', `general_setting_value` = \'100\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'concurrentuser\''),
(130, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'recordperpage\', `general_setting_value` = \'20\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'recordperpage\''),
(131, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showildp\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'showildp\''),
(132, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'loginbyemail\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'loginbyemail\''),
(133, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'sessiontimeout\', `general_setting_value` = \'3600\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'sessiontimeout\''),
(134, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'inactiveperiod\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'inactiveperiod\''),
(135, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'multiplelogin\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'multiplelogin\''),
(136, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'expiredpassword\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'expiredpassword\''),
(137, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'minpasslen\', `general_setting_value` = \'4\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'minpasslen\''),
(138, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxpasslen\', `general_setting_value` = \'12\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'maxpasslen\''),
(139, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'passchar\', `general_setting_value` = \'free\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'passchar\''),
(140, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxchangepassword\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'maxchangepassword\''),
(141, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changepass1st\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'changepass1st\''),
(142, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'errorlogin\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'errorlogin\''),
(143, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxtaken\', `general_setting_value` = \'2\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'maxtaken\''),
(144, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'personalreportmateri\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'personalreportmateri\''),
(145, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingprint\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'showtrainingprint\''),
(146, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingminlulus\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'showtrainingminlulus\''),
(147, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'showtrainingquestionall\''),
(148, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totallooptraining\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'totallooptraining\''),
(149, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typelooptraining\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'typelooptraining\''),
(150, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'certificatesign\', `general_setting_value` = \'Head, Organization Learning\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'certificatesign\''),
(151, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationprint\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'showcertificationprint\''),
(152, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationminlulus\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'showcertificationminlulus\''),
(153, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'showcertificationquestionall\''),
(154, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totalloopcertification\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'totalloopcertification\''),
(155, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typeloopcertification\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'typeloopcertification\''),
(156, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcemaxsize\', `general_setting_value` = \'1048576\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'resourcemaxsize\''),
(157, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcetype\', `general_setting_value` = \'a:11:{i:0;s:4:\\\"text\\\";i:1;s:5:\\\"audio\\\";i:2;s:5:\\\"video\\\";i:3;s:11:\\\"application\\\";i:4;s:5:\\\"image\\\";i:5;s:4:\\\".pps\\\";i:6;s:0:\\\"\\\";i:7;s:0:\\\"\\\";i:8;s:0:\\\"\\\";i:9;s:0:\\\"\\\";i:10;s:0:\\\"\\\";}\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'resourcetype\''),
(158, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'day_interval\', `general_setting_value` = \'30\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'day_interval\''),
(159, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notice_per\', `general_setting_value` = \'7\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'notice_per\''),
(160, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsender\', `general_setting_value` = \'999999\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'remindermailsender\''),
(161, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindersendername\', `general_setting_value` = \'Learning Development\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'remindersendername\'');
INSERT INTO `lmsv2_logs` (`logs_id`, `logs_table_name`, `logs_container_id`, `logs_action`, `logs_timestamp`, `logs_action_by`, `logs_sql_string`) VALUES
(162, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsubject\', `general_setting_value` = \'Learning Reminder\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'remindermailsubject\''),
(163, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_activity_periodic\', `general_setting_value` = \'90\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'cms_activity_periodic\''),
(164, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_news_per_page\', `general_setting_value` = \'3\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'cms_news_per_page\''),
(165, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_show_admin_news\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'cms_show_admin_news\''),
(166, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_running_text_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'show_running_text_approval\''),
(167, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'notif_email_approval\''),
(168, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_sender\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'notif_email_sender\''),
(169, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_name\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'notif_email_name\''),
(170, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_subject\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'notif_email_subject\''),
(171, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_body\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'notif_email_body\''),
(172, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_learning_catalog\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'show_learning_catalog\''),
(173, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'questionaire_anonim_user\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'questionaire_anonim_user\''),
(174, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'submit\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'submit\''),
(175, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'user_minimal_approval_request_training\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'user_minimal_approval_request_training\''),
(176, 'general_setting', 0, 'update', '2018-03-16 08:14:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'total_step_approval\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-16 08:14:57\' WHERE `general_setting_code` = \'total_step_approval\''),
(177, 'user', 1, 'update', '2018-03-17 06:07:29', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(178, 'user', 1, 'update', '2018-03-17 06:07:36', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180317\', `user_lastlogin_time` = \'60736\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(179, 'user', 1, 'update', '2018-03-17 07:56:25', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180317\', `user_lastlogin_time` = \'75625\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(180, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'defaultlang\', `general_setting_value` = \'en\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'defaultlang\''),
(181, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changelang\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'changelang\''),
(182, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitetitle\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'websitetitle\''),
(183, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword1\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'websiteloginword1\''),
(184, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword2\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'websiteloginword2\''),
(185, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'concurrentuser\', `general_setting_value` = \'100\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'concurrentuser\''),
(186, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'recordperpage\', `general_setting_value` = \'20\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'recordperpage\''),
(187, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showildp\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'showildp\''),
(188, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'loginbyemail\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'loginbyemail\''),
(189, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'sessiontimeout\', `general_setting_value` = \'3600\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'sessiontimeout\''),
(190, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'inactiveperiod\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'inactiveperiod\''),
(191, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'multiplelogin\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'multiplelogin\''),
(192, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'expiredpassword\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'expiredpassword\''),
(193, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'minpasslen\', `general_setting_value` = \'4\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'minpasslen\''),
(194, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxpasslen\', `general_setting_value` = \'12\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'maxpasslen\''),
(195, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'passchar\', `general_setting_value` = \'free\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'passchar\''),
(196, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxchangepassword\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'maxchangepassword\''),
(197, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changepass1st\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'changepass1st\''),
(198, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'errorlogin\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'errorlogin\''),
(199, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxtaken\', `general_setting_value` = \'2\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'maxtaken\''),
(200, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'personalreportmateri\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'personalreportmateri\''),
(201, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingprint\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'showtrainingprint\''),
(202, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingminlulus\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'showtrainingminlulus\''),
(203, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'showtrainingquestionall\''),
(204, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totallooptraining\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'totallooptraining\''),
(205, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typelooptraining\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'typelooptraining\''),
(206, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'certificatesign\', `general_setting_value` = \'Head, Organization Learning\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'certificatesign\''),
(207, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationprint\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'showcertificationprint\''),
(208, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationminlulus\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'showcertificationminlulus\''),
(209, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'showcertificationquestionall\''),
(210, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totalloopcertification\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'totalloopcertification\''),
(211, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typeloopcertification\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'typeloopcertification\''),
(212, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcemaxsize\', `general_setting_value` = \'1048576\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'resourcemaxsize\''),
(213, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcetype\', `general_setting_value` = \'a:11:{i:0;s:4:\\\"text\\\";i:1;s:5:\\\"audio\\\";i:2;s:5:\\\"video\\\";i:3;s:11:\\\"application\\\";i:4;s:5:\\\"image\\\";i:5;s:4:\\\".pps\\\";i:6;s:0:\\\"\\\";i:7;s:0:\\\"\\\";i:8;s:0:\\\"\\\";i:9;s:0:\\\"\\\";i:10;s:0:\\\"\\\";}\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'resourcetype\''),
(214, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'day_interval\', `general_setting_value` = \'30\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'day_interval\''),
(215, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notice_per\', `general_setting_value` = \'7\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'notice_per\''),
(216, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsender\', `general_setting_value` = \'999999\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'remindermailsender\''),
(217, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindersendername\', `general_setting_value` = \'Learning Development\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'remindersendername\''),
(218, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsubject\', `general_setting_value` = \'Learning Reminder\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'remindermailsubject\''),
(219, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_activity_periodic\', `general_setting_value` = \'90\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'cms_activity_periodic\''),
(220, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_news_per_page\', `general_setting_value` = \'3\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'cms_news_per_page\''),
(221, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_show_admin_news\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'cms_show_admin_news\''),
(222, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_running_text_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'show_running_text_approval\''),
(223, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'notif_email_approval\''),
(224, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_sender\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'notif_email_sender\''),
(225, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_name\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'notif_email_name\''),
(226, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_subject\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'notif_email_subject\''),
(227, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_body\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'notif_email_body\''),
(228, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_learning_catalog\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'show_learning_catalog\''),
(229, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'questionaire_anonim_user\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'questionaire_anonim_user\''),
(230, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'submit\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'submit\''),
(231, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'user_minimal_approval_request_training\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'user_minimal_approval_request_training\''),
(232, 'general_setting', 0, 'update', '2018-03-17 07:57:02', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'total_step_approval\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:02\' WHERE `general_setting_code` = \'total_step_approval\''),
(233, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'defaultlang\', `general_setting_value` = \'en\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'defaultlang\''),
(234, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changelang\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'changelang\''),
(235, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitetitle\', `general_setting_value` = \'test\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'websitetitle\''),
(236, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword1\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'websiteloginword1\''),
(237, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword2\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'websiteloginword2\''),
(238, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'concurrentuser\', `general_setting_value` = \'100\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'concurrentuser\''),
(239, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'recordperpage\', `general_setting_value` = \'20\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'recordperpage\''),
(240, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showildp\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'showildp\''),
(241, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'loginbyemail\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'loginbyemail\''),
(242, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'sessiontimeout\', `general_setting_value` = \'3600\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'sessiontimeout\''),
(243, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'inactiveperiod\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'inactiveperiod\''),
(244, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'multiplelogin\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'multiplelogin\''),
(245, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'expiredpassword\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'expiredpassword\''),
(246, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'minpasslen\', `general_setting_value` = \'4\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'minpasslen\''),
(247, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxpasslen\', `general_setting_value` = \'12\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'maxpasslen\''),
(248, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'passchar\', `general_setting_value` = \'free\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'passchar\''),
(249, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxchangepassword\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'maxchangepassword\''),
(250, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changepass1st\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'changepass1st\''),
(251, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'errorlogin\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'errorlogin\''),
(252, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxtaken\', `general_setting_value` = \'2\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'maxtaken\''),
(253, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'personalreportmateri\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'personalreportmateri\''),
(254, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingprint\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'showtrainingprint\''),
(255, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingminlulus\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'showtrainingminlulus\''),
(256, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'showtrainingquestionall\''),
(257, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totallooptraining\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'totallooptraining\''),
(258, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typelooptraining\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'typelooptraining\''),
(259, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'certificatesign\', `general_setting_value` = \'Head, Organization Learning\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'certificatesign\''),
(260, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationprint\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'showcertificationprint\''),
(261, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationminlulus\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'showcertificationminlulus\''),
(262, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'showcertificationquestionall\''),
(263, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totalloopcertification\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'totalloopcertification\''),
(264, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typeloopcertification\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'typeloopcertification\''),
(265, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcemaxsize\', `general_setting_value` = \'1048576\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'resourcemaxsize\''),
(266, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcetype\', `general_setting_value` = \'a:11:{i:0;s:4:\\\"text\\\";i:1;s:5:\\\"audio\\\";i:2;s:5:\\\"video\\\";i:3;s:11:\\\"application\\\";i:4;s:5:\\\"image\\\";i:5;s:4:\\\".pps\\\";i:6;s:0:\\\"\\\";i:7;s:0:\\\"\\\";i:8;s:0:\\\"\\\";i:9;s:0:\\\"\\\";i:10;s:0:\\\"\\\";}\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'resourcetype\''),
(267, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'day_interval\', `general_setting_value` = \'30\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'day_interval\''),
(268, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notice_per\', `general_setting_value` = \'7\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'notice_per\''),
(269, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsender\', `general_setting_value` = \'999999\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'remindermailsender\''),
(270, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindersendername\', `general_setting_value` = \'Learning Development\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'remindersendername\''),
(271, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsubject\', `general_setting_value` = \'Learning Reminder\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'remindermailsubject\''),
(272, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_activity_periodic\', `general_setting_value` = \'90\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'cms_activity_periodic\''),
(273, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_news_per_page\', `general_setting_value` = \'3\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'cms_news_per_page\''),
(274, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_show_admin_news\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'cms_show_admin_news\''),
(275, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_running_text_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'show_running_text_approval\''),
(276, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'notif_email_approval\''),
(277, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_sender\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'notif_email_sender\''),
(278, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_name\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'notif_email_name\''),
(279, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_subject\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'notif_email_subject\''),
(280, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_body\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'notif_email_body\''),
(281, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_learning_catalog\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'show_learning_catalog\''),
(282, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'questionaire_anonim_user\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'questionaire_anonim_user\''),
(283, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'submit\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'submit\''),
(284, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'user_minimal_approval_request_training\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'user_minimal_approval_request_training\''),
(285, 'general_setting', 0, 'update', '2018-03-17 07:57:16', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'total_step_approval\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:16\' WHERE `general_setting_code` = \'total_step_approval\''),
(286, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'defaultlang\', `general_setting_value` = \'en\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'defaultlang\''),
(287, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changelang\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'changelang\''),
(288, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitetitle\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'websitetitle\''),
(289, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword1\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'websiteloginword1\''),
(290, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword2\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'websiteloginword2\''),
(291, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'concurrentuser\', `general_setting_value` = \'100\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'concurrentuser\''),
(292, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'recordperpage\', `general_setting_value` = \'20\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'recordperpage\''),
(293, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showildp\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'showildp\''),
(294, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'loginbyemail\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'loginbyemail\''),
(295, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'sessiontimeout\', `general_setting_value` = \'3600\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'sessiontimeout\''),
(296, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'inactiveperiod\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'inactiveperiod\''),
(297, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'multiplelogin\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'multiplelogin\''),
(298, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'expiredpassword\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'expiredpassword\''),
(299, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'minpasslen\', `general_setting_value` = \'4\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'minpasslen\''),
(300, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxpasslen\', `general_setting_value` = \'12\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'maxpasslen\''),
(301, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'passchar\', `general_setting_value` = \'free\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'passchar\''),
(302, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxchangepassword\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'maxchangepassword\''),
(303, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changepass1st\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'changepass1st\''),
(304, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'errorlogin\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'errorlogin\''),
(305, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxtaken\', `general_setting_value` = \'2\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'maxtaken\''),
(306, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'personalreportmateri\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'personalreportmateri\''),
(307, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingprint\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'showtrainingprint\''),
(308, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingminlulus\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'showtrainingminlulus\''),
(309, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'showtrainingquestionall\''),
(310, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totallooptraining\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'totallooptraining\''),
(311, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typelooptraining\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'typelooptraining\''),
(312, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'certificatesign\', `general_setting_value` = \'Head, Organization Learning\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'certificatesign\'');
INSERT INTO `lmsv2_logs` (`logs_id`, `logs_table_name`, `logs_container_id`, `logs_action`, `logs_timestamp`, `logs_action_by`, `logs_sql_string`) VALUES
(313, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationprint\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'showcertificationprint\''),
(314, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationminlulus\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'showcertificationminlulus\''),
(315, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'showcertificationquestionall\''),
(316, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totalloopcertification\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'totalloopcertification\''),
(317, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typeloopcertification\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'typeloopcertification\''),
(318, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcemaxsize\', `general_setting_value` = \'1048576\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'resourcemaxsize\''),
(319, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcetype\', `general_setting_value` = \'a:11:{i:0;s:4:\\\"text\\\";i:1;s:5:\\\"audio\\\";i:2;s:5:\\\"video\\\";i:3;s:11:\\\"application\\\";i:4;s:5:\\\"image\\\";i:5;s:4:\\\".pps\\\";i:6;s:0:\\\"\\\";i:7;s:0:\\\"\\\";i:8;s:0:\\\"\\\";i:9;s:0:\\\"\\\";i:10;s:0:\\\"\\\";}\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'resourcetype\''),
(320, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'day_interval\', `general_setting_value` = \'30\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'day_interval\''),
(321, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notice_per\', `general_setting_value` = \'7\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'notice_per\''),
(322, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsender\', `general_setting_value` = \'999999\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'remindermailsender\''),
(323, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindersendername\', `general_setting_value` = \'Learning Development\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'remindersendername\''),
(324, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsubject\', `general_setting_value` = \'Learning Reminder\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'remindermailsubject\''),
(325, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_activity_periodic\', `general_setting_value` = \'90\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'cms_activity_periodic\''),
(326, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_news_per_page\', `general_setting_value` = \'3\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'cms_news_per_page\''),
(327, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_show_admin_news\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'cms_show_admin_news\''),
(328, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_running_text_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'show_running_text_approval\''),
(329, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'notif_email_approval\''),
(330, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_sender\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'notif_email_sender\''),
(331, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_name\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'notif_email_name\''),
(332, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_subject\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'notif_email_subject\''),
(333, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_body\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'notif_email_body\''),
(334, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_learning_catalog\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'show_learning_catalog\''),
(335, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'questionaire_anonim_user\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'questionaire_anonim_user\''),
(336, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'submit\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'submit\''),
(337, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'user_minimal_approval_request_training\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'user_minimal_approval_request_training\''),
(338, 'general_setting', 0, 'update', '2018-03-17 07:57:29', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'total_step_approval\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-03-17 07:57:29\' WHERE `general_setting_code` = \'total_step_approval\''),
(339, 'user', 1, 'update', '2018-03-19 07:01:17', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(340, 'user', 1, 'update', '2018-03-19 07:01:21', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180319\', `user_lastlogin_time` = \'70121\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(341, 'user', 1, 'update', '2018-03-21 06:21:35', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(342, 'user', 1, 'update', '2018-03-21 06:21:43', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(343, 'user', 1, 'update', '2018-03-21 06:21:45', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(344, 'user', 1, 'update', '2018-03-21 06:21:50', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180321\', `user_lastlogin_time` = \'62150\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(345, 'category', 1, 'insert', '2018-03-21 06:23:07', 1, 'INSERT INTO `lmsv2_category` (`category_name`, `category_desc`, `category_status`, `category_parent`, `category_type`, `category_created`, `category_creator`) VALUES (\'KSEi eLearning\', \'\', \'1\', \'0\', 0, \'20180321\', \'1\')'),
(346, 'category', 2, 'insert', '2018-03-21 06:34:55', 1, 'INSERT INTO `lmsv2_category` (`category_name`, `category_desc`, `category_parent`, `category_code`, `category_status`, `category_type`, `category_created`, `category_creator`) VALUES (\'FAQ\', \'\', \'1\', \'OL0001\', \'1\', 1, \'20180321\', \'1\')'),
(347, 'training', 1, 'insert', '2018-03-21 06:35:29', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES (\'\', \'2\', \'Modul 0\', \'\', \'admin\', \'lms\', \'\', \'admin@learning.co.id\', 1, \'1\', \'\', 0, \'2018-03-21 06:35:29\', \'1\', 0, \'TRN-000001\', \'1\', \'20180321\', \'1\', 1)'),
(348, 'training', 1, 'update', '2018-03-21 06:36:13', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = \'1\', `training_modified` = \'2018-03-21 06:36:13\', `training_modifier` = \'1\' WHERE `training_id` = \'1\''),
(349, 'training_npk', 1, 'delete', '2018-03-21 06:36:13', 1, 'UPDATE `lmsv2_training` SET `training_all_staff` = \'1\', `training_modified` = \'2018-03-21 06:36:13\', `training_modifier` = \'1\' WHERE `training_id` = \'1\''),
(350, 'training_npk', 1, 'insert', '2018-03-21 06:36:13', 1, 'INSERT INTO `lmsv2_training_npk` (`training_npk_npk`, `training_npk_training`, `training_npk_time_id`) VALUES (\'1\', \'1\', 0)'),
(351, 'user', 1, 'update', '2018-04-01 05:38:19', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180401\', `user_lastlogin_time` = \'53819\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(352, 'user', 1, 'update', '2018-04-01 05:38:21', 1, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180401\', `user_lastlogin_time` = \'53821\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(353, 'training', 2, 'insert', '2018-04-01 05:39:15', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_material`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES (\'\', \'2\', \'Test\', \'\', \'admin\', \'lms\', \'\', \'admin@learning.co.id\', 1, \'2\', \'\', 0, \'2018-04-01 05:39:15\', \'1\', 0, \'/MATERIAL/TRN-00001\', \'TRN-000002\', \'1\', \'20180401\', \'1\', 1)'),
(354, 'training', 2, 'update', '2018-04-01 05:39:15', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = \'\' WHERE `training_id` = 2'),
(355, 'training_time', 2, 'delete', '2018-04-01 05:39:15', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = \'\' WHERE `training_id` = 2'),
(356, 'user', 1, 'update', '2018-04-02 02:44:04', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(357, 'user', 1, 'update', '2018-04-02 02:44:06', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(358, 'user', 1, 'update', '2018-04-02 02:44:14', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(359, 'user', 1, 'update', '2018-04-02 02:44:16', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(360, 'user', 1, 'update', '2018-04-02 02:44:29', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(361, 'user', 1, 'update', '2018-04-02 02:44:31', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(362, 'user', 1, 'update', '2018-04-02 02:44:36', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180402\', `user_lastlogin_time` = \'24436\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(363, 'user', 1, 'update', '2018-04-02 03:08:13', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(364, 'user', 1, 'update', '2018-04-02 03:08:19', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180402\', `user_lastlogin_time` = \'30819\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(365, 'training', 3, 'insert', '2018-04-02 03:11:30', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES (\'\', \'2\', \'Modul 1\', \'\', \'admin\', \'lms\', \'\', \'admin@learning.co.id\', 1, \'1\', \'\', 0, \'2018-04-02 03:11:30\', \'1\', 0, \'TRN-000003\', \'1\', \'20180402\', \'1\', 1)'),
(366, 'user', 1, 'update', '2018-04-05 07:41:41', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180405\', `user_lastlogin_time` = \'74141\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(367, 'user', 1, 'update', '2018-04-09 02:44:43', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(368, 'user', 1, 'update', '2018-04-09 02:44:48', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180409\', `user_lastlogin_time` = \'24448\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(369, 'user', 1, 'update', '2018-04-09 15:03:03', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180409\', `user_lastlogin_time` = \'150303\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(370, 'user', 1, 'update', '2018-04-09 15:05:02', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(371, 'user', 1, 'update', '2018-04-09 15:05:09', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180409\', `user_lastlogin_time` = \'150509\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(372, 'training', 4, 'insert', '2018-04-09 15:06:01', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES (\'\', \'2\', \'Test 1\', \'\', \'admin\', \'lms\', \'\', \'admin@learning.co.id\', 1, \'1\', \'\', 0, \'2018-04-09 15:06:01\', \'1\', 3600, \'TRN-000004\', \'1\', \'20180409\', \'1\', 1)'),
(373, 'training', 5, 'insert', '2018-04-09 15:08:59', 1, 'INSERT INTO `lmsv2_training` (`training_data`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_status`, `training_material_type`, `training_cost`, `training_refreshment`, `training_modified`, `training_modifier`, `training_duration`, `training_code`, `training_author_id`, `training_created_date`, `training_creator`, `training_type`) VALUES (\'\', \'2\', \'Test 2\', \'\', \'admin\', \'lms\', \'\', \'admin@learning.co.id\', 1, \'1\', \'\', 0, \'2018-04-09 15:08:59\', \'1\', 3600, \'TRN-000005\', \'1\', \'20180409\', \'1\', 1)'),
(374, 'training', 5, 'update', '2018-04-09 15:09:00', 1, 'UPDATE `lmsv2_training` SET `training_material` = \'TRN-000005\', `training_modified` = \'2018-04-09 15:09:00\', `training_modifier` = \'1\' WHERE `training_id` = 5'),
(375, 'training', 5, 'update', '2018-04-09 15:09:00', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = \'\' WHERE `training_id` = 5'),
(376, 'training_time', 5, 'delete', '2018-04-09 15:09:00', 1, 'UPDATE `lmsv2_training` SET `training_cert_tpl` = \'\' WHERE `training_id` = 5'),
(377, 'training_time', 1, 'insert', '2018-04-09 15:09:00', 1, 'INSERT INTO `lmsv2_training_time` (`training_time_date1`, `training_time_date2`, `training_time_period`, `training_time_training`, `training_time_parent`) VALUES (\'20180401\', \'20180430\', 0, 5, 0)'),
(378, 'user', 1, 'update', '2018-04-15 07:02:15', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(379, 'user', 1, 'update', '2018-04-15 07:02:19', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180415\', `user_lastlogin_time` = \'70219\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(380, 'user', 1, 'update', '2018-04-17 03:14:19', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180417\', `user_lastlogin_time` = \'31419\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(381, 'user', 1, 'update', '2018-04-19 04:44:48', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180419\', `user_lastlogin_time` = \'44448\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(382, 'user', 1, 'update', '2018-04-19 09:09:04', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(383, 'user', 1, 'update', '2018-04-19 09:09:27', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180419\', `user_lastlogin_time` = \'90927\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(384, 'category', 3, 'insert', '2018-04-19 09:10:09', 1, 'INSERT INTO `lmsv2_category` (`category_name`, `category_desc`, `category_status`, `category_parent`, `category_type`, `category_created`, `category_creator`) VALUES (\'External\', \'\', \'1\', \'0\', 0, \'20180419\', \'1\')'),
(385, 'user', 1, 'update', '2018-04-19 09:22:32', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(386, 'user', 1, 'update', '2018-04-19 09:22:55', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(387, 'user', 1, 'update', '2018-04-19 09:23:01', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180419\', `user_lastlogin_time` = \'92301\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(388, 'category', 2, 'update', '2018-04-19 09:23:20', 1, 'UPDATE `lmsv2_category` SET `category_name` = \'FAQ\', `category_desc` = \'\', `category_parent` = \'3\', `category_code` = \'OL0001\', `category_status` = \'1\' WHERE `category_id` = \'2\''),
(389, 'user', 1, 'update', '2018-04-24 21:42:01', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180424\', `user_lastlogin_time` = \'214201\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(390, 'user', 1, 'update', '2018-04-24 21:42:41', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180424\', `user_lastlogin_time` = \'214241\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(391, 'user', 1, 'update', '2018-04-24 22:09:08', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180424\', `user_lastlogin_time` = \'220908\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(392, 'user', 1, 'update', '2018-04-24 22:17:33', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180424\', `user_lastlogin_time` = \'221733\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(393, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'defaultlang\', `general_setting_value` = \'id\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'defaultlang\''),
(394, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changelang\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'changelang\''),
(395, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websitetitle\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'websitetitle\''),
(396, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword1\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'websiteloginword1\''),
(397, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'websiteloginword2\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'websiteloginword2\''),
(398, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'concurrentuser\', `general_setting_value` = \'100\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'concurrentuser\''),
(399, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'recordperpage\', `general_setting_value` = \'20\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'recordperpage\''),
(400, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showildp\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'showildp\''),
(401, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'loginbyemail\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'loginbyemail\''),
(402, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'sessiontimeout\', `general_setting_value` = \'3600\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'sessiontimeout\''),
(403, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'inactiveperiod\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'inactiveperiod\''),
(404, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'multiplelogin\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'multiplelogin\''),
(405, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'expiredpassword\', `general_setting_value` = \'365\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'expiredpassword\''),
(406, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'minpasslen\', `general_setting_value` = \'4\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'minpasslen\''),
(407, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxpasslen\', `general_setting_value` = \'12\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'maxpasslen\''),
(408, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'passchar\', `general_setting_value` = \'free\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'passchar\''),
(409, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxchangepassword\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'maxchangepassword\''),
(410, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'changepass1st\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'changepass1st\''),
(411, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'errorlogin\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'errorlogin\''),
(412, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'maxtaken\', `general_setting_value` = \'2\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'maxtaken\''),
(413, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'personalreportmateri\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'personalreportmateri\''),
(414, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingprint\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'showtrainingprint\''),
(415, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingminlulus\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'showtrainingminlulus\''),
(416, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showtrainingquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'showtrainingquestionall\''),
(417, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totallooptraining\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'totallooptraining\''),
(418, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typelooptraining\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'typelooptraining\''),
(419, 'general_setting', 0, 'insert', '2018-04-24 22:17:57', 1, 'INSERT INTO `lmsv2_general_setting` (`general_setting_code`, `general_setting_value`, `general_setting_updatedby`, `general_setting_lastupdated`) VALUES (\'showtrainingcounterpraexammateri\', \'0\', \'1\', \'2018-04-24 22:17:57\')'),
(420, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'certificatesign\', `general_setting_value` = \'Head, Organization Learning\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'certificatesign\''),
(421, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationprint\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'showcertificationprint\''),
(422, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationminlulus\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'showcertificationminlulus\''),
(423, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'showcertificationquestionall\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'showcertificationquestionall\''),
(424, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'totalloopcertification\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'totalloopcertification\''),
(425, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'typeloopcertification\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'typeloopcertification\''),
(426, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcemaxsize\', `general_setting_value` = \'1048576\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'resourcemaxsize\''),
(427, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'resourcetype\', `general_setting_value` = \'a:11:{i:0;s:4:\\\"text\\\";i:1;s:5:\\\"audio\\\";i:2;s:5:\\\"video\\\";i:3;s:11:\\\"application\\\";i:4;s:5:\\\"image\\\";i:5;s:4:\\\".pps\\\";i:6;s:0:\\\"\\\";i:7;s:0:\\\"\\\";i:8;s:0:\\\"\\\";i:9;s:0:\\\"\\\";i:10;s:0:\\\"\\\";}\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'resourcetype\''),
(428, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'day_interval\', `general_setting_value` = \'30\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'day_interval\''),
(429, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notice_per\', `general_setting_value` = \'7\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'notice_per\''),
(430, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsender\', `general_setting_value` = \'999999\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'remindermailsender\''),
(431, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindersendername\', `general_setting_value` = \'Learning Development\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'remindersendername\''),
(432, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'remindermailsubject\', `general_setting_value` = \'Learning Reminder\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'remindermailsubject\''),
(433, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_activity_periodic\', `general_setting_value` = \'90\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'cms_activity_periodic\''),
(434, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_news_per_page\', `general_setting_value` = \'3\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'cms_news_per_page\''),
(435, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'cms_show_admin_news\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'cms_show_admin_news\''),
(436, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_running_text_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'show_running_text_approval\''),
(437, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_approval\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'notif_email_approval\''),
(438, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_sender\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'notif_email_sender\''),
(439, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_name\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'notif_email_name\''),
(440, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_subject\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'notif_email_subject\''),
(441, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'notif_email_body\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'notif_email_body\''),
(442, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'show_learning_catalog\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'show_learning_catalog\''),
(443, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'questionaire_anonim_user\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'questionaire_anonim_user\''),
(444, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'submit\', `general_setting_value` = \'\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'submit\''),
(445, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'user_minimal_approval_request_training\', `general_setting_value` = \'0\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'user_minimal_approval_request_training\''),
(446, 'general_setting', 0, 'update', '2018-04-24 22:17:57', 1, 'UPDATE `lmsv2_general_setting` SET `general_setting_code` = \'total_step_approval\', `general_setting_value` = \'1\', `general_setting_updatedby` = \'1\', `general_setting_lastupdated` = \'2018-04-24 22:17:57\' WHERE `general_setting_code` = \'total_step_approval\''),
(447, 'user', 1, 'update', '2018-04-24 22:18:13', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180424\', `user_lastlogin_time` = \'221813\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(448, 'user', 1, 'update', '2018-04-24 22:33:37', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180424\', `user_lastlogin_time` = \'223337\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(449, 'user', 1, 'update', '2018-04-25 05:35:36', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180425\', `user_lastlogin_time` = \'53536\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(450, 'user', 1, 'update', '2018-06-28 17:41:39', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(451, 'user', 1, 'update', '2018-06-28 17:41:46', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180628\', `user_lastlogin_time` = \'174146\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(452, 'user', 1, 'update', '2018-08-03 16:50:42', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(453, 'user', 1, 'update', '2018-08-03 16:50:49', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180803\', `user_lastlogin_time` = \'165049\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(454, 'user', 1, 'update', '2018-08-13 09:12:40', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(455, 'user', 1, 'update', '2018-08-13 09:12:41', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(456, 'user', 1, 'update', '2018-08-13 09:12:45', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(457, 'user', 1, 'update', '2018-08-13 09:13:06', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180813\', `user_lastlogin_time` = \'91306\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(458, 'user', 1, 'update', '2018-08-13 09:13:06', 1, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180813\', `user_lastlogin_time` = \'91306\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(459, 'user', 1, 'update', '2018-08-16 09:46:59', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(460, 'user', 1, 'update', '2018-08-16 09:47:04', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(461, 'user', 1, 'update', '2018-08-16 09:47:06', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(462, 'user', 1, 'update', '2018-08-16 09:47:12', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20180816\', `user_lastlogin_time` = \'94712\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(463, 'user', 1, 'update', '2018-10-09 16:45:31', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(464, 'user', 1, 'update', '2018-10-09 16:45:37', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(465, 'user', 1, 'update', '2018-10-09 16:45:41', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20181009\', `user_lastlogin_time` = \'164541\', `user_loginerror` = 0 WHERE `user_id` = \'1\''),
(466, 'user', 1, 'update', '2018-10-10 09:58:05', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(467, 'user', 1, 'update', '2018-10-10 09:58:13', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(468, 'user', 1, 'update', '2018-10-10 09:58:21', 0, 'UPDATE `lmsv2_user` SET `user_loginerror` = 1 WHERE `user_type` <> 0 AND `user_id` = \'1\''),
(469, 'user', 1, 'update', '2018-10-10 09:58:28', 0, 'UPDATE `lmsv2_user` SET `user_lastlogin_date` = \'20181010\', `user_lastlogin_time` = \'95828\', `user_loginerror` = 0 WHERE `user_id` = \'1\'');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_lokasi`
--

CREATE TABLE `lmsv2_lokasi` (
  `lokasi_id` int(11) NOT NULL,
  `lokasi_kota` varchar(100) DEFAULT NULL,
  `lokasi_alamat` varchar(255) DEFAULT NULL,
  `lokasi_creator` int(11) DEFAULT NULL,
  `lokasi_created` int(11) DEFAULT NULL,
  `lokasi_status` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_module`
--

CREATE TABLE `lmsv2_module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `module_desc` varchar(255) DEFAULT NULL,
  `module_status` int(11) DEFAULT '1',
  `module_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `lmsv2_order` (
  `order_id` int(11) NOT NULL,
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
  `order_resetted_date` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order_catalog`
--

CREATE TABLE `lmsv2_order_catalog` (
  `order_catalog_id` int(11) NOT NULL,
  `order_catalog_order` int(11) DEFAULT NULL COMMENT 'FK table order',
  `order_catalog_catalog` int(11) DEFAULT NULL,
  `order_catalog_period` int(11) DEFAULT NULL,
  `order_catalog_status` int(11) DEFAULT '1' COMMENT '1=baru',
  `order_catalog_rejected` int(11) DEFAULT NULL,
  `order_catalog_rejected_date` timestamp NULL DEFAULT NULL,
  `order_catalog_rejected_comment` text,
  `order_catalog_repropose` int(11) DEFAULT '0' COMMENT '1=catalog direpropose'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order_catalog_report`
--

CREATE TABLE `lmsv2_order_catalog_report` (
  `order_catalog_report_id` int(11) NOT NULL,
  `order_catalog_report_catalog` int(11) DEFAULT NULL,
  `order_catalog_report_user` int(11) DEFAULT NULL,
  `order_catalog_report_order` int(11) DEFAULT NULL,
  `order_catalog_report_status` int(11) DEFAULT '0',
  `order_catalog_report_approved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_catalog_report_approver` int(11) DEFAULT NULL COMMENT 'yang mengapprove'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_order_externaldata`
--

CREATE TABLE `lmsv2_order_externaldata` (
  `externaldata_id` int(11) NOT NULL,
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
  `externaldata_repropose` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_password_hist`
--

CREATE TABLE `lmsv2_password_hist` (
  `phis_id` int(11) NOT NULL,
  `pass_hist_user_id` int(11) NOT NULL,
  `pass_hist_user_npk` varchar(10) NOT NULL,
  `pass_hist_user_pass` varchar(100) NOT NULL,
  `pass_hist_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_password_hist`
--

INSERT INTO `lmsv2_password_hist` (`phis_id`, `pass_hist_user_id`, `pass_hist_user_npk`, `pass_hist_user_pass`, `pass_hist_created`) VALUES
(1, 1, '999999', '382e0360e4eb7b70034fbaa69bec5786', '2018-03-09 10:44:24'),
(2, 1, '999999', '52c69e3a57331081823331c4e69d3f2e', '2018-03-09 10:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference`
--

CREATE TABLE `lmsv2_reference` (
  `reference_id` int(11) NOT NULL,
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
  `reference_allstaff` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_function`
--

CREATE TABLE `lmsv2_reference_function` (
  `reference_function_id` int(11) NOT NULL,
  `reference_function_reference` int(11) DEFAULT NULL,
  `reference_function_function` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_jabatan`
--

CREATE TABLE `lmsv2_reference_jabatan` (
  `reference_jabatan_id` int(11) NOT NULL,
  `reference_jabatan_jabatan` int(11) DEFAULT NULL,
  `reference_jabatan_reference` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_levelgroup`
--

CREATE TABLE `lmsv2_reference_levelgroup` (
  `reference_levelgroup_id` int(11) NOT NULL,
  `reference_levelgroup_reference` int(11) DEFAULT NULL,
  `reference_levelgroup_levelgroup` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reference_npk`
--

CREATE TABLE `lmsv2_reference_npk` (
  `reference_npk_id` int(11) NOT NULL,
  `reference_npk_npk` int(11) DEFAULT NULL,
  `reference_npk_reference` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reminder`
--

CREATE TABLE `lmsv2_reminder` (
  `reminder_id` int(11) NOT NULL,
  `reminder_date` int(11) DEFAULT NULL,
  `reminder_from` varchar(255) DEFAULT NULL,
  `reminder_user` int(11) DEFAULT NULL,
  `reminder_message` text,
  `reminder_training` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reminderext`
--

CREATE TABLE `lmsv2_reminderext` (
  `reminder_id` int(11) NOT NULL,
  `reminder_training_id` int(11) DEFAULT NULL COMMENT 'training, classroom, certificate',
  `reminder_schedule` int(11) DEFAULT NULL COMMENT 'dalam hari',
  `reminder_condition` int(11) DEFAULT NULL COMMENT '-1=all period,0=tidak ada,>0 n hari',
  `reminder_status` int(11) DEFAULT '1' COMMENT '1=aktif',
  `reminder_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reminder_creator` int(11) DEFAULT NULL,
  `reminder_type` varchar(32) DEFAULT NULL,
  `reminder_deadline_date` varchar(100) NOT NULL,
  `reminder_deadline_month` int(11) NOT NULL,
  `reminder_deadline_year` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_reminderuser`
--

CREATE TABLE `lmsv2_reminderuser` (
  `reminderuser_id` int(11) NOT NULL,
  `reminderuser_user` int(11) DEFAULT NULL,
  `reminderuser_email` varchar(100) DEFAULT NULL,
  `reminderuser_status` int(11) DEFAULT '1' COMMENT '1=aktif',
  `reminderuser_reminder` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_bi_category`
--

CREATE TABLE `lmsv2_request_bi_category` (
  `bict_id` int(11) NOT NULL,
  `bict_name` varchar(100) NOT NULL,
  `bict_entryuser` varchar(100) NOT NULL,
  `bict_entrydate` datetime NOT NULL,
  `bict_changeuser` varchar(100) NOT NULL,
  `bict_changedate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_jenis_pendidikan`
--

CREATE TABLE `lmsv2_request_jenis_pendidikan` (
  `jepd_id` int(11) NOT NULL,
  `jepd_name` varchar(100) NOT NULL,
  `jepd_entryuser` varchar(100) NOT NULL,
  `jepd_entrydate` datetime NOT NULL,
  `jepd_changeuser` varchar(100) NOT NULL,
  `jepd_changedate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training`
--

CREATE TABLE `lmsv2_request_training` (
  `rqtr_id` int(11) NOT NULL,
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
  `rqtr_updatetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training_approval`
--

CREATE TABLE `lmsv2_request_training_approval` (
  `trap_id` int(11) NOT NULL,
  `trap_rqtr_id` int(11) NOT NULL,
  `trap_jabatan` varchar(100) DEFAULT NULL,
  `trap_step_order_no` int(11) NOT NULL,
  `trap_user_id` int(11) DEFAULT NULL,
  `trap_status_approval` tinyint(4) NOT NULL,
  `trap_reason_approval` text NOT NULL,
  `trap_entryuser` varchar(200) NOT NULL,
  `trap_entrytime` datetime NOT NULL,
  `trap_updateuser` varchar(200) NOT NULL,
  `trap_updatetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training_default`
--

CREATE TABLE `lmsv2_request_training_default` (
  `trdf_id` int(11) NOT NULL,
  `trdf_jabatan_request` varchar(100) NOT NULL,
  `trdf_jabatan_approval` text NOT NULL,
  `trdf_entryuser` varchar(100) NOT NULL,
  `trdf_entrydate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_request_training_setting`
--

CREATE TABLE `lmsv2_request_training_setting` (
  `trse_id` int(11) NOT NULL,
  `trse_rqtr_id` int(11) NOT NULL,
  `trse_user_step_approval` text NOT NULL,
  `trse_user_approval` text NOT NULL,
  `trse_total_user_approval` tinyint(4) NOT NULL,
  `trse_one_approval_status` int(11) NOT NULL,
  `trse_entryuser` varchar(100) NOT NULL,
  `trse_entrytime` datetime NOT NULL,
  `trse_changeuser` varchar(100) NOT NULL,
  `trse_changetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_right`
--

CREATE TABLE `lmsv2_right` (
  `right_id` int(11) NOT NULL,
  `right_name` varchar(100) DEFAULT NULL,
  `right_creator` int(11) DEFAULT NULL,
  `right_created` int(11) DEFAULT NULL,
  `right_status` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `lmsv2_right_module` (
  `right_module_id` int(11) NOT NULL,
  `right_module_module` int(11) DEFAULT NULL,
  `right_module_right` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `lmsv2_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_sessions`
--

INSERT INTO `lmsv2_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('e8a859d19e55f5a2c8b8072b7ebd8c23', '158.140.187.201', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12) Appl', 1539141289, 'a:2:{s:8:\"referrer\";s:49:\"http://neolyceum.net/lms/ksei/index.php/user/info\";s:8:\"lms_sess\";s:1135:\"a:38:{s:7:\"user_id\";s:1:\"1\";s:8:\"user_npk\";s:6:\"999999\";s:9:\"user_pass\";s:32:\"52c69e3a57331081823331c4e69d3f2e\";s:15:\"user_first_name\";s:5:\"admin\";s:14:\"user_last_name\";s:3:\"lms\";s:14:\"user_join_date\";s:8:\"20100219\";s:14:\"user_birthdate\";s:8:\"19760104\";s:16:\"user_description\";s:9:\"developer\";s:13:\"user_location\";s:1:\"0\";s:9:\"user_type\";s:1:\"0\";s:19:\"user_lastlogin_date\";s:8:\"20181009\";s:19:\"user_lastlogin_time\";s:6:\"164541\";s:12:\"user_creator\";s:1:\"0\";s:17:\"user_created_date\";s:1:\"0\";s:17:\"user_created_time\";s:1:\"0\";s:10:\"user_email\";s:20:\"admin@learning.co.id\";s:13:\"user_function\";s:1:\"0\";s:12:\"user_jabatan\";s:1:\"0\";s:11:\"user_status\";s:1:\"1\";s:8:\"user_emp\";s:1:\"0\";s:23:\"user_forgotpass_confirm\";N;s:20:\"user_forgotpass_date\";N;s:25:\"user_lastmodifiedpassword\";s:8:\"20180309\";s:15:\"user_loginerror\";s:1:\"0\";s:11:\"user_import\";N;s:15:\"user_grade_code\";N;s:15:\"user_npk_atasan\";N;s:9:\"user_telp\";s:0:\"\";s:7:\"user_fb\";s:0:\"\";s:12:\"user_twitter\";s:0:\"\";s:14:\"user_instagram\";s:0:\"\";s:9:\"user_city\";s:0:\"\";s:8:\"right_id\";N;s:10:\"right_name\";N;s:13:\"right_creator\";N;s:13:\"right_created\";N;s:12:\"right_status\";N;s:7:\"asadmin\";i:1;}\";}');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training`
--

CREATE TABLE `lmsv2_training` (
  `training_id` int(11) NOT NULL,
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
  `training_data` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_training`
--

INSERT INTO `lmsv2_training` (`training_id`, `training_topic`, `training_name`, `training_desc`, `training_author_firstname`, `training_author_lastname`, `training_author_inital`, `training_author_email`, `training_author_id`, `training_created_date`, `training_creator`, `training_status`, `training_material`, `training_all_staff`, `training_max`, `training_material_type`, `training_type`, `training_pass`, `training_duration`, `training_total_question`, `training_setting_jmlsoal`, `training_setting_bobotmudah`, `training_setting_bobotsedang`, `training_setting_bobotsulit`, `training_durationperquestion`, `training_banksoal`, `training_code`, `training_cost`, `training_intro`, `training_refreshment`, `training_kelompok`, `training_grade`, `training_learning_method`, `training_instructor`, `training_organization`, `training_address`, `training_objective`, `training_tag`, `training_catalog_status`, `training_created_time`, `training_modified`, `training_modifier`, `training_cert_tpl`, `training_data`) VALUES
(1, 2, 'Modul 0', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20180321, 1, 1, NULL, 1, NULL, 1, 1, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000001', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-21 06:36:13', 1, '', ''),
(2, 2, 'Test', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20180401, 1, 1, '/MATERIAL/TRN-00001', 0, NULL, 2, 1, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000002', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-01 05:39:15', 1, '', ''),
(3, 2, 'Modul 1', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20180402, 1, 1, NULL, 0, NULL, 1, 1, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000003', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-02 03:11:30', 1, '', ''),
(4, 2, 'Test 1', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20180409, 1, 1, NULL, 0, NULL, 1, 1, NULL, 3600, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000004', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-09 15:06:01', 1, '', ''),
(5, 2, 'Test 2', '', 'admin', 'lms', '', 'admin@learning.co.id', 1, 20180409, 1, 1, 'TRN-000005', 0, NULL, 1, 1, NULL, 3600, NULL, 0, 0, 0, 0, 0, 0, 'TRN-000005', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-09 15:09:00', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_catalog`
--

CREATE TABLE `lmsv2_training_catalog` (
  `catalog_id` int(11) NOT NULL,
  `catalog_category_id` int(11) DEFAULT NULL,
  `catalog_training_type` varchar(100) DEFAULT NULL,
  `catalog_status` tinyint(4) DEFAULT NULL,
  `catalog_created_by` int(11) DEFAULT NULL,
  `catalog_created_time` datetime DEFAULT NULL,
  `catalog_modified_by` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_catjabatan`
--

CREATE TABLE `lmsv2_training_catjabatan` (
  `training_catjabatan_id` int(11) NOT NULL,
  `training_catjabatan_training` int(11) DEFAULT NULL,
  `training_catjabatan_category` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_exam`
--

CREATE TABLE `lmsv2_training_exam` (
  `training_exam_id` int(11) NOT NULL,
  `training_exam_training` int(11) DEFAULT NULL,
  `training_exam_banksoal` int(11) DEFAULT NULL,
  `training_exam_type` int(11) DEFAULT '1' COMMENT '1=praexam;2=exam',
  `training_exam_max` int(11) DEFAULT NULL,
  `training_exam_pass` float DEFAULT NULL,
  `training_exam_jmlsoal` int(11) DEFAULT NULL,
  `training_exam_duration` int(11) NOT NULL,
  `training_exam_durationperquestion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_function`
--

CREATE TABLE `lmsv2_training_function` (
  `training_function_id` int(11) NOT NULL,
  `training_function_training` int(11) DEFAULT NULL,
  `training_function_function` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_jabatan`
--

CREATE TABLE `lmsv2_training_jabatan` (
  `training_jabatan_id` int(11) NOT NULL,
  `training_jabatan_training` int(11) DEFAULT NULL,
  `training_jabatan_jabatan` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_levelgroup`
--

CREATE TABLE `lmsv2_training_levelgroup` (
  `training_levelgroup_id` int(11) NOT NULL,
  `training_levelgroup_training` int(11) DEFAULT NULL,
  `training_levelgroup_levelgroup` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_lokasi`
--

CREATE TABLE `lmsv2_training_lokasi` (
  `training_lokasi_id` int(11) NOT NULL,
  `training_lokasi_lokasi` int(11) DEFAULT NULL,
  `training_lokasi_training` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_npk`
--

CREATE TABLE `lmsv2_training_npk` (
  `training_npk_id` int(11) NOT NULL,
  `training_npk_npk` int(11) DEFAULT NULL,
  `training_npk_training` int(11) DEFAULT NULL,
  `training_npk_time_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_training_npk`
--

INSERT INTO `lmsv2_training_npk` (`training_npk_id`, `training_npk_npk`, `training_npk_training`, `training_npk_time_id`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_postrequisite`
--

CREATE TABLE `lmsv2_training_postrequisite` (
  `training_postrequisite_id` int(11) NOT NULL,
  `training_postrequisite_training` int(11) DEFAULT NULL,
  `training_postrequisite_postrequisite` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_prequisite`
--

CREATE TABLE `lmsv2_training_prequisite` (
  `training_prequisite_id` int(11) NOT NULL,
  `training_prequisite_training` int(11) DEFAULT NULL,
  `training_prequisite_prequisite` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_time`
--

CREATE TABLE `lmsv2_training_time` (
  `training_time_id` int(11) NOT NULL,
  `training_time_date1` int(11) DEFAULT NULL,
  `training_time_date2` int(11) DEFAULT NULL,
  `training_time_period` int(11) DEFAULT NULL,
  `training_time_training` int(11) DEFAULT NULL,
  `training_time_parent` int(11) DEFAULT '0',
  `training_time_refreshed` int(11) DEFAULT '0' COMMENT 'apakah sudah direfresh'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_training_time`
--

INSERT INTO `lmsv2_training_time` (`training_time_id`, `training_time_date1`, `training_time_date2`, `training_time_period`, `training_time_training`, `training_time_parent`, `training_time_refreshed`) VALUES
(1, 20180401, 20180430, 0, 5, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_training_user`
--

CREATE TABLE `lmsv2_training_user` (
  `training_user_id` int(11) NOT NULL,
  `training_user_training` int(11) DEFAULT NULL,
  `training_user_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lmsv2_user`
--

CREATE TABLE `lmsv2_user` (
  `user_id` int(11) NOT NULL,
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
  `user_city` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lmsv2_user`
--

INSERT INTO `lmsv2_user` (`user_id`, `user_npk`, `user_pass`, `user_first_name`, `user_last_name`, `user_join_date`, `user_birthdate`, `user_description`, `user_location`, `user_type`, `user_lastlogin_date`, `user_lastlogin_time`, `user_creator`, `user_created_date`, `user_created_time`, `user_email`, `user_function`, `user_jabatan`, `user_status`, `user_emp`, `user_forgotpass_confirm`, `user_forgotpass_date`, `user_lastmodifiedpassword`, `user_loginerror`, `user_import`, `user_grade_code`, `user_npk_atasan`, `user_telp`, `user_fb`, `user_twitter`, `user_instagram`, `user_city`) VALUES
(1, '999999', '52c69e3a57331081823331c4e69d3f2e', 'admin', 'lms', 20100219, 19760104, 'developer', 0, 0, 20181010, 95828, 0, 0, 0, 'admin@learning.co.id', 0, 0, 1, 0, NULL, NULL, 20180309, 0, NULL, NULL, NULL, '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lmsv2_banksoal`
--
ALTER TABLE `lmsv2_banksoal`
  ADD PRIMARY KEY (`banksoal_id`),
  ADD UNIQUE KEY `NewIndex1` (`banksoal_name`,`banksoal_type`);

--
-- Indexes for table `lmsv2_banksoal_answer`
--
ALTER TABLE `lmsv2_banksoal_answer`
  ADD PRIMARY KEY (`banksoal_answer_id`),
  ADD KEY `NewIndex1` (`banksoal_answer_question`);

--
-- Indexes for table `lmsv2_banksoal_answer_archive`
--
ALTER TABLE `lmsv2_banksoal_answer_archive`
  ADD PRIMARY KEY (`banksoal_answer_id`),
  ADD KEY `NewIndex1` (`banksoal_answer_question`);

--
-- Indexes for table `lmsv2_banksoal_jabatan`
--
ALTER TABLE `lmsv2_banksoal_jabatan`
  ADD PRIMARY KEY (`banksoal_jabatan_id`);

--
-- Indexes for table `lmsv2_banksoal_question`
--
ALTER TABLE `lmsv2_banksoal_question`
  ADD PRIMARY KEY (`banksoal_question_id`),
  ADD KEY `NewIndex1` (`banksoal_question_banksoal`),
  ADD KEY `idx_banksoal_packet` (`banksoal_question_packet`);

--
-- Indexes for table `lmsv2_banksoal_question_archive`
--
ALTER TABLE `lmsv2_banksoal_question_archive`
  ADD PRIMARY KEY (`banksoal_question_id`),
  ADD KEY `NewIndex1` (`banksoal_question_banksoal`);

--
-- Indexes for table `lmsv2_banksoal_unit`
--
ALTER TABLE `lmsv2_banksoal_unit`
  ADD PRIMARY KEY (`banksoal_unit_id`),
  ADD UNIQUE KEY `NewIndex1` (`banksoal_unit_name`,`banksoal_unit_banksoal`);

--
-- Indexes for table `lmsv2_banksoal_unit_setting`
--
ALTER TABLE `lmsv2_banksoal_unit_setting`
  ADD PRIMARY KEY (`banksoal_unit_setting_id`),
  ADD UNIQUE KEY `NewIndex1` (`banksoal_unit_setting_unit`,`banksoal_unit_setting_training`);

--
-- Indexes for table `lmsv2_catalog_grade`
--
ALTER TABLE `lmsv2_catalog_grade`
  ADD PRIMARY KEY (`catalog_grade_id`);

--
-- Indexes for table `lmsv2_category`
--
ALTER TABLE `lmsv2_category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `NewIndex1` (`category_name`,`category_parent`);

--
-- Indexes for table `lmsv2_catjabatan`
--
ALTER TABLE `lmsv2_catjabatan`
  ADD PRIMARY KEY (`catjabatan_id`),
  ADD UNIQUE KEY `NewIndex1` (`catjabatan_name`,`catjabatan_parent`);

--
-- Indexes for table `lmsv2_cms_news`
--
ALTER TABLE `lmsv2_cms_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `lmsv2_cron`
--
ALTER TABLE `lmsv2_cron`
  ADD PRIMARY KEY (`cron_id`);

--
-- Indexes for table `lmsv2_delegetion`
--
ALTER TABLE `lmsv2_delegetion`
  ADD PRIMARY KEY (`delegetion_id`),
  ADD UNIQUE KEY `NewIndex1` (`delegetion_training`,`delegetion_user`,`delegetion_creator`);

--
-- Indexes for table `lmsv2_delegetion_ildp`
--
ALTER TABLE `lmsv2_delegetion_ildp`
  ADD PRIMARY KEY (`delegetion_ildp_id`),
  ADD UNIQUE KEY `NewIndex1` (`delegetion_ildp_user`,`delegetion_ildp_delegator`),
  ADD KEY `NewIndex2` (`delegetion_ildp_status`),
  ADD KEY `NewIndex3` (`delegetion_ildp_user`);

--
-- Indexes for table `lmsv2_events`
--
ALTER TABLE `lmsv2_events`
  ADD PRIMARY KEY (`evnt_id`);

--
-- Indexes for table `lmsv2_function`
--
ALTER TABLE `lmsv2_function`
  ADD PRIMARY KEY (`function_id`),
  ADD UNIQUE KEY `NewIndex1` (`function_desc`,`function_jabatan`),
  ADD KEY `NewIndex2` (`function_creator`);

--
-- Indexes for table `lmsv2_general_setting`
--
ALTER TABLE `lmsv2_general_setting`
  ADD KEY `general_setting_code` (`general_setting_code`);

--
-- Indexes for table `lmsv2_grade`
--
ALTER TABLE `lmsv2_grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD UNIQUE KEY `NewIndex1` (`grade_code`);

--
-- Indexes for table `lmsv2_history_answer`
--
ALTER TABLE `lmsv2_history_answer`
  ADD PRIMARY KEY (`history_answer_id`),
  ADD KEY `NewIndex1` (`history_answer_question`),
  ADD KEY `NewIndex2` (`history_answer_answer`),
  ADD KEY `NewIndex3` (`history_answer_history_exam`);

--
-- Indexes for table `lmsv2_history_exam`
--
ALTER TABLE `lmsv2_history_exam`
  ADD PRIMARY KEY (`history_exam_id`),
  ADD KEY `NewIndex1` (`history_exam_training`),
  ADD KEY `NewIndex2` (`history_exam_user`),
  ADD KEY `NewIndex3` (`history_exam_lokasi`);

--
-- Indexes for table `lmsv2_history_reference`
--
ALTER TABLE `lmsv2_history_reference`
  ADD PRIMARY KEY (`history_reference_id`);

--
-- Indexes for table `lmsv2_hrld`
--
ALTER TABLE `lmsv2_hrld`
  ADD PRIMARY KEY (`hrld_id`),
  ADD UNIQUE KEY `NewIndex1` (`hrld_npk`,`hrld_category`);

--
-- Indexes for table `lmsv2_hrrm`
--
ALTER TABLE `lmsv2_hrrm`
  ADD PRIMARY KEY (`hrrm_id`),
  ADD UNIQUE KEY `NewIndex1` (`hrrm_npk`,`hrrm_group`);

--
-- Indexes for table `lmsv2_ildp_catalog`
--
ALTER TABLE `lmsv2_ildp_catalog`
  ADD PRIMARY KEY (`ildp_catalog_id`),
  ADD UNIQUE KEY `abb_unique` (`ildp_catalog_course_abb`(6));

--
-- Indexes for table `lmsv2_ildp_catalog_method`
--
ALTER TABLE `lmsv2_ildp_catalog_method`
  ADD PRIMARY KEY (`ildp_catalog_method_id`),
  ADD UNIQUE KEY `ildp_catalog_method_unique` (`ildp_catalog_method_catalog`,`ildp_catalog_method_method`);

--
-- Indexes for table `lmsv2_ildp_category`
--
ALTER TABLE `lmsv2_ildp_category`
  ADD PRIMARY KEY (`ildp_category_id`),
  ADD UNIQUE KEY `ildp_category_unique` (`ildp_category_name`,`ildp_category_parent`);

--
-- Indexes for table `lmsv2_ildp_detail`
--
ALTER TABLE `lmsv2_ildp_detail`
  ADD PRIMARY KEY (`ildp_detail_id`);

--
-- Indexes for table `lmsv2_ildp_detail_trail`
--
ALTER TABLE `lmsv2_ildp_detail_trail`
  ADD PRIMARY KEY (`ildp_detail_trail_id`);

--
-- Indexes for table `lmsv2_ildp_development_area`
--
ALTER TABLE `lmsv2_ildp_development_area`
  ADD PRIMARY KEY (`dev_area_id`);

--
-- Indexes for table `lmsv2_ildp_form`
--
ALTER TABLE `lmsv2_ildp_form`
  ADD PRIMARY KEY (`ildp_id`),
  ADD UNIQUE KEY `ild_form_unique` (`ildp_form_ildp_period`,`ildp_user_id`);

--
-- Indexes for table `lmsv2_ildp_form_trail`
--
ALTER TABLE `lmsv2_ildp_form_trail`
  ADD PRIMARY KEY (`ildp_trail_id`);

--
-- Indexes for table `lmsv2_ildp_method`
--
ALTER TABLE `lmsv2_ildp_method`
  ADD PRIMARY KEY (`ildp_method_id`),
  ADD UNIQUE KEY `ildp_method_name` (`ildp_method_name`);

--
-- Indexes for table `lmsv2_ildp_registration_period`
--
ALTER TABLE `lmsv2_ildp_registration_period`
  ADD PRIMARY KEY (`ildp_registration_period_id`),
  ADD UNIQUE KEY `ildp_registration_period_unique` (`ildp_registration_period_start`,`ildp_registration_period_end`);

--
-- Indexes for table `lmsv2_ildp_trail_old`
--
ALTER TABLE `lmsv2_ildp_trail_old`
  ADD PRIMARY KEY (`ildp_trail_id`);

--
-- Indexes for table `lmsv2_import`
--
ALTER TABLE `lmsv2_import`
  ADD PRIMARY KEY (`import_id`);

--
-- Indexes for table `lmsv2_jabatan`
--
ALTER TABLE `lmsv2_jabatan`
  ADD PRIMARY KEY (`jabatan_id`),
  ADD UNIQUE KEY `NewIndex1` (`jabatan_name`,`jabatan_level_group`),
  ADD KEY `NewIndex6` (`jabatan_creator`),
  ADD KEY `NewIndex7` (`jabatan_level_group`);

--
-- Indexes for table `lmsv2_level`
--
ALTER TABLE `lmsv2_level`
  ADD PRIMARY KEY (`level_id`),
  ADD UNIQUE KEY `NewIndex1` (`level_name`,`level_parent`);

--
-- Indexes for table `lmsv2_level_group`
--
ALTER TABLE `lmsv2_level_group`
  ADD PRIMARY KEY (`level_group_id`),
  ADD UNIQUE KEY `NewIndex2` (`level_group_name`,`level_group_parent`),
  ADD KEY `NewIndex1` (`level_group_parent`);

--
-- Indexes for table `lmsv2_log`
--
ALTER TABLE `lmsv2_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `lmsv2_logs`
--
ALTER TABLE `lmsv2_logs`
  ADD PRIMARY KEY (`logs_id`);

--
-- Indexes for table `lmsv2_lokasi`
--
ALTER TABLE `lmsv2_lokasi`
  ADD PRIMARY KEY (`lokasi_id`);

--
-- Indexes for table `lmsv2_module`
--
ALTER TABLE `lmsv2_module`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `NewIndex1` (`module_name`);

--
-- Indexes for table `lmsv2_order`
--
ALTER TABLE `lmsv2_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `lmsv2_order_catalog`
--
ALTER TABLE `lmsv2_order_catalog`
  ADD PRIMARY KEY (`order_catalog_id`);

--
-- Indexes for table `lmsv2_order_catalog_report`
--
ALTER TABLE `lmsv2_order_catalog_report`
  ADD PRIMARY KEY (`order_catalog_report_id`);

--
-- Indexes for table `lmsv2_order_externaldata`
--
ALTER TABLE `lmsv2_order_externaldata`
  ADD PRIMARY KEY (`externaldata_id`);

--
-- Indexes for table `lmsv2_password_hist`
--
ALTER TABLE `lmsv2_password_hist`
  ADD PRIMARY KEY (`phis_id`);

--
-- Indexes for table `lmsv2_reference`
--
ALTER TABLE `lmsv2_reference`
  ADD PRIMARY KEY (`reference_id`),
  ADD UNIQUE KEY `NewIndex1` (`reference_name`,`reference_topic`),
  ADD KEY `NewIndex2` (`reference_creator`);

--
-- Indexes for table `lmsv2_reference_function`
--
ALTER TABLE `lmsv2_reference_function`
  ADD PRIMARY KEY (`reference_function_id`),
  ADD KEY `NewIndex1` (`reference_function_reference`),
  ADD KEY `NewIndex2` (`reference_function_function`);

--
-- Indexes for table `lmsv2_reference_jabatan`
--
ALTER TABLE `lmsv2_reference_jabatan`
  ADD PRIMARY KEY (`reference_jabatan_id`),
  ADD KEY `NewIndex1` (`reference_jabatan_jabatan`),
  ADD KEY `NewIndex2` (`reference_jabatan_reference`);

--
-- Indexes for table `lmsv2_reference_levelgroup`
--
ALTER TABLE `lmsv2_reference_levelgroup`
  ADD PRIMARY KEY (`reference_levelgroup_id`),
  ADD KEY `NewIndex1` (`reference_levelgroup_reference`),
  ADD KEY `NewIndex2` (`reference_levelgroup_levelgroup`);

--
-- Indexes for table `lmsv2_reference_npk`
--
ALTER TABLE `lmsv2_reference_npk`
  ADD PRIMARY KEY (`reference_npk_id`),
  ADD KEY `NewIndex1` (`reference_npk_npk`),
  ADD KEY `NewIndex2` (`reference_npk_reference`);

--
-- Indexes for table `lmsv2_reminder`
--
ALTER TABLE `lmsv2_reminder`
  ADD PRIMARY KEY (`reminder_id`),
  ADD KEY `NewIndex1` (`reminder_training`),
  ADD KEY `NewIndex2` (`reminder_user`);

--
-- Indexes for table `lmsv2_reminderext`
--
ALTER TABLE `lmsv2_reminderext`
  ADD PRIMARY KEY (`reminder_id`);

--
-- Indexes for table `lmsv2_reminderuser`
--
ALTER TABLE `lmsv2_reminderuser`
  ADD PRIMARY KEY (`reminderuser_id`);

--
-- Indexes for table `lmsv2_request_bi_category`
--
ALTER TABLE `lmsv2_request_bi_category`
  ADD PRIMARY KEY (`bict_id`);

--
-- Indexes for table `lmsv2_request_jenis_pendidikan`
--
ALTER TABLE `lmsv2_request_jenis_pendidikan`
  ADD PRIMARY KEY (`jepd_id`);

--
-- Indexes for table `lmsv2_request_training`
--
ALTER TABLE `lmsv2_request_training`
  ADD PRIMARY KEY (`rqtr_id`);

--
-- Indexes for table `lmsv2_request_training_approval`
--
ALTER TABLE `lmsv2_request_training_approval`
  ADD PRIMARY KEY (`trap_id`);

--
-- Indexes for table `lmsv2_request_training_default`
--
ALTER TABLE `lmsv2_request_training_default`
  ADD PRIMARY KEY (`trdf_id`);

--
-- Indexes for table `lmsv2_request_training_setting`
--
ALTER TABLE `lmsv2_request_training_setting`
  ADD PRIMARY KEY (`trse_id`);

--
-- Indexes for table `lmsv2_right`
--
ALTER TABLE `lmsv2_right`
  ADD PRIMARY KEY (`right_id`),
  ADD UNIQUE KEY `NewIndex1` (`right_name`);

--
-- Indexes for table `lmsv2_right_module`
--
ALTER TABLE `lmsv2_right_module`
  ADD PRIMARY KEY (`right_module_id`),
  ADD UNIQUE KEY `NewIndex1` (`right_module_module`,`right_module_right`);

--
-- Indexes for table `lmsv2_sessions`
--
ALTER TABLE `lmsv2_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `lmsv2_training`
--
ALTER TABLE `lmsv2_training`
  ADD PRIMARY KEY (`training_id`),
  ADD UNIQUE KEY `NewIndex1` (`training_topic`,`training_name`),
  ADD UNIQUE KEY `NewIndex4` (`training_code`,`training_type`),
  ADD KEY `NewIndex2` (`training_author_id`),
  ADD KEY `NewIndex3` (`training_creator`),
  ADD KEY `idx_training_banksoal` (`training_banksoal`);

--
-- Indexes for table `lmsv2_training_catalog`
--
ALTER TABLE `lmsv2_training_catalog`
  ADD PRIMARY KEY (`catalog_id`);

--
-- Indexes for table `lmsv2_training_catjabatan`
--
ALTER TABLE `lmsv2_training_catjabatan`
  ADD PRIMARY KEY (`training_catjabatan_id`),
  ADD UNIQUE KEY `NewIndex1` (`training_catjabatan_training`,`training_catjabatan_category`);

--
-- Indexes for table `lmsv2_training_exam`
--
ALTER TABLE `lmsv2_training_exam`
  ADD PRIMARY KEY (`training_exam_id`),
  ADD KEY `NewIndex1` (`training_exam_training`),
  ADD KEY `NewIndex2` (`training_exam_banksoal`);

--
-- Indexes for table `lmsv2_training_function`
--
ALTER TABLE `lmsv2_training_function`
  ADD PRIMARY KEY (`training_function_id`),
  ADD UNIQUE KEY `NewIndex1` (`training_function_training`,`training_function_function`);

--
-- Indexes for table `lmsv2_training_jabatan`
--
ALTER TABLE `lmsv2_training_jabatan`
  ADD PRIMARY KEY (`training_jabatan_id`),
  ADD UNIQUE KEY `NewIndex1` (`training_jabatan_training`,`training_jabatan_jabatan`);

--
-- Indexes for table `lmsv2_training_levelgroup`
--
ALTER TABLE `lmsv2_training_levelgroup`
  ADD PRIMARY KEY (`training_levelgroup_id`),
  ADD KEY `NewIndex1` (`training_levelgroup_training`),
  ADD KEY `NewIndex2` (`training_levelgroup_levelgroup`);

--
-- Indexes for table `lmsv2_training_lokasi`
--
ALTER TABLE `lmsv2_training_lokasi`
  ADD PRIMARY KEY (`training_lokasi_id`),
  ADD KEY `NewIndex1` (`training_lokasi_lokasi`),
  ADD KEY `NewIndex2` (`training_lokasi_training`);

--
-- Indexes for table `lmsv2_training_npk`
--
ALTER TABLE `lmsv2_training_npk`
  ADD PRIMARY KEY (`training_npk_id`),
  ADD KEY `NewIndex1` (`training_npk_training`),
  ADD KEY `NewIndex2` (`training_npk_npk`);

--
-- Indexes for table `lmsv2_training_postrequisite`
--
ALTER TABLE `lmsv2_training_postrequisite`
  ADD PRIMARY KEY (`training_postrequisite_id`),
  ADD UNIQUE KEY `NewIndex1` (`training_postrequisite_training`,`training_postrequisite_postrequisite`);

--
-- Indexes for table `lmsv2_training_prequisite`
--
ALTER TABLE `lmsv2_training_prequisite`
  ADD PRIMARY KEY (`training_prequisite_id`),
  ADD UNIQUE KEY `NewIndex1` (`training_prequisite_training`,`training_prequisite_prequisite`);

--
-- Indexes for table `lmsv2_training_time`
--
ALTER TABLE `lmsv2_training_time`
  ADD PRIMARY KEY (`training_time_id`),
  ADD KEY `NewIndex1` (`training_time_training`);

--
-- Indexes for table `lmsv2_training_user`
--
ALTER TABLE `lmsv2_training_user`
  ADD PRIMARY KEY (`training_user_id`),
  ADD UNIQUE KEY `NewIndex1` (`training_user_training`,`training_user_user`);

--
-- Indexes for table `lmsv2_user`
--
ALTER TABLE `lmsv2_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `NewIndex1` (`user_npk`),
  ADD KEY `NewIndex6` (`user_type`),
  ADD KEY `NewIndex7` (`user_creator`),
  ADD KEY `NewIndex9` (`user_function`),
  ADD KEY `NewIndex10` (`user_jabatan`),
  ADD KEY `NewIndex2` (`user_location`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lmsv2_banksoal`
--
ALTER TABLE `lmsv2_banksoal`
  MODIFY `banksoal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_banksoal_answer`
--
ALTER TABLE `lmsv2_banksoal_answer`
  MODIFY `banksoal_answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_banksoal_answer_archive`
--
ALTER TABLE `lmsv2_banksoal_answer_archive`
  MODIFY `banksoal_answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_banksoal_jabatan`
--
ALTER TABLE `lmsv2_banksoal_jabatan`
  MODIFY `banksoal_jabatan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_banksoal_question`
--
ALTER TABLE `lmsv2_banksoal_question`
  MODIFY `banksoal_question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_banksoal_question_archive`
--
ALTER TABLE `lmsv2_banksoal_question_archive`
  MODIFY `banksoal_question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_banksoal_unit`
--
ALTER TABLE `lmsv2_banksoal_unit`
  MODIFY `banksoal_unit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_banksoal_unit_setting`
--
ALTER TABLE `lmsv2_banksoal_unit_setting`
  MODIFY `banksoal_unit_setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_catalog_grade`
--
ALTER TABLE `lmsv2_catalog_grade`
  MODIFY `catalog_grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_category`
--
ALTER TABLE `lmsv2_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lmsv2_catjabatan`
--
ALTER TABLE `lmsv2_catjabatan`
  MODIFY `catjabatan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_cms_news`
--
ALTER TABLE `lmsv2_cms_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_cron`
--
ALTER TABLE `lmsv2_cron`
  MODIFY `cron_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_delegetion`
--
ALTER TABLE `lmsv2_delegetion`
  MODIFY `delegetion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_delegetion_ildp`
--
ALTER TABLE `lmsv2_delegetion_ildp`
  MODIFY `delegetion_ildp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_events`
--
ALTER TABLE `lmsv2_events`
  MODIFY `evnt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_function`
--
ALTER TABLE `lmsv2_function`
  MODIFY `function_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_grade`
--
ALTER TABLE `lmsv2_grade`
  MODIFY `grade_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_history_answer`
--
ALTER TABLE `lmsv2_history_answer`
  MODIFY `history_answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_history_exam`
--
ALTER TABLE `lmsv2_history_exam`
  MODIFY `history_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `lmsv2_history_reference`
--
ALTER TABLE `lmsv2_history_reference`
  MODIFY `history_reference_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_hrld`
--
ALTER TABLE `lmsv2_hrld`
  MODIFY `hrld_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_hrrm`
--
ALTER TABLE `lmsv2_hrrm`
  MODIFY `hrrm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_catalog`
--
ALTER TABLE `lmsv2_ildp_catalog`
  MODIFY `ildp_catalog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_catalog_method`
--
ALTER TABLE `lmsv2_ildp_catalog_method`
  MODIFY `ildp_catalog_method_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_category`
--
ALTER TABLE `lmsv2_ildp_category`
  MODIFY `ildp_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_detail`
--
ALTER TABLE `lmsv2_ildp_detail`
  MODIFY `ildp_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_detail_trail`
--
ALTER TABLE `lmsv2_ildp_detail_trail`
  MODIFY `ildp_detail_trail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_development_area`
--
ALTER TABLE `lmsv2_ildp_development_area`
  MODIFY `dev_area_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_form`
--
ALTER TABLE `lmsv2_ildp_form`
  MODIFY `ildp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_form_trail`
--
ALTER TABLE `lmsv2_ildp_form_trail`
  MODIFY `ildp_trail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_method`
--
ALTER TABLE `lmsv2_ildp_method`
  MODIFY `ildp_method_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_registration_period`
--
ALTER TABLE `lmsv2_ildp_registration_period`
  MODIFY `ildp_registration_period_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_ildp_trail_old`
--
ALTER TABLE `lmsv2_ildp_trail_old`
  MODIFY `ildp_trail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_import`
--
ALTER TABLE `lmsv2_import`
  MODIFY `import_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_jabatan`
--
ALTER TABLE `lmsv2_jabatan`
  MODIFY `jabatan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_level`
--
ALTER TABLE `lmsv2_level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- AUTO_INCREMENT for table `lmsv2_level_group`
--
ALTER TABLE `lmsv2_level_group`
  MODIFY `level_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_log`
--
ALTER TABLE `lmsv2_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_logs`
--
ALTER TABLE `lmsv2_logs`
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=470;

--
-- AUTO_INCREMENT for table `lmsv2_lokasi`
--
ALTER TABLE `lmsv2_lokasi`
  MODIFY `lokasi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_module`
--
ALTER TABLE `lmsv2_module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lmsv2_order`
--
ALTER TABLE `lmsv2_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_order_catalog`
--
ALTER TABLE `lmsv2_order_catalog`
  MODIFY `order_catalog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_order_catalog_report`
--
ALTER TABLE `lmsv2_order_catalog_report`
  MODIFY `order_catalog_report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_order_externaldata`
--
ALTER TABLE `lmsv2_order_externaldata`
  MODIFY `externaldata_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_password_hist`
--
ALTER TABLE `lmsv2_password_hist`
  MODIFY `phis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lmsv2_reference`
--
ALTER TABLE `lmsv2_reference`
  MODIFY `reference_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_reference_function`
--
ALTER TABLE `lmsv2_reference_function`
  MODIFY `reference_function_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_reference_jabatan`
--
ALTER TABLE `lmsv2_reference_jabatan`
  MODIFY `reference_jabatan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_reference_levelgroup`
--
ALTER TABLE `lmsv2_reference_levelgroup`
  MODIFY `reference_levelgroup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_reference_npk`
--
ALTER TABLE `lmsv2_reference_npk`
  MODIFY `reference_npk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_reminder`
--
ALTER TABLE `lmsv2_reminder`
  MODIFY `reminder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_reminderext`
--
ALTER TABLE `lmsv2_reminderext`
  MODIFY `reminder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_reminderuser`
--
ALTER TABLE `lmsv2_reminderuser`
  MODIFY `reminderuser_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_request_bi_category`
--
ALTER TABLE `lmsv2_request_bi_category`
  MODIFY `bict_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_request_jenis_pendidikan`
--
ALTER TABLE `lmsv2_request_jenis_pendidikan`
  MODIFY `jepd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_request_training`
--
ALTER TABLE `lmsv2_request_training`
  MODIFY `rqtr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_request_training_approval`
--
ALTER TABLE `lmsv2_request_training_approval`
  MODIFY `trap_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_request_training_default`
--
ALTER TABLE `lmsv2_request_training_default`
  MODIFY `trdf_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_request_training_setting`
--
ALTER TABLE `lmsv2_request_training_setting`
  MODIFY `trse_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_right`
--
ALTER TABLE `lmsv2_right`
  MODIFY `right_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lmsv2_right_module`
--
ALTER TABLE `lmsv2_right_module`
  MODIFY `right_module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `lmsv2_training`
--
ALTER TABLE `lmsv2_training`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lmsv2_training_catalog`
--
ALTER TABLE `lmsv2_training_catalog`
  MODIFY `catalog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_catjabatan`
--
ALTER TABLE `lmsv2_training_catjabatan`
  MODIFY `training_catjabatan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_exam`
--
ALTER TABLE `lmsv2_training_exam`
  MODIFY `training_exam_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_function`
--
ALTER TABLE `lmsv2_training_function`
  MODIFY `training_function_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_jabatan`
--
ALTER TABLE `lmsv2_training_jabatan`
  MODIFY `training_jabatan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_levelgroup`
--
ALTER TABLE `lmsv2_training_levelgroup`
  MODIFY `training_levelgroup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_lokasi`
--
ALTER TABLE `lmsv2_training_lokasi`
  MODIFY `training_lokasi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_npk`
--
ALTER TABLE `lmsv2_training_npk`
  MODIFY `training_npk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lmsv2_training_postrequisite`
--
ALTER TABLE `lmsv2_training_postrequisite`
  MODIFY `training_postrequisite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_prequisite`
--
ALTER TABLE `lmsv2_training_prequisite`
  MODIFY `training_prequisite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_training_time`
--
ALTER TABLE `lmsv2_training_time`
  MODIFY `training_time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lmsv2_training_user`
--
ALTER TABLE `lmsv2_training_user`
  MODIFY `training_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lmsv2_user`
--
ALTER TABLE `lmsv2_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
