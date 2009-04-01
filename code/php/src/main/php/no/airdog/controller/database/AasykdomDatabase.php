<?php 
require_once 'Tilkobling.php';

class AasykdomDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAasykdom($aaId, $klubbId)
	{	
		$select = $this->database->select()
		->from(array('p'=>'nkk_aasykdom'), 'p.*')
		->where('p.aaId=?', $aaId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function settInn($aasykdomArray, $klubbId)
	{
		if ($aasykdomArray["raseId"] == $klubbId)
		{
			return $this->_settInnAasykdom($aasykdomArray);
		}

		return "RaseID " . $aasykdomArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnAasykdom($aasykdomArray)
	{
		if (sizeof($aasykdomArray) != 26)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($aasykdomArray).", forventet 26."; 
		}
		
		if (!isset($aasykdomArray["aaId"]) || $aasykdomArray["aaId"] == "")
		{ 
			return "aaId-verdien mangler."; 
		}

		if (DatReferanseDatabase::hentReferanse(AasykdomParser::getDatabaseSomDat($aasykdomArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbAasykdom = $this->hentAasykdom($aasykdomArray["aaId"], $aasykdomArray["raseId"]);
		
		if ($dbAasykdom == null)
		{
			$this->database->insert('nkk_aasykdom', $aasykdomArray);
			return "Lagt til";
		}
		else if ($dbAasykdom["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('aaId = ?', $aasykdomArray["aaId"]) . 
				$this->database->quoteInto('AND raseId = ?', $aasykdomArray["raseId"]);
			$this->database->update('nkk_aasykdom', $aasykdomArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(AasykdomParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(AasykdomParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('aaId = ?', $verdier['aaId']).
			$this->database->quoteInto('AND raseId = ?', $verdier['raseId']);
		
		return $this->database->update('nkk_aasykdom', $verdier, $hvor);
	}
}