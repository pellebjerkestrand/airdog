<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.parser').'/PremieParser.php';

class PremieParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetPremieArray() 
    {
    	$hp = new PremieParser();
    	$parseString = "1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30";
        $pa = $hp->getPremieArray($parseString);
        
    	$this->assertEquals("1", $pa["doId"]);
    	$this->assertEquals("2", $pa["utstillingId"]);
    	$this->assertEquals("3", $pa["hundId"]);
    	$this->assertEquals("4", $pa["katalogNr"]);
    	$this->assertEquals("5", $pa["personIdDommer"]);
    	$this->assertEquals("6", $pa["klasse"]);
    	$this->assertEquals("7", $pa["kjonn"]);
    	$this->assertEquals("8", $pa["raseId"]);
    	$this->assertEquals("9", $pa["IM"]);
    	$this->assertEquals("10", $pa["KIP"]);
    	$this->assertEquals("11", $pa["JK"]);
    	$this->assertEquals("12", $pa["JKK"]);
    	$this->assertEquals("13", $pa["UK"]);
    	$this->assertEquals("14", $pa["UKK"]);
    	$this->assertEquals("15", $pa["BK"]);
    	$this->assertEquals("16", $pa["BKK"]);
    	$this->assertEquals("17", $pa["AK"]);
    	$this->assertEquals("18", $pa["AKK"]);
    	$this->assertEquals("19", $pa["VK"]);
    	$this->assertEquals("20", $pa["CHK"]);
    	$this->assertEquals("21", $pa["CHKK"]);
    	$this->assertEquals("22", $pa["VTK"]);
    	$this->assertEquals("23", $pa["VTKK"]);
    	$this->assertEquals("24", $pa["HP"]);
    	$this->assertEquals("25", $pa["CK"]);
    	$this->assertEquals("26", $pa["CC"]);
    	$this->assertEquals("27", $pa["CA"]);
    	$this->assertEquals("28", $pa["BIK"]);
    	$this->assertEquals("29", $pa["BIR"]);
    	$this->assertEquals("30", $pa["BIM"]);
    }
    
    function testGetPremielisteArray()
    {
    	$parseString = 'DOID|UTID|HUID|Katalognr|PEIDdommer|Klasse|Kjonn|RAID|IM|KIP|JK|JKK|UK|UKK|BK|BKK|AK|AKK|VK|CHK|CHKK|VTK|VTKK|HP|CK|CC|CA|BIK|BIR|BIM
    					1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30
    					1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30';
    	
    	
        $hp = new PremieParser();
        $pa = $hp->getPremielisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("1", $pa[0]["doId"]);			// Toppen i arrayet
		$this->assertEquals("16", $pa[0]["BKK"]);			// Midten
    	$this->assertEquals("30", $pa[0]["BIM"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("1", $pa[1]["doId"]);			// Toppen i arrayet
    	$this->assertEquals("16", $pa[1]["BKK"]);			// Midten
    	$this->assertEquals("30", $pa[1]["BIM"]);			// Bunnen i arrayet
    }    
    
	function testGetPremielisteArrayFraFil()
    {	
    	$hp = new PremieParser();
    	
    	$pa = $hp->getPremielisteArrayFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Premie.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("1", $pa[0]["doId"]);			// Toppen i arrayet
		$this->assertEquals("16", $pa[0]["BKK"]);			// Midten
    	$this->assertEquals("30", $pa[0]["BIM"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("1", $pa[1]["doId"]);			// Toppen i arrayet
    	$this->assertEquals("16", $pa[1]["BKK"]);			// Midten
    	$this->assertEquals("30", $pa[1]["BIM"]);			// Bunnen i arrayet
    }
    
    function testValiderPremielisteFraFil()
    {
    	$hp = new PremieParser();
    	$this->assertTrue($hp->validerPremielisteFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Premie.dat'));
    }
    
    function testValiderPremieliste()
    {
    	$hp = new PremieParser();
    	
    	$this->assertTrue($hp->validerPremieliste("DOID|UTID|HUID|Katalognr|PEIDdommer|Klasse|Kjonn|RAID|IM|KIP|JK|JKK|UK|UKK|BK|BKK|AK|AKK|VK|CHK|CHKK|VTK|VTKK|HP|CK|CC|CA|BIK|BIR|BIM"));
    	$this->assertFalse($hp->validerPremieliste("DOIT|UTID|HUID|Katalognr|PEIDdommer|Klasse|Kjonn|RAID|IM|KIP|JK|JKK|UK|UKK|BK|BKK|AK|AKK|VK|CHK|CHKK|VTK|VTKK|HP|CK|CC|CA|BIK|BIR|BIM"));
    	$this->assertFalse($hp->validerPremieliste(""));
    	$this->assertFalse($hp->validerPremieliste("false"));
    } 
    
    function testgetPremieDatabaseSomDat()
    {
    	$hp = new PremieParser();
    	$parseString = "1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30";
        $paa = $hp->getPremieArray($parseString);
        $pa = $hp->getPremieDatabaseSomDat($paa);
        
    	$this->assertEquals($parseString, $pa);
    	
    }   
}
?>