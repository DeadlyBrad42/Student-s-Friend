-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2012 at 02:46 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_card`(
IN cardID INT
)
BEGIN
DELETE FROM flashcard WHERE card_ID = cardID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCoursesForUser`(
IN userID VARCHAR(30)
)
BEGIN
SELECT * FROM course WHERE user_ID = userID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser`(
IN userId VARCHAR(30)
)
BEGIN
SELECT *
FROM sfuser
WHERE user_ID = userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_card`(
IN cardID INT
)
BEGIN
SELECT * FROM flashcard WHERE card_ID = cardID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cardTitles`(
IN courseID INT
)
BEGIN
SELECT flashcard_title FROM flashcard WHERE course_ID = courseID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_Deck`(
IN courseID INT, IN userID INT, IN cardTitle varchar(255)
)
BEGIN
SELECT * FROM flashcard WHERE card_title = cardTitle AND course_ID = courseID AND user_ID = userID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_eventByUser`(
IN userID INT
)
BEGIN
SELECT * FROM sfevent WHERE user_ID = userID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posts`(
IN threadID INT
)
BEGIN
SELECT * FROM thread WHERE thread_ID = threadID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertNewUser`(
IN userID VARCHAR(30),
IN fName VARCHAR(255),
IN lName VARCHAR(255)
)
BEGIN
INSERT INTO sfuser (user_ID, user_fname, user_lname) 
VALUES (userID, fName, lName);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_card`(
IN courseID INT, IN userID INT, IN cardTitle varchar(255), IN cardQuestion varchar(255), IN cardAnswer varchar(255)
)
BEGIN
INSERT INTO flashcard(card_ID, card_title, card_question, card_answer, user_ID, course_ID) VALUES ( null, cardTitle, cardQuestion, cardAnswer, userID, courseID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_post`(
IN threadID INT, IN name varchar(255), IN content varchar(255), IN date DATETIME
)
BEGIN
INSERT INTO post(post_ID, thread_ID, post_name, post_content, post_time) VALUES ( null, threadID, name, content, date);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_thread`(
IN courseID INT, IN threadTitle varchar(255)
)
BEGIN
INSERT INTO thread(thread_ID, thread_title, course_ID) VALUES ( null, threadTitle, courseID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `returnIdIfExists`(
IN userID VARCHAR(30)
)
BEGIN
SELECT user_ID FROM sfuser WHERE user_ID = userID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `course_ID` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `course_description` varchar(255) CHARACTER SET latin1 NOT NULL,
  `course_time` datetime NOT NULL,
  `course_location` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_ID` varchar(30) CHARACTER SET latin1 NOT NULL,
  `sfevent_ID` int(11) NOT NULL,
  PRIMARY KEY (`course_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_ID`, `course_name`, `course_description`, `course_time`, `course_location`, `user_ID`, `sfevent_ID`) VALUES
(1, 'cmpsci335', 'comp course', '2012-02-01 11:00:00', 'behrend', '100002149553265', 1),
(2, 'cmpsci484', 'comp class', '2012-02-15 00:00:00', 'behrend', '100002149553265', 2),
(3, 'bio421', 'bio class', '2012-02-14 00:00:00', 'behrend', '100002149553265', 3);

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
  `course_ID` int(11) NOT NULL,
  PRIMARY KEY (`card_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `flashcard`
--

INSERT INTO `flashcard` (`card_ID`, `card_title`, `card_question`, `card_answer`, `user_ID`, `course_ID`) VALUES
(1, 'Chapter 3', 'What is 7*7?', '49', 0, 0),
(2, 'Chapter 3', 'What is 9*6?', '54', 0, 0),
(3, '49', '2401', '343', 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_ID`, `post_name`, `post_content`, `post_time`, `thread_ID`) VALUES
(1, 'Lopez', 'Hi my name is Lopez', '2012-02-16 21:24:06', 343);

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
  `user_fbToken` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `user_major` varchar(255) NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sfuser`
--

INSERT INTO `sfuser` (`user_ID`, `user_fname`, `user_lname`, `user_dob`, `user_semester`, `user_university`, `user_fbToken`, `user_type`, `user_major`) VALUES
('100002149553265', 'Alex', 'Wardi', '', '', '', '', 0, ''),
('609904185', 'Jared', 'Thompson', '', '', '', '', 0, ''),
('9384948', 'Brad', 'Mason', '', '', '', '', 0, ''),
('100002585728884', 'Leonard', 'Church', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_ID` int(11) NOT NULL AUTO_INCREMENT,
  `thread_title` varchar(255) NOT NULL,
  `course_ID` int(11) NOT NULL,
  PRIMARY KEY (`thread_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_ID`, `thread_title`, `course_ID`) VALUES
(1, 'test', 343);

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
