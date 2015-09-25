-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2015 at 11:52 PM
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
-- Table structure for table `question_state`
--

CREATE TABLE IF NOT EXISTS `question_state` (
  `email_id` varchar(60) NOT NULL COMMENT 'hacking team''s current location',
  `question_no` int(4) NOT NULL COMMENT 'qn no the user plays',
  `has_solved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'has the user solved the question',
  `no_of_attempts_made` int(4) NOT NULL DEFAULT '0' COMMENT 'note down the no of attempts made to identify violations',
  `plays_as_character` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL DEFAULT '{"name":"Dimitry", "profilePic":"img/dimitry.png"}' COMMENT 'character json',
  PRIMARY KEY (`email_id`,`question_no`),
  KEY `current_level_no` (`plays_as_character`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table to preserve game state';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
