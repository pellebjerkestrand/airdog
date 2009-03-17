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
	
	public function leggBrukerTilRollePaKlubb($klubb, $rolle, $bruker)
	{		
		if($this->finnesBrukerPaRolleIklubb($klubb, $rolle, $bruker))
		{
			$data = array(
	   			'ad_klubb_raseid'	=> $klubb,
	    		'ad_rolle_navn' => $rolle,
	    		'ad_bruker_epost' => $bruker
			);
	
			return $this->database->insert('ad_bruker_klubb_rolle_link', $data);
		}
		
		throw(new Exception('Brukeren finnes allerede i denne rollen hos denne klubben', "1"));
	}
	
	public function slettBrukerFraRollePaKlubb($klubb, $rolle, $bruker)
	{		
		if(!$this->finnesBrukerPaRolleIklubb($klubb, $rolle, $bruker))
		{
			$hvor = $this->database->quoteInto('ad_klubb_raseid = ? ', $klubb) . 
				'AND ' . $this->database->quoteInto('ad_rolle_navn = ? ', $rolle) . 
				'AND ' . $this->database->quoteInto('ad_bruker_epost = ? ', $bruker);
				
			return $this->database->delete('ad_bruker_klubb_rolle_link', $hvor);
		}
		
		throw(new Exception('Brukeren finnes allerede i denne rollen hos denne klubben', "1"));
	}
	
	private function finnesBrukerPaRolleIklubb($klubb, $rolle, $bruker)
	{
		$hent = $this->database->select()
		->from('ad_bruker_klubb_rolle_link', array('ad_bruker_epost'))
		->where('ad_klubb_raseid=?', $klubb)
		->where('ad_rolle_navn =?', $rolle)
		->where('ad_bruker_epost =?', $bruker);
		
		$gyldig = $this->database->fetchRow($hent);
		
		if($gyldig)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function slettBruker($epost)
	{
		if(!$this->finnesBruker($epost))
		{
			$link = $this->database->quoteInto('ad_bruker_epost = ? ', $epost);
			$bruker = $this->database->quoteInto('epost = ? ', $epost);
		
			$this->database->delete('ad_bruker_klubb_rolle_link', $link);
			
			return $this->database->delete('ad_bruker', $bruker);
		}
		
		throw(new Exception('Denne rollen er slettet allerede', "1"));

	}	
	
	public function finnesBruker($epost)
	{
		$hent = $this->database->select()
		->from('ad_bruker', array('epost'))
		->where('epost =?', $epost);
		
		$gyldig = $this->database->fetchRow($hent);
		
		if($gyldig)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function leggInnBruker($bruker)
	{
			return $this->database->insert('ad_bruker', $bruker);
	}
	
	public function redigerBruker($bruker)
	{
		$hvor = $this->database->quoteInto('epost = ?', $bruker['epost']);			
		
		return $this->database->update('ad_bruker', $bruker, $hvor);
	}
}
