<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/UtstillingParser.php';

//UTID|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|
//UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato

class UtstillignParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetUtstillingArray() 
    {
    	$hp = new UtstillingParser();
    	$parseString = "010001|036200|foo|22.11.1999|sb|GUSTAFSSON, ELLEN|MARKERUDLIA 2|foo|1490|foo|09.02.2000|SKEDSMOHALLEN|NORSK DOBERMANN KLUB|foo|22.03.2001";
        $pa = $hp->getUtstillingArray($parseString);
        
    	$this->assertEquals("010001", $pa["UTID"]);
    	$this->assertEquals("036200", $pa["KLID"]);
    	$this->assertEquals("foo", $pa["PEID"]);
    	$this->assertEquals("22.11.1999", $pa["RegDato"]);
    	$this->assertEquals("sb", $pa["RegAv"]);
    	$this->assertEquals("GUSTAFSSON, ELLEN", $pa["Navn"]);
    	$this->assertEquals("MARKERUDLIA 2", $pa["Adresse1"]);
    	$this->assertEquals("foo", $pa["Adresse2"]);
    	$this->assertEquals("1490", $pa["Postnr"]);
    	$this->assertEquals("foo", $pa["SpesialAdresse"]);
    	$this->assertEquals("09.02.2000", $pa["UtstillingDato"]);
    	$this->assertEquals("SKEDSMOHALLEN", $pa["UtstillingSted"]);
    	$this->assertEquals("NORSK DOBERMANN KLUB", $pa["ArrangoerNavn1"]);
    	$this->assertEquals("foo", $pa["ArrangoerNavn2"]);
    	$this->assertEquals("22.03.2001", $pa["OverfoertDato"]);
    }    
    
    function testGetUtstillingListeArray()
    {
    	$parseString = '100005|111100|3033819|07.11.1999|sb|BYRBØKKEN, TOVE|foo|foo|2739|foo|16.01.2010|VINSTRAHALLEN|POINTER HUNDEKLUBB|foo|foo
						100006|014100|2594871|03.11.1999|sb|PETTERSEN, TORILL|SORLAND|foo|3538|foo|16.01.2010|GLOMMA, DAL|NORSK POLAREHUNDKLUBB|foo|21.02.2010';
    	
        $hp = new UtstillingParser();
        $pa = $hp->getUtstillingListeArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("100005", $pa[0]["UTID"]);			// Toppen i arrayet
    	$this->assertEquals("foo", $pa[0]["Adresse1"]);				// Midten
    	$this->assertEquals("foo", $pa[0]["OverfoertDato"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("100006", $pa[1]["UTID"]);			// Toppen i arrayet
    	$this->assertEquals("SORLAND", $pa[1]["Adresse1"]);				// Midten
    	$this->assertEquals("21.02.2010", $pa[1]["OverfoertDato"]);			// Bunnen i arrayet
    }    
}
?>