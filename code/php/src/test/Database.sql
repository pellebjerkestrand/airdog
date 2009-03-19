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
INSERT INTO `ad_rettighet` VALUES('tering', NULL);

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
INSERT INTO `ad_rolle_rettighet_link` VALUES('gjest', 'Rollehåndtering');
INSERT INTO `ad_rolle_rettighet_link` VALUES('admin', 'Rollehåndtering');











CREATE TABLE IF NOT EXISTS `nkk_aasykdom` (
  `veId` varchar(4) NOT NULL,
  `aaId` varchar(7) NOT NULL,
  `diagnoseKode` int(1) NOT NULL,
  `idmerkeKode` int(1) NOT NULL,
  `lidelseKode` int(1) NOT NULL,
  `sekHoyreKode` int(1) NOT NULL,
  `sekVenstreKode` int(1) NOT NULL,
  `endretAv` varchar(32) NOT NULL,
  `regAv` varchar(32) NOT NULL,
  `avlestAv` varchar(32) NOT NULL,
  `betaling` int(1) NOT NULL,
  `diagnose` varchar(6) NOT NULL,
  `hundId` varchar(9) NOT NULL,
  `idFeil` varchar(6) NOT NULL,
  `idMerket` varchar(1) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `lidelse` varchar(1) NOT NULL,
  `peId` varchar(7) NOT NULL,
  `purring` varchar(20) NOT NULL,
  `raseId` int(3) NOT NULL,
  `retur` varchar(20) NOT NULL,
  `sekHoyre` varchar(16) NOT NULL,
  `sekVenstre` varchar(16) NOT NULL,
  `sendes` varchar(20) NOT NULL,
  `avlestDato` date NOT NULL,
  `rontgenDato` date NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_aasykdom`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_eier`
--

CREATE TABLE IF NOT EXISTS `nkk_eier` (
  `eier` varchar(64) NOT NULL,
  `hundId` varchar(9) NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_eier`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_fugl`
--

CREATE TABLE IF NOT EXISTS `nkk_fugl` (
  `proveNr` varchar(8) NOT NULL,
  `proveDato` date NOT NULL,
  `partiNr` varchar(3) NOT NULL,
  `klasse` int(1) NOT NULL,
  `dommerId1` varchar(7) NOT NULL,
  `dommerId2` varchar(7) NOT NULL,
  `hundId` varchar(17) NOT NULL,
  `slippTid` int(2) DEFAULT NULL,
  `egneStand` int(1) DEFAULT NULL,
  `egneStokk` int(1) DEFAULT NULL,
  `tomStand` int(1) DEFAULT NULL,
  `makkerStand` int(1) DEFAULT NULL,
  `makkerStokk` int(1) DEFAULT NULL,
  `jaktlyst` int(1) DEFAULT NULL,
  `fart` int(1) DEFAULT NULL,
  `stil` int(1) DEFAULT NULL,
  `selvstendighet` int(1) DEFAULT NULL,
  `bredde` int(1) DEFAULT NULL,
  `reviering` int(1) DEFAULT NULL,
  `samarbeid` int(1) DEFAULT NULL,
  `presUpresis` int(1) DEFAULT NULL,
  `presNoeUpresis` int(1) DEFAULT NULL,
  `presPresis` int(1) DEFAULT NULL,
  `reisNekter` int(1) DEFAULT NULL,
  `reisNoelende` int(1) DEFAULT NULL,
  `reisVillig` int(1) DEFAULT NULL,
  `reisDjerv` int(1) DEFAULT NULL,
  `sokStjeler` int(1) DEFAULT NULL,
  `sokSpontant` int(1) DEFAULT NULL,
  `appIkkeGodkjent` int(1) DEFAULT NULL,
  `appGodkjent` int(1) DEFAULT NULL,
  `rappInnkalt` int(1) DEFAULT NULL,
  `rappSpont` int(1) DEFAULT NULL,
  `premiegrad` int(1) DEFAULT NULL,
  `certifikat` int(1) DEFAULT NULL,
  `regAv` varchar(32) NOT NULL,
  `regDato` date NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  `kritikk` mediumtext,
  KEY `proveNr` (`proveNr`,`proveDato`,`hundId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_fugl`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_hdsykdom`
--

CREATE TABLE IF NOT EXISTS `nkk_hdsykdom` (
  `avlestAv` varchar(16) NOT NULL,
  `betaling` int(1) NOT NULL,
  `diagnose` varchar(3) NOT NULL,
  `diagnoseKode` int(1) NOT NULL,
  `endretAv` varchar(16) NOT NULL,
  `hofteDyId` varchar(7) NOT NULL,
  `hundId` varchar(9) NOT NULL,
  `idmerket` varchar(1) NOT NULL,
  `idmerketKode` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `lidelse` varchar(1) NOT NULL,
  `lidelseKode` int(1) NOT NULL,
  `personId` varchar(7) NOT NULL,
  `raseId` int(3) NOT NULL,
  `registrertAv` varchar(16) NOT NULL,
  `sekHoyre` varchar(20) NOT NULL,
  `sekHoyreKode` int(1) NOT NULL,
  `sekVenstre` varchar(20) NOT NULL,
  `sekVenstreKode` int(1) NOT NULL,
  `sendes` varchar(20) NOT NULL,
  `veterinerId` varchar(4) NOT NULL,
  `rontgenDato` date NOT NULL,
  `avlestDato` date NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_hdsykdom`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_hund`
--

CREATE TABLE IF NOT EXISTS `nkk_hund` (
  `raseId` int(3) NOT NULL,
  `kullId` varchar(6) NOT NULL,
  `hundId` varchar(17) NOT NULL,
  `tittel` varchar(64) NOT NULL,
  `navn` varchar(64) NOT NULL,
  `hundFarId` varchar(17) NOT NULL,
  `hundMorId` varchar(17) NOT NULL,
  `idNr` varchar(7) NOT NULL,
  `farge` varchar(32) NOT NULL,
  `fargeVariant` varchar(32) NOT NULL,
  `oyesykdom` varchar(16) NOT NULL,
  `hoftesykdom` varchar(1) NOT NULL,
  `haarlag` varchar(16) NOT NULL,
  `idMerke` varchar(1) NOT NULL,
  `kjonn` varchar(1) NOT NULL,
  `eierId` varchar(7) NOT NULL,
  `endretAv` varchar(16) NOT NULL,
  `endretDato` date NOT NULL,
  `regDato` date NOT NULL,
  `storrelse` varchar(16) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`raseId`,`hundId`),
  KEY `hundId` (`hundId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_hund`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_kull`
--

CREATE TABLE IF NOT EXISTS `nkk_kull` (
  `kullId` varchar(6) NOT NULL,
  `hundIdFar` varchar(9) NOT NULL,
  `hundIdMor` varchar(9) NOT NULL,
  `oppdretterId` varchar(7) NOT NULL,
  `endretDato` date NOT NULL,
  `fodt` date NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_kull`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_oppdrett`
--

CREATE TABLE IF NOT EXISTS `nkk_oppdrett` (
  `kullId` varchar(6) NOT NULL,
  `oppdretter` varchar(64) NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_oppdrett`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_oyesykdom`
--

CREATE TABLE IF NOT EXISTS `nkk_oyesykdom` (
  `oyId` varchar(7) NOT NULL,
  `hundId` varchar(9) NOT NULL,
  `veterinerId` varchar(4) NOT NULL,
  `oyeVeteriner` varchar(2) NOT NULL,
  `lystDato` date NOT NULL,
  `idmerketKode` varchar(1) NOT NULL,
  `idmerket` int(1) NOT NULL,
  `idfeil` varchar(20) NOT NULL,
  `raseId` int(3) NOT NULL,
  `sendtEierDato` date NOT NULL,
  `longAnnet` varchar(20) NOT NULL,
  `diagnoseKode1` varchar(20) NOT NULL,
  `diagnoseGrad1` varchar(20) NOT NULL,
  `diagnoseKode2` varchar(20) NOT NULL,
  `diagnoseGrad2` varchar(20) NOT NULL,
  `diagnoseKode3` varchar(20) NOT NULL,
  `diagnoseGrad3` varchar(20) NOT NULL,
  `regAv` varchar(16) NOT NULL,
  `regDato` date NOT NULL,
  `endretAv` varchar(16) NOT NULL,
  `endretDato` date NOT NULL,
  `personId` varchar(7) NOT NULL,
  `sendtVetDato` date NOT NULL,
  `sendtKlubbDato` date NOT NULL,
  `longAnnet1` varchar(20) NOT NULL,
  `longAnnet2` varchar(20) NOT NULL,
  `inaktiv` varchar(1) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_oyesykdom`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_person`
--

CREATE TABLE IF NOT EXISTS `nkk_person` (
  `personId` varchar(7) NOT NULL,
  `navn` varchar(64) NOT NULL,
  `adresse1` varchar(64) NOT NULL,
  `adresse2` varchar(64) NOT NULL,
  `adresse3` varchar(64) NOT NULL,
  `postNr` varchar(4) NOT NULL,
  `landkode` varchar(1) NOT NULL,
  `raseId` int(3) NOT NULL,
  `status` varchar(20) NOT NULL,
  `telefon1` varchar(16) NOT NULL,
  `endretDato` date NOT NULL,
  `regDato` date NOT NULL,
  `fodt` date NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_person`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_premie`
--

CREATE TABLE IF NOT EXISTS `nkk_premie` (
  `doId` varchar(6) NOT NULL,
  `utstillingId` varchar(6) NOT NULL,
  `hundId` varchar(9) NOT NULL,
  `katalogNr` int(3) NOT NULL,
  `personIdDommer` varchar(7) NOT NULL,
  `klasse` varchar(1) NOT NULL,
  `kjonn` varchar(1) NOT NULL,
  `raseId` int(3) NOT NULL,
  `IM` int(1) NOT NULL,
  `KIP` int(1) NOT NULL,
  `JK` int(1) NOT NULL,
  `JKK` int(1) NOT NULL,
  `UK` int(1) NOT NULL,
  `UKK` int(1) NOT NULL,
  `BK` int(1) NOT NULL,
  `BKK` int(1) NOT NULL,
  `AK` int(1) NOT NULL,
  `AKK` int(1) NOT NULL,
  `VK` int(1) NOT NULL,
  `CHK` int(1) NOT NULL,
  `CHKK` int(1) NOT NULL,
  `VTK` int(1) NOT NULL,
  `VTKK` int(1) NOT NULL,
  `HP` int(1) NOT NULL,
  `CK` int(1) NOT NULL,
  `CC` int(1) NOT NULL,
  `CA` int(1) NOT NULL,
  `BIK` int(1) NOT NULL,
  `BIR` int(1) NOT NULL,
  `BIM` int(1) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_premie`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_utstilling`
--

CREATE TABLE IF NOT EXISTS `nkk_utstilling` (
  `utstillingId` varchar(6) NOT NULL,
  `klasseId` varchar(6) NOT NULL,
  `personId` varchar(7) NOT NULL,
  `regDato` date NOT NULL,
  `regAv` varchar(16) NOT NULL,
  `navn` varchar(64) NOT NULL,
  `adresse1` varchar(64) NOT NULL,
  `adresse2` varchar(64) NOT NULL,
  `postNr` varchar(4) NOT NULL,
  `spesialAdresse` varchar(64) NOT NULL,
  `utstillingDato` date NOT NULL,
  `utstillingSted` varchar(64) NOT NULL,
  `arrangorNavn1` varchar(64) NOT NULL,
  `arrangorNavn2` varchar(64) NOT NULL,
  `overfortDato` date NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_utstilling`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_veteriner`
--

CREATE TABLE IF NOT EXISTS `nkk_veteriner` (
  `veterinerId` varchar(5) NOT NULL,
  `personId` varchar(7) NOT NULL,
  `adresse1` varchar(64) NOT NULL,
  `adresse2` varchar(64) NOT NULL,
  `adresse3` varchar(64) NOT NULL,
  `postNr` varchar(4) NOT NULL,
  `telefon` varchar(16) NOT NULL,
  `telefax` varchar(16) NOT NULL,
  `klinikkNavn` varchar(64) NOT NULL,
  `regDato` date NOT NULL,
  `regAv` varchar(16) NOT NULL,
  `endretAv` varchar(16) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_veteriner`
--


