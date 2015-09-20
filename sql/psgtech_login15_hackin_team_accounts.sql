-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2015 at 10:57 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `psgtech_login15_hackin_team_accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `connections_creation_logger`
--

CREATE TABLE IF NOT EXISTS `connections_creation_logger` (
  `connection_no` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `at_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time of creation',
  `additional_info` text CHARACTER SET latin1 COLLATE latin1_general_ci COMMENT 'purpose of connection creation',
  PRIMARY KEY (`connection_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Log the no of db connections made while running the event' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `connections_db_access_logger`
--

CREATE TABLE IF NOT EXISTS `connections_db_access_logger` (
  `db_access_no` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `db_name` varchar(50) NOT NULL COMMENT 'name of the db being accessed',
  `db_purpose` varchar(35) DEFAULT NULL COMMENT 'purpose of access- to overcome db shrinking, (session logger, request logger, access logger, quora logger, game engine logger)',
  `at_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'accessed at time',
  `additional_info` text COMMENT 'purpose of db access',
  PRIMARY KEY (`db_access_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Log the no of times a particular db is being accessed. Aggregate them later' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_state`
--

CREATE TABLE IF NOT EXISTS `game_state` (
  `email_id` varchar(60) NOT NULL COMMENT 'hacking team''s current location',
  `current_level_no` int(4) NOT NULL DEFAULT '0',
  `current_mission_no` int(4) NOT NULL DEFAULT '0',
  `current_plot_no` int(4) NOT NULL DEFAULT '0',
  `current_count_of_attempts_made` int(8) NOT NULL DEFAULT '0' COMMENT 'no of attempts made for this question',
  `current_score` int(8) NOT NULL DEFAULT '0',
  `is_user_alumni` tinyint(1) NOT NULL DEFAULT '0',
  `plays_as_character` int(4) NOT NULL DEFAULT '1' COMMENT 'character no from the game engine characters table',
  PRIMARY KEY (`email_id`),
  KEY `current_level_no` (`current_level_no`,`current_mission_no`,`current_plot_no`,`current_score`,`is_user_alumni`,`plays_as_character`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table to preserve game state';

-- --------------------------------------------------------

--
-- Table structure for table `hacks_logger`
--

CREATE TABLE IF NOT EXISTS `hacks_logger` (
  `log_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'logging no',
  `email_id` varchar(60) NOT NULL,
  `session_id` int(10) NOT NULL,
  `question_no` int(4) DEFAULT NULL COMMENT 'for the question',
  `at_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `http_header` text CHARACTER SET latin1 COLLATE latin1_general_cs COMMENT 'header with which the event occured',
  `additional_details` text CHARACTER SET latin1 COLLATE latin1_general_cs COMMENT 'all other details gathered as json string',
  PRIMARY KEY (`log_no`),
  KEY `email_id` (`email_id`,`session_id`),
  KEY `question_no` (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='log everything from user' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `email_id` varchar(60) NOT NULL COMMENT 'id for the table',
  `screen_name` varchar(30) DEFAULT NULL COMMENT 'name of the user',
  `roll_no` varchar(15) DEFAULT NULL COMMENT 'rollno of the user- especially if alumni',
  `is_user_alumni` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'if alumni=1',
  `profile_pic` text COMMENT 'path to the image',
  `phone_no` varchar(13) NOT NULL COMMENT 'phone no for contacting the team',
  `college_code` varchar(10) DEFAULT NULL COMMENT 'code set for the college',
  `department_name` varchar(50) DEFAULT NULL COMMENT 'name of the department',
  `college_name` varchar(50) DEFAULT NULL COMMENT 'name of the college',
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='register users for the first time to store information about them';

-- --------------------------------------------------------

--
-- Table structure for table `sessions_alive`
--

CREATE TABLE IF NOT EXISTS `sessions_alive` (
  `email_id` varchar(60) NOT NULL COMMENT 'id for the table',
  `php_session_id` varchar(50) NOT NULL COMMENT 'php''s session id as provided by <?php session_id() ?>',
  `hackin_session_id` varchar(40) NOT NULL COMMENT 'session id assigned by Hackin event for tracking down',
  `last_login_time` timestamp NULL DEFAULT NULL COMMENT 'time at which login happened',
  `last_refresh_time` timestamp NULL DEFAULT NULL COMMENT 'time at which reload happened = login.php called',
  `last_active_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'time at which any request is received',
  `last_active_user_agent` text COMMENT 'browser agent for further details',
  `last_active_browser` varchar(30) DEFAULT NULL COMMENT 'browser name',
  `last_active_browser_details` text COMMENT 'complete information about the browser-> from useragentstring.com',
  `last_active_ip` text COMMENT 'last used IP',
  `last_active_ip_details` text NOT NULL COMMENT 'complete ip details',
  PRIMARY KEY (`email_id`),
  KEY `php_session_id` (`php_session_id`),
  KEY `hackin_session_id` (`hackin_session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='only alive sessions';

-- --------------------------------------------------------

--
-- Table structure for table `sessions_logger`
--

CREATE TABLE IF NOT EXISTS `sessions_logger` (
  `no` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `email_id` varchar(60) NOT NULL,
  `php_session_id` varchar(30) NOT NULL COMMENT 'php''s session id as provided by <?php session_id() ?>',
  `hackin_session_id` varchar(30) NOT NULL COMMENT 'hackin session id used to isolate hackin users',
  `session_type` varchar(15) NOT NULL COMMENT 'type of session = [login, logout, refresh, access, force_logout]',
  `browser_name` varchar(30) DEFAULT NULL COMMENT 'name of the browser used',
  `user_agent` text COMMENT 'user agent string',
  `browser_details` text COMMENT 'as provided by useragentstring.com',
  `ip` text COMMENT 'from ip',
  `ip_details` text COMMENT 'complete ip details as json',
  PRIMARY KEY (`no`),
  KEY `email_id` (`email_id`),
  KEY `hackin_session_id` (`hackin_session_id`),
  KEY `browser_name` (`browser_name`),
  KEY `session_type` (`session_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='logs all users login and logout times' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
