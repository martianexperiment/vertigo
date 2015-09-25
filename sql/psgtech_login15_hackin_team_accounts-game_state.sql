-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2015 at 11:53 PM
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
-- Table structure for table `game_state`
--

CREATE TABLE IF NOT EXISTS `game_state` (
  `email_id` varchar(50) NOT NULL COMMENT 'id for the table',
  `is_user_alumni` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'alumni=1',
  `current_score` int(8) NOT NULL DEFAULT '0' COMMENT 'score',
  `no_of_violations_made` int(4) NOT NULL DEFAULT '0' COMMENT 'note down the violations to block user',
  `plays_as_character` varchar(60) DEFAULT '{"name":"Dimitry", "profilePic":"img/dimitry.png"}' COMMENT 'default character dimitry',
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='get game state of the user';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
