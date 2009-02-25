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
	
	public function hentBrukersKlubber($brukerEpost, $brukerPassord)
	{	
		if(ValiderBruker::validerSuperadmin($this->database, $brukerEpost, $brukerPassord))
		{
			$hent = $this->database->select()
			->from(array('a'=>'ad_klubb'), array('a.navn', 'a.raseId'));
			
			return $this->database->fetchAll($hent);
		}
		
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{		
			$bruker = $this->database->quoteInto('a.ad_bruker_epost=?', $brukerEpost);
			
			$hent = $this->database->select()
			->from(array('a'=>'ad_bruker_klubb_rolle_link'), array('b.navn', 'b.raseId'))
			->join(array('b'=>'ad_klubb'),'a.ad_klubb_raseid = b.raseId', array())
			->where($bruker);
			
			return $this->database->fetchAll($hent);
		}
		
		return null;
	}
	
	public function hentBrukersRoller($brukerEpost, $brukerPassord, $klubbId)
	{	
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{		
			$bruker = $this->database->quoteInto('a.ad_bruker_epost=?', $brukerEpost);
			$klubb = $this->database->quoteInto('a.ad_klubb_raseid=?', $klubbId);
			
			$hent = $this->database->select()
			->from(array('a'=>'AD_bruker_klubb_rolle_link'), array('navn' => 'a.AD_rolle_navn'))
			->where($bruker)
			->where($klubb);
			
			return $this->database->fetchAll($hent);
		}
		
		return null;
	}

	public function hentBrukersRettigheter($brukerEpost, $passord, $klubbId)
	{
		if(ValiderBruker::validerSuperadmin($this->database, $brukerEpost, $passord))
		{
			$hent = $this->database->select()
			->from(array('a'=>'ad_rettighet'), array('a.navn'));
			
			return $this->database->fetchAll($hent);
		}
		
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $passord))
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
		return null;
	}
}