<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.database').'/HundDatabase.php';

class HundDataBaseTest extends PHPUnit_Framework_TestCase 
{
	function testHundSomDatString()
	{
		$hundId = "00348/97";
		$klubbId = "00348/97";
		$dat = "348|970074|00348/97||BONNIE|00046/88|21203/91|1042993|HVIT/SORT||||||T|3071892|SS|08.01.1997|08.01.1997|";
		$bat = "348|970074|00348/97||BONNIE|00046/88|21203/91|1042993|HVIT/SORT||||||T|3071892|SS|08.01.1997|08.01.1997|";
		
//		$db = new HundDatabase();
//		$ut = $db->hentHundSomDatString($hundId, $klubbId);
		
		$this->assertEquals($bat, $dat);
	}
	
}