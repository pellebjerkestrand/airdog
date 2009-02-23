<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZend.php';
require_once str_replace('.','/','no.airdog.controller.database').'/KullDatabase.php';
require_once str_replace('.','/','no.airdog.controller.database').'/Verktoy.php';

class KullDatabaseTest extends PHPUnit_Framework_TestCase 
{
    function testSettInnKull() 
    {
    	$hd = new KullDatabase();
    	
    	$kullArray = $this->getTestKull();
			
		if (sizeof($hd->hentKull("TESTID")) > 0)
		{
			$hd->slettKull("TESTID");
		}
			
		$this->assertTrue($hd->settInnKull($kullArray));	
    	$this->assertTrue(sizeof($hd->hentKull("TESTID")) > 0);	
    	
    	$hd->slettKull("TESTID");	
    }
    
    function testOppdaterKull()
    {
    	$hd = new KullDatabase();
    	
    	$kullArray = $this->getTestKull();
			
		if (sizeof($hd->hentKull("TESTID")) > 0)
		{
			$hd->slettKull("TESTID");
		}
			
		$this->assertTrue($hd->settInnKull($kullArray));

		$kullArray["oppdretterId"] = "666";
		$this->assertTrue($hd->oppdaterKull($kullArray, "Tore"));
		
		$kull = $hd->hentKull("TESTID");
    	$this->assertTrue(sizeof($kull) > 0);	
    	$this->assertEquals("666", $kull["oppdretterId"]);
    	$this->assertEquals("Tore", $kull["manueltEndretAv"]);
    	
    	$hd->slettKull("TESTID");	
    }
    	
    function testSlettKull()
    {
    	$hd = new KullDatabase();
    	
    	$kullArray = $this->getTestKull();
			
		if (sizeof($hd->hentKull("TESTID")) > 0)
		{
			$hd->slettKull("TESTID");
		}
			
		$this->assertTrue($hd->settInnKull($kullArray));		
    	
    	$this->assertTrue($hd->slettKull("TESTID"));	
    }
    
    function testFinnesKull()
    {
    	$hd = new KullDatabase();
    	
    	$kullArray = $this->getTestKull();
			
		if (sizeof($hd->hentKull("TESTID")) > 0)
		{
			$hd->slettKull("TESTID");
		}
			
		$this->assertTrue($hd->settInnKull($kullArray));	
		
    	$this->assertTrue($hd->finnesKull("TESTID"));	
    	$this->assertFalse($hd->finnesKull("TESTID2"));	
    	
    	$hd->slettKull("TESTID");	
    }
    	
    function testHentKull()
    {
    	$hd = new KullDatabase();
    	
    	$kullArray = $this->getTestKull();
			
		if (sizeof($hd->hentKull("TESTID")) > 0)
		{
			$hd->slettKull("TESTID");
		}
			
		$this->assertTrue($hd->settInnKull($kullArray));	
		
		$kull = $hd->hentKull("TESTID");
		$testKull = $this->getTestKull();
		
    	$this->assertEquals($testKull["kullId"], $kull["kullId"]);	
    	$this->assertEquals($testKull["hundIdFar"], $kull["hundIdFar"]);	
    	$this->assertEquals($testKull["hundIdMor"], $kull["hundIdMor"]);	
    	$this->assertEquals($testKull["oppdretterId"], $kull["oppdretterId"]);	
    	$this->assertEquals($testKull["endretDato"], $kull["endretDato"]);	
    	$this->assertEquals($testKull["fodt"], $kull["fodt"]);	
    	$this->assertEquals($testKull["raseId"], $kull["raseId"]);	
    	
    	$hd->slettKull("TESTID");	
    }
    	
    function testHentKuller()
    {
    	$hd = new KullDatabase();
    	
    	$kullArray = $this->getTestKull();
			
		if (sizeof($hd->hentKull("TESTID")) > 0)
		{
			$hd->slettKull("TESTID");
		}
			
		$this->assertTrue($hd->settInnKull($kullArray));	
    	$this->assertTrue(sizeof($hd->hentKuller()) > 0);	
    	
    	$hd->slettKull("TESTID");	
    }
    
    private function getTestKull()
    {
    	$vt = new Verktoy();
    	
    	return array (
			"kullId" => "TESTID",
			"hundIdFar" => "TEST_MOR",
			"hundIdMor" => "TEST_FAR",
			"oppdretterId" => "999999",
			"endretDato" => $vt->konverterDatTilDatabaseDato("10.01.2001"),
			"fodt" => $vt->konverterDatTilDatabaseDato("10.01.2002"),
			"raseId" => "385"
		);
    }
}
?>