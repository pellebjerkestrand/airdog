<?php

error_reporting(E_ALL|E_STRICT);
ini_set("display_errors", "on");

if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
	ini_set("include_path", ini_get("include_path") . ";..\..\com\;..\..\no\\"); 
} else { 
	ini_set("include_path", ini_get("include_path") . ":../../com/:../../no/"); 
}


require_once '../../com/Zend/Amf/Server.php';
require_once 'controller/HundController.php';
require_once 'controller/BrukerController.php';

$server = new Zend_Amf_Server();
$server->setClass("HundController");
$server->setClass("BrukerController");
$server->setClassMap("AmfHund", "AmfHund");

echo($server->handle());

?>