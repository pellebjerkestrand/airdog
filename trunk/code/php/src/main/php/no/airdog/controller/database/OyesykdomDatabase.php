<?php 
require_once 'Tilkobling.php';

class OyesykdomDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentOyesykdom($oyId, $klubbId)
	{	
		$select = $this->database->select()
		->from(array('p'=>'nkk_oyesykdom'), 'p.*')
		->where('p.oyId=?', $oyId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function settInn($oyesykdomArray, $klubbId)
	{
		if ($oyesykdomArray["raseId"] == $klubbId)
		{
			return $this->_settInnOyesykdom($oyesykdomArray);
		}

		return "RaseID " . $oyesykdomArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnOyesykdom($oyesykdomArray)
	{
		if (sizeof($oyesykdomArray) != 27)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($oyesykdomArray).", forventet 27."; 
		}
		
		if (!isset($oyesykdomArray["oyId"]) || $oyesykdomArray["oyId"] == "")
		{ 
			return "oyId-verdien mangler."; 
		}

		if (DatReferanseDatabase::hentReferanse(OyesykdomParser::getDatabaseSomDat($oyesykdomArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbOyesykdom = $this->hentOyesykdom($oyesykdomArray["oyId"], $oyesykdomArray["raseId"]);
		
		if ($dbOyesykdom == null)
		{
			$this->database->insert('nkk_oyesykdom', $oyesykdomArray);
			return "Lagt til";
		}
		else if ($dbOyesykdom["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('oyId = ?', $oyesykdomArray["oyId"]) . 
				$this->database->quoteInto('AND raseId = ?', $oyesykdomArray["raseId"]);
			$this->database->update('nkk_oyesykdom', $oyesykdomArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(OyesykdomParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(OyesykdomParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('oyId = ?', $verdier['oyId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_oyesykdom', $verdier, $hvor);
	}
}