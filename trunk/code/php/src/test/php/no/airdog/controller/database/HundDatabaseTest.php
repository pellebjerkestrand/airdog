<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZend.php';
require_once str_replace('.','/','no.airdog.controller.database').'/HundDatabase.php';
require_once str_replace('.','/','no.airdog.controller.database').'/Verktoy.php';

class HundDatabaseTest extends PHPUnit_Framework_TestCase 
{
    function testSettInnHund() 
    {
    	$hd = new HundDatabase();
    	
    	$hundArray = $this->getTestHund();
			
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
    	$hd = new HundDatabase();
    	
    	$hundArray = $this->getTestHund();
			
		if (sizeof($hd->hentHund("TEST_ID")) > 0)
		{
			$hd->slettHund("TEST_ID");
		}
			
		$this->assertTrue($hd->settInnHund($hundArray));

		$hundArray["farge"] = "gul";
		$this->assertTrue($hd->oppdaterHund($hundArray, "Tore"));
		
		$hund = $hd->hentHund("TEST_ID");
    	$this->assertTrue(sizeof($hund) > 0);	
    	$this->assertEquals("gul", $hund["farge"]);
    	$this->assertEquals("Tore", $hund["manueltEndretAv"]);
    	
    	$hd->slettHund("TEST_ID");	
    }
    	
    function testSlettHund()
    {
    	$hd = new HundDatabase();
    	
    	$hundArray = $this->getTestHund();
			
		if (sizeof($hd->hentHund("TEST_ID")) > 0)
		{
			$hd->slettHund("TEST_ID");
		}
			
		$this->assertTrue($hd->settInnHund($hundArray));		
    	
    	$this->assertTrue($hd->slettHund("TEST_ID"));	
    }
    
    function testFinnesHund()
    {
    	$hd = new HundDatabase();
    	
    	$hundArray = $this->getTestHund();
			
		if (sizeof($hd->hentHund("TEST_ID")) > 0)
		{
			$hd->slettHund("TEST_ID");
		}
			
		$this->assertTrue($hd->settInnHund($hundArray));	
		
    	$this->assertTrue($hd->finnesHund("TEST_ID"));	
    	$this->assertFalse($hd->finnesHund("TEST_ID2"));	
    	
    	$hd->slettHund("TEST_ID");	
    }
    	
    function testHentHund()
    {
    	$hd = new HundDatabase();
    	
    	$hundArray = $this->getTestHund();
			
		if (sizeof($hd->hentHund("TEST_ID")) > 0)
		{
			$hd->slettHund("TEST_ID");
		}
			
		$this->assertTrue($hd->settInnHund($hundArray));	
		
		$hund = $hd->hentHund("TEST_ID");
		$testHund = $this->getTestHund();
		
    	$this->assertEquals($testHund["hundId"], $hund["hundId"]);	
    	$this->assertEquals($testHund["raseId"], $hund["raseId"]);	
    	$this->assertEquals($testHund["kullId"], $hund["kullId"]);	
    	$this->assertEquals($testHund["tittel"], $hund["tittel"]);	
    	$this->assertEquals($testHund["navn"], $hund["navn"]);	
    	$this->assertEquals($testHund["hundFarId"], $hund["hundFarId"]);	
    	$this->assertEquals($testHund["hundMorId"], $hund["hundMorId"]);	
    	$this->assertEquals($testHund["idNr"], $hund["idNr"]);	
    	$this->assertEquals($testHund["farge"], $hund["farge"]);	
    	$this->assertEquals($testHund["fargeVariant"], $hund["fargeVariant"]);	
    	$this->assertEquals($testHund["oyesykdom"], $hund["oyesykdom"]);	
    	$this->assertEquals($testHund["hoftesykdom"], $hund["hoftesykdom"]);	
    	$this->assertEquals($testHund["haarlag"], $hund["haarlag"]);	
    	$this->assertEquals($testHund["idMerke"], $hund["idMerke"]);	
    	$this->assertEquals($testHund["kjonn"], $hund["kjonn"]);	
    	$this->assertEquals($testHund["eierId"], $hund["eierId"]);	
    	$this->assertEquals($testHund["endretAv"], $hund["endretAv"]);	
    	$this->assertEquals($testHund["endretDato"], $hund["endretDato"]);	
    	$this->assertEquals($testHund["regDato"], $hund["regDato"]);	
    	$this->assertEquals($testHund["storrelse"], $hund["storrelse"]);	
			
    	$hd->slettHund("TEST_ID");	
    }
    	
    function testHentHunder()
    {
    	$hd = new HundDatabase();
    	
    	$hundArray = $this->getTestHund();
			
		if (sizeof($hd->hentHund("TEST_ID")) > 0)
		{
			$hd->slettHund("TEST_ID");
		}
			
		$this->assertTrue($hd->settInnHund($hundArray));	
    	$this->assertTrue(sizeof($hd->hentHunder()) > 0);	
    	
    	$hd->slettHund("TEST_ID");	
    }
    
    private function getTestHund()
    {
    	$vt = new Verktoy();
    	
    	return array (
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
    }
}
?>