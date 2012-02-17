-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2012 at 12:48 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sf`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser`(
IN userId VARCHAR(30)
)
BEGIN
SELECT *
FROM sfuser
WHERE user_ID = userId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `course_ID` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) COLLATE armscii8_bin NOT NULL,
  `course_description` varchar(255) COLLATE armscii8_bin NOT NULL,
  `course_time` datetime NOT NULL,
  `course_location` varchar(255) COLLATE armscii8_bin NOT NULL,
  `user_ID` varchar(30) COLLATE armscii8_bin NOT NULL,
  `sfevent_ID` int(11) NOT NULL,
  PRIMARY KEY (`course_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `flashcard`
--

CREATE TABLE IF NOT EXISTS `flashcard` (
  `card_ID` int(11) NOT NULL AUTO_INCREMENT,
  `card_title` varchar(255) NOT NULL,
  `card_question` varchar(255) NOT NULL,
  `card_answer` varchar(255) NOT NULL,
  `user_ID` int(11) NOT NULL,
  PRIMARY KEY (`card_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_ID` int(11) NOT NULL AUTO_INCREMENT,
  `post_name` varchar(255) NOT NULL,
  `post_content` varchar(255) NOT NULL,
  `post_time` datetime NOT NULL,
  `thread_ID` int(11) NOT NULL,
  PRIMARY KEY (`post_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sfevent`
--

CREATE TABLE IF NOT EXISTS `sfevent` (
  `event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_desc` varchar(255) NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_startTime` datetime NOT NULL,
  `event_endTime` datetime NOT NULL,
  `event_privacy` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  PRIMARY KEY (`event_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sfupdate`
--

CREATE TABLE IF NOT EXISTS `sfupdate` (
  `updates_ID` int(11) NOT NULL AUTO_INCREMENT,
  `courses_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `update_text` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`updates_ID`),
  KEY `updates_ID` (`updates_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sfuser`
--

CREATE TABLE IF NOT EXISTS `sfuser` (
  `user_ID` varchar(30) NOT NULL,
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `user_dob` varchar(255) NOT NULL,
  `user_semester` varchar(255) NOT NULL,
  `user_university` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `user_major` varchar(255) NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sfuser`
--

INSERT INTO `sfuser` (`user_ID`, `user_fname`, `user_lname`, `user_dob`, `user_semester`, `user_university`, `user_type`, `user_major`) VALUES
('100002149553265', 'Alex', 'Wardi', '', '', '', 0, ''),
('609904185', 'Jared', 'Thompson', '', '', '', 0, ''),
('9384948', 'Brad', 'Mason', 'q', 'w', 'e', 0, 'r');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_ID` int(11) NOT NULL AUTO_INCREMENT,
  `thread_title` varchar(255) NOT NULL,
  `course_ID` int(11) NOT NULL,
  PRIMARY KEY (`thread_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userstorage`
--

CREATE TABLE IF NOT EXISTS `userstorage` (
  `storage_ID` int(11) NOT NULL AUTO_INCREMENT,
  `storage_directory` varchar(255) NOT NULL,
  `user_ID` int(11) NOT NULL,
  PRIMARY KEY (`storage_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
