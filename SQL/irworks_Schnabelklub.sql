-- phpMyAdmin SQL Dump
-- version 4.1.14.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 09, 2015 at 06:28 PM
-- Server version: 5.1.73-log
-- PHP Version: 5.5.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `irworks_Schnabelklub`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `newsID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `newsTitle` varchar(255) NOT NULL DEFAULT '',
  `newsContent` mediumtext NOT NULL,
  `newsAuthorID` int(11) NOT NULL,
  `newsTimestamp` int(11) NOT NULL,
  PRIMARY KEY (`newsID`),
  UNIQUE KEY `newsID` (`newsID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest`
--

CREATE TABLE IF NOT EXISTS `quest` (
  `questID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questName` varchar(255) NOT NULL DEFAULT '',
  `questDescription` varchar(255) NOT NULL DEFAULT '',
  `questScore` int(11) NOT NULL,
  `questShowTweetBtn` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`questID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `questlog`
--

CREATE TABLE IF NOT EXISTS `questlog` (
  `questLogID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questIdConnection` int(11) NOT NULL,
  `questLogUserID` int(11) NOT NULL,
  `questLogMessage` varchar(255) NOT NULL DEFAULT '',
  `questLogTimestamp` int(11) NOT NULL,
  `questReviewed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`questLogID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `rankID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rankName` varchar(128) NOT NULL DEFAULT '',
  `rankMinScore` int(11) NOT NULL,
  PRIMARY KEY (`rankID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `twitterID` varchar(250) NOT NULL DEFAULT '',
  `username` varchar(128) NOT NULL DEFAULT '',
  `displayName` varchar(128) NOT NULL DEFAULT '',
  `displayBio` varchar(255) NOT NULL DEFAULT '',
  `displayProfileImage` varchar(255) NOT NULL DEFAULT '',
  `oauthToken` varchar(255) NOT NULL DEFAULT '',
  `oauthTokenSecret` varchar(255) NOT NULL DEFAULT '',
  `currentQuest` int(11) NOT NULL DEFAULT '1',
  `currentRank` int(11) NOT NULL DEFAULT '1',
  `currentScore` int(11) NOT NULL DEFAULT '0',
  `firstLogin` int(42) NOT NULL,
  `lastLogin` int(42) NOT NULL,
  `lastQuest` int(11) NOT NULL,
  `questEnabled` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID` (`userID`),
  UNIQUE KEY `twitterID` (`twitterID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
