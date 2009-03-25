<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.parser').'/UtstillingParser.php';

//UTID|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|
//UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato

class UtstillignParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetUtstillingArray() 
    {
    	$hp = new UtstillingParser();
    	$parseString = "010001|036200|foo|22.11.1999|sb|GUSTAFSSON, ELLEN|MARKERUDLIA 2|foo|1490|foo|09.02.2000|SKEDSMOHALLEN|NORSK DOBERMANN KLUB|foo|22.03.2001";
        $pa = $hp->getUtstillingArray($parseString);
        
    	$this->assertEquals("010001", $pa["utstillingId"]);
    	$this->assertEquals("036200", $pa["klasseId"]);
    	$this->assertEquals("foo", $pa["personId"]);
    	$this->assertEquals("1999-11-22", $pa["regDato"]);
    	$this->assertEquals("sb", $pa["regAv"]);
    	$this->assertEquals("GUSTAFSSON, ELLEN", $pa["navn"]);
    	$this->assertEquals("MARKERUDLIA 2", $pa["adresse1"]);
    	$this->assertEquals("foo", $pa["adresse2"]);
    	$this->assertEquals("1490", $pa["postNr"]);
    	$this->assertEquals("foo", $pa["spesialAdresse"]);
    	$this->assertEquals("2000-02-09", $pa["utstillingDato"]);
    	$this->assertEquals("SKEDSMOHALLEN", $pa["utstillingSted"]);
    	$this->assertEquals("NORSK DOBERMANN KLUB", $pa["arrangorNavn1"]);
    	$this->assertEquals("foo", $pa["arrangorNavn2"]);
    	$this->assertEquals("2001-03-22", $pa["overfortDato"]);
    }    
    
    function testGetUtstillinglisteArray()
    {
    	$parseString = 'UTID|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato
    					100005|111100|3033819|07.11.1999|sb|BYRB�KKEN, TOVE|foo|foo|2739|foo|16.01.2010|VINSTRAHALLEN|POINTER HUNDEKLUBB|foo|foo
						100006|014100|2594871|03.11.1999|sb|PETTERSEN, TORILL|SORLAND|foo|3538|foo|16.01.2010|GLOMMA, DAL|NORSK POLAREHUNDKLUBB|foo|21.02.2010';
    	
        $hp = new UtstillingParser();
        $pa = $hp->getUtstillinglisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("100005", $pa[0]["utstillingId"]);			// Toppen i arrayet
    	$this->assertEquals("foo", $pa[0]["adresse1"]);					// Midten
    	$this->assertEquals("foo", $pa[0]["overfortDato"]);				// Bunnen i arrayet
    	
    	$this->assertEquals("100006", $pa[1]["utstillingId"]);			// Toppen i arrayet
    	$this->assertEquals("SORLAND", $pa[1]["adresse1"]);				// Midten
   		$this->assertEquals("2010-02-21", $pa[1]["overfortDato"]);		// Bunnen i arrayet
    }    
    
	function testGetUtstillinglisteArrayFraFil()
    {	
    	$hp = new UtstillingParser();
    	
    	$pa = $hp->getUtstillinglisteArrayFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Utstilling.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("100005", $pa[0]["utstillingId"]);			// Toppen i arrayet
    	$this->assertEquals("foo", $pa[0]["adresse1"]);					// Midten
    	$this->assertEquals("foo", $pa[0]["overfortDato"]);				// Bunnen i arrayet
    	
    	$this->assertEquals("100006", $pa[1]["utstillingId"]);			// Toppen i arrayet
    	$this->assertEquals("SORLAND", $pa[1]["adresse1"]);				// Midten
   		$this->assertEquals("2010-02-21", $pa[1]["overfortDato"]);		// Bunnen i arrayet
    }
    
    function testValiderUtstillinglisteFraFil()
    {
    	$hp = new UtstillingParser();
    	$this->assertTrue($hp->validerUtstillinglisteFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Utstilling.dat'));
    }
    
    function testValiderUtstillingliste()
    {
    	$hp = new UtstillingParser();
    	
    	$this->assertTrue($hp->validerUtstillingliste("UTID|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato"));
    	$this->assertFalse($hp->validerUtstillingliste("UTIT|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato"));
    	$this->assertFalse($hp->validerUtstillingliste(""));
    	$this->assertFalse($hp->validerUtstillingliste("false"));
    }    
}
?>