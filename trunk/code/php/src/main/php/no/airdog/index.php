<?php
//Error rapportering
error_reporting(E_ALL|E_STRICT);
//Skru av fÀr produktet skal lanseres
ini_set("display_errors", "on");

ini_set("include_path", ini_get("include_path") .
	PATH_SEPARATOR . '../../../com/' .
	PATH_SEPARATOR . '../../../no/' .
	PATH_SEPARATOR . '../../../'); 

//AUTOLOADER - Setter opp automatisk loading.
//GjÀr at ZF sine klasser ikke trenger Î inkluderes eller kreves.
require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();
$server = new Zend_Amf_Server();

require_once 'controller/HundController.php';
require_once 'controller/LoggInnController.php';

$server->setClass("HundController");
$server->setClass("LoggInnController");

$server->setClassMap("AmfHund", "AmfHund");
$server->setClassMap("AmfAvkom", "AmfAvkom");
$server->setClassMap("AmfJaktprove", "AmfJaktprove");
$server->setClassMap("AmfBruker","AmfBruker");

//Bytt til true nÎr det skal lanseres
$server->setProduction(false);
echo($server->handle());