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
-- Database: `psgtech_login15_hackin_game_engine`
--
DROP DATABASE `psgtech_login15_hackin_game_engine`;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
