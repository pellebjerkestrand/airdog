<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZendTest.php';
require_once str_replace('.','/','no.airdog.controller.parser').'/VeterinerParser.php';

class VeterinerParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetVeterinerArray() 
    {
    	$hp = new VeterinerParser();
    	$parseString = "9000|1000|Veien 1|Svingen 2|Kroken 3|6666|22225555|55552222|Ze Name|Ze Date|Ze Germans!|Jackie Chan";
        $pa = $hp->getVeterinerArray($parseString);
        
    	$this->assertEquals("9000", $pa["veterinerId"]);
    	$this->assertEquals("1000", $pa["personId"]);
    	$this->assertEquals("Veien 1", $pa["adresse1"]);
    	$this->assertEquals("Svingen 2", $pa["adresse2"]);
    	$this->assertEquals("Kroken 3", $pa["adresse3"]);
    	$this->assertEquals("6666", $pa["postNr"]);
    	$this->assertEquals("22225555", $pa["telefon"]);
    	$this->assertEquals("55552222", $pa["telefax"]);
    	$this->assertEquals("Ze Name", $pa["klinikkNavn"]);
    	$this->assertEquals("Ze Date", $pa["regDato"]);
    	$this->assertEquals("Ze Germans!", $pa["regAv"]);
    	$this->assertEquals("Jackie Chan", $pa["endretAv"]);
    }
    
    function testGetVeterinerlisteArray()
    {
    	$parseString = 'VEID|PEID|Adresse1|Adresse2|Adresse3|Postnr|Telefon|Telefax|KlinikkNavn|RegDato|RegAv|EndretAv
    					9000|1000|Veien 1|Svingen 2|Kroken 3|6666|22225555|55552222|Ze Name|Ze Date|Ze Germans!|Jackie Chan
    					9000|1000|Veien 1|Svingen 2|Kroken 3|6666|22225555|55552222|Ze Name|Ze Date|Ze Germans!|Jackie Chan';
    	
        $hp = new VeterinerParser();
        $pa = $hp->getVeterinerlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("9000", $pa[0]["veterinerId"]);			// Toppen i arrayet
    	$this->assertEquals("6666", $pa[0]["postNr"]);				// Midten
    	$this->assertEquals("Jackie Chan", $pa[0]["endretAv"]);		// Bunnen i arrayet
    	
    	$this->assertEquals("9000", $pa[1]["veterinerId"]);			// Toppen i arrayet
    	$this->assertEquals("6666", $pa[1]["postNr"]);				// Midten
    	$this->assertEquals("Jackie Chan", $pa[1]["endretAv"]);		// Bunnen i arrayet
    }    
    
	function testGetVeterinerlisteArrayFraFil()
    {	
    	$hp = new VeterinerParser();
    	
    	$pa = $hp->getVeterinerlisteArrayFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Veteriner.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("9000", $pa[0]["veterinerId"]);			// Toppen i arrayet
    	$this->assertEquals("6666", $pa[0]["postNr"]);				// Midten
    	$this->assertEquals("Jackie Chan", $pa[0]["endretAv"]);		// Bunnen i arrayet
    	
    	$this->assertEquals("9000", $pa[1]["veterinerId"]);			// Toppen i arrayet
    	$this->assertEquals("6666", $pa[1]["postNr"]);				// Midten
    	$this->assertEquals("Jackie Chan", $pa[1]["endretAv"]);		// Bunnen i arrayet
    }
    
    function testValiderVeterinerlisteFraFil()
    {
    	$hp = new VeterinerParser();
    	$this->assertTrue($hp->validerVeterinerlisteFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Veteriner.dat'));
    }
    
    function testValiderVeterinerliste()
    {
    	$hp = new VeterinerParser();
    	
    	$this->assertTrue($hp->validerVeterinerliste("VEID|PEID|Adresse1|Adresse2|Adresse3|Postnr|Telefon|Telefax|KlinikkNavn|RegDato|RegAv|EndretAv"));
    	$this->assertFalse($hp->validerVeterinerliste("VEIT|PEID|Adresse1|Adresse2|Adresse3|Postnr|Telefon|Telefax|KlinikkNavn|RegDato|RegAv|EndretAv"));
    	$this->assertFalse($hp->validerVeterinerliste(""));
    	$this->assertFalse($hp->validerVeterinerliste("false"));
    }    
}
?>