<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller.parser').'/Verktoy.php';

class VerktoyTest extends PHPUnit_Framework_TestCase 
{
	
	
	function testKonverterDatTilDatabaseDato()
	{
		$datoInn = "10.01.2001";
		$datoUt = "2001-01-10";
		
		$vt = new Verktoy();
		$ut = $vt->konverterDatTilDatabaseDato($datoInn);
		$this->assertEquals($ut, $datoUt);
		
	}
	
	function testKonverterDatabaseTilDatDato()
	{
		$datoInn = "10-01-2001";
		$datoUt = "2001.01.10";

		$vt = new Verktoy();
		$ut = $vt->konverterDatabaseTilDatDato($datoInn);
		
		$this->assertEquals($ut, $datoUt);
	}
}