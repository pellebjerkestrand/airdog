<?php 
require_once 'Tilkobling.php';

class RolleBrukerDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleBrukere()
	{
		$hent = $this->database->select()
		->from('ad_bruker', array('ad_bruker.*'));
		
		return $this->database->fetchAll($hent);
	}
		
	public function hentRollesBrukere($rolle, $klubb)
	{
		$hent = $this->database->select()
		->from('ad_bruker_klubb_rolle_link', array('ad_bruker_epost'))
		->where('ad_rolle_navn =?', $rolle)
		->where('ad_klubb_raseid =?', $klubb);
	
		return $this->database->fetchAll($hent);
	}
	
	public function hentKlubbsRoller($klubb)
	{
		$hent = $this->database->select()
		->from('ad_bruker_klubb_rolle_link', array('ad_rolle_navn'))
		->where('ad_klubb_raseid =?', $klubb);
	
		return $this->database->fetchAll($hent);
	}
}
