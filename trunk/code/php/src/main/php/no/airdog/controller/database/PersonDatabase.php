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
	
	public function settInnPerson($personArray, $klubbId)
	{
		if ($personArray["raseId"] == $klubbId)
		{
			return $this->_settInnPerson($personArray);
		}

		return "RaseID " . $personArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnPerson($personArray)
	{
		if (sizeof($personArray) != 13)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($personArray).", forventet 20."; 
		}
		
		if (!isset($personArray["personId"]) || $personArray["personId"] == "")
		{ 
			return "personId-verdien mangler."; 
		}
		
		$dbPerson = $this->hentPerson($personArray["personId"], $personArray["raseId"]);
		
		if ($dbPerson == null)
		{
			$this->database->insert('nkk_person', $personArray);
		}
		else if ($dbPerson["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive???";
		}
		else
		{
			$hvor = $this->database->quoteInto('personId = ?', $personArray["personId"]) . $this->database->quoteInto('AND raseId = ?', $personArray["raseId"]);
			$this->database->update('nkk_person', $personArray, $hvor);
			return $personArray["personId"] . " ble oppdatert.";
		}
		
		return true;
	}
}