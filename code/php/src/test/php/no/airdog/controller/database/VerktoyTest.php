<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller.database').'/Verktoy.php';

class VerktoyTest extends PHPUnit_Framework_TestCase 
{
    function testTomTabell() 
    {
    	$vt = new Verktoy();
    	
    	$this->assertTrue($vt->tomTabell("Eier"));
		$this->assertTrue($vt->tomTabell("Fugl"));		
		$this->assertTrue($vt->tomTabell("Hdsykdom"));		
		$this->assertTrue($vt->tomTabell("Hund"));		
		$this->assertTrue($vt->tomTabell("Kull"));		
		$this->assertTrue($vt->tomTabell("Oppdrett"));		
		$this->assertTrue($vt->tomTabell("Person"));		
		$this->assertTrue($vt->tomTabell("Premie"));		
		$this->assertTrue($vt->tomTabell("Utstilling"));	
		$this->assertTrue($vt->tomTabell("Veteriner"));	
		$this->assertTrue($vt->tomTabell("Aasykdom"));		
		$this->assertTrue($vt->tomTabell("Rase"));
    }
}
?>