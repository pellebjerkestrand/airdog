<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.database').'/HundDatabase.php';

class HundDatabaseTest extends PHPUnit_Framework_TestCase 
{
	function hentHundSomDatStringTest()
	{
		$hundId = "00348/97";
		$klubbId = "348";
		
		$dat = "348|970074|00348/97||BONNIE|00046/88|21203/91|1042993|HVIT/SORT||||||T|3071892|SS|08.01.1997|08.01.1997|";
		
		$db = new HundDatabase();
		$ut = $vt->hentHundSomDatString($hundId, $klubbId);
		$this->assertEquals($dat, $dat);
	}
	
}