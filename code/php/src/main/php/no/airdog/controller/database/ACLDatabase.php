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
	
	//array av alle roller en bruker har
	public function hentRoller($brukerEpost)
	{	
		//superviktig med sanitering! tryner hvis ikke:'(
		$hvor = $this->database->quoteInto('a.AD_bruker_epost = ?', $brukerEpost);
		
		$hent = $this->database->select()
		->from(array('a'=>'AD_bruker_rolle_link'), array('a.AD_rolle_navn', 'a.AD_bruker_epost'))
		->where($hvor);
		
		return $this->database->fetchAll($hent);
	}
	
	//assosiativ array av alle rolle/rettighet-par
	public function hentRettigheter($brukerEpost)
	{
		$hent = $this->database->select()
		->from(array('a'=>'AD_bruker_rolle_link'), array('a.AD_rolle_navn', 'rr.AD_rolle_navn', 'rr.AD_rettighet_navn'))
		->joinLeft(array('rr'=>'AD_rolle_rettighet_link'),'a.AD_rolle_navn = rr.AD_rolle_navn', array());
		
		return $this->database->fetchAll($hent);
	}
}