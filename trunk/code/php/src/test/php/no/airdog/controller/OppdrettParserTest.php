<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/OppdrettParser.php';

class OppdrettParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetOppdrettArray() 
    {
    	$hp = new OppdrettParser();
    	$parseString = "544|Svein, Geir Svein|33348";
        $pa = $hp->getOppdrettArray($parseString);
        
    	$this->assertEquals("544", $pa["kullId"]);
    	$this->assertEquals("Svein, Geir Svein", $pa["oppdretter"]);
    	$this->assertEquals("33348", $pa["raseId"]);
    }
    
    function testGetOppdrettlisteArray()
    {
    	$parseString = '244234|Gro Geir|32211
						244234|Mansen Hasen|12212';
    	
        $hp = new OppdrettParser();
        $pa = $hp->getOppdrettlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("244234", $pa[0]["kullId"]);			// Toppen i arrayet
    	$this->assertEquals("Gro Geir", $pa[0]["oppdretter"]);				// Midten
    	$this->assertEquals("32211", $pa[0]["raseId"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("244234", $pa[1]["kullId"]);			// Toppen i arrayet
    	$this->assertEquals("Mansen Hasen", $pa[1]["oppdretter"]);				// Midten
    	$this->assertEquals("12212", $pa[1]["raseId"]);			// Bunnen i arrayet
    }    
}
?>
