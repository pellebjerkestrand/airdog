<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZendTest.php';
require_once str_replace('.','/','no.airdog.controller.parser').'/KullParser.php';

class KullParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetKullArray() 
    {
    	$hp = new KullParser();
    	$parseString = "665525|11111/96|03225/97|3074574|20.04.2001|19.09.2000|348";
        $pa = $hp->getKullArray($parseString);
        
    	$this->assertEquals("665525", $pa["kullId"]);
    	$this->assertEquals("11111/96", $pa["hundIdFar"]);
    	$this->assertEquals("03225/97", $pa["hundIdMor"]);
    	$this->assertEquals("3074574", $pa["oppdretterId"]);
    	$this->assertEquals("2001-04-20", $pa["endretDato"]);
    	$this->assertEquals("2000-09-19", $pa["fodt"]);
    	$this->assertEquals("348", $pa["raseId"]);
    }
    
    function testGetKulllisteArray()
    {
    	$parseString = 'KUID|HUIDFar|HUIDMor|PEIDOppdretter|EndretDato|Foedt|RAID
    					665525|11111/96|03225/97|3074574|20.04.2001|19.09.2000|348
						775525|11111/96|03225/97|3074575|20.04.2001|19.09.2000|349';
    	
        $hp = new KullParser();
        $pa = $hp->getKulllisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("665525", $pa[0]["kullId"]);				// Toppen i arrayet
    	$this->assertEquals("3074574", $pa[0]["oppdretterId"]);			// Midten
    	$this->assertEquals("348", $pa[0]["raseId"]);					// Bunnen i arrayet
    	
    	$this->assertEquals("775525", $pa[1]["kullId"]);				// Toppen i arrayet
    	$this->assertEquals("3074575", $pa[1]["oppdretterId"]);			// Midten
    	$this->assertEquals("349", $pa[1]["raseId"]);					// Bunnen i arrayet
    }    
    
	function testGetKulllisteArrayFraFil()
    {	
    	$hp = new KullParser();
    	
    	$pa = $hp->getKulllisteArrayFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Kull.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("665525", $pa[0]["kullId"]);				// Toppen i arrayet
    	$this->assertEquals("3074574", $pa[0]["oppdretterId"]);			// Midten
    	$this->assertEquals("348", $pa[0]["raseId"]);					// Bunnen i arrayet
    	
    	$this->assertEquals("775525", $pa[1]["kullId"]);				// Toppen i arrayet
    	$this->assertEquals("3074575", $pa[1]["oppdretterId"]);			// Midten
    	$this->assertEquals("349", $pa[1]["raseId"]);					// Bunnen i arrayet
    }
    
    function testValiderKulllisteFraFil()
    {
    	$hp = new KullParser();
    	$this->assertTrue($hp->validerKulllisteFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Kull.dat'));
    }
    
    function testValiderKullliste()
    {
    	$hp = new KullParser();
    	
    	$this->assertTrue($hp->validerKullliste("KUID|HUIDFar|HUIDMor|PEIDOppdretter|EndretDato|Foedt|RAID"));
    	$this->assertFalse($hp->validerKullliste("KUID|HUIDFar|HUIDM0r|PEIDOppdretter|EndretDato|Foedt|RAID"));
    	$this->assertFalse($hp->validerKullliste(""));
    	$this->assertFalse($hp->validerKullliste("false"));
    }
}
?>