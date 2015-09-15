-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2015 at 05:30 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `psgtech_login15_hackin_game_engine`
--
CREATE DATABASE `psgtech_login15_hackin_game_engine` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `psgtech_login15_hackin_game_engine`;

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `character_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'name of the character, id for the table',
  `image_src` text CHARACTER SET latin1 COLLATE latin1_general_cs COMMENT 'image link for the character',
  `gender` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL DEFAULT 'male' COMMENT '{male,female,transgender}gender of the character- use small case',
  `job_designation` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'whether the character is spy/jailor/etc.',
  `location_no` int(8) DEFAULT NULL COMMENT 'home location of the character',
  PRIMARY KEY (`character_name`),
  KEY `location_no` (`location_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='characters involved in the game play';

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE IF NOT EXISTS `conversations` (
  `sequence_no` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `level_no` int(4) NOT NULL COMMENT 'for level - to introduce a level',
  `mission_no` int(4) DEFAULT NULL COMMENT 'for mission - to introduce the mission',
  `plot_no` int(4) DEFAULT NULL COMMENT 'for plot - to introduce the plot',
  `character_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'who speaks what',
  `conversation_message` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'chat message.',
  PRIMARY KEY (`sequence_no`),
  KEY `level_no` (`level_no`),
  KEY `mission_no` (`mission_no`),
  KEY `plot_no` (`plot_no`),
  KEY `character_name` (`character_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='List of conversations made. Includes the chat messages too' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `level_no` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `level_description` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'description of the level',
  `no_of_missions` int(4) NOT NULL COMMENT 'no of missions for the question. Max mission be 5',
  PRIMARY KEY (`level_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Aggregate missions into levels for sibling skips and for metadata' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `location_no` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id for the table, for easier access',
  `location_description` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'description about the place. eg: Jail/FBI office/FBI Headquarters etc.',
  `place` text COMMENT 'place on the map',
  `state` text COMMENT 'state of the country',
  `country` text COMMENT 'location on the map',
  PRIMARY KEY (`location_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='locations used in the game. To refer easily in the context' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE IF NOT EXISTS `missions` (
  `mission_no` int(4) NOT NULL COMMENT 'id for the table',
  `mission_description` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'mission''s mission',
  `belongs_to_level_no` int(4) NOT NULL COMMENT 'level details',
  `has_more_sub_plots` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'boolean value to know about multiple missions',
  `additional_description` text CHARACTER SET latin1 COLLATE latin1_general_cs COMMENT 'if any',
  PRIMARY KEY (`mission_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Missions for the hacker';

-- --------------------------------------------------------

--
-- Table structure for table `plots`
--

CREATE TABLE IF NOT EXISTS `plots` (
  `plot_no` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `mission_no` int(4) NOT NULL COMMENT 'plot belonging to mission',
  `question_no` int(4) NOT NULL COMMENT 'to map the question no for the plot. One question per plot',
  `plot_description` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'any more details',
  PRIMARY KEY (`plot_no`),
  KEY `mission_no` (`mission_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='plots for the mission' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`location_no`) REFERENCES `locations` (`location_no`);

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`level_no`) REFERENCES `levels` (`level_no`),
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`mission_no`) REFERENCES `missions` (`mission_no`),
  ADD CONSTRAINT `conversations_ibfk_3` FOREIGN KEY (`plot_no`) REFERENCES `plots` (`plot_no`),
  ADD CONSTRAINT `conversations_ibfk_4` FOREIGN KEY (`character_name`) REFERENCES `characters` (`character_name`);

--
-- Constraints for table `plots`
--
ALTER TABLE `plots`
  ADD CONSTRAINT `plots_ibfk_1` FOREIGN KEY (`mission_no`) REFERENCES `missions` (`mission_no`);
--
-- Database: `psgtech_login15_hackin_quora`
--
CREATE DATABASE `psgtech_login15_hackin_quora` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `psgtech_login15_hackin_quora`;

-- --------------------------------------------------------

--
-- Table structure for table `answer_details`
--

CREATE TABLE IF NOT EXISTS `answer_details` (
  `answer_no` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id for the table, for easier access',
  `question_no` int(4) NOT NULL COMMENT 'Answer belonging to question',
  `is_evaluated_at_back_end` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'evaluation at backend?',
  `answer` text NOT NULL COMMENT 'actual answer',
  PRIMARY KEY (`answer_no`),
  KEY `question_no` (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stores the answers for both variable and non-variable questions' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_answer_specialization`
--

CREATE TABLE IF NOT EXISTS `question_answer_specialization` (
  `web_link_no` int(8) NOT NULL COMMENT 'id for the table, for easier access',
  `question_no` int(4) NOT NULL COMMENT 'for the question',
  `specialization_description` text COMMENT 'description about the link',
  `specialization_link` text NOT NULL COMMENT 'link',
  PRIMARY KEY (`web_link_no`),
  KEY `question_no` (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For curious players, provide with additional info';

-- --------------------------------------------------------

--
-- Table structure for table `question_category_attachments`
--

CREATE TABLE IF NOT EXISTS `question_category_attachments` (
  `attachment_no` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id for the table, for easier access',
  `question_no` int(4) NOT NULL COMMENT 'for the question',
  `category_no` int(4) NOT NULL COMMENT 'for the category',
  `attachment_metadata` text NOT NULL,
  `attachment_link` text NOT NULL,
  PRIMARY KEY (`attachment_no`),
  KEY `question_no` (`question_no`),
  KEY `category_no` (`category_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Attachment details' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_category_metadata`
--

CREATE TABLE IF NOT EXISTS `question_category_metadata` (
  `category_no` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `category_description` text NOT NULL COMMENT 'description on the area',
  PRIMARY KEY (`category_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Classify questions into segments for front-end processing' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_details`
--

CREATE TABLE IF NOT EXISTS `question_details` (
  `question_no` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id for the table',
  `question_text` text CHARACTER SET latin1 COLLATE latin1_bin NOT NULL COMMENT 'question text',
  `max_attempts_to_allow` int(4) NOT NULL DEFAULT '15' COMMENT 'maximum no of attempts permitted for the question',
  `has_hints` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'does the question has hint(s)',
  `question_variable_ans` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'false->constant answer',
  `question_category` int(4) NOT NULL COMMENT 'category to which the question belongs to',
  `has_attachments` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'does the question have attachment(s)',
  PRIMARY KEY (`question_no`),
  KEY `question_category` (`question_category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Question details' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_hints`
--

CREATE TABLE IF NOT EXISTS `question_hints` (
  `hint_sequence_no` int(8) NOT NULL AUTO_INCREMENT COMMENT 'for easier access',
  `question_no` int(4) NOT NULL COMMENT 'for the question',
  `hint_no` int(4) NOT NULL COMMENT 'order cum level of the hint',
  `hint_description` text NOT NULL COMMENT 'hint description',
  `deduction_score_value` int(8) NOT NULL DEFAULT '20' COMMENT 'the value which will be deduced from score from the player for using the hint',
  PRIMARY KEY (`hint_sequence_no`),
  KEY `question_no` (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='hints for the question' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_scores`
--

CREATE TABLE IF NOT EXISTS `question_scores` (
  `question_no` int(4) NOT NULL COMMENT 'id for the table',
  `score` int(8) NOT NULL COMMENT '(int)score for the corresponding qn',
  `min_attempts_to_avert_deduction` int(2) NOT NULL DEFAULT '5' COMMENT 'No of attempts below which score will not be deduced',
  `min_deduction_value` int(11) NOT NULL DEFAULT '10' COMMENT 'score to be deduced for attempts made',
  `after_limit_deduce_once_for_every_x_attempts` varchar(2) NOT NULL DEFAULT '5' COMMENT 'after crossing the limit, deduce once after this no of attempts',
  `incremental_detection_value` int(2) NOT NULL DEFAULT '0' COMMENT 'for(attempts=1;attempts<max_attempt;attempts++) {boundary_violations = (attempts - min_attempts_to_avert_deduction)/after_limit_deduce_once_for_every_x_attempts;if(attempts - min_attempts_to_avert_deduction)%after_limit_deduce_once_for_every_x_attempts == 0) {score -= (min_deduction_value + boundary_violations * incremental_detection_value}}',
  PRIMARY KEY (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='scores and their deduction calculations';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_details`
--
ALTER TABLE `answer_details`
  ADD CONSTRAINT `answer_details_ibfk_1` FOREIGN KEY (`question_no`) REFERENCES `question_details` (`question_no`);

--
-- Constraints for table `question_answer_specialization`
--
ALTER TABLE `question_answer_specialization`
  ADD CONSTRAINT `question_answer_specialization_ibfk_1` FOREIGN KEY (`question_no`) REFERENCES `question_details` (`question_no`);

--
-- Constraints for table `question_category_attachments`
--
ALTER TABLE `question_category_attachments`
  ADD CONSTRAINT `question_category_attachments_ibfk_1` FOREIGN KEY (`question_no`) REFERENCES `question_details` (`question_no`),
  ADD CONSTRAINT `question_category_attachments_ibfk_2` FOREIGN KEY (`category_no`) REFERENCES `question_category_metadata` (`category_no`);

--
-- Constraints for table `question_hints`
--
ALTER TABLE `question_hints`
  ADD CONSTRAINT `question_hints_ibfk_1` FOREIGN KEY (`question_no`) REFERENCES `question_details` (`question_no`);
--
-- Database: `psgtech_login15_hackin_team_accounts`
--
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
  `email_id` varchar(60) NOT NULL COMMENT 'email id used by the hacking team',
  `department_name` varchar(65) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'hacking team''s dept name',
  `college_name` varchar(65) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'belonging to college',
  `photo_for_team` text CHARACTER SET latin1 COLLATE latin1_general_cs COMMENT 'location to photo of the team(alumni/participant)',
  `phone_no` varchar(13) NOT NULL COMMENT 'phone no for contacting the team',
  `is_user_alumni` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'alumni = 1, participant = 0',
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `screen_name` (`screen_name`,`phone_no`),
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
