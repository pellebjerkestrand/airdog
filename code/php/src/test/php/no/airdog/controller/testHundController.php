<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog.controller').'/HundController.php';

class AppTest extends PHPUnit_Framework_TestCase 
{
    function testGetAlleHunderNotNull() 
    {
    	$hc = new HundController();
        $this->assertNotNull($hc->getAlleHunder());
    }
}
?>