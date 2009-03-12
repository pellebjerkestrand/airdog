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
	
	public function hentRollersRettigheter($rolle)
	{
		$hent = $this->database->select()
		->from('ad_rolle_rettighet_link', array('ad_rettighet_navn'))
		->where('ad_rolle_navn =?', $rolle);
	
		return $this->database->fetchAll($hent);
	}
	
	public function leggtilRettighetPaRolle($rolle, $rettighet)
	{
		$data = array(
		    'ad_rolle_navn'	=> $rolle,
		    'ad_rettighet_navn' => $rettighet
		);
		
		return $this->database->insert('ad_rolle_rettighet_link', $data);
	}
	
}
