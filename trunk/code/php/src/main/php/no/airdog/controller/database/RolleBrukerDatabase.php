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
}
