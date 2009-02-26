<?php
require_once "ImportParserController.php";

if (isset($_FILES['Filedata'])) 
{
	$MAKSSTORRELSE = 1024 * 1024 * 50; // 50MB
	$upload_dir = dirname(__FILE__)."./../temp_opplasting/";

	$temp_navn = $_FILES['Filedata']['tmp_name'];
	$fil_navn = $_FILES['Filedata']['name'];
	$fil_storrelse = $_FILES['Filedata']['size'];
	$fil_type = $_FILES['Filedata']['type'];
	$fil_ext = $_FILES['Filedata']['extension'];
	
	$fil_stien = $upload_dir.$fil_navn;

	$fil_navn = str_replace("\\","",$fil_navn);
	$fil_navn = str_replace("'","",$fil_navn);
	
	if ($fil_storrelse <= $MAKSSTORRELSE)
	{
	    move_uploaded_file($temp_navn, $fil_stien);
	    
	    $ip = new importParserController();
	    echo $ip->lagreDb($fil_stien);
	    
	    
	}
}
else
{
	echo "Denne filen skal du ikke gå direkte til";
}