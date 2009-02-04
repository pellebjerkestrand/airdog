<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/FuglParser.php';

class FuglParserTest extends PHPUnit_Framework_TestCase 
{
    function testGetFuglArray() 
    {
    	$hp = new FuglParser();
    	$parseString = "50-95042|01.04.1995|L1|4|1355668|2425066|20466/90|8|1|0|1|2|3|5|4|3|2|1|2|3|4|5|6|5|4|3|2|1|2|3|4|5|6|5|4|TA|13.05.1995|348";
        $pa = $hp->getFuglArray($parseString);
        
    	$this->assertEquals("50-95042", $pa["proveNr"]);
    	$this->assertEquals("01.04.1995", $pa["proveDato"]);
    	$this->assertEquals("L1", $pa["partiNr"]);
    	$this->assertEquals("4", $pa["klasse"]);
    	$this->assertEquals("1355668", $pa["dommerId1"]);
    	$this->assertEquals("2425066", $pa["dommerId2"]);
    	$this->assertEquals("20466/90", $pa["hundId"]);
    	$this->assertEquals("8", $pa["slippTid"]);
    	$this->assertEquals("1", $pa["egneStand"]);
    	$this->assertEquals("0", $pa["egneStokk"]);
    	$this->assertEquals("1", $pa["tomStand"]);
    	$this->assertEquals("2", $pa["makkerStand"]);
    	$this->assertEquals("3", $pa["makkerStokk"]);
    	$this->assertEquals("5", $pa["jaktlyst"]);
    	$this->assertEquals("4", $pa["fart"]);
    	$this->assertEquals("3", $pa["stil"]);
    	$this->assertEquals("2", $pa["selvstendighet"]);
    	$this->assertEquals("1", $pa["bredde"]);
    	$this->assertEquals("2", $pa["reviering"]);
    	$this->assertEquals("3", $pa["samarbeid"]);
    	$this->assertEquals("4", $pa["presUpresis"]);
    	$this->assertEquals("5", $pa["presNoeUpresis"]);
    	$this->assertEquals("6", $pa["presPresis"]);
    	$this->assertEquals("5", $pa["reisNekter"]);
    	$this->assertEquals("4", $pa["reisNoelende"]);
    	$this->assertEquals("3", $pa["reisVillig"]);
    	$this->assertEquals("2", $pa["reidDjerv"]);
    	$this->assertEquals("1", $pa["sokStjeler"]);
    	$this->assertEquals("2", $pa["sokSpontant"]);
    	$this->assertEquals("3", $pa["appIkkeGodkjent"]);
    	$this->assertEquals("4", $pa["appGodkjent"]);
    	$this->assertEquals("5", $pa["rappInnkalt"]);
    	$this->assertEquals("6", $pa["rappSpont"]);
    	$this->assertEquals("5", $pa["premiegrad"]);
    	$this->assertEquals("4", $pa["certifikat"]);
    	$this->assertEquals("TA", $pa["regAv"]);
    	$this->assertEquals("13.05.1995", $pa["regDato"]);
    	$this->assertEquals("348", $pa["raseId"]);
    }
    
