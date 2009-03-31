<?php
//Error rapportering
error_reporting(E_ALL|E_STRICT);
//Skru av før produktet skal lanseres
ini_set("display_errors", "on");

ini_set("include_path", ini_get("include_path") .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../com/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../no/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../'); 

//AUTOLOADER - Setter opp automatisk loading.
//Gjør at ZF sine klasser ikke trenger å inkluderes eller kreves.
require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();
$server = new Zend_Amf_Server();

require_once 'controller/HundController.php';
require_once 'controller/LoggInnController.php';
require_once 'controller/ACLController.php';
require_once 'controller/JaktproveController.php';
require_once 'controller/UtstillingController.php';
require_once 'controller/RolleRettighetController.php';
require_once 'controller/BackupController.php';
require_once 'controller/RolleBrukerController.php';
require_once 'controller/PersonController.php';
require_once 'controller/DatOpplastningsController.php';
require_once 'controller/CupController.php';

$server->setClass("HundController");
$server->setClass("JaktproveController");
$server->setClass("UtstillingController");
$server->setClass("LoggInnController");
$server->setClass("ACLController");
$server->setClass("RolleRettighetController");
$server->setClass("BackupController");
$server->setClass("RolleBrukerController");
$server->setClass("PersonController");
$server->setClass("DatOpplastningsController");
$server->setClass("CupController");

$server->setClassMap("AmfRettigheter", "AmfRettigheter");
$server->setClassMap("AmfHund", "AmfHund");
$server->setClassMap("AmfAvkom", "AmfAvkom");
$server->setClassMap("AmfJaktprove", "AmfJaktprove");
$server->setClassMap("AmfUtstilling", "AmfUtstilling");
$server->setClassMap("AmfBruker","AmfBruker");
$server->setClassMap("AmfPerson","AmfPerson");
$server->setClassMap("AmfOpplastningObjekt","AmfOpplastningObjekt");

//Bytt til true når det skal lanseres
$server->setProduction(false);
echo($server->handle());