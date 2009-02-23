<?php
require_once 'Tilkobling.php';

class ACLDatabase
{
	private $database;
	
	public function __construct()
	{
		//i can has dbasecunecshun
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	//alle roller i databasen
	public function hentAlleRoller()
	{
		$hent = $this->database->select()
		->from(array('r'=>'AD_rolle'), array('r.navn'));
		
		return $this->database->fetchAll($hent);
	}
	
	//alle rettigheter i databasen
	public function hentAlleRettigheter()
	{
		$hent = $this->database->select()
		->from(array('r'=>'AD_rettighet'), array('r.navn'));
		
		return $this->database->fetchAll($hent);
	}
	
	//rollene sine rettigheter
	public function hentRollesRettigheter()
	{
		$hent = $this->database->select()
		->from(array('r'=>'AD_rolle_rettighet_link'), array('r.AD_rolle_navn', 'AD_rettighet_navn'));
		
		return $this->database->fetchAll($hent);
	}
	
	//array av alle roller en bruker har
	public function hentRoller($brukerEpost)
	{	
		//superviktig med sanitering! tryner hvis ikke:'(
		$hvor = $this->database->quoteInto('a.AD_bruker_epost=?', $brukerEpost);
		
		$hent = $this->database->select()
		->from(array('a'=>'AD_bruker_rolle_link'), array('a.AD_rolle_navn', 'a.AD_bruker_epost'))
		->where($hvor);
		
		return $this->database->fetchAll($hent);
	}
	
	//array av rettighetene til en bruker
	public function hentRettigheter($brukerEpost)
	{
		$hvor = $this->database->quoteInto('a.AD_bruker_epost=?', $brukerEpost);
		
		$hent = $this->database->select()
		->from(array('a'=>'AD_bruker_rolle_link'), array('a.AD_rolle_navn', 'rr.AD_rolle_navn', 'rr.AD_rettighet_navn'))
		->joinLeft(array('rr'=>'AD_rolle_rettighet_link'),'a.AD_rolle_navn = rr.AD_rolle_navn', array())
		->where($hvor);
		
		return $this->database->fetchAll($hent);
	}
}