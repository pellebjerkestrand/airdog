-- phpMyAdmin SQL Dump
-- version 2.11.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2009 at 09:22 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `airdog`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_bruker`
--

DROP TABLE IF EXISTS `ad_bruker`;
CREATE TABLE `ad_bruker` (
  `epost` varchar(50) NOT NULL,
  `fornavn` varchar(30) NOT NULL,
  `etternavn` varchar(30) NOT NULL,
  `passord` varchar(50) NOT NULL,
  `superadmin` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`epost`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_bruker`
--

INSERT INTO `ad_bruker` VALUES('gjest', 'gjest', 'gjest', '9195bf0c194e9e0b8fff4bbcdfe89298e1ecb051', 0);
INSERT INTO `ad_bruker` VALUES('admin', 'admin', '', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1);
INSERT INTO `ad_bruker` VALUES('hmi@live.no', 'Hans Magnus', 'Inderberg', 'test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ad_bruker_klubb_rolle_link`
--

DROP TABLE IF EXISTS `ad_bruker_klubb_rolle_link`;
CREATE TABLE `ad_bruker_klubb_rolle_link` (
  `ad_rolle_navn` varchar(50) NOT NULL default '',
  `ad_bruker_epost` varchar(50) NOT NULL default '',
  `ad_klubb_raseid` int(3) NOT NULL,
  KEY `AD_rolle_navn` (`ad_rolle_navn`),
  KEY `AD_bruker_epost` (`ad_bruker_epost`),
  KEY `AD_klubb_navn` (`ad_klubb_raseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_bruker_klubb_rolle_link`
--

INSERT INTO `ad_bruker_klubb_rolle_link` VALUES('admin', 'admin', 348);
INSERT INTO `ad_bruker_klubb_rolle_link` VALUES('gjest', 'gjest', 306);
INSERT INTO `ad_bruker_klubb_rolle_link` VALUES('gjest', 'gjest', 348);
INSERT INTO `ad_bruker_klubb_rolle_link` VALUES('gjest', 'hmi@live.no', 348);
INSERT INTO `ad_bruker_klubb_rolle_link` VALUES('admin', 'hmi@live.no', 348);
INSERT INTO `ad_bruker_klubb_rolle_link` VALUES('gjest', 'admin', 348);
INSERT INTO `ad_bruker_klubb_rolle_link` VALUES('gjest', 'hmi@live.no', 307);

-- --------------------------------------------------------

--
-- Table structure for table `ad_klubb`
--

DROP TABLE IF EXISTS `ad_klubb`;
CREATE TABLE `ad_klubb` (
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(50) default NULL,
  `raseid` int(3) NOT NULL,
  PRIMARY KEY  (`raseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_klubb`
--

INSERT INTO `ad_klubb` VALUES('Norsk Breton Klubb', NULL, 306);
INSERT INTO `ad_klubb` VALUES('Norsk Pointer Klubb', NULL, 348);
INSERT INTO `ad_klubb` VALUES('Test', NULL, 307);

-- --------------------------------------------------------

--
-- Table structure for table `ad_rettighet`
--

DROP TABLE IF EXISTS `ad_rettighet`;
CREATE TABLE `ad_rettighet` (
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(250) default NULL,
  PRIMARY KEY  (`navn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_rettighet`
--

INSERT INTO `ad_rettighet` VALUES('Lese', 'Utføre handlinger som ikke endrer på databasen');
INSERT INTO `ad_rettighet` VALUES('Rediger hund', NULL);
INSERT INTO `ad_rettighet` VALUES('Rediger jaktprøve', NULL);
INSERT INTO `ad_rettighet` VALUES('Importer database', NULL);
INSERT INTO `ad_rettighet` VALUES('Legge inn jaktprøve', NULL);
INSERT INTO `ad_rettighet` VALUES('Slett jaktprøve', NULL);
INSERT INTO `ad_rettighet` VALUES('Rollehåndtering', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ad_rolle`
--

DROP TABLE IF EXISTS `ad_rolle`;
CREATE TABLE `ad_rolle` (
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(50) default NULL,
  PRIMARY KEY  (`navn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_rolle`
--

INSERT INTO `ad_rolle` VALUES('admin', 'admin');
INSERT INTO `ad_rolle` VALUES('gjest', 'gjest');

-- --------------------------------------------------------

--
-- Table structure for table `ad_rolle_rettighet_link`
--

DROP TABLE IF EXISTS `ad_rolle_rettighet_link`;
CREATE TABLE `ad_rolle_rettighet_link` (
  `ad_rolle_navn` varchar(50) NOT NULL default '',
  `ad_rettighet_navn` varchar(50) NOT NULL default '',
  KEY `AD_rolle_navn` (`ad_rolle_navn`),
  KEY `AD_rettighet_navn` (`ad_rettighet_navn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_rolle_rettighet_link`
--

INSERT INTO `ad_rolle_rettighet_link` VALUES('gjest', 'Rediger hund');
INSERT INTO `ad_rolle_rettighet_link` VALUES('gjest', 'Lese');
INSERT INTO `ad_rolle_rettighet_link` VALUES('gjest', 'Rediger jaktprøve');
INSERT INTO `ad_rolle_rettighet_link` VALUES('admin', 'Legge inn jaktprøve');
INSERT INTO `ad_rolle_rettighet_link` VALUES('gjest', 'RolleHåndtering');
INSERT INTO `ad_rolle_rettighet_link` VALUES('admin', 'Rollehåndtering');
