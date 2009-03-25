<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\..\LastZendTest.php';
require_once str_replace('.','/','no.airdog.controller.parser').'/Verktoy.php';

class VerktoyTest extends PHPUnit_Framework_TestCase 
{
    function testKonverterDatTilDatabaseDato() 
    {    	
    	$this->assertEquals("2002-12-24", Verktoy::konverterDatTilDatabaseDato("24.12.2002"));
    }
}
?>