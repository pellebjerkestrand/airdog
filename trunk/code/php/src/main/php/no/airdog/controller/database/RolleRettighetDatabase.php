<?php 
require_once 'Tilkobling.php';

class RolleRettighetDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
}
