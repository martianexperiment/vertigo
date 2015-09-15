-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2015 at 06:09 PM
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
DROP DATABASE `psgtech_login15_hackin_team_accounts`;
CREATE DATABASE `psgtech_login15_hackin_team_accounts` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `psgtech_login15_hackin_team_accounts`;

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
  `screen_name` varchar(30) DEFAULT NULL COMMENT 'screen name of the hacking team',
  `roll_no` varchar(10) DEFAULT NULL COMMENT 'roll no- alumni''s in general',
  `email_id` varchar(60) NOT NULL COMMENT 'email id used by the hacking team',
  `department_name` varchar(65) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'hacking team''s dept name',
  `college_name` varchar(65) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'belonging to college',
  `photo_for_team` text CHARACTER SET latin1 COLLATE latin1_general_cs COMMENT 'location to photo of the team(alumni/participant)',
  `phone_no` varchar(13) NOT NULL COMMENT 'phone no for contacting the team',
  `is_user_alumni` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'alumni = 1, participant = 0',
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `screen_name` (`screen_name`,`phone_no`),
  UNIQUE KEY `roll_no` (`roll_no`),
  KEY `college_name` (`college_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='to register new users';

-- --------------------------------------------------------

--
-- Table structure for table `sessions_alive`
--

CREATE TABLE IF NOT EXISTS `sessions_alive` (
  `email_id` varchar(60) NOT NULL COMMENT 'id for the table',
  `session_id` varchar(10) NOT NULL COMMENT 'unique id for the person',
  `last_login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'time of recent login',
  PRIMARY KEY (`email_id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='only alive sessions';

-- --------------------------------------------------------

--
-- Table structure for table `sessions_logger`
--

CREATE TABLE IF NOT EXISTS `sessions_logger` (
  `email_id` varchar(60) NOT NULL,
  `session_id` varchar(10) NOT NULL,
  `is_new_incoming_session` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether the logging session is new or not',
  `session_login_count` int(8) NOT NULL DEFAULT '0' COMMENT 'the no of time, at which the session logs in with the same session id',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'the time at which he logs in',
  `http_header` text COMMENT 'header details of the user',
  `browser_agent` text COMMENT 'browser agent details',
  `logout_time` timestamp NULL DEFAULT NULL COMMENT 'the time at which he logs out/switches over the session',
  `is_logged_out_by_new_request` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'whether he logs out on his own(=1) or by alternate user',
  `ip_list_used_by_user` text COMMENT 'list of all IPs used by the player',
  PRIMARY KEY (`email_id`,`session_id`,`session_login_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='logs all users login and logout times';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
