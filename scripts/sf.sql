-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 26, 2012 at 09:54 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `createEvent`(
IN evtName VARCHAR(255),
IN evtDesc VARCHAR(255),
IN evtLoc VARCHAR(255),
IN evtSTime DATETIME,
IN evtETime DATETIME,
IN evtPriv INT(11),
IN userID VARCHAR(30),
IN courseID VARCHAR(11),
IN evtIsRecurr TINYINT(1),
IN daysUntilRecurr INT(11),
IN evtRecurrs INT(11)
)
BEGIN

INSERT
INTO sfevent (event_name, event_desc, event_location, event_startTime, event_endTime, event_privacy, user_ID, course_ID, event_isRecur, event_daysUntilRecur, event_recurs)
VALUES (evtName, evtDesc, evtLoc, evtSTime, evtETime, evtPriv, userID, courseID, evtIsRecurr, daysUntilRecurr, evtRecurrs);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteStorageItem`(
IN sid INT
)
BEGIN
DELETE FROM sfstorage WHERE storage_ID=sid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_card`(
IN cID INT
)
BEGIN
DELETE FROM flashcard
WHERE card_ID = cID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_event`(
IN eID INT
)
BEGIN
DELETE FROM sfevent
WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `events_by_course`(
IN cID INT
)
BEGIN
SELECT *
FROM sfevent 
WHERE course_ID = cID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `events_by_user`(
IN uID VARCHAR(30)
)
BEGIN
SELECT *
FROM sfevent 
WHERE user_ID = uID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `event_drag_day`(
IN eID INT, IN dD INT
)
BEGIN
UPDATE sfevent SET event_endTime = DATE_ADD(event_endTime, INTERVAL dD DAY) WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `event_drag_min`(
IN eID INT, IN mD INT
)
BEGIN
UPDATE sfevent SET event_endTime = DATE_ADD(event_endTime, INTERVAL mD MINUTE) WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `event_drop_day`(
IN eID INT, IN dD INT
)
BEGIN
UPDATE sfevent SET event_startTime = DATE_ADD(event_startTime, INTERVAL dD DAY), 
        event_endTime = DATE_ADD(event_endTime, INTERVAL dD DAY) WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `event_drop_min`(
IN eID INT, IN mD INT
)
BEGIN
UPDATE sfevent SET event_startTime = DATE_ADD(event_startTime, INTERVAL md MINUTE), 
        event_endTime = DATE_ADD(event_endTime, INTERVAL md MINUTE) WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCoursesForUser`(
IN uid VARCHAR(30)
)
BEGIN
SELECT c.course_ID, c.course_name, c.course_description, c.course_time, c.course_location, sfuser.user_fname AS ins_fname, sfuser.user_lname AS ins_lname
FROM course AS c
INNER JOIN enrollment ON c.course_ID = enrollment.course_ID
INNER JOIN sfuser ON c.instructor_ID = sfuser.user_ID
WHERE enrollment.user_ID = uid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStorageItemPath`(
IN sid INT(11),
OUT sd VARCHAR(255),
OUT itm VARCHAR(255)
)
BEGIN
SELECT storage_directory, item_name 
INTO sd, itm
FROM sfstorage WHERE
storage_ID = sid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStorageItems`( 
IN oid VARCHAR(30),
appr TINYINT(1)
 )
BEGIN
SELECT * FROM sfstorage
WHERE (owner_ID = oid AND approved = appr);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cards`(
IN title VARCHAR(255)
)
BEGIN
SELECT *
FROM flashcard
WHERE card_title = title;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cardTitles`(
IN courseID INT
)
BEGIN
SELECT flashcard_title FROM flashcard WHERE course_ID = courseID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_Deck`(
IN courseID INT, IN userID varchar(255), IN cardTitle varchar(255)
)
BEGIN
SELECT * FROM flashcard WHERE card_title = 'cardTitle' AND course_ID = courseID AND user_ID = 'userID';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_eventByCourse`(
IN courseID INT
)
BEGIN
SELECT * FROM sfevent WHERE course_ID = courseID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_eventByID`(
IN eID INT
)
BEGIN
SELECT * FROM sfevent WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_eventByUser`(
IN uID varchar(255)
)
BEGIN
SELECT * FROM sfevent WHERE user_ID = uID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posts`(
IN threadID INT
)
BEGIN
SELECT * FROM thread WHERE thread_ID = threadID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_teacher`(
IN cID INT
)
BEGIN
SELECT instructor_ID FROM course WHERE course_ID = cID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_threads`(
IN courseID INT
)
BEGIN
SELECT * FROM thread WHERE course_ID = courseID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_title`(
IN cID INT
)
BEGIN
SELECT card_title
FROM flashcard
WHERE course_ID = cID
GROUP BY card_title;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertNewUser`(
IN userID VARCHAR(30),
IN fName VARCHAR(255),
IN lName VARCHAR(255)
)
BEGIN
INSERT INTO sfuser (user_ID, user_fname, user_lname, user_type) 
VALUES (userID, fName, lName, 2);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertStorageItem`(
IN oid VARCHAR(30),
IN dir VARCHAR(255),
IN name VARCHAR(255),
IN app TINYINT(1)
)
BEGIN
INSERT INTO sfstorage (owner_ID, storage_directory, item_name, approved)
VALUES (oid, dir, name, app);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_card`(
IN cID INT, IN uID VARCHAR(30), IN cT VARCHAR(255), IN cQ VARCHAR(255), IN cA VARCHAR(255)
)
BEGIN
INSERT INTO flashcard (course_ID, user_ID, card_title, card_question, card_answer)
VALUES(cID, uID, cT, cQ, cA);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_event`(
 IN name VARCHAR(255), IN d VARCHAR(255), IN l VARCHAR(255), IN sT datetime, IN eT datetime, IN eP INT, IN uID VARCHAR(30), 
	IN cID INT, IN isR tinyint, IN dUR INT, IN eR INT
)
BEGIN
INSERT INTO sfevent (event_name, event_desc, event_location, event_startTime, event_endTime, event_privacy, user_ID,
                  course_ID, event_isRecur, event_daysUntilRecur, event_recurs)
