<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.parser').'/OyesykdomParser.php';

class OyesykdomParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetOyesykdomArray() 
    {
    	$hp = new OyesykdomParser();
    	$parseString = "0000421|11111/97|0049|03|16.11.1999|3|M|1|318|3|4|0|5|16|2|3|1|ta|17.03.2000|ta|4|3099999|2|4|2|2|X";
        $pa = $hp->getArray($parseString);
        
    	$this->assertEquals("0000421", $pa["oyId"]);
    	$this->assertEquals("11111/97", $pa["hundId"]);
    	$this->assertEquals("0049", $pa["veterinerId"]);
    	$this->assertEquals("03", $pa["oyeVeteriner"]);
    	$this->assertEquals("1999-11-16", $pa["lystDato"]);
    	$this->assertEquals("3", $pa["idmerketKode"]);
    	$this->assertEquals("M", $pa["idmerket"]);
    	$this->assertEquals("1", $pa["idfeil"]);
    	$this->assertEquals("318", $pa["raseId"]);
    	$this->assertEquals("3", $pa["sendtEierDato"]);
    	$this->assertEquals("4", $pa["longAnnet"]);
    	$this->assertEquals("0", $pa["diagnoseKode1"]);
    	$this->assertEquals("5", $pa["diagnoseGrad1"]);
    	$this->assertEquals("16", $pa["diagnoseKode2"]);
    	$this->assertEquals("2", $pa["diagnoseGrad2"]);
    	$this->assertEquals("3", $pa["diagnoseKode3"]);
    	$this->assertEquals("1", $pa["diagnoseGrad3"]);
    	$this->assertEquals("ta", $pa["regAv"]);
    	$this->assertEquals("2000-03-17", $pa["regDato"]);
    	$this->assertEquals("ta", $pa["endretAv"]);
    	$this->assertEquals("4", $pa["endretDato"]);
    	$this->assertEquals("3099999", $pa["personId"]);
    	$this->assertEquals("2", $pa["sendtVetDato"]);
    	$this->assertEquals("4", $pa["sendtKlubbDato"]);
    	$this->assertEquals("2", $pa["longAnnet1"]);
    	$this->assertEquals("2", $pa["longAnnet2"]);
    	$this->assertEquals("X", $pa["inaktiv"]);
    }
    
    function testGetOyesykdomlisteArray()
    {
    	$parseString = 'OYID|HUID|VEID|OYEVET|LystDato|IdMerketKode|IdMerket|IdFeil|RAID|SendtEierDato|long_Annet|DiagnoseKode1|DiagnoseGrad1|DiagnoseKode2|DiagnoseGrad2|DiagnoseKode3|DiagnoseGrad3|RegAv|RegDato|EndretAv|EndretAv|PEID|SendtVetDato|SendtKlubbDato|long_Annet1|long_Annet2|Inaktiv
    					0000421|11111/97|0049|03|16.11.1999|3|M|1|318|3|4|0|5|16|2|3|1|ta|17.03.2000|ta|4|3099999|2|4|2|2|X
    					0000422|11111/97|0049|03|16.11.1999|3|M|1|319|3|4|0|5|16|2|3|1|ta|17.03.2000|ta|4|3099999|2|4|2|2|Y';
    	
        $hp = new OyesykdomParser();
        $pa = $hp->getOyesykdomlisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("0000421", $pa[0]["oyId"]);			// Toppen i arrayet
    	$this->assertEquals("318", $pa[0]["raseId"]);			// Midten
    	$this->assertEquals("X", $pa[0]["inaktiv"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("0000422", $pa[1]["oyId"]);			// Toppen i arrayet
    	$this->assertEquals("319", $pa[1]["raseId"]);			// Midten
    	$this->assertEquals("Y", $pa[1]["inaktiv"]);			// Bunnen i arrayet
    }    
    
	function testGetOyesykdomlisteArrayFraFil()
    {	
    	$hp = new OyesykdomParser();
    	
    	$pa = $hp->getOyesykdomlisteArrayFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Oyesykdom.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("0000421", $pa[0]["oyId"]);			// Toppen i arrayet
    	$this->assertEquals("318", $pa[0]["raseId"]);			// Midten
    	$this->assertEquals("X", $pa[0]["inaktiv"]);			// Bunnen i arrayet
    	
    	$this->assertEquals("0000422", $pa[1]["oyId"]);			// Toppen i arrayet
    	$this->assertEquals("319", $pa[1]["raseId"]);			// Midten
    	$this->assertEquals("Y", $pa[1]["inaktiv"]);			// Bunnen i arrayet
    }
    
    function testValiderOyesykdomlisteFraFil()
    {
    	$hp = new OyesykdomParser();
    	$this->assertTrue($hp->validerOyesykdomlisteFraFil(dirname(__FILE__).'/../../../../../dummyfiler/Oyesykdom.dat'));
    }
    
    function testValiderOyesykdomliste()
    {
    	$hp = new OyesykdomParser();
    	
    	$this->assertTrue($hp->validerOyesykdomliste("OYID|HUID|VEID|OYEVET|LystDato|IdMerketKode|IdMerket|IdFeil|RAID|SendtEierDato|long_Annet|DiagnoseKode1|DiagnoseGrad1|DiagnoseKode2|DiagnoseGrad2|DiagnoseKode3|DiagnoseGrad3|RegAv|RegDato|EndretAv|EndretAv|PEID|SendtVetDato|SendtKlubbDato|long_Annet1|long_Annet2|Inaktiv"));
    	$this->assertFalse($hp->validerOyesykdomliste("OYID|HUIT|VEID|OYEVET|LystDato|IdMerketKode|IdMerket|IdFeil|RAID|SendtEierDato|long_Annet|DiagnoseKode1|DiagnoseGrad1|DiagnoseKode2|DiagnoseGrad2|DiagnoseKode3|DiagnoseGrad3|RegAv|RegDato|EndretAv|EndretAv|PEID|SendtVetDato|SendtKlubbDato|long_Annet1|long_Annet2|Inaktiv"));
    	$this->assertFalse($hp->validerOyesykdomliste(""));
    	$this->assertFalse($hp->validerOyesykdomliste("false"));
    }
}
?>