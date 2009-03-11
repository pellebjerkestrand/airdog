<?php 
require_once 'Tilkobling.php';

class RolleRettighetDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleRoller()
	{
		$hent = $this->database->select()
		->from('ad_rolle', array('ad_rolle.*'));
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentAlleRettigheter()
	{
		$hent = $this->database->select()
		->from('ad_rettighet', array('ad_rettighet.*'));
		
		return $this->database->fetchAll($hent);
	}
	
}
