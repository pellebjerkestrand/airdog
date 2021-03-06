<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.parser').'/PersonParser.php';

class PersonParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetPersonArray() 
    {
    	$hp = new PersonParser();
    	$parseString = "2459201|Petter, Svein Hansen|En gate. 2 A|3. b|4 a|4323|N|348|lol|112|05.02.2008|22.09.1993|19.09.1949";
        $pa = $hp->getArray($parseString);
        
    	$this->assertEquals("2459201", $pa["personId"]);
    	$this->assertEquals("Petter, Svein Hansen", $pa["navn"]);
    	$this->assertEquals("En gate. 2 A", $pa["adresse1"]);
    	$this->assertEquals("3. b", $pa["adresse2"]);
    	$this->assertEquals("4 a", $pa["adresse3"]);
    	$this->assertEquals("4323", $pa["postNr"]);
    	$this->assertEquals("N", $pa["landkode"]);
    	$this->assertEquals("348", $pa["raseId"]);
    	$this->assertEquals("lol", $pa["status"]);
    	$this->assertEquals("112", $pa["telefon1"]);
    	$this->assertEquals("2008-02-05", $pa["endretDato"]);
    	$this->assertEquals("1993-09-22", $pa["regDato"]);
    	$this->assertEquals("1949-09-19", $pa["fodt"]);
    }
    
    function testGetPersonlisteArray()
    {
    	$parseString = 'PEID|Navn|Adresse1|Adresse2|Adresse3|Postnr|Landkode|RAID|Status|Telefon1|EndretDato|RegDato|Foedt
    					2459201|Petter, Svein Hansen|En gate. 2 A|3. b|4 a|4323|N|348|lol|112|05.02.2008|22.09.1993|19.09.1949
    					2459202|Petter, Svein Hansen|En gate. 2 A|3. b|4 a|4323|N|349|lol|112|05.02.2008|22.09.1993|19.09.1950';
    	
        $hp = new PersonParser();
        $pa = $hp->getlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("2459201", $pa[0]["personId"]);			// Toppen i arrayet
    	$this->assertEquals("348", $pa[0]["raseId"]);				// Midten
    	$this->assertEquals("1949-09-19", $pa[0]["fodt"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("2459202", $pa[1]["personId"]);			// Toppen i arrayet
    	$this->assertEquals("349", $pa[1]["raseId"]);				// Midten
    	$this->assertEquals("1950-09-19", $pa[1]["fodt"]);			// Bunnen i arrayet
    }    
    
	function testGetPersonlisteArrayFraFil()
    {	
    	$hp = new PersonParser();
    	
    	$pa = $hp->getlisteArrayFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Person.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("2459201", $pa[0]["personId"]);			// Toppen i arrayet
    	$this->assertEquals("348", $pa[0]["raseId"]);				// Midten
    	$this->assertEquals("1949-09-19", $pa[0]["fodt"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("2459202", $pa[1]["personId"]);			// Toppen i arrayet
    	$this->assertEquals("349", $pa[1]["raseId"]);				// Midten
    	$this->assertEquals("1950-09-19", $pa[1]["fodt"]);			// Bunnen i arrayet
    }
    
    function testValiderPersonlisteFraFil()
    {
    	$hp = new PersonParser();
    	$this->assertTrue($hp->validerPersonlisteFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Person.dat'));
    }
    
    function testValiderPersonliste()
    {
    	$hp = new PersonParser();
    	
    	$this->assertTrue($hp->validerPersonliste("PEID|Navn|Adresse1|Adresse2|Adresse3|Postnr|Landkode|RAID|Status|Telefon1|EndretDato|RegDato|Foedt"));
    	$this->assertFalse($hp->validerPersonliste("PEID|Navn|Adresse1|Adresse3|Adresse3|Postnr|Landkode|RAID|Status|Telefon1|EndretDato|RegDato|Foedt"));
    	$this->assertFalse($hp->validerPersonliste(""));
    	$this->assertFalse($hp->validerPersonliste("false"));
    }    
    
    function testgetPersonDatabaseSomDat()
    {
    	$hp = new PersonParser();
    	$parseString = "2459201|Petter, Svein Hansen|En gate. 2 A|3. b|4 a|4323|N|348|lol|112|05.02.2008|22.09.1993|19.09.1949";
        $paa = $hp->getArray($parseString);
        $pa = $hp->getDatabaseSomDat($paa);
        
    	$this->assertEquals($parseString, $pa);
    	
    }   
}
?>