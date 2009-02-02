<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/PersonParser.php';

class PersonParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetPersonArray() 
    {
    	$hp = new PersonParser();
    	$parseString = "2459201|Petter, Svein Hansen|En gate. 2 A|3. b|4 a|4323|N|348|lol|112|05.02.2008|22.09.1993|19.09.1949";
        $pa = $hp->getPersonArray($parseString);
        
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
    	$this->assertEquals("05.02.2008", $pa["endretDato"]);
    	$this->assertEquals("22.09.1993", $pa["regDato"]);
    	$this->assertEquals("19.09.1949", $pa["fodt"]);
    }
    
    function testGetPersonlisteArray()
    {
    	$parseString = '2459201|Petter, Svein Hansen|En gate. 2 A|3. b|4 a|4323|N|348|lol|112|05.02.2008|22.09.1993|19.09.1949
    					2459202|Petter, Svein Hansen|En gate. 2 A|3. b|4 a|4323|N|349|lol|112|05.02.2008|22.09.1993|19.09.1950';
    	
        $hp = new PersonParser();
        $pa = $hp->getPersonlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("2459201", $pa[0]["personId"]);			// Toppen i arrayet
    	$this->assertEquals("348", $pa[0]["raseId"]);				// Midten
    	$this->assertEquals("19.09.1949", $pa[0]["fodt"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("2459202", $pa[1]["personId"]);			// Toppen i arrayet
    	$this->assertEquals("349", $pa[1]["raseId"]);				// Midten
    	$this->assertEquals("19.09.1950", $pa[1]["fodt"]);			// Bunnen i arrayet
    }    
}
?>