<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.parser').'/HundParser.php';

class HundParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetHundArray() 
    {
    	$hp = new HundParser();
    	$parseString = "323|345453|&15335/4354|Tittel|hunden|&1212/2323|&213/57213270|1032332303067|Farge M/Svart|gra|ja|kanskje|skallet|1337|H|21232123323|tore|idag|igar|stor";
        $pa = $hp->getArray($parseString);
        
    	$this->assertEquals("323", $pa["raseId"]);
    	$this->assertEquals("345453", $pa["kullId"]);
    	$this->assertEquals("&15335/4354", $pa["hundId"]);
    	$this->assertEquals("Tittel", $pa["tittel"]);
    	$this->assertEquals("hunden", $pa["navn"]);
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
    
    function testGetHundelisteArray()
    {
    	$parseString = 'RAID|KUID|HUID|Tittel|Navn|HUIDFar|HUIDMor|IDNR|FargeBeskrivelse|FargeVariant|AD|HD|Haarlag|IDMerk|Kjoenn|PEID|EndretAv|EndretDato|RegDato|Stoerrelse
    					323|345453|&15335/4354|Tittel|Hei&HåHuden|&1212/2323|&213/57213270|1032332303067|Farge M/Svart|gra|ja|kanskje|skallet|1337|H|21232123323|tore|idag|igar|stor
        				3232|345453|&15335/4354|Tittel|Hei&HåHuden|&1212/2323|&213/57213270|1032332303067|Farge M/Svart|gra2|ja|kanskje|skallet|1337|H|21232123323|tore|idag|igar|stor2';
    	
        $hp = new HundParser();
        $pa = $hp->getlisteArray($parseString);
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("323", $pa[0]["raseId"]);			// Toppen i arrayet
    	$this->assertEquals("gra", $pa[0]["fargeVariant"]);		// Midten
    	$this->assertEquals("stor", $pa[0]["storrelse"]);		// Bunnen i arrayet
    	
    	$this->assertEquals("3232", $pa[1]["raseId"]);			// Toppen i arrayet
    	$this->assertEquals("gra2", $pa[1]["fargeVariant"]);		// Midten
    	$this->assertEquals("stor2", $pa[1]["storrelse"]);		// Bunnen i arrayet
    }
    
    function testGetHundelisteArrayFraFil()
    {	
    	$hp = new HundParser();
    	
    	$pa = $hp->getHundelisteArrayFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Hund.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("323", $pa[0]["raseId"]);			// Toppen i arrayet
    	$this->assertEquals("gra", $pa[0]["fargeVariant"]);		// Midten
    	$this->assertEquals("stor", $pa[0]["storrelse"]);		// Bunnen i arrayet
    	
    	$this->assertEquals("3232", $pa[1]["raseId"]);			// Toppen i arrayet
    	$this->assertEquals("gra2", $pa[1]["fargeVariant"]);	// Midten
    	$this->assertEquals("stor2", $pa[1]["storrelse"]);		// Bunnen i arrayet
    }
    
    function testValiderHundelisteFraFil()
    {
    	$hp = new HundParser();
    	$this->assertTrue($hp->validerHundelisteFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Hund.dat'));
    }
    
    function testValiderHundeliste()
    {
    	$hp = new HundParser();
    	
    	$this->assertTrue($hp->validerHundeliste("RAID|KUID|HUID|Tittel|Navn|HUIDFar|HUIDMor|IDNR|FargeBeskrivelse|FargeVariant|AD|HD|Haarlag|IDMerk|Kjoenn|PEID|EndretAv|EndretDato|RegDato|Stoerrelse"));
    	$this->assertFalse($hp->validerHundeliste("RAID|KUID|HUID|Tittel|Navn|HUIDFar|HUIDMor|IDNR|FaargeBeskrivelse|FargeVariant|AD|HD|Haarlag|IDMerk|Kjoenn|PEID|EndretAv|EndretDato|RegDato|Stoerrelse"));
    	$this->assertFalse($hp->validerHundeliste(""));
    	$this->assertFalse($hp->validerHundeliste("false"));
    }
    
    function testgetHundDatabaseSomDat()
    {
    	$hp = new HundParser();
    	$parseString = "323|345453|&15335/4354|Tittel|hunden|&1212/2323|&213/57213270|1032332303067|Farge M/Svart|gra|ja|kanskje|skallet|1337|H|21232123323|tore|10.02.2022|10.22.2222|stor";
        $paa = $hp->getHundArray($parseString);
        $pa = $hp->getHundDatabaseSomDat($paa);
        
    	$this->assertEquals($parseString, $pa);
    	
    }
}
?>