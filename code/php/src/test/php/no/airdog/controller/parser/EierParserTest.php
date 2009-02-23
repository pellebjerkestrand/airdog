<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZend.php';
require_once str_replace('.','/','no.airdog.controller.parser').'/EierParser.php';

class EierParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetEierArray() 
    {
    	$hp = new EierParser();
    	$parseString = "PETTER HANSEN|02033/89|348";
        $pa = $hp->getEierArray($parseString);
        
    	$this->assertEquals("PETTER HANSEN", $pa["eier"]);			// Toppen i arrayet
    	$this->assertEquals("02033/89", $pa["hundId"]);				// Midten
    	$this->assertEquals("348", $pa["raseId"]);					// Bunnen i arrayet
    }
    
    function testGetEierlisteArray()
    {
    	$parseString = 'EIER|HUID|RAID
						PELLE OG TORE BJERKESTRAND|04444/73|348
						TORE OG PELLE|00222/92|348';
    	
        $hp = new EierParser();
        $pa = $hp->getEierlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("PELLE OG TORE BJERKESTRAND", $pa[0]["eier"]);			// Toppen i arrayet
    	$this->assertEquals("04444/73", $pa[0]["hundId"]);							// Midten
    	$this->assertEquals("348", $pa[0]["raseId"]);								// Bunnen i arrayet
    	
    	$this->assertEquals("TORE OG PELLE", $pa[1]["eier"]);						// Toppen i arrayet
    	$this->assertEquals("00222/92", $pa[1]["hundId"]);							// Midten
    	$this->assertEquals("348", $pa[1]["raseId"]);								// Bunnen i arrayet
    }    
    
	function testGetEierlisteArrayFraFil()
    {	
    	$hp = new EierParser();
    	
    	$pa = $hp->getEierlisteArrayFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Eier.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("PELLE OG TORE BJERKESTRAND", $pa[0]["eier"]);			// Toppen i arrayet
    	$this->assertEquals("04444/73", $pa[0]["hundId"]);							// Midten
    	$this->assertEquals("348", $pa[0]["raseId"]);								// Bunnen i arrayet
    	
    	$this->assertEquals("TORE OG PELLE", $pa[1]["eier"]);						// Toppen i arrayet
    	$this->assertEquals("00222/92", $pa[1]["hundId"]);							// Midten
    	$this->assertEquals("348", $pa[1]["raseId"]);								// Bunnen i arrayet
    }
    
    function testValiderEierlisteFraFil()
    {
    	$hp = new EierParser();
    	$this->assertTrue($hp->validerEierlisteFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Eier.dat'));
    }
    
    function testValiderEierliste()
    {
    	$hp = new EierParser();
    	
    	$this->assertTrue($hp->validerEierliste("EIER|HUID|RAID"));
    	$this->assertFalse($hp->validerEierliste("EIER|HOID|RAID"));
    	$this->assertFalse($hp->validerEierliste(""));
    	$this->assertFalse($hp->validerEierliste("false"));
    }
}
?>