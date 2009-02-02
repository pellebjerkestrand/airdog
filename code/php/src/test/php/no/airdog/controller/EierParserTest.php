<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/EierParser.php';

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
    	$parseString = 'PETTER HANSEN|02033/89|348
        				PELLE HANSEN|02213/91|349';
    	
        $hp = new EierParser();
        $pa = $hp->getEierlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("PETTER HANSEN", $pa[0]["eier"]);			// Toppen i arrayet
    	$this->assertEquals("02033/89", $pa[0]["hundId"]);				// Midten
    	$this->assertEquals("348", $pa[0]["raseId"]);					// Bunnen i arrayet
    	
    	$this->assertEquals("PELLE HANSEN", $pa[1]["eier"]);			// Toppen i arrayet
    	$this->assertEquals("02213/91", $pa[1]["hundId"]);				// Midten
    	$this->assertEquals("349", $pa[1]["raseId"]);					// Bunnen i arrayet
    }    
}
?>