<?php

class Tilkobling
{
	private $config;
	
	public function __construct() 
	{
		$this->config = new Zend_Config(require 'no/airdog/config/db.php');
	}

	public function getTilkobling()
	{
		try 
		{
			$database = Zend_Db::factory($this->config->database);  
			$database->query('SET NAMES UTF8');
			
			return $database;
		}
		catch ( Zend_database_Exception $e)
		{
			return "Feil med tilkobling: " . get_class($e) . "\nMelding: " . $e->getMessage();
		}
	}
}


