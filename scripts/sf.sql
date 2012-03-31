-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2012 at 09:41 PM
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
IN oid VARCHAR(30)
)
BEGIN
SELECT * FROM sfstorage
WHERE owner_ID = oid;
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
INSERT INTO sfuser (user_ID, user_fname, user_lname) 
VALUES (userID, fName, lName);
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
IN threadID INT, IN name varchar(255), IN content varchar(255), IN date DATETIME
)
BEGIN
INSERT INTO post(post_ID, thread_ID, post_name, post_content, post_time) VALUES ( null, threadID, name, content, date);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_thread`(
IN uID VARCHAR(30), IN c VARCHAR(255), IN tID INT
)
BEGIN
INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) 
VALUES (null, uID, c, now(), tID);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_endTime_day`(
IN eID INT, IN dD INT
)
BEGIN
UPDATE sfevent SET event_endTime = DATE_ADD(event_endTime, INTERVAL dD DAY) WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_endTime_min`(
IN eID INT, IN mD INT
)
BEGIN
UPDATE sfevent SET event_endTime = DATE_ADD(event_endTime, INTERVAL mD MINUTE) WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_startTime_day`(
IN eID INT, IN dD INT
)
BEGIN
UPDATE sfevent SET event_startTime = DATE_ADD(event_startTime, INTERVAL dD DAY), 
        event_endTime = DATE_ADD(event_endTime, INTERVAL dD DAY) WHERE event_ID = eID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_startTime_min`(
IN eID INT, IN mD INT
)
BEGIN
UPDATE sfevent SET event_startTime = DATE_ADD(event_startTime, INTERVAL md MINUTE), 
        event_endTime = DATE_ADD(event_endTime, INTERVAL md MINUTE) WHERE event_ID = eID;
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
) ENGINE=MyISAM  DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin AUTO_INCREMENT=12 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_ID`, `course_name`, `course_description`, `course_time`, `course_location`, `instructor_ID`) VALUES
(1, 'cmpsci335', 'comp course', '2012-02-01 11:00:00', 'behrend', '100'),
(2, 'cmpsci484', 'comp class', '2012-02-15 00:00:00', 'behrend', '100'),
(3, 'bio421', 'bio class', '2012-02-14 00:00:00', 'behrend', '100002149553265'),
(4, 'bio421', 'bio class', '2012-02-14 00:00:00', 'behrend', '300'),
(5, 'cmpsci335', 'comp course', '2012-02-01 11:00:00', 'behrend', '100002585728884'),
(6, 'CMPSC 474', 'Operating systems', '2012-02-22 12:00:00', 'Witowski', '200'),
(7, 'MIS 336', 'Databases', '2012-02-22 12:25:00', 'Redc', '609904185'),
(9, 'Walker Time Prime', 'Name says it all', '2012-03-07 10:00:00', 'The Walker Dome', '100');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE IF NOT EXISTS `enrollment` (
  `user_ID` varchar(30) NOT NULL,
  `course_ID` int(11) NOT NULL,
  PRIMARY KEY (`user_ID`,`course_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`user_ID`, `course_ID`) VALUES
('100002149553265', 1),
('100002149553265', 2),
('100002149553265', 3),
('100002149553265', 7),
('100002149553265', 9),
('100002585728884', 5),
('100002585728884', 9),
('609904185', 5),
('609904185', 6),
('609904185', 7),
('609904185', 9),
('9384948', 4),
('9384948', 5),
('9384948', 9);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=789 ;

--
-- Dumping data for table `flashcard`
--

INSERT INTO `flashcard` (`card_ID`, `card_title`, `card_question`, `card_answer`, `user_ID`, `course_ID`) VALUES
(725, 'Bob', 'abababab', 'abbaba', '100002585728884', '9'),
(753, 'Addin', 'Cards    ', 'To    ', '100002585728884', '9'),
(754, 'Addin', 'or   ', 'is  ', '100002585728884', '9'),
(755, 'Addin', 'brakes  ', 'something', '100002585728884', '9'),
(756, 'Addin', 'same', 'time', '100002585728884', '9'),
(757, 'Addin', 'at ', 'the', '100002585728884', '9'),
(758, 'Addin', 'being', 'added', '100002585728884', '9'),
(759, 'Addin', 'of ', 'cards', '100002585728884', '9'),
(760, 'Addin', 'if', 'alot', '100002585728884', '9'),
(761, 'Test ', 'To', 'See', '100002585728884', '5'),
(762, 'Test ', 'IF', 'teacher', '100002585728884', '5'),
(763, 'Test ', 'can ', 'edit', '100002585728884', '5'),
(764, 'Test ', 'the ', 'cards', '100002585728884', '5'),
(780, 'BIG TEST', 'od', 'eifweoj', '100002585728884', '5'),
(781, 'BIG TEST', 'vm', 'wo', '100002585728884', '5'),
(788, 'BIG TEST', 'wr', 'OE', '100002585728884', '5'),
(782, 'BIG TEST', 'a', 'b', '100002585728884', '5'),
(783, 'BIG TEST', 'q', 'w', '100002585728884', '5'),
(784, 'BIG TEST', 'e', 'r', '100002585728884', '5'),
(785, 'BIG TEST', 't', 'y', '100002585728884', '5'),
(786, 'BIG TEST', 'v', 'e', '100002585728884', '5'),
(787, 'BIG TEST', 'oe', 'EO', '100002585728884', '5'),
(621, 'thetitle', 'question', 'answer', '9384948', '49'),
(622, 'thetitle', 'question2', 'answer2', '9384948', '49'),
(626, 'title, eh?', 'quest', 'answer', '9384948', '49'),
(625, 'title, eh?', 'quest', 'answer', '9384948', '49'),
(610, 'Real Questions', 'What is the value of pi?', '3.14', '100002585728884', '49'),
(611, 'Real Questions', 'What is the value of c?', '3*10^8 m/s', '100002585728884', '49'),
(612, 'Block', 'Rock', 'Sock', '100002585728884', '49'),
(613, 'Block', 'Mock', 'wock', '100002585728884', '49'),
(614, 'Bob', 'How many bob?', '5', '609904185', '49'),
(619, 'thetitle', 'question2', 'answer2', '9384948', '49'),
(618, 'thetitle', 'question', 'answer', '9384948', '49'),
(607, 'Bob', 'NEW', 'CARDS', '100002585728884', '49'),
(608, 'Bob', 'AND', 'HAS', '100002585728884', '49'),
(609, 'Bob', 'IS', 'BACK', '100002585728884', '49'),
(468, 'Start test', 'even', 'tualy', '9384948', '49'),
(743, 'Bam', 'c ', 'B  ', '100002585728884', '9'),
(744, 'Bam', 'W ', 'Q ', '100002585728884', '9');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_ID`, `user_ID`, `post_name`, `post_content`, `post_time`, `thread_ID`) VALUES
(1, '', 'Lopez', 'Hi my name is Lopez', '2012-02-16 21:24:06', 343),
(2, '9384948', 'Brad', 'post 2-1', '2012-02-23 19:54:51', 2),
(3, '9384948', 'Brad', 'post 2-2', '2012-02-23 19:55:06', 2),
(4, '9384948', 'Brad', 'post 3-1', '2012-02-23 19:55:16', 3),
(5, '9384948', 'Brad', 'post 2-3', '2012-02-23 19:55:38', 2),
(6, '9384948', 'Brad', 'post 3-2', '2012-02-23 19:55:57', 3),
(7, '', 'Bob', 'This is a test', '2012-02-23 20:23:02', 1),
(22, '9384948', '', 'body3', '2012-03-19 17:39:07', 15),
(21, '9384948', '', 'Check', '2012-03-15 18:02:51', 8),
(10, '', 'Gabe', 'Need help with problem on page 21', '2012-02-23 20:26:40', 7),
(11, '', 'Bob', 'Need help', '2012-02-23 20:27:03', 8),
(12, '', 'anonymous', 'Sup?', '2012-02-23 22:44:37', 8),
(13, '', 'anonymous', 'Sup?', '2012-02-23 22:44:52', 8),
(14, '', 'anonymous', 'New post!', '2012-02-23 22:45:56', 3),
(15, '', 'anonymous', 'Ok Cool', '2012-02-23 22:51:25', 7),
(16, '', 'anonymous', 'I can help', '2012-02-23 22:51:59', 8),
(17, '', 'anonymous', 'HI', '2012-02-23 22:54:34', 7),
(93, '9384948', '', 'lol ?sdfsdf = sdf  ', '2012-03-28 20:22:18', 61),
(92, '9384948', '', 'twice.', '2012-03-21 20:19:15', 60),
(91, '9384948', '', 'And replying', '2012-03-21 20:19:10', 60),
(90, '9384948', '', 'Does it work?', '2012-03-21 20:19:02', 60),
(89, '9384948', '', 'new post', '2012-03-21 19:59:20', 2),
(88, '9384948', '', 'more like nude post', '2012-03-21 18:42:06', 59);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `sfevent`
--

INSERT INTO `sfevent` (`event_ID`, `event_name`, `event_desc`, `event_location`, `event_startTime`, `event_endTime`, `event_privacy`, `user_ID`, `course_ID`, `event_isRecur`, `event_daysUntilRecur`, `event_recurs`) VALUES
(1, 'Walker time!', 'Meeting with Walker', 'Tenessee', '2012-03-05 03:14:07', '2012-03-06 04:14:07', 1, '609904185', '0', 0, 0, 0),
(53, 'Test', 'Test', 'Reed', '2012-03-06 12:00:00', '2012-03-06 13:00:00', 0, '0', '7', 0, 0, 0),
(3, 'Walker time!', 'Meeting with Walker', 'Tenessee', '2012-02-07 03:14:07', '2012-02-07 04:14:07', 1, '9384948', '0', 0, 0, 0),
(5, 'Walker time!', 'Meeting with Walker', 'Tenessee', '2012-03-10 03:14:07', '2012-03-10 04:14:07', 1, '100002585728884', '0', 0, 0, 0),
(51, 'courseTest', 'tester', 'tester', '2012-03-22 12:00:00', '2012-03-27 12:00:00', 0, '0', '1', 0, 0, 0),
(41, 'Work!', 'WORKS!', 'YES!', '2012-03-07 12:00:00', '2012-03-07 12:00:00', 0, '609904185', '0', 1, 7, 52),
(8, 'Walker time!', 'Meeting with Walker', 'Tenessee', '2012-02-27 03:14:07', '2012-02-27 04:14:07', 1, '9384948', '0', 0, 0, 0),
(9, 'Walker time!', 'Meeting with Walker', 'Tenessee', '2012-02-16 03:14:07', '2012-02-17 04:14:07', 1, '9384948', '0', 0, 0, 0),
(10, 'Walker Time II Walker Time Strikes Back', 'Student, I am your Father!', 'Tenessee', '2012-02-21 07:30:00', '2012-02-22 11:30:00', 0, '609904185', '0', 1, 7, 10),
(11, 'Walker Time II Walker Time Strikes Back', 'Student, I am your Father!', 'Tenessee', '2012-02-08 12:00:00', '2012-02-08 13:00:00', 0, '9384948', '0', 1, 7, 10),
(39, 'Walker time ULTIMATE!', 'The ultimate walker time!', 'Walker World', '2012-03-06 00:00:00', '2012-03-06 01:00:00', 0, 'Walker', '9', 0, 0, 0),
(48, 'asdfasdf', 'asdf', 'asdf', '2012-03-12 12:00:00', '2012-03-16 12:00:00', 0, '100002149553265', '0', 0, 0, 0),
(54, 'Study session', 'Study', 'Lab', '2012-03-12 10:00:00', '2012-03-12 12:00:00', 0, '0', '7', 0, 0, 0),
(55, 'Win', 'Forever', 'Yes', '2012-03-16 12:00:00', '2012-03-16 12:00:00', 0, '0', '7', 0, 0, 0),
(20, 'New Appointment', 'This appointment is new.', 'Office', '2012-03-19 12:00:00', '2012-03-20 12:00:00', 0, '609904185', '0', 1, 7, 52),
(60, 'Event', 'is', 'as', '2012-03-14 12:00:00', '2012-03-14 12:00:00', 0, '0', '7', 0, 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=254 ;

--
-- Dumping data for table `sfstorage`
--

INSERT INTO `sfstorage` (`storage_ID`, `storage_directory`, `owner_ID`, `item_name`, `approved`) VALUES
(244, 'uploads/Users/100002149553265', '100002149553265', '03.26.12', 1),
(250, 'uploads/Courses/9', '9', 'ChecklistFormat.txt', 0),
(246, 'uploads/Courses/1', '1', '03.26.12', 0),
(247, 'uploads/Courses/2', '2', '03.26.12', 0),
(248, 'uploads/Courses/3', '3', '03.26.12', 0),
(249, 'uploads/Courses/9', '9', '03.26.12', 0),
(251, 'uploads/Courses/1', '1', 'proj10.c', 0),
(253, 'uploads/Courses/3', '3', 'proj10.c', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `sfupdate`
--

INSERT INTO `sfupdate` (`update_ID`, `course_ID`, `update_text`, `update_time`) VALUES
(1, 6, 'Class had a test', '2012-03-02 12:20:00'),
(2, 7, 'Class discussed Normalized tables', '2012-03-02 13:35:00'),
(3, 6, 'Another update to course.', '2012-03-07 16:00:00'),
(4, 7, 'Test update.', '2012-03-07 00:00:00'),
(7, 7, 'Study hard!', '2012-03-07 21:25:43'),
(6, 7, 'Test coming up!', '2012-03-07 21:21:37'),
(8, 7, 'Remember the homework for friday.', '2012-03-07 21:26:05'),
(9, 7, 'No class thursday.', '2012-03-07 21:30:41'),
(10, 6, 'Everyone passed the exam!', '2012-03-07 13:00:00'),
(11, 7, 'Disco time!', '2012-03-07 21:47:38'),
(12, 9, 'I am born!', '2012-03-07 22:27:54'),
(13, 9, 'Read library by end of semester.', '2012-03-07 22:29:57'),
(14, 9, 'Did you read the library yet?', '2012-03-07 22:30:17'),
(15, 9, 'I really need that library read now.', '2012-03-07 22:30:30'),
(16, 9, 'Seriously guys, the library, read it.', '2012-03-07 22:34:35'),
(17, 9, 'Everyone passes!', '2012-03-08 00:00:00'),
(18, 9, 'Actually you all failed...', '2012-03-09 11:40:02'),
(19, 9, 'Let''s hope this works!', '2012-03-09 15:37:39'),
(20, 9, 'One more time!', '2012-03-09 14:00:00'),
(21, 9, 'Third time is a charm...', '2012-03-09 16:00:00'),
(22, 9, 'Last time?', '2012-03-09 16:00:00'),
(23, 9, 'Let''s hope this works again!', '2012-03-09 17:00:00'),
(24, 9, 'And the horse we rode in on...', '2012-03-09 17:00:00'),
(25, 9, 'Another test update.', '2012-03-10 13:00:00'),
(26, 9, 'One more test update.', '2012-03-10 14:00:00'),
(27, 9, 'Once again!', '2012-03-10 15:00:00'),
(28, 9, 'Keep at it junior.', '2012-03-10 16:00:00'),
(29, 9, 'Lookin good!', '2012-03-10 17:00:00'),
(30, 9, 'More work!', '2012-03-15 00:00:00'),
(31, 9, 'Into the future!', '2012-03-18 00:00:00'),
(32, 9, 'Back to the future!', '2012-03-18 01:00:00'),
(33, 9, 'Back to the future 2!', '2012-03-18 02:00:00'),
(34, 9, 'We hit 88 so this SHOULD work.', '2012-03-18 03:00:00'),
(35, 7, 'New event added.undefined', '2012-03-27 22:12:33'),
(36, 7, 'New event added.undefined', '2012-03-27 22:16:14'),
(37, 7, 'New event added.Win', '2012-03-27 22:33:17'),
(38, 7, 'New event added: Event on 2012-3-8 at 12:00.', '2012-03-27 22:43:21'),
(39, 7, 'New event added: New Event on 2012-3-14 at 12:00.', '2012-03-27 22:44:45'),
(40, 7, 'New event junk added on 2012-3-15 at 12:00.', '2012-03-27 22:46:56'),
(41, 7, 'New event q added on 2012-3-20 at 12:00.', '2012-03-27 22:48:53'),
(42, 7, 'New event Event added on 2012-3-21 12:00', '2012-03-27 23:28:53'),
(47, 7, 'Event q was deleted from calendar', '2012-03-28 00:06:04'),
(44, 7, 'Event Study session rescheduled to 2012-03-12 10:00:00', '2012-03-28 00:00:32'),
(45, 7, 'Event Test rescheduled to 2012-03-06 12:00:00', '2012-03-28 00:02:30'),
(48, 7, 'Event junk was deleted from calendar.', '2012-03-28 00:06:47'),
(49, 7, 'Event Event rescheduled to 2012-03-14 12:00:00.', '2012-03-28 18:38:33'),
(50, 7, 'Event Event was deleted from calendar.', '2012-03-28 18:39:43'),
(51, 7, 'New event New Event added on 2012-3-8 12:00', '2012-03-28 18:40:22'),
(52, 0, 'Event Walker time! rescheduled to 2012-02-27 03:14:07.', '2012-03-28 18:44:15'),
(53, 0, 'Event Walker time! rescheduled to 2012-03-05 03:14:07.', '2012-03-28 18:44:20'),
(54, 0, 'Event Walker Time II Walker Time Strikes Back rescheduled to 2012-02-21 07:30:00.', '2012-03-28 18:44:25'),
(55, 7, 'Event Win rescheduled to 2012-02-29 12:00:00.', '2012-03-28 19:26:40'),
(56, 7, 'Event New Event was deleted from calendar.', '2012-03-28 19:26:57'),
(57, 7, 'Event Win rescheduled to 2012-03-16 12:00:00.', '2012-03-28 19:27:07');

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
('567403185', 'Zack', 'Bush', '', '', '', '', 0, ''),
('609904185', 'Jared', 'Thompson', '', '', '', '', 0, ''),
('9384948', 'Brad', 'Mason', '', '', '', '', 0, ''),
('100002585728884', 'Leonard', 'Church', '', '', '', '', 0, ''),
('100002149553265', 'Alex', 'Wardi', '', '', '', '', 0, ''),
('100', 'Gary', 'Walker', '', '', 'Penn State Behrend', '', 1, ''),
('200', 'Charles', 'Burchard', '', '', 'Penn State Behrend', '', 1, ''),
('300', 'Dudley', 'Morris', '', '', 'Penn State Behrend', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_ID` int(11) NOT NULL AUTO_INCREMENT,
  `thread_title` varchar(255) NOT NULL,
  `course_ID` int(11) NOT NULL,
  PRIMARY KEY (`thread_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_ID`, `thread_title`, `course_ID`) VALUES
(1, 'test', 343),
(2, 'Thread 2', 4),
(3, 'Thread 3', 5),
(6, 'Chapter 1', 343),
(7, 'Chapter 2', 343),
(8, 'Chapter 3', 343),
(61, '', 4),
(60, 'adding a new thread', 4),
(59, 'new post', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