    function testGetFugllisteArray()
    {
    	$parseString = 'ProeveNr|ProveDato|PartiNr|Klasse|PEID_Domm1|PEID_Domm2|HUID|SlippTid|EgneStand|EgneStoekk|TomStand|MakkerStand|MakkerStoekk|JaktLyst|Fart|Stil|Selvstendighet|Bredde|Reviering|Samarbeid|Pres_Upresis|Pres_NoeUpresis|Pres_Presis|Reis_Nekter|Reis_Noelende|Reis_Villig|Reis_Djerv|Sek_Stjeler|Sek_Spontan|App_IkkeGodkj|App_Godkj|Rapp_Innkalt|Rapp_Spont|Premiegrad|CERTIFIKAT|RegAv|RegDato|RAID
    					50-95042|01.04.1995|L1|4|1355668|2425066|20466/90|8|1|0|1|2|3|5|4|3|2|1|2|3|4|5|6|5|4|3|2|1|2|3|4|5|6|5|4|TA|13.05.1995|348
    					50-95044|01.04.1995|L1|4|1355668|2425066|20466/90|8|1|0|1|2|3|5|4|3|2|1|2|3|4|9|6|5|4|3|2|1|2|3|4|5|6|5|4|TA|13.05.1995|349';
    	
        $hp = new FuglParser();
        $pa = $hp->getFugllisteArray($parseString);
        
        $this->assertEquals("2", sizeof($pa));
    	
    	$this->assertEquals("50-95042", $pa[0]["proveNr"]);				// Toppen i arrayet
    	$this->assertEquals("5", $pa[0]["presNoeUpresis"]);				// Midten
    	$this->assertEquals("348", $pa[0]["raseId"]);					// Bunnen i arrayet
    	
    	$this->assertEquals("50-95044", $pa[1]["proveNr"]);				// Toppen i arrayet
    	$this->assertEquals("9", $pa[1]["presNoeUpresis"]);				// Midten
    	$this->assertEquals("349", $pa[1]["raseId"]);					// Bunnen i arrayet
    }    
    
	function testGetFugllisteArrayFraFil()
    {	
    	$hp = new FuglParser();
    	
    	$pa = $hp->getFugllisteArrayFraFil(dirname(__FILE__).'\..\..\..\..\dummyfiler\Fugl.dat');
    	
        $this->assertEquals("2", sizeof($pa));
        
    	$this->assertEquals("50-95042", $pa[0]["proveNr"]);				// Toppen i arrayet
    	$this->assertEquals("5", $pa[0]["presNoeUpresis"]);				// Midten
    	$this->assertEquals("348", $pa[0]["raseId"]);					// Bunnen i arrayet
    	
    	$this->assertEquals("50-95044", $pa[1]["proveNr"]);				// Toppen i arrayet
    	$this->assertEquals("9", $pa[1]["presNoeUpresis"]);				// Midten
    	$this->assertEquals("349", $pa[1]["raseId"]);					// Bunnen i arrayet
    }
    
    function testValiderFugllisteFraFil()
    {
    	$hp = new FuglParser();
    	$this->assertTrue($hp->validerFugllisteFraFil(dirname(__FILE__).'\..\..\..\..\dummyfiler\Fugl.dat'));
    }
    
    function testValiderFuglliste()
    {
    	$hp = new FuglParser();
    	
    	$this->assertTrue($hp->validerFuglliste("ProeveNr|ProveDato|PartiNr|Klasse|PEID_Domm1|PEID_Domm2|HUID|SlippTid|EgneStand|EgneStoekk|TomStand|MakkerStand|MakkerStoekk|JaktLyst|Fart|Stil|Selvstendighet|Bredde|Reviering|Samarbeid|Pres_Upresis|Pres_NoeUpresis|Pres_Presis|Reis_Nekter|Reis_Noelende|Reis_Villig|Reis_Djerv|Sek_Stjeler|Sek_Spontan|App_IkkeGodkj|App_Godkj|Rapp_Innkalt|Rapp_Spont|Premiegrad|CERTIFIKAT|RegAv|RegDato|RAID"));
    	$this->assertFalse($hp->validerFuglliste("ProveNr|ProveDato|PartiNr|Klasse|PEID_Domm1|PEID_Domm2|HUID|SlippTid|EgneStand|EgneStoekk|TomStand|MakkerStand|MakkerStoekk|JaktLyst|Fart|Stil|Selvstendighet|Bredde|Reviering|Samarbeid|Pres_Upresis|Pres_NoeUpresis|Pres_Presis|Reis_Nekter|Reis_Noelende|Reis_Villig|Reis_Djerv|Sek_Stjeler|Sek_Spontan|App_IkkeGodkj|App_Godkj|Rapp_Innkalt|Rapp_Spont|Premiegrad|CERTIFIKAT|RegAv|RegDato|RAID"));
    	$this->assertFalse($hp->validerFuglliste(""));
    	$this->assertFalse($hp->validerFuglliste("false"));
    }    
}
?>