<?php
ini_set("include_path", ini_get("include_path") .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../com/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../no/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../'); 
	
require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

require_once "ImportParserController.php";

if (isset($_FILES['Filedata']) && isset($_GET["brukerEpost"]) && isset($_GET["brukerPassord"]) && isset($_GET["klubbId"])) 
{
	$MAKSSTORRELSE = 1024 * 1024 * 50; // 50MB
	$upload_dir = dirname(__FILE__)."/temp_opplasting/";

	$temp_navn = $_FILES['Filedata']['tmp_name'];
	$fil_navn = $_FILES['Filedata']['name'];
	$fil_storrelse = $_FILES['Filedata']['size'];
	$fil_type = $_FILES['Filedata']['type'];
	//$fil_ext = $_FILES['Filedata']['extension'];
	
	$fil_stien = $upload_dir.$fil_navn;

	$fil_navn = str_replace("\\","",$fil_navn);
	$fil_navn = str_replace("'","",$fil_navn);
	
	if ($fil_storrelse <= $MAKSSTORRELSE)
	{
	    move_uploaded_file($temp_navn, $fil_stien);
	    
	    $ip = new importParserController();
	    echo $ip->lagreDb($fil_stien, $_GET["brukerEpost"], $_GET["brukerPassord"], $_GET["klubbId"]);
	}
}
else
{
	echo "Denne filen skal du ikke gå direkte til";
}