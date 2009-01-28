<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/HundController.php';

class HundControllerTest extends PHPUnit_Framework_TestCase 
{
    function testGetAlleHunderNotNull() 
    {
    	$hc = new HundController();
        $this->assertNotNull($hc->getAlleHunder());
    }
    
	function testGetAlleHunderEquals() 
    {
    	$hc = new HundController();
    	$hc2 = new HundController();
        $this->assertEquals($hc->getAlleHunder(), $hc2->getAlleHunder());
    }
}
?>