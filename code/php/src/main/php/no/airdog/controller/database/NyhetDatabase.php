<?php
require_once 'Tilkobling.php';

class NyhetDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentRSS($klubbId)
	{
		$hvor = $this->database->select()
				->from('ad_klubb', 'rss')
				->where('raseid = ?', $klubbId)
				->limit(1);
		
		$resultat = $this->database->fetchRow($hvor);
		
		return $resultat;
	}	
}