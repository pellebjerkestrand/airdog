<?php
require_once 'Tilkobling.php';

class ACLDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling_();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentRolleArray($brukerEpost)
	{	
		$hent = $this->database->select()
		->from(array('a'=>'AD_bruker_klubb_rolle_link'), 'a.AD_rolle_navn')
		->where('a.AD_bruker_epost = "%'.$brukerEpost.'%"');
		
		$resultat = $this->database->fetchAll($hent);
		
		$rolleArray = array();
		
		foreach($resultat as $r)
		{
			$rolleArray[] = $r["AD_rolle_navn"];
		}
		
		return $rolleArray;
	}
	
	public function hentRettighetArray()
	{
		$hent = $this->database->select()
		->from(array('rr'=>'AD_rolle_rettighet_link', 'rr.*'));
		
		$resultat = $this->database->fetchAll($hent);
		
		$rettighetArray = array();
		
		foreach($resultat as $r)
		{
			$rettighetArray[$r["AD_rolle_navn"]] = $r["AD_rettighet_navn"];
		}
		
		return $rettighetArray;
	}
	
	public function hentBrukersRettighetArray($brukerEpost)
	{
		$roller = hentRolleArray($brukerEpost);
		$rettigheter = hentRettighetArray();
		
		$brukersRettigheter = array();
		
		foreach($rettigheter as $rettighet)
		{
			for($i = 0; sizeof($roller) > $i; $i++)
			{
				if($rettighet["AD_rolle_navn"] == $roller[$i])
				{
					$brukersRettigheter = $rettighet["AD_rettighet_navn"];
				}
			}
		}
	}
}