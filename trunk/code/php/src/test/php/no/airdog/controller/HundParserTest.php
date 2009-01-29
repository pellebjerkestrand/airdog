<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/HundParser.php';

class HundParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetHundArray() 
    {
    	$hp = new HundParser();
    	$parseString = "323|345453|&15335/4354|Tittel|Hei&HŒHuden|&1212/2323|&213/57213270|1032332303067|Farge M/Svart||||||H|21232123323||||";
        $pa = $hp->getHundArray($parseString);
        
    	$this->assertEquals("323", $pa["raseId"]);
    	$this->assertEquals("345453", $pa["kullId"]);
    	$this->assertEquals("&15335/4354", $pa["hundId"]);
    	$this->assertEquals("Tittel", $pa["tittel"]);
    	$this->assertEquals("Hei&HŒHuden", $pa["navn"]);
    	$this->assertEquals("&1212/2323", $pa["hundFarId"]);
    	$this->assertEquals("&213/57213270", $pa["hundMorId"]);
    	$this->assertEquals("1032332303067", $pa["idNr"]);
    	$this->assertEquals("Farge M/Svart", $pa["farge"]);
    	$this->assertEquals("", $pa["fargeVariant"]);
    	$this->assertEquals("", $pa["oyesykdom"]);
    	$this->assertEquals("", $pa["hoftesykdom"]);
    	$this->assertEquals("", $pa["haarlag"]);
    	$this->assertEquals("", $pa["idMerke"]);
    	$this->assertEquals("H", $pa["kjonn"]);
    	$this->assertEquals("21232123323", $pa["eierId"]);
    	$this->assertEquals("", $pa["endretAv"]);
    	$this->assertEquals("", $pa["endretDato"]);
    	$this->assertEquals("", $pa["regDato"]);
    	$this->assertEquals("", $pa["storrelse"]);
    }
}
?>