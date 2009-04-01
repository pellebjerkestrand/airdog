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
require_once "FilopplastController.php";

if (isset($_FILES['Filedata']) && isset($_GET['brukerEpost']) && isset($_GET['brukerPassord']) && isset($_GET['klubbId'])) 
{
	$MAKSSTORRELSE = 1024 * 1024 * 50; // 50MB
	$dat_upload_dir = dirname(__FILE__)."/temp_opplasting/";
	$bilde_upload_dir = hoppBakover(3) . "/images/";

	$temp_navn = $_FILES['Filedata']['tmp_name'];
	$fil_navn = $_FILES['Filedata']['name'];
	$fil_storrelse = $_FILES['Filedata']['size'];
	$fil_type = $_FILES['Filedata']['type'];
	
	$info = pathinfo($fil_navn);
	$fil_ext = strtolower($info['extension']);
	
	
	$dat_fil_stien = $dat_upload_dir . $fil_navn;
	
	if ($fil_storrelse <= $MAKSSTORRELSE && $fil_ext == "dat")
	{
		if(move_uploaded_file($temp_navn, $dat_fil_stien))
		{
			$ip = new importParserController();
	    	echo $ip->lagreDb($dat_fil_stien, $_GET["brukerEpost"], $_GET["brukerPassord"], $_GET["klubbId"]);
	    	unlink($dat_fil_stien);
		}
		else
		{
			// Bør byttes ut med bedre informasjon.
			echo 'Klarte ikke laste opp filen til. ' . $_FILES['Filedata']['tmp_name'] .' - '. $fil_stien;
		}

	}
	else if ($fil_storrelse <= $MAKSSTORRELSE && ($fil_ext == 'jpg' || $fil_ext == 'jpeg' || $fil_ext == 'gif'  || $fil_ext == 'png' ))
	{
		$klubb = $_GET['klubbId'];
		$hund = $_GET['hundId'];
		
		if  (!file_exists($bilde_upload_dir))
		{
			mkdir($bilde_upload_dir);
			chmod($bilde_upload_dir, 0777);
		}
		
		$bilde_upload_dir =  $bilde_upload_dir . $klubb . "/";
		
		if (!file_exists($bilde_upload_dir))
		{
			mkdir($bilde_upload_dir);
			chmod($bilde_upload_dir, 0777);
		}
		
		$bilde_fil_stien = $bilde_upload_dir . $hund . "." . $fil_ext;
		
		if (file_exists($bilde_fil_stien))
			unlink ($bilde_fil_stien);
			
		if(move_uploaded_file($temp_navn, $bilde_fil_stien))
		{
			$be = new BildeendringController();
			echo $be->endreStorrelse($bilde_fil_stien, "200", "200", "50", "50");
		}
		else
		{
			// Bør byttes ut med bedre informasjon.
			echo 'Klarte ikke laste opp filen til. ' . $_FILES['Filedata']['tmp_name'] .' - '. $fil_stien;
		}
	}
	else
	{
		// Bør byttes ut med bedre informasjon.
		echo 'Fil formatet stemmer ikke: ' . $fil_ext;
	}
}
else
{
	echo 'Denne filen skal du ikke gå direkte til';
}

function hoppBakover($antall)
{	
	$mapper = dirname(__FILE__);
	$mapper = str_replace("\\","/",$mapper);
	
	$mapper = split("/", $mapper);
	$sti = "";
	
	for ($i = 1; $i < sizeof($mapper) - $antall; $i++)
	{
		$sti .= "/" . $mapper[$i];
	}
	
	return $sti;
}