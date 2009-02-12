-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Vert: localhost
-- Generert den: 12. Feb, 2009 14:38 PM
-- Tjenerversjon: 5.1.30
-- PHP-Versjon: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `airdog`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `aasykdom`
--

CREATE TABLE IF NOT EXISTS `aasykdom` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `aasykdom`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bruker`
--

CREATE TABLE IF NOT EXISTS `bruker` (
  `brukernavn` varchar(20) NOT NULL,
  `passord` varchar(20) NOT NULL,
  `fornavn` varchar(20) NOT NULL,
  `etternavn` varchar(20) NOT NULL,
  `rolle` varchar(20) NOT NULL,
  PRIMARY KEY (`brukernavn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `bruker`
--

INSERT INTO `bruker` (`brukernavn`, `passord`, `fornavn`, `etternavn`, `rolle`) VALUES
('admin', 'password', 'admin', 'admin', 'admin'),
('Super', 'password', 'Super', 'Super', 'Super');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `eier`
--

CREATE TABLE IF NOT EXISTS `eier` (
  `eier` varchar(64) NOT NULL,
  `hundId` varchar(9) NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `eier`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `fugl`
--

CREATE TABLE IF NOT EXISTS `fugl` (
  `proveNr` varchar(8) NOT NULL,
  `proveDato` date NOT NULL,
  `partiNr` varchar(3) NOT NULL,
  `klasse` int(1) NOT NULL,
  `dommerId1` varchar(7) NOT NULL,
  `dommerId2` varchar(7) NOT NULL,
  `hundId` varchar(9) NOT NULL,
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
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `fugl`
--

INSERT INTO `fugl` (`proveNr`, `proveDato`, `partiNr`, `klasse`, `dommerId1`, `dommerId2`, `hundId`, `slippTid`, `egneStand`, `egneStokk`, `tomStand`, `makkerStand`, `makkerStokk`, `jaktlyst`, `fart`, `stil`, `selvstendighet`, `bredde`, `reviering`, `samarbeid`, `presUpresis`, `presNoeUpresis`, `presPresis`, `reisNekter`, `reisNoelende`, `reisVillig`, `reisDjerv`, `sokStjeler`, `sokSpontant`, `appIkkeGodkjent`, `appGodkjent`, `rappInnkalt`, `rappSpont`, `premiegrad`, `certifikat`, `regAv`, `regDato`, `raseId`, `manueltEndretAv`, `manueltEndretDato`) VALUES
('50-94014', '2009-02-09', '', 0, '', '', '1337', 30, 2, 0, 0, 1, 2, 3, 5, 2, 3, 1, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '', '0000-00-00', 0, '', '0000-00-00'),
('50-94015', '2009-02-13', '', 0, '', '', '1337', 30, 2, 0, 0, 1, 1, 34, 3, 1, 2, 4, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '', '0000-00-00', 0, '', '0000-00-00');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `hdsykdom`
--

CREATE TABLE IF NOT EXISTS `hdsykdom` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `hdsykdom`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `hund`
--

CREATE TABLE IF NOT EXISTS `hund` (
  `raseId` int(3) NOT NULL,
  `kullId` varchar(6) NOT NULL,
  `hundId` varchar(9) NOT NULL,
  `tittel` varchar(64) NOT NULL,
  `navn` varchar(64) NOT NULL,
  `hundFarId` varchar(9) NOT NULL,
  `hundMorId` varchar(9) NOT NULL,
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
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `hund`
--

INSERT INTO `hund` (`raseId`, `kullId`, `hundId`, `tittel`, `navn`, `hundFarId`, `hundMorId`, `idNr`, `farge`, `fargeVariant`, `oyesykdom`, `hoftesykdom`, `haarlag`, `idMerke`, `kjonn`, `eierId`, `endretAv`, `endretDato`, `regDato`, `storrelse`, `manueltEndretAv`, `manueltEndretDato`) VALUES
(348, 'kullid', '1337', 'tittel', 'Rocky', 'far', 'mor', '12432', 'grønn', 'blå', '', '', '', '', 'H', 'eierId', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00'),
(348, 'kullid', 'hundid', 'tittel', 'navn og sånt', 'enFar', 'enMor', '12432', 'grønn', 'blå', '', '', '', '', 'H', 'eierId', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00'),
(348, 'kullid', 'enMor', 'tittel', 'mor sitt navn', 'far', 'mor', '12432', 'grønn', 'blå', '', '', '', '', 'H', 'eierId', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00'),
(348, 'kullid', 'enFar', 'tittel', 'Hancock', 'far', 'mor', '12432', 'grønn', 'blå', '', '', '', '', 'H', 'eierId', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `kull`
--

CREATE TABLE IF NOT EXISTS `kull` (
  `kullId` varchar(6) NOT NULL,
  `hundIdFar` varchar(9) NOT NULL,
  `hundIdMor` varchar(9) NOT NULL,
  `oppdretterId` varchar(7) NOT NULL,
  `endretDato` date NOT NULL,
  `fodt` date NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `kull`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `oppdrett`
--

CREATE TABLE IF NOT EXISTS `oppdrett` (
  `kullId` varchar(6) NOT NULL,
  `oppdretter` varchar(64) NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `oppdrett`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `oyesykdom`
--

CREATE TABLE IF NOT EXISTS `oyesykdom` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `oyesykdom`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `person`
--

CREATE TABLE IF NOT EXISTS `person` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `person`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `premie`
--

CREATE TABLE IF NOT EXISTS `premie` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `premie`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `utstilling`
--

CREATE TABLE IF NOT EXISTS `utstilling` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `utstilling`
--


-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `veteriner`
--

CREATE TABLE IF NOT EXISTS `veteriner` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `veteriner`
--

