SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `bill_friends` (
  `USERID` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bill_friends` (`USERID`) VALUES
('Hank'),
('Dale');

CREATE TABLE IF NOT EXISTS `bill_updates` (
  `USERID` varchar(80) NOT NULL,
  `STATUS` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bill_updates` (`USERID`, `STATUS`) VALUES
('Hank', 'Propene!'),
('Dale', 'THE GOVERMENT IS RUINING OUR MINDS!');

CREATE TABLE IF NOT EXISTS `bobby_friends` (
  `USERID` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bobby_friends` (`USERID`) VALUES
('Joseph'),
('Hank');

CREATE TABLE IF NOT EXISTS `bobby_updates` (
  `USERID` varchar(80) NOT NULL,
  `STATUS` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bobby_updates` (`USERID`, `STATUS`) VALUES
('Hank', 'Propene!'),
('Joseph', 'My dad is weird...');

CREATE TABLE IF NOT EXISTS `dale_friends` (
  `USERID` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `dale_friends` (`USERID`) VALUES
('Joseph'),
('Hank'),
('Bill');

CREATE TABLE IF NOT EXISTS `dale_updates` (
  `USERID` varchar(80) NOT NULL,
  `STATUS` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `dale_updates` (`USERID`, `STATUS`) VALUES
('Hank', 'Propene!'),
('Bill', 'Hank I can see your post!'),
('Joseph', 'My dad is weird...');

CREATE TABLE IF NOT EXISTS `example` (
  `name` char(80) NOT NULL,
  `age` int(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `example` (`name`, `age`) VALUES
('Timmy Mellowman', 23),
('Sandy Smith', 21),
('Bobby Wallace', 15),
('Timmy Mellowman', 23),
('Sandy Smith', 21),
('Bobby Wallace', 15),
('Timmy Mellowman', 23),
('Sandy Smith', 21),
('Bobby Wallace', 15),
('Timmy', 3),
('Timmy Mellowman', 23),
('Sandy Smith', 21),
('Bobby Wallace', 15),
('Timmy Mellowman', 23),
('Sandy Smith', 21),
('Bobby Wallace', 15);

CREATE TABLE IF NOT EXISTS `hank_friends` (
  `USERID` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `hank_friends` (`USERID`) VALUES
('Dale'),
('Bill'),
('Bobby');

CREATE TABLE IF NOT EXISTS `hank_updates` (
  `USERID` varchar(80) NOT NULL,
  `STATUS` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `hank_updates` (`USERID`, `STATUS`) VALUES
('Dale', 'THE GOVERMENT IS RUINING OUR MINDS!'),
('Bill', 'Hank I can see your post!'),
('Bobby', 'Im a dalmation!');

CREATE TABLE IF NOT EXISTS `joseph_friends` (
  `USERID` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `joseph_friends` (`USERID`) VALUES
('Dale'),
('Bobby');

CREATE TABLE IF NOT EXISTS `joseph_updates` (
  `USERID` varchar(80) NOT NULL,
  `STATUS` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `joseph_updates` (`USERID`, `STATUS`) VALUES
('Dale', 'THE GOVERMENT IS RUINING OUR MINDS!'),
('Bobby', 'Im a dalmation!');

CREATE TABLE IF NOT EXISTS `statustable` (
  `User` varchar(80) NOT NULL,
  `Status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `statustable` (`User`, `Status`) VALUES
('Jim', 'Status'),
('Rob', 'I am rob.'),
('Timothy', 'I am tim.'),
('Tony', 'I am tony.'),
('Tony', 'I am tony. WUZZUP!?'),
('Tony Broni', 'I am tony. WUZZUP!?'),
('Rob', 'Powermanplan'),
('Rob', 'Powermanplan'),
('Rob', 'Powermanplan'),
('Rob', 'Powermanplan'),
('Rob', 'go go go'),
('Rob', 'go go go'),
('test', 'Tim Tebow!'),
('test', 'Pokemon!?'),
('test', 'Pokemon!?'),
('test', 'Pokemon!?');

CREATE TABLE IF NOT EXISTS `test_friends` (
  `USERID` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `test_friends` (`USERID`) VALUES
('test');

CREATE TABLE IF NOT EXISTS `test_updates` (
  `USERID` varchar(80) NOT NULL,
  `STATUS` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `test_updates` (`USERID`, `STATUS`) VALUES
('test', 'Pokemon!?'),
('test', 'Yeah!');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
