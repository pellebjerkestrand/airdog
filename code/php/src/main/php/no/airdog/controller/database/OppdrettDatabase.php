<?php 
require_once 'Tilkobling.php';

class OppdrettDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentOppdrett($kullId, $klubbId)
	{	
		$select = $this->database->select()
		->from(array('p'=>'nkk_oppdrett'), 'p.*')
		->where('p.kullId=?', $kullId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function settInn($oppdrettArray, $klubbId)
	{
		if ($oppdrettArray["raseId"] == $klubbId)
		{
			return $this->_settInnOppdrett($oppdrettArray);
		}

		return "RaseID " . $oppdrettArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnOppdrett($oppdrettArray)
	{
		if (sizeof($oppdrettArray) != 3)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($oppdrettArray).", forventet 3."; 
		}
		
		if (!isset($oppdrettArray["kullId"]) || $oppdrettArray["kullId"] == "")
		{ 
			return "kullId-verdien mangler."; 
		}
		
		if (DatReferanseDatabase::hentReferanse(OppdrettParser::getDatabaseSomDat($oppdrettArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbOppdrett = $this->hentOppdrett($oppdrettArray["kullId"], $oppdrettArray["raseId"]);
		
		if ($dbOppdrett == null)
		{
			$this->database->insert('nkk_oppdrett', $oppdrettArray);
			return "Lagt til";
		}
		else if ($dbOppdrett["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('kullId = ?', $oppdrettArray["kullId"]) . 
				$this->database->quoteInto('AND raseId = ?', $oppdrettArray["raseId"]);
			$this->database->update('nkk_oppdrett', $oppdrettArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(OppdrettParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(OppdrettParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('kullId = ?', $verdier['kullId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_oppdrett', $verdier, $hvor);
	}
}