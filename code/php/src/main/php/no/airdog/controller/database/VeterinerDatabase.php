<?php 
require_once 'Tilkobling.php';

class VeterinerDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentVeteriner($veterinerId, $klubbId)
	{	
		$select = $this->database->select()
		->from(array('p'=>'nkk_veteriner'), 'p.*')
		->where('p.veterinerId=?', $veterinerId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function settInnVeteriner($veterinerArray, $klubbId)
	{
		$veterinerArray["raseId"] = $klubbId;
		
		return $this->_settInnVeteriner($veterinerArray);
	}
	
	private function _settInnVeteriner($veterinerArray)
	{
		if (sizeof($veterinerArray) != 13)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($veterinerArray).", forventet 13."; 
		}
		
		if (!isset($veterinerArray["veterinerId"]) || $veterinerArray["veterinerId"] == "")
		{ 
			return "veterinerId-verdien mangler."; 
		}

		if (DatReferanseDatabase::hentReferanse(VeterinerParser::getVeterinerDatabaseSomDat($veterinerArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbVeteriner = $this->hentVeteriner($veterinerArray["veterinerId"], $veterinerArray["raseId"]);
		
		if ($dbVeteriner == null)
		{
			$this->database->insert('nkk_veteriner', $veterinerArray);
			return "Lagt til";
		}
		else if ($dbVeteriner["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('veterinerId = ?', $veterinerArray["veterinerId"]) . 
				$this->database->quoteInto('AND raseId = ?', $veterinerArray["raseId"]);
			$this->database->update('nkk_veteriner', $veterinerArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskrivVeteriner($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(VeterinerParser::getVeterinerDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(VeterinerParser::getVeterinerDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('veterinerId = ?', $verdier['veterinerId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_veteriner', $verdier, $hvor);
	}
}