<?php
header("Content-type: application/msword; charset=UTF-16LE"); 
header("Content-Disposition: inline; filename=aarBok.doc"); //. $_POST["navn"] . ".csv"

set_time_limit(7200);
ini_set('memory_limit', '128M');
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
ini_set('LimitRequestBody ', '16777216');

ini_set("include_path", ini_get("include_path") .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../com/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../no/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../'); 
	
require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

require_once 'AarbokController.php';
 
$hundId = $_POST['hundId'];
$aar = $_POST['aar'];
$kjonn = $_POST['kjonn'];
$klubbId = $_POST['klubbId'];

$aarbokController = new AarbokController();

$nyRTF = $aarbokController->lag_RTF($hundId, $klubbId, $aar, $kjonn);
echo $nyRTF;	



