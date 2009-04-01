-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Vert: localhost
-- Generert den: 31. Mar, 2009 14:19 PM
-- Tjenerversjon: 5.1.30
-- PHP-Versjon: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `airdog`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_bruker`
--

CREATE TABLE IF NOT EXISTS `ad_bruker` (
  `epost` varchar(50) NOT NULL,
  `fornavn` varchar(30) NOT NULL,
  `etternavn` varchar(30) NOT NULL,
  `passord` varchar(50) NOT NULL,
  `superadmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`epost`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_bruker`
--



-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_bruker_klubb_rolle_link`
--

CREATE TABLE IF NOT EXISTS `ad_bruker_klubb_rolle_link` (
  `ad_rolle_navn` varchar(50) NOT NULL DEFAULT '',
  `ad_bruker_epost` varchar(50) NOT NULL DEFAULT '',
  `ad_klubb_raseid` int(3) NOT NULL,
  KEY `AD_rolle_navn` (`ad_rolle_navn`),
  KEY `AD_bruker_epost` (`ad_bruker_epost`),
  KEY `AD_klubb_navn` (`ad_klubb_raseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_bruker_klubb_rolle_link`
--



-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_datreferanser`
--

CREATE TABLE IF NOT EXISTS `ad_datreferanser` (
  `hash` varchar(40) NOT NULL,
  `tekst` mediumtext NOT NULL,
  `endretAv` varchar(50) NOT NULL,
  `endretDato` date NOT NULL,
  PRIMARY KEY (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_datreferanser`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_klubb`
--

CREATE TABLE IF NOT EXISTS `ad_klubb` (
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(50) DEFAULT NULL,
  `raseid` int(3) NOT NULL,
  PRIMARY KEY (`raseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_klubb`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_rettighet`
--

CREATE TABLE IF NOT EXISTS `ad_rettighet` (
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`navn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_rettighet`
--



-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_rolle`
--

CREATE TABLE IF NOT EXISTS `ad_rolle` (
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`navn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_rolle`
--



-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_rolle_rettighet_link`
--

CREATE TABLE IF NOT EXISTS `ad_rolle_rettighet_link` (
  `ad_rolle_navn` varchar(50) NOT NULL DEFAULT '',
  `ad_rettighet_navn` varchar(50) NOT NULL DEFAULT '',
  KEY `AD_rolle_navn` (`ad_rolle_navn`),
  KEY `AD_rettighet_navn` (`ad_rettighet_navn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_rolle_rettighet_link`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_aasykdom`
--

CREATE TABLE IF NOT EXISTS `nkk_aasykdom` (
  `veId` varchar(4) NOT NULL,
  `aaId` varchar(7) NOT NULL,
  `diagnoseKode` int(1) NOT NULL,
  `idmerketkode` int(1) NOT NULL,
  `lidelseKode` int(1) NOT NULL,
  `sekHoyreKode` int(1) NOT NULL,
  `sekVenstreKode` int(1) NOT NULL,
  `endretAv` varchar(32) NOT NULL,
  `regAv` varchar(32) NOT NULL,
  `avlestAv` varchar(32) NOT NULL,
  `betaling` int(1) NOT NULL,
  `diagnose` varchar(6) NOT NULL,
  `hundId` varchar(17) NOT NULL,
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
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`aaId`,`raseId`)
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
  `hundId` varchar(17) NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`hundId`,`raseId`)
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
  `hundId` varchar(17) NOT NULL,
  `idmerket` varchar(1) NOT NULL,
  `idmerketkode` varchar(20) NOT NULL,
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
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`hofteDyId`,`raseId`)
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
  `hundId` varchar(17) NOT NULL,
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
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`oyId`,`raseId`)
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
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`personId`)
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
  `hundId` varchar(17) NOT NULL,
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
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`utstillingId`,`hundId`,`raseId`)
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
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`utstillingId`,`raseId`)
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
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`veterinerId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `nkk_veteriner`
--
