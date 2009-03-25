<?php
require_once 'PHPUnit/Framework.php';
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__).'/../../../../../main/php/');
require_once str_replace('.','/','no.airdog.controller.parser').'/Verktoy.php';

class VerktoyTest extends PHPUnit_Framework_TestCase 
{
    function testKonverterDatTilDatabaseDato() 
    {    	
    	$this->assertEquals("2002-12-24", Verktoy::konverterDatTilDatabaseDato("24.12.2002"));
    }
}
?>