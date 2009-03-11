<?php
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';
class ACLDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleKlubber()
	{
		$hent = $this->database->select()
		->from(array('a'=>'ad_klubb'), array('a.navn', 'a.raseid'));
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentBrukersKlubber($brukerEpost)
	{	
		$bruker = $this->database->quoteInto('a.ad_bruker_epost=?', $brukerEpost);
		
		$hent = $this->database->select()
		->from(array('a'=>'ad_bruker_klubb_rolle_link'), array('b.navn', 'b.raseid'))
		->join(array('b'=>'ad_klubb'),'a.ad_klubb_raseid = b.raseid', array())
		->where($bruker);
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentBrukersRoller($brukerEpost, $klubbId)
	{	
		$bruker = $this->database->quoteInto('a.ad_bruker_epost=?', $brukerEpost);
		$klubb = $this->database->quoteInto('a.ad_klubb_raseid=?', $klubbId);
		
		$hent = $this->database->select()
		->from(array('a'=>'ad_bruker_klubb_rolle_link'), array('navn' => 'a.ad_rolle_navn'))
		->where($bruker)
		->where($klubb);
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentAlleRettigheter($klubbId)
	{
		$hent = $this->database->select()
		->from(array('a'=>'ad_rettighet'), array('a.navn'));
		
		return $this->database->fetchAll($hent);
	}

	public function hentBrukersRettigheter($brukerEpost, $klubbId)
	{
		$bruker = $this->database->quoteInto('a.ad_bruker_epost=?', $brukerEpost);
		$klubb = $this->database->quoteInto('a.ad_klubb_raseid=?', $klubbId);
		
		$hent = $this->database->select()
		->from(array('a'=>'ad_bruker_klubb_rolle_link'), array('navn' => 'rr.ad_rettighet_navn'))
		->joinLeft(array('rr'=>'ad_rolle_rettighet_link'),'a.ad_rolle_navn = rr.ad_rolle_navn', array())
		->where($bruker)
		->where($klubb);
		
		return $this->database->fetchAll($hent);
	}
}