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
	
	public function settInn($personArray, $klubbId)
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
			return "Arrayet er av feil størrelse. Fikk ".sizeof($personArray).", forventet 13."; 
		}
		
		if (!isset($personArray["personId"]) || $personArray["personId"] == "")
		{ 
			return "personId-verdien mangler."; 
		}
		
		if (DatReferanseDatabase::hentReferanse(PersonParser::getDatabaseSomDat($personArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbPerson = $this->hentPerson($personArray["personId"], $personArray["raseId"]);
		
		if ($dbPerson == null)
		{
			$this->database->insert('nkk_person', $personArray);
			return "Lagt til";
		}
		else if ($dbPerson["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('personId = ?', $personArray["personId"]) . 
				$this->database->quoteInto('AND raseId = ?', $personArray["raseId"]);
			$this->database->update('nkk_person', $personArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(PersonParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(PersonParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('personId = ?', $verdier['personId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_person', $verdier, $hvor);
	}
}