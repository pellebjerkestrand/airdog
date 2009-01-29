<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/HundParser.php';

class HundParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetHundArray() 
    {
    	$hp = new HundParser();
    	$parseString = "323|345453|&15335/4354|Tittel|Hei&HŒHuden|&1212/2323|&213/57213270|1032332303067|Farge M/Svart|gra|ja|kanskje|skallet|1337|H|21232123323|tore|idag|igar|stor";
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
    	$this->assertEquals("gra", $pa["fargeVariant"]);
    	$this->assertEquals("ja", $pa["oyesykdom"]);
    	$this->assertEquals("kanskje", $pa["hoftesykdom"]);
    	$this->assertEquals("skallet", $pa["haarlag"]);
    	$this->assertEquals("1337", $pa["idMerke"]);
    	$this->assertEquals("H", $pa["kjonn"]);
    	$this->assertEquals("21232123323", $pa["eierId"]);
    	$this->assertEquals("tore", $pa["endretAv"]);
    	$this->assertEquals("idag", $pa["endretDato"]);
    	$this->assertEquals("igar", $pa["regDato"]);
    	$this->assertEquals("stor", $pa["storrelse"]);
    }
}
?>