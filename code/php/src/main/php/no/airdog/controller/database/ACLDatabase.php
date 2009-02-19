<?php
require_once 'Tilkobling.php';

class ACLDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	//array av alle roller en bruker har
	public function hentRoller($brukerEpost)
	{	
		$hent = $this->database->select()
		->from(array('a'=>'AD_bruker_klubb_rolle_link'), array('a.AD_rolle_navn'))
		->where('a.AD_bruker_epost = "%'.$brukerEpost.'%"');
		
		$resultat = $this->database->fetchAll($hent);
		
		$rolleArray = array();
		
		foreach($resultat as $r)
		{
			$rolleArray[] = $r["AD_rolle_navn"];
		}
		
		return $rolleArray;
	}
	
	//assosiativ array av alle rolle/rettighet-par
	public function hentRettigheter()
	{
		$hent = $this->database->select()
		->from(array('rr'=>'AD_rolle_rettighet_link', array('rr.*')));
		
		$resultat = $this->database->fetchAll($hent);
		
		$rettighetArray = array();
		
		foreach($resultat as $r)
		{
			$rettighetArray[$r["AD_rolle_navn"]] = $r["AD_rettighet_navn"];
		}
		
		return $rettighetArray;
	}
}