<?php
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';
class ACLDatabase
{
	private $database;
	private $valider;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleRoller()
	{
		$hent = $this->database->select()
		->from(array('a'=>'AD_rolle'), array('a.navn'));
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentAlleRettigheter()
	{
		$hent = $this->database->select()
		->from(array('r'=>'AD_rettighet'), array('r.navn', 'r.beskrivelse'));
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentRollesRettigheter($rolle)
	{
		$hvor = $this->database->quoteInto('r.AD_rolle_navn=?', $rolle);
		
		$hent = $this->database->select()
		->from(array('r'=>'AD_rolle_rettighet_link'), array('AD_rettighet_navn'))
		->where($hvor);
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentBrukersKlubber($brukerEpost, $brukerPassord)
	{	
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{		
			$bruker = $this->database->quoteInto('a.AD_bruker_epost=?', $brukerEpost);
			
			$hent = $this->database->select()
			->from(array('a'=>'AD_bruker_klubb_rolle_link'), array('a.ad_klubb_id', 'b.navn', 'b.raseId'))
			->join(array('b'=>'ad_klubb'),'a.ad_klubb_id = b.raseId', array())
			->where($bruker);
			
			return $this->database->fetchAll($hent);
		}
		
		return null;
	}
	
	public function hentBrukersRoller($brukerEpost, $brukerPassord, $klubbId)
	{	
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{		
			$bruker = $this->database->quoteInto('a.AD_bruker_epost=?', $brukerEpost);
			$klubb = $this->database->quoteInto('a.AD_klubb_id=?', $klubbId);
			
			$hent = $this->database->select()
			->from(array('a'=>'AD_bruker_klubb_rolle_link'), array('a.AD_rolle_navn', 'a.AD_bruker_epost'))
			->where($bruker)
			->where($klubb);
			
			return $this->database->fetchAll($hent);
		}
		
		return null;
	}

	public function hentBrukersRettigheter($brukerEpost, $passord, $klubbId)
	{
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $passord))
		{		
			$bruker = $this->database->quoteInto('a.AD_bruker_epost=?', $brukerEpost);
			$klubb = $this->database->quoteInto('a.AD_klubb_id=?', $klubbId);
			
			$hent = $this->database->select()
			->from(array('a'=>'AD_bruker_klubb_rolle_link'), array('a.AD_rolle_navn', 'rr.AD_rolle_navn', 'rr.AD_rettighet_navn'))
			->joinLeft(array('rr'=>'AD_rolle_rettighet_link'),'a.AD_rolle_navn = rr.AD_rolle_navn', array())
			->where($bruker)
			->where($klubb);
			
			return $this->database->fetchAll($hent);
		}
		return null;
	}
}