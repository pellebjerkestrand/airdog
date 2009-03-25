<?php 
	require_once 'PHPUnit/Framework.php';
	
	ini_set("include_path", ini_get("include_path") .
		PATH_SEPARATOR . dirname(__FILE__).'/../../../main/php/com/' .
		PATH_SEPARATOR . dirname(__FILE__).'/../../../main/php/no/' .
		PATH_SEPARATOR . dirname(__FILE__).'/../../../main/php/' .
		PATH_SEPARATOR . dirname(__FILE__).'/../'); 
	
	//require_once 'no/airdog/index.php';
	
	
	class LastZendTest extends PHPUnit_Framework_TestCase 
	{
		function testLastZendTest()
		{
			//Zend_Loader::registerAutoload();	
		}
	}