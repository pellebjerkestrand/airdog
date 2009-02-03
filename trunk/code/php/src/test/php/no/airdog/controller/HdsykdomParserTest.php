<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/HdsykdomParser.php';

class OppdrettParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetHdsykdomArray() 
    {
    	$hp = new HdsykdomParser();
    	$parseString = "testNr|100|Pa|1|hundsomharnr|223321|231212855/9128|i|||||14823320706|3423238|sin||||||0022332|30.11.2020|01.04.2040";
        $pa = $hp->getHdsykdomArray($parseString);
        
    	$this->assertEquals("testNr", $pa["avlestAv"]);
    	$this->assertEquals("100", $pa["betaling"]);
    	$this->assertEquals("Pa", $pa["diagnose"]);
    	$this->assertEquals("1", $pa["diagnoseKode"]);
    	$this->assertEquals("hundsomharnr", $pa["endretAv"]);
    	$this->assertEquals("223321", $pa["hofteDyId"]);
    	$this->assertEquals("231212855/9128", $pa["hundeId"]);
    	$this->assertEquals("i", $pa["idmerket"]);
    	$this->assertEquals("", $pa["idmerketkode"]);
    	$this->assertEquals("", $pa["kode"]);
    	$this->assertEquals("", $pa["lidelse"]);
    	$this->assertEquals("", $pa["lidelsekode"]);
    	$this->assertEquals("14823320706", $pa["personId"]);
    	$this->assertEquals("3423238", $pa["raseId"]);
    	$this->assertEquals("sin", $pa["registrertAv"]);
    	$this->assertEquals("", $pa["sekHoyre"]);
    	$this->assertEquals("", $pa["sekHoyreKode"]);
    	$this->assertEquals("", $pa["sekVenstre"]);
    	$this->assertEquals("", $pa["sekVenstreKode"]);
    	$this->assertEquals("", $pa["sendes"]);
    	$this->assertEquals("0022332", $pa["veterinerId"]);
    	$this->assertEquals("30.11.2020", $pa["rontgenDato"]);
    	$this->assertEquals("01.04.2040", $pa["avlestDato"]);
    }
    
    function testGetHdsykdomlisteArray()
    {
    	$parseString = 'to|1222|A1221|1121|geir|12121221|2121/9933|Xh|||||1221|1221|121ggfd||||||1221|14.02.2000|23.02.2000
						tre|12214|A12121|121|teir|122112|1212/212112|M|||||12112|12122|gfffl||||||12112|08.03.2000|09.03.2000';
    	
        $hp = new HdsykdomParser();
        $pa = $hp->getHdsykdomlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("to", $pa[0]["avlestAv"]);			// Toppen i arrayet
    	$this->assertEquals("", $pa[0]["lidelse"]);				// Midten
    	$this->assertEquals("23.02.2000", $pa[0]["avlestDato"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("tre", $pa[1]["avlestAv"]);			// Toppen i arrayet
    	$this->assertEquals("", $pa[1]["lidelse"]);				// Midten
    	$this->assertEquals("09.03.2000", $pa[1]["avlestDato"]);			// Bunnen i arrayet
    }    
}
?>