VALUES(name, d, l, sT, eT, eP, uID, cID, isR, dUR, eR);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_news`(
IN cID INT, IN upT VARCHAR(255)
)
BEGIN
INSERT INTO sfupdate (course_ID, update_text, update_time) 
VALUES (cID, upT, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_post`(
IN uID VARCHAR(30), IN c VARCHAR(255), IN tID INT
)
BEGIN
INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) 
VALUES (null, uID, c, now(), tID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_thread`(
IN cID INT, IN t VARCHAR(255)
)
BEGIN
INSERT INTO thread (thread_ID, thread_title, course_ID) 
VALUES (null, t, cID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `returnIdIfExists`(
IN userID VARCHAR(30),
OUT count INT(1)
)
BEGIN
SELECT COUNT(user_fname) INTO count 
FROM sfuser 
WHERE user_ID = userID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_threads`(
IN cID INT
)
BEGIN
SELECT * 
FROM thread LEFT JOIN post ON thread.thread_ID=post.thread_ID LEFT JOIN sfuser ON post.user_ID=sfuser.user_ID 
WHERE thread.course_ID= cID GROUP BY thread.thread_ID 
ORDER BY post.post_time DESC;
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
  `instructor_ID` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`course_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE IF NOT EXISTS `enrollment` (
  `user_ID` varchar(30) NOT NULL,
  `course_ID` int(11) NOT NULL,
  PRIMARY KEY (`user_ID`,`course_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `enrollmentrequests`
--

CREATE TABLE IF NOT EXISTS `enrollmentrequests` (
  `user_ID` varchar(30) NOT NULL,
  `course_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flashcard`
--

CREATE TABLE IF NOT EXISTS `flashcard` (
  `card_ID` int(11) NOT NULL AUTO_INCREMENT,
  `card_title` varchar(255) NOT NULL,
  `card_question` varchar(255) NOT NULL,
  `card_answer` varchar(255) NOT NULL,
  `user_ID` varchar(30) NOT NULL,
  `course_ID` varchar(30) NOT NULL,
  PRIMARY KEY (`card_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1124 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` varchar(30) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_content` varchar(255) NOT NULL,
  `post_time` datetime NOT NULL,
  `thread_ID` int(11) NOT NULL,
  PRIMARY KEY (`post_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=358 ;

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
  `user_ID` varchar(30) NOT NULL,
  `course_ID` varchar(11) NOT NULL DEFAULT '0',
  `event_isRecur` tinyint(1) NOT NULL DEFAULT '0',
  `event_daysUntilRecur` int(11) NOT NULL DEFAULT '0',
  `event_recurs` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

-- --------------------------------------------------------

--
-- Table structure for table `sfstorage`
--

CREATE TABLE IF NOT EXISTS `sfstorage` (
  `storage_ID` int(11) NOT NULL AUTO_INCREMENT,
  `storage_directory` varchar(255) NOT NULL,
  `owner_ID` varchar(30) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`storage_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=327 ;

-- --------------------------------------------------------

--
-- Table structure for table `sfupdate`
--

CREATE TABLE IF NOT EXISTS `sfupdate` (
  `update_ID` int(11) NOT NULL AUTO_INCREMENT,
  `course_ID` int(11) NOT NULL,
  `update_text` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`update_ID`),
  KEY `updates_ID` (`update_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=608 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_ID` int(11) NOT NULL AUTO_INCREMENT,
  `thread_title` varchar(255) NOT NULL,
  `course_ID` int(11) NOT NULL,
  PRIMARY KEY (`thread_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=196 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
