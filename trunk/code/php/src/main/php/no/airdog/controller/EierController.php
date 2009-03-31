<?php
require_once "no/airdog/controller/database/EierDatabase.php";

require_once 'database/Tilkobling.php';

class PersonController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
}