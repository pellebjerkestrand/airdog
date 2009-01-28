<?php
include "c:/wamp/www/zend/Amf/Server.php";
include "HundController.php";

$server = new Zend_Amf_Server();

$server -> setClass( "HundController" );
$server -> setClassMap("AmfHund", "AmfHund");

echo( $server -> handle() );
?>