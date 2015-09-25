-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2015 at 11:51 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `psgtech_login15_hackin_quora`
--

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
  `question_no` int(4) NOT NULL COMMENT 'id for the table',
  `question_text` text CHARACTER SET latin1 COLLATE latin1_bin COMMENT 'question text',
  `max_no_of_attempts_allowed` int(4) NOT NULL DEFAULT '15' COMMENT 'maximum no of attempts permitted for the question',
  `has_hints` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'does the question has hint(s)',
  `question_variable_ans` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'false->constant answer',
  `question_categories` text COMMENT 'JSON array format, categories to which the question belongs to',
  `has_attachments` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'does the question have attachment(s)',
  PRIMARY KEY (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Question details';

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
-- Constraints for table `question_scores`
--
ALTER TABLE `question_scores`
  ADD CONSTRAINT `question_scores_ibfk_1` FOREIGN KEY (`question_no`) REFERENCES `question_details` (`question_no`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
