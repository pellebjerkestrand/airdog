<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZend.php';
require_once str_replace('.','/','no.airdog.controller.parser').'/AasykdomParser.php';

class AasykdomParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetAasykdomArray() 
    {
    	$hp = new AasykdomParser();
    	$parseString = "9711|0201417|2|fooa|foob|fooc|food|tonn|gl|fooe|3|A|21787/89|foof|K|foo1|foo2|3426653|foo3|348|foo4|foo5|foo6|foo7|20.07.2010|04.07.2010";
        $pa = $hp->getAasykdomArray($parseString);
        
    	$this->assertEquals("9711", $pa["veId"]);
    	$this->assertEquals("0201417", $pa["aaId"]);
    	$this->assertEquals("2", $pa["diagnoseKode"]);
    	$this->assertEquals("fooa", $pa["idMerkerKode"]);
    	$this->assertEquals("foob", $pa["lidelseKode"]);
    	$this->assertEquals("fooc", $pa["sekHoyreKode"]);
    	$this->assertEquals("food", $pa["sekVenstreKode"]);
    	$this->assertEquals("tonn", $pa["endretAv"]);
    	$this->assertEquals("gl", $pa["regAv"]);
    	$this->assertEquals("fooe", $pa["avlestAv"]);
    	$this->assertEquals("3", $pa["betaling"]);
    	$this->assertEquals("A", $pa["diagnose"]);
    	$this->assertEquals("21787/89", $pa["hundId"]);
    	$this->assertEquals("foof", $pa["idFeil"]);
    	$this->assertEquals("K", $pa["idMerket"]);
    	$this->assertEquals("foo1", $pa["kode"]);
    	$this->assertEquals("foo2", $pa["lidelse"]);
    	$this->assertEquals("3426653", $pa["peId"]);
    	$this->assertEquals("foo3", $pa["purring"]);
    	$this->assertEquals("348", $pa["raseId"]);
    	$this->assertEquals("foo4", $pa["retur"]);
    	$this->assertEquals("foo5", $pa["sekHoyre"]);
    	$this->assertEquals("foo6", $pa["sekVenstre"]);
    	$this->assertEquals("foo7", $pa["sendes"]);
    	$this->assertEquals("20.07.2010", $pa["avlestDato"]);
    	$this->assertEquals("04.07.2010", $pa["rontgenDato"]);
    }    
    
    function testGetAasykdomlisteArray()
    {
    	$parseString = 'VEID|AAID|DiagnoseKode|IdMerkerKode|LidelseKode|SekHoyreKode|SekVenstreKode|EndretAv|RegAv|AvlestAv|Betaling|Diagnose|HUID|IdFeil|IdMerket|Kode|Lidelse|PEID|Purring|RAID|Retur|SekHoyre|SekVenstre|Sendes|AvlestDato|RontgenDato
    					9711|0201417|2|fooa|foob|fooc|food|tonn|gl|fooe|3|A|21787/89|foof|K|foo1|foo2|3426653|foo3|348|foo4|foo5|foo6|foo7|20.07.2010|04.07.2010
    					0202|0302989|1|lol|1|lol|lol|gl|saa|HKAS|8|A1|s28391/2005|lol|+|lol|C|3221747|lol|348|lol|lol|lol|lol|23.12.2009|16.11.2009';
    	
        $hp = new AasykdomParser();
        $pa = $hp->getAasykdomlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("9711", $pa[0]["veId"]);						// Toppen i arrayet
    	$this->assertEquals("gl", $pa[0]["regAv"]);							// Midten
    	$this->assertEquals("04.07.2010", $pa[0]["rontgenDato"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("0202", $pa[1]["veId"]);						// Toppen i arrayet
    	$this->assertEquals("saa", $pa[1]["regAv"]);						// Midten
    	$this->assertEquals("16.11.2009", $pa[1]["rontgenDato"]);			// Bunnen i arrayet
    }    
    
	function testGetAasykdomlisteArrayFraFil()
    {	
    	$hp = new AasykdomParser();
    	
    	$pa = $hp->getAasykdomlisteArrayFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Aasykdom.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("9711", $pa[0]["veId"]);						// Toppen i arrayet
    	$this->assertEquals("gl", $pa[0]["regAv"]);							// Midten
    	$this->assertEquals("04.07.2010", $pa[0]["rontgenDato"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("0202", $pa[1]["veId"]);						// Toppen i arrayet
    	$this->assertEquals("saa", $pa[1]["regAv"]);						// Midten
    	$this->assertEquals("16.11.2009", $pa[1]["rontgenDato"]);			// Bunnen i arrayet
    }
    
    function testValiderAasykdomlisteFraFil()
    {
    	$hp = new AasykdomParser();
    	$this->assertTrue($hp->validerAasykdomlisteFraFil(dirname(__FILE__).'\..\..\..\..\..\dummyfiler\Aasykdom.dat'));
    }
    
    function testValiderAasykdomliste()
    {
    	$hp = new AasykdomParser();
    	
    	$this->assertTrue($hp->validerAasykdomliste("VEID|AAID|DiagnoseKode|IdMerkerKode|LidelseKode|SekHoyreKode|SekVenstreKode|EndretAv|RegAv|AvlestAv|Betaling|Diagnose|HUID|IdFeil|IdMerket|Kode|Lidelse|PEID|Purring|RAID|Retur|SekHoyre|SekVenstre|Sendes|AvlestDato|RontgenDato"));
    	$this->assertFalse($hp->validerAasykdomliste("VEID|AAID|DiagnoseKode|IdMerkerKode|LidelseKode|SekHoyreKode|SekVenstreKode|EndretAv|RegAv|AvlestAv|Betaling|Diagnose|HUIT|IdFeil|IdMerket|Kode|Lidelse|PEID|Purring|RAID|Retur|SekHoyre|SekVenstre|Sendes|AvlestDato|RontgenDato"));
    	$this->assertFalse($hp->validerAasykdomliste(""));
    	$this->assertFalse($hp->validerAasykdomliste("false"));
    }    
}
?>