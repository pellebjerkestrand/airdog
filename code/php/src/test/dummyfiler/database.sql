-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Vert: localhost
-- Generert den: 04. Feb, 2009 12:49 PM
-- Tjenerversjon: 5.1.30
-- PHP-Versjon: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `airdog`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `eier`
--

DROP TABLE IF EXISTS `eier`;
CREATE TABLE IF NOT EXISTS `eier` (
  `navn` varchar(64) NOT NULL,
  `hundId` varchar(16) NOT NULL,
  `raseId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `eier`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `hund`
--

DROP TABLE IF EXISTS `hund`;
CREATE TABLE IF NOT EXISTS `hund` (
  `raseId` varchar(8) NOT NULL,
  `kullId` varchar(8) NOT NULL,
  `hundId` varchar(16) NOT NULL,
  `tittel` varchar(128) NOT NULL,
  `navn` varchar(128) NOT NULL,
  `hundFarId` varchar(16) NOT NULL,
  `hundMorId` varchar(16) NOT NULL,
  `idNr` varchar(16) NOT NULL,
  `farge` varchar(16) NOT NULL,
  `fargeVariant` varchar(16) NOT NULL,
  `oyesykdom` varchar(16) NOT NULL,
  `hoftesykdom` varchar(16) NOT NULL,
  `haarlag` varchar(16) NOT NULL,
  `idMerke` varchar(16) NOT NULL,
  `kjonn` varchar(1) NOT NULL,
  `eierId` varchar(16) NOT NULL,
  `endretAv` varchar(16) NOT NULL,
  `endretDato` date NOT NULL,
  `regDato` date NOT NULL,
  `storrelse` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `hund`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `rase`
--

DROP TABLE IF EXISTS `rase`;
CREATE TABLE IF NOT EXISTS `rase` (
  `id` int(11) NOT NULL,
  `navn` varchar(64) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `rase`
--

