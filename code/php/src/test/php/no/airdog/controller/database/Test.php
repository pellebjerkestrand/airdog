<?php
require_once 'PHPUnit/Framework.php';

class Testen extends PHPUnit_Framework_TestCase 
{
	function testen()
	{
		$hundId = "00348/3";
		$klubbId = "00348/3";
		
		$this->assertEquals($hundId, $klubbId);
	}
	
}