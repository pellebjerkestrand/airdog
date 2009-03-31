<?php
set_time_limit(600);
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
ini_set('LimitRequestBody ', '16777216');

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
	$dat_upload_dir = dirname(__FILE__)."/temp_opplasting/";
	$bilde_upload_dir = "../../../images/";

	$temp_navn = $_FILES['Filedata']['tmp_name'];
	$fil_navn = $_FILES['Filedata']['name'];
	$fil_storrelse = $_FILES['Filedata']['size'];
	//$fil_type = $_FILES['Filedata']['type'];
	
	$info = pathinfo($fil_navn);
	$fil_ext = $info['extension'];;
	
	$dat_fil_stien = $dat_upload_dir . $fil_navn;
	$bilde_fil_stien = $bilde_upload_dir . $_GET["klubbId"] . "/" . $fil_navn;

	$fil_navn = str_replace("\\","",$fil_navn);
	$fil_navn = str_replace("'","",$fil_navn);
	
	if ($fil_storrelse <= $MAKSSTORRELSE && move_uploaded_file($temp_navn, $dat_fil_stien) && $fil_ext == "dat")
	{
	    $ip = new importParserController();
	    echo $ip->lagreDb($dat_fil_stien, $_GET["brukerEpost"], $_GET["brukerPassord"], $_GET["klubbId"]);
	    unlink($fil_stien);
	}
	else if ($fil_storrelse <= $MAKSSTORRELSE && move_uploaded_file($temp_navn, $bilde_fil_stien))
	{
		
	}
	else
	{
		// Bør byttes ut med bedre informasjon.
		echo "Klarte ikke laste opp filen til. " . $_FILES['Filedata']['tmp_name'] ." - ". $fil_stien;
	}
}
else
{
	echo "Denne filen skal du ikke gå direkte til";
}