SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `schedulebucket` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `schedulebucket`;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `cid` int(5) NOT NULL,
  `gid` int(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `cat_order` int(5) NOT NULL,
  `status` int(4) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `tid` int(11) NOT NULL,
  `gid` int(5) NOT NULL,
  `status` int(4) NOT NULL,
  `cid` int(5) NOT NULL,
  `task_order` int(4) NOT NULL,
  `description` varchar(250) NOT NULL,
  `color` varchar(7) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `status` (`status`),
  KEY `gid` (`gid`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `gid` int(5) NOT NULL AUTO_INCREMENT,
  `nameshort` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`gid`),
  UNIQUE KEY `nameshort` (`nameshort`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10000 ;


ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `units` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `units` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE;

GRANT USAGE ON `schedulebucket`.* TO 'sb-webuser'@'localhost' IDENTIFIED BY 'db-password';
GRANT SELECT, INSERT, UPDATE, DELETE ON `schedulebucket`.* TO 'sb-webuser'@'localhost';
