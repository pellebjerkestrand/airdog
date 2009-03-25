<?php 
	ini_set("include_path", ini_get("include_path") .
		PATH_SEPARATOR . dirname(__FILE__).'/../../../main/php/com/' .
		PATH_SEPARATOR . dirname(__FILE__).'/../../../main/php/no/' .
		PATH_SEPARATOR . dirname(__FILE__).'/../../../main/php/' .
		PATH_SEPARATOR . dirname(__FILE__).'/../'); 
	
	
	class LastZend extends PHPUnit_Framework_TestCase 
	{
		function testLastZendLoader()
		{
			$this->assertEquals("", "");	
		}
	}