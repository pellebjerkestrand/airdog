<?php
include "../../com/Zend/Amf/Server.php";
include "controller/HundController.php";

$server = new Zend_Amf_Server();

$server -> setClass( "HundController" );
$server -> setClassMap("AmfHund", "AmfHund");

echo( $server -> handle() );
?>