-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Vert: localhost
-- Generert den: 28. Apr, 2009 10:15 AM
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

INSERT INTO `ad_bruker` (`epost`, `fornavn`, `etternavn`, `passord`, `superadmin`) VALUES
('gjest', 'gjest', 'gjest', '9195bf0c194e9e0b8fff4bbcdfe89298e1ecb051', 0),
('admin', 'Administrator', '', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
('test@lcd.no', 'test', 'tester', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 0);

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

INSERT INTO `ad_bruker_klubb_rolle_link` (`ad_rolle_navn`, `ad_bruker_epost`, `ad_klubb_raseid`) VALUES
('admin', 'admin', 348),
('gjest', 'gjest', 306),
('gjest', 'gjest', 348),
('admin', 'gjest', 348),
('admin', 'admin', 306),
('admin', 'test@lcd.no', 306),
('admin', 'gjest', 306),
('admin', 'test@lcd.no', 348),
('gjest', 'test@lcd.no', 306),
('gjest', 'admin', 348),
('gjest', 'test@lcd.no', 348);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ad_klubb`
--

CREATE TABLE IF NOT EXISTS `ad_klubb` (
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(50) DEFAULT NULL,
  `raseid` int(3) NOT NULL,
  `rss` mediumtext NOT NULL,
  `forsidetekst` mediumtext NOT NULL,
  PRIMARY KEY (`raseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dataark for tabell `ad_klubb`
--

INSERT INTO `ad_klubb` (`navn`, `beskrivelse`, `raseid`, `rss`, `forsidetekst`) VALUES
('Norsk Breton Klubb', NULL, 306, 'http://pipes.yahooapis.com/pipes/pipe.run?_id= Jowwq8wz3hGrvLIjPm7D0g&_render=rss&rssurl=http://breton.no/index.php/weblog/rss_2.0/', ''),
('Norsk Pointer Klubb', NULL, 348, 'http://pipes.yahooapis.com/pipes/pipe.run?_id= Jowwq8wz3hGrvLIjPm7D0g&_render=rss&rssurl=http://pointer.no/index.php?format=feed&type=rss', '');

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

INSERT INTO `ad_rettighet` (`navn`, `beskrivelse`) VALUES
('lese', 'Utføre handlinger som ikke endrer på databasen'),
('redigerHund', 'Redigere hunder'),
('redigerJaktprove', 'Redigere jaktprøver'),
('importerDatabase', 'Importere data fra NKK til databasen'),
('leggInnJaktprove', 'Legge inn jaktprøver'),
('slettJaktprove', 'Slette jaktprøver'),
('rolleRettighetHandtering', 'Tildele rettigheter på roller'),
('administrereBackup', 'Administrere Backup av databasen'),
('klubbRolleBrukerHandtering', 'Legge en bruker på en rolle i en klubb'),
('redigerEgenBruker', 'En bruker skal kunne redigere seg selv'),
('redigerUtstilling', 'Redigere utstillinger'),
('arrangementer', ''),
('lagAarbok', ''),
('redigerKlubb', '');

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

INSERT INTO `ad_rolle` (`navn`, `beskrivelse`) VALUES
('admin', 'admin'),
('gjest', 'gjest');

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

INSERT INTO `ad_rolle_rettighet_link` (`ad_rolle_navn`, `ad_rettighet_navn`) VALUES
('gjest', 'klubbRolleBrukerHandtering'),
('gjest', 'redigerJaktprove'),
('admin', 'lese'),
('gjest', 'leggInnJaktprove'),
('gjest', 'administrereBackup'),
('gjest', 'rolleRettighetHandtering'),
('gjest', 'lese'),
('gjest', 'slettJaktprove'),
('gjest', 'importerDatabase');


-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Vert: localhost
-- Generert den: 28. Apr, 2009 10:16 AM
-- Tjenerversjon: 5.1.30
-- PHP-Versjon: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `airdog`
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

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_aasykdom`
--

CREATE TABLE IF NOT EXISTS `nkk_aasykdom` (
  `veId` varchar(4) DEFAULT NULL,
  `aaId` varchar(7) NOT NULL,
  `diagnoseKode` int(1) DEFAULT NULL,
  `idmerketkode` int(1) DEFAULT NULL,
  `lidelseKode` int(1) DEFAULT NULL,
  `sekHoyreKode` int(1) DEFAULT NULL,
  `sekVenstreKode` int(1) DEFAULT NULL,
  `endretAv` varchar(32) DEFAULT NULL,
  `regAv` varchar(32) DEFAULT NULL,
  `avlestAv` varchar(32) DEFAULT NULL,
  `betaling` int(1) DEFAULT NULL,
  `diagnose` varchar(6) DEFAULT NULL,
  `hundId` varchar(17) DEFAULT NULL,
  `idFeil` varchar(6) DEFAULT NULL,
  `idMerket` varchar(1) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `lidelse` varchar(1) DEFAULT NULL,
  `peId` varchar(7) DEFAULT NULL,
  `purring` varchar(20) DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `retur` varchar(20) DEFAULT NULL,
  `sekHoyre` varchar(16) DEFAULT NULL,
  `sekVenstre` varchar(16) DEFAULT NULL,
  `sendes` varchar(20) DEFAULT NULL,
  `avlestDato` date DEFAULT NULL,
  `rontgenDato` date DEFAULT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`aaId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_arrangement`
--

CREATE TABLE IF NOT EXISTS `nkk_arrangement` (
  `proveNr` varchar(8) NOT NULL,
  `sted` varchar(200) DEFAULT NULL,
  `navn` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`proveNr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_fugl`
--

CREATE TABLE IF NOT EXISTS `nkk_fugl` (
  `proveNr` varchar(8) NOT NULL,
  `proveDato` date NOT NULL,
  `partiNr` varchar(3) NOT NULL,
  `klasse` int(1) NOT NULL,
  `dommerId1` varchar(7) DEFAULT NULL,
  `dommerId2` varchar(7) DEFAULT NULL,
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
  `regAv` varchar(32) DEFAULT NULL,
  `regDato` date DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  `kritikk` mediumtext,
  KEY `proveNr` (`proveNr`,`proveDato`,`hundId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_hdsykdom`
--

CREATE TABLE IF NOT EXISTS `nkk_hdsykdom` (
  `avlestAv` varchar(16) DEFAULT NULL,
  `betaling` int(1) DEFAULT NULL,
  `diagnose` varchar(3) DEFAULT NULL,
  `diagnoseKode` int(1) DEFAULT NULL,
  `endretAv` varchar(16) DEFAULT NULL,
  `hofteDyId` varchar(7) NOT NULL,
  `hundId` varchar(17) DEFAULT NULL,
  `idmerket` varchar(1) DEFAULT NULL,
  `idmerketkode` varchar(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `lidelse` varchar(1) DEFAULT NULL,
  `lidelseKode` int(1) DEFAULT NULL,
  `personId` varchar(7) DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `registrertAv` varchar(16) DEFAULT NULL,
  `sekHoyre` varchar(20) DEFAULT NULL,
  `sekHoyreKode` int(1) DEFAULT NULL,
  `sekVenstre` varchar(20) DEFAULT NULL,
  `sekVenstreKode` int(1) DEFAULT NULL,
  `sendes` varchar(20) DEFAULT NULL,
  `veterinerId` varchar(4) DEFAULT NULL,
  `rontgenDato` date DEFAULT NULL,
  `avlestDato` date DEFAULT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`hofteDyId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_hund`
--

CREATE TABLE IF NOT EXISTS `nkk_hund` (
  `raseId` int(3) NOT NULL,
  `kullId` varchar(6) DEFAULT NULL,
  `hundId` varchar(17) NOT NULL,
  `tittel` varchar(64) DEFAULT NULL,
  `navn` varchar(64) DEFAULT NULL,
  `hundFarId` varchar(17) DEFAULT NULL,
  `hundMorId` varchar(17) DEFAULT NULL,
  `idNr` varchar(7) DEFAULT NULL,
  `farge` varchar(32) DEFAULT NULL,
  `fargeVariant` varchar(32) DEFAULT NULL,
  `oyesykdom` varchar(16) DEFAULT NULL,
  `hoftesykdom` varchar(1) DEFAULT NULL,
  `haarlag` varchar(16) DEFAULT NULL,
  `idMerke` varchar(1) DEFAULT NULL,
  `kjonn` varchar(1) DEFAULT NULL,
  `eierId` varchar(7) DEFAULT NULL,
  `endretAv` varchar(16) DEFAULT NULL,
  `endretDato` date DEFAULT NULL,
  `regDato` date DEFAULT NULL,
  `storrelse` varchar(16) DEFAULT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`raseId`,`hundId`),
  KEY `hundId` (`hundId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_kull`
--

CREATE TABLE IF NOT EXISTS `nkk_kull` (
  `kullId` varchar(6) NOT NULL,
  `hundIdFar` varchar(9) DEFAULT NULL,
  `hundIdMor` varchar(9) DEFAULT NULL,
  `oppdretterId` varchar(7) DEFAULT NULL,
  `endretDato` date DEFAULT NULL,
  `fodt` date DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`kullId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_oppdrett`
--

CREATE TABLE IF NOT EXISTS `nkk_oppdrett` (
  `kullId` varchar(6) NOT NULL,
  `oppdretter` varchar(64) NOT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) NOT NULL,
  `manueltEndretDato` date NOT NULL,
  PRIMARY KEY (`kullId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_oyesykdom`
--

CREATE TABLE IF NOT EXISTS `nkk_oyesykdom` (
  `oyId` varchar(7) NOT NULL,
  `hundId` varchar(17) DEFAULT NULL,
  `veterinerId` varchar(4) DEFAULT NULL,
  `oyeVeteriner` varchar(2) DEFAULT NULL,
  `lystDato` date DEFAULT NULL,
  `idmerketKode` varchar(1) DEFAULT NULL,
  `idmerket` int(1) DEFAULT NULL,
  `idfeil` varchar(20) DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `sendtEierDato` date DEFAULT NULL,
  `longAnnet` varchar(20) DEFAULT NULL,
  `diagnoseKode1` varchar(20) DEFAULT NULL,
  `diagnoseGrad1` varchar(20) DEFAULT NULL,
  `diagnoseKode2` varchar(20) DEFAULT NULL,
  `diagnoseGrad2` varchar(20) DEFAULT NULL,
  `diagnoseKode3` varchar(20) DEFAULT NULL,
  `diagnoseGrad3` varchar(20) DEFAULT NULL,
  `regAv` varchar(16) DEFAULT NULL,
  `regDato` date DEFAULT NULL,
  `endretAv` varchar(16) DEFAULT NULL,
  `endretDato` date DEFAULT NULL,
  `personId` varchar(7) DEFAULT NULL,
  `sendtVetDato` date DEFAULT NULL,
  `sendtKlubbDato` date DEFAULT NULL,
  `longAnnet1` varchar(20) DEFAULT NULL,
  `longAnnet2` varchar(20) DEFAULT NULL,
  `inaktiv` varchar(1) DEFAULT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`oyId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_person`
--

CREATE TABLE IF NOT EXISTS `nkk_person` (
  `personId` varchar(7) NOT NULL,
  `navn` varchar(64) DEFAULT NULL,
  `adresse1` varchar(64) DEFAULT NULL,
  `adresse2` varchar(64) DEFAULT NULL,
  `adresse3` varchar(64) DEFAULT NULL,
  `postNr` varchar(4) DEFAULT NULL,
  `landkode` varchar(1) DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `telefon1` varchar(16) DEFAULT NULL,
  `endretDato` date DEFAULT NULL,
  `regDato` date DEFAULT NULL,
  `fodt` date DEFAULT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`personId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_premie`
--

CREATE TABLE IF NOT EXISTS `nkk_premie` (
  `doId` varchar(6) DEFAULT NULL,
  `utstillingId` varchar(6) NOT NULL,
  `hundId` varchar(17) NOT NULL,
  `katalogNr` int(3) DEFAULT NULL,
  `personIdDommer` varchar(7) DEFAULT NULL,
  `klasse` varchar(1) DEFAULT NULL,
  `kjonn` varchar(1) DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `IM` int(1) DEFAULT NULL,
  `KIP` int(1) DEFAULT NULL,
  `JK` int(1) DEFAULT NULL,
  `JKK` int(1) DEFAULT NULL,
  `UK` int(1) DEFAULT NULL,
  `UKK` int(1) DEFAULT NULL,
  `BK` int(1) DEFAULT NULL,
  `BKK` int(1) DEFAULT NULL,
  `AK` int(1) DEFAULT NULL,
  `AKK` int(1) DEFAULT NULL,
  `VK` int(1) DEFAULT NULL,
  `CHK` int(1) DEFAULT NULL,
  `CHKK` int(1) DEFAULT NULL,
  `VTK` int(1) DEFAULT NULL,
  `VTKK` int(1) DEFAULT NULL,
  `HP` int(1) DEFAULT NULL,
  `CK` int(1) DEFAULT NULL,
  `CC` int(1) DEFAULT NULL,
  `CA` int(1) DEFAULT NULL,
  `BIK` int(1) DEFAULT NULL,
  `BIR` int(1) DEFAULT NULL,
  `BIM` int(1) DEFAULT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`utstillingId`,`hundId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_utstilling`
--

CREATE TABLE IF NOT EXISTS `nkk_utstilling` (
  `utstillingId` varchar(6) NOT NULL,
  `klasseId` varchar(6) DEFAULT NULL,
  `personId` varchar(7) DEFAULT NULL,
  `regDato` date DEFAULT NULL,
  `regAv` varchar(16) DEFAULT NULL,
  `navn` varchar(64) DEFAULT NULL,
  `adresse1` varchar(64) DEFAULT NULL,
  `adresse2` varchar(64) DEFAULT NULL,
  `postNr` varchar(4) DEFAULT NULL,
  `spesialAdresse` varchar(64) DEFAULT NULL,
  `utstillingDato` date DEFAULT NULL,
  `utstillingSted` varchar(64) DEFAULT NULL,
  `arrangorNavn1` varchar(64) DEFAULT NULL,
  `arrangorNavn2` varchar(64) DEFAULT NULL,
  `overfortDato` date DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`utstillingId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `nkk_veteriner`
--

CREATE TABLE IF NOT EXISTS `nkk_veteriner` (
  `veterinerId` varchar(5) NOT NULL,
  `personId` varchar(7) DEFAULT NULL,
  `adresse1` varchar(64) DEFAULT NULL,
  `adresse2` varchar(64) DEFAULT NULL,
  `adresse3` varchar(64) DEFAULT NULL,
  `postNr` varchar(4) DEFAULT NULL,
  `telefon` varchar(16) DEFAULT NULL,
  `telefax` varchar(16) DEFAULT NULL,
  `klinikkNavn` varchar(64) DEFAULT NULL,
  `regDato` date DEFAULT NULL,
  `regAv` varchar(16) DEFAULT NULL,
  `endretAv` varchar(16) DEFAULT NULL,
  `raseId` int(3) NOT NULL,
  `manueltEndretAv` varchar(20) DEFAULT NULL,
  `manueltEndretDato` date DEFAULT NULL,
  PRIMARY KEY (`veterinerId`,`raseId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
