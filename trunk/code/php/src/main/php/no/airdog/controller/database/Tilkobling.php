<?php

class Tilkobling
{
	private $dbServer;
	private $dbNavn;
	private $dbBrukernavn;
	private $dbPassord;
	
	public function __construct() 
	{
		$this->dbServer='localhost';
		$this->dbNavn='airdog';
		$this->dbBrukernavn ='root';
		$this->dbPassord = '';
	}

	public function getTilkobling()
	{
		try 
		{
			$database = Zend_Db::factory('Mysqli',array(
			'host' => $this->dbServer,
			'dbname' => $this->dbNavn,
			'username' => $this->dbBrukernavn,
			'password' => $this->dbPassord));
			
			$database->query('SET NAMES UTF8');
			
			return $database;
		}
		catch ( Zend_database_Exception $e)
		{
			return "Feil med tilkobling: " . get_class($e) . "\nMelding: " . $e->getMessage();
		}
	}
}