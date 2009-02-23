<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZend.php';
require_once str_replace('.','/','no.airdog.controller.database').'/Verktoy.php';

class VerktoyTest extends PHPUnit_Framework_TestCase 
{
    function testKonverterDatTilDatabaseDato() 
    {
    	$vt = new Verktoy();
    	
    	$this->assertEquals("2000-12-24", $vt->konverterDatTilDatabaseDato("24.12.2000"));
    }
}
?>