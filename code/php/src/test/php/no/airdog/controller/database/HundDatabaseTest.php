<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller.database').'/HundDatabase.php';
require_once str_replace('.','/','no.airdog.controller.database').'/Verktoy.php';

class HundDatabaseTest extends PHPUnit_Framework_TestCase 
{
    function testSettInnHund() 
    {
    	$hd = new HundDatabase();
    	$vt = new Verktoy();
    	
    	$hundArray = array (
			"raseId" => "666",
			"kullId" => "999999",
			"hundId" => "TEST_ID",
			"tittel" => "Sir",
			"navn" => "En test hund laget av test klassen",
			"hundFarId" => "TEST_MOR",
			"hundMorId" => "TEST_FAR",
			"idNr" => "1234567",
			"farge" => "HVIT/SORT",
			"fargeVariant" => "GRÅ",
			"oyesykdom" => "A",
			"hoftesykdom" => "A",
			"haarlag" => "",
			"idMerke" => "M",
			"kjonn" => "H",
			"eierId" => "1234567",
			"endretAv" => "TL",
			"endretDato" => $vt->konverterDatTilDatabaseDato("10.01.2001"),
			"regDato" => $vt->konverterDatTilDatabaseDato("10.01.2001"),
			"storrelse" => "DIGER"
		);
			
		if (sizeof($hd->hentHund("TEST_ID")) > 0)
		{
			$hd->slettHund("TEST_ID");
		}
			
		$this->assertTrue($hd->settInnHund($hundArray));	
    	$this->assertTrue(sizeof($hd->hentHund("TEST_ID")) > 0);	
    	
    	$hd->slettHund("TEST_ID");	
    }
    
    function testOppdaterHund()
    {
    	
    }
    	
    function testSlettHund()
    {
    	
    }
    	
    function testHentHund()
    {
    	
    }
    	
    function testHentHunder()
    {
    	
    }
}
?>