<?php
require_once 'Tilkobling.php';

class BrukerDatabase{
	private $database;
	
	/**
	* @return avhengigheter
	*/
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function getDb()
	{
		return $this-database;
	}	
}