<?php 
require_once 'Tilkobling.php';

class EierDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentEier($hundId, $klubbId)
	{	
		$select = $this->database->select()
		->from(array('p'=>'nkk_eier'), 'p.*')
		->where('p.hundId=?', $hundId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function settInn($eierArray, $klubbId)
	{
		if ($eierArray["raseId"] == $klubbId)
		{
			return $this->_settInnEier($eierArray);
		}

		return "RaseID " . $eierArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnEier($eierArray)
	{
		if (sizeof($eierArray) != 3)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($eierArray).", forventet 3."; 
		}
		
		if (!isset($eierArray["eier"]) || $eierArray["eier"] == "")
		{ 
			return "eier-verdien mangler."; 
		}
		
		if (DatReferanseDatabase::hentReferanse(EierParser::getDatabaseSomDat($eierArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbEier = $this->hentEier($eierArray["hundId"], $eierArray["raseId"]);
		
		if ($dbEier == null)
		{
			$this->database->insert('nkk_eier', $eierArray);
			return "Lagt til";
		}
		else if ($dbEier["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('hundId = ?', $eierArray["hundId"]) . 
				$this->database->quoteInto('AND raseId = ?', $eierArray["raseId"]);
			$this->database->update('nkk_eier', $eierArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(EierParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(EierParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('hundId = ?', $verdier['hundId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_eier', $verdier, $hvor);
	}
}