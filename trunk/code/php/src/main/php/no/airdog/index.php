<?php
//Error rapportering
error_reporting(E_ALL|E_STRICT);
//Skru av f¿r produktet skal lanseres
ini_set("display_errors", "on");

if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
	ini_set("include_path", ini_get("include_path") . ";..\\..\\com\\;..\\..\\no\\;..\\..\\"); 
} else { 
	ini_set("include_path", ini_get("include_path") . ":../../com/:../../no/:../../"); 
}

//ini_set("include_path", ini_get("include_path").PATH_SEPARATOR."../../com/:../../no/");


require_once '../../com/Zend/Loader.php';
Zend_Loader::registerAutoload();

require_once '../../com/Zend/Amf/Server.php';

require_once 'controller/HundController.php';
require_once 'controller/LoggInnController.php';


$server = new Zend_Amf_Server();
$server->setClass("HundController");
$server->setClass("LoggInnController");

$server->setClassMap("AmfHund", "AmfHund");
$server->setClassMap("AmfAvkom", "AmfAvkom");
$server->setClassMap("AmfBruker","AmfBruker");

//Bytt til true nŒr det skal lanseres
$server->setProduction(false);
echo($server->handle());

?>