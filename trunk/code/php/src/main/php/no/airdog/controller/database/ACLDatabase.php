<?php
require_once 'Tilkobling.php';
require_once 'Tilkobling_.php';

class ACLDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling_();
		$this->database = $tilkobling->getTilkobling();
	}
}