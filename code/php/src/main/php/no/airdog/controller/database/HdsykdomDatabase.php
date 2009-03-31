<?php 
require_once 'Tilkobling.php';

class HdsykdomDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentHdsykdom($hofteDyId, $klubbId)
	{	
		$select = $this->database->select()
		->from(array('p'=>'nkk_hdsykdom'), 'p.*')
		->where('p.hofteDyId=?', $hofteDyId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function settInnHdsykdom($hdsykdomArray, $klubbId)
	{
		if ($hdsykdomArray["raseId"] == $klubbId)
		{
			return $this->_settInnHdsykdom($hdsykdomArray);
		}

		return "RaseID " . $hdsykdomArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnHdsykdom($hdsykdomArray)
	{
		if (sizeof($hdsykdomArray) != 23)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($hdsykdomArray).", forventet 23."; 
		}
		
		if (!isset($hdsykdomArray["hofteDyId"]) || $hdsykdomArray["hofteDyId"] == "")
		{ 
			return "hofteDyId-verdien mangler."; 
		}
		
		if (DatReferanseDatabase::hentReferanse(HdsykdomParser::getHdsykdomDatabaseSomDat($hdsykdomArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbHdsykdom = $this->hentHdsykdom($hdsykdomArray["hofteDyId"], $hdsykdomArray["raseId"]);
		
		if ($dbHdsykdom == null)
		{
			$this->database->insert('nkk_hdsykdom', $hdsykdomArray);
			return "Lagt til";
		}
		else if ($dbHdsykdom["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('hofteDyId = ?', $hdsykdomArray["hofteDyId"]) . 
				$this->database->quoteInto('AND raseId = ?', $hdsykdomArray["raseId"]);
			$this->database->update('nkk_hdsykdom', $hdsykdomArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskrivHdsykdom($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(HdsykdomParser::getHdsykdomDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(HdsykdomParser::getHdsykdomDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('hofteDyId = ?', $verdier['hofteDyId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_hdsykdom', $verdier, $hvor);
	}
}