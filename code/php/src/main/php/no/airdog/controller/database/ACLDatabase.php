<?php
require_once 'ValiderBruker.php';
require_once "RolleBrukerDatabase.php";
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
		->group('a.ad_klubb_raseid')
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
	
	public function redigerEgenBruker($fraBruker, $tilBruker, $brukerPassord)
	{
		$db = new RolleBrukerDatabase();
		
		$nyEpostBruker = $this->hentBruker($tilBruker->epost);
		
		if($fraBruker->epost != $tilBruker->epost && isset($nyEpostBruker))
		{
			throw(new Exception('E-posten er allerede registrert på en annen bruker', "1"));
		}
		else if ($fraBruker->epost == "")
		{
			throw(new Exception('E-postfeltet kan ikke være tomt', 1));
		}
		
		if ($tilBruker->passord == "")
		{
			$gammelBruker = $db->hentBruker($fraBruker->epost);
			
			if(!isset($gammelBruker))
				throw(new Exception('Passordfeltet kan ikke være tomt', 1));
				
			$tilBruker->passord = $gammelBruker['passord'];
		}
		else
		{
			$tilBruker['passord'] = sha1($tilBruker->passord);
		}
		
		if($tilBruker->passord != "")
		{
			$fraBruker->passord = $tilBruker->passord;
		}
		
		$redigertBruker = array();
		$redigertBruker['epost'] = $tilBruker->epost;
    	$redigertBruker['fornavn'] = $tilBruker->fornavn;
    	$redigertBruker['etternavn'] = $tilBruker->etternavn;
    	$redigertBruker['passord'] = sha1($tilBruker->passord);
			
		$hvor = $this->database->quoteInto('epost = ?', $fraBruker->epost);			
		$this->database->update('ad_bruker', $redigertBruker, $hvor);
		
		$tilBruker->passord = $bruker->passord;

		return $tilBruker;
	}
	
}