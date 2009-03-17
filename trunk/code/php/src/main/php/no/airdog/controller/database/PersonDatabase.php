<?php 
require_once 'Tilkobling.php';

class PersonDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentPerson($personId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('p'=>'nkk_person'), 'p.*')
		->where('p.personId=?', $personId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
}