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
require_once "no/airdog/controller/Verktoy.php";

if (isset($_FILES['Filedata']) && isset($_GET['brukerEpost']) && isset($_GET['brukerPassord']) && isset($_GET['klubbId'])) 
{
	$MAKSSTORRELSE = 1024 * 1024 * 50; // 50MB

	$temp_navn = $_FILES['Filedata']['tmp_name'];
	$fil_navn = $_FILES['Filedata']['name'];
	$fil_storrelse = $_FILES['Filedata']['size'];
	$fil_type = $_FILES['Filedata']['type'];
	
	$info = pathinfo($fil_navn);
	$fil_ext = strtolower($info['extension']);
	
	if ($fil_storrelse <= $MAKSSTORRELSE && $fil_ext == "dat")
	{
		$sti = dirname(__FILE__)."/temp_opplasting/" . $fil_navn . " - " . $_GET['klubbId'] . " - " . $_GET['brukerEpost'] . " - " . microTime() . "." . $fil_ext;
		
		if (file_exists($sti))
			unlink($sti);
		
		if(move_uploaded_file($temp_navn, $sti))
		{
			$ip = new importParserController();
			
	    	echo $ip->lagreDb($sti, $_GET["brukerEpost"], $_GET["brukerPassord"], $_GET["klubbId"]);
	    	unlink($sti);
		}
		else
		{
			echo 'Klarte ikke laste opp filen til. ' . $sti;
		}

	}
	else if ($fil_storrelse <= $MAKSSTORRELSE && ($fil_ext == 'jpg' || $fil_ext == 'jpeg' || $fil_ext == 'gif'  || $fil_ext == 'png' ))
	{
		$sti = Verktoy::hoppBakover(dirname(__FILE__),3) . "/images/";
		
		if  (!file_exists($sti))
		{
			mkdir($sti);
			chmod($sti, 0777);
		}

		$klubb = $_GET['klubbId'];
		
		$sti =  $sti . $klubb . "/";
		
		if (!file_exists($sti))
		{
			mkdir($sti);
			chmod($sti, 0777);
		}
		
		$filnavn = $_GET['hundId'] . "." . $fil_ext;
		
		$fil_sti = $sti . $filnavn;
		
		if (file_exists($fil_sti))
			unlink ($fil_sti);
			
		if(move_uploaded_file($temp_navn, $fil_sti))
		{
			$be = new BildeendringController();
			echo $be->lagreBilde($sti, $filnavn, "200", "200", "50", "50");
		}
		else
		{
			// Bør byttes ut med bedre informasjon.
			echo 'Klarte ikke laste opp filen til. ' . $fil_sti;
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