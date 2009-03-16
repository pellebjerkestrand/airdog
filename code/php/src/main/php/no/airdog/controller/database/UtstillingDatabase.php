<?php
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';

class UtstillingDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function redigerUtstilling($utstilling, $klubbId)
	{
		$hvor = $this->database->quoteInto('proveNr = ?', $utstilling['proveNr']);			
		return $this->database->update('nkk_utstilling', $utstilling, $hvor);
	}
	
	public function leggInnUtstilling($utstilling, $klubbId)
	{
			return $this->database->insert('nkk_utstilling', $utstilling);
	}
	
	public function slettUtstilling($utstillingId, $klubbId)
	{
		$hvor = $this->database->quoteInto('proveNr = ?', $utstillingId);
		return $this->database->delete('nkk_utstilling', $hvor);
	}
	
	public function hentUtstillinger($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('p'=>'nkk_premie'), array('p.*', 'u.*'))
		->joinLeft(array('u'=>'nkk_utstilling'),'p.utstillingId = u.utstillingId', array())
		->where('p.raseId=?', $klubbId)
		->where('p.hundId=?', $hundId)
		->order('u.utstillingDato DESC');
	
		return $this->database->fetchAll($select); 
	}	
	
	public function settInnUtstilling($utstillingarray, $klubbId)
	{
		if (sizeof($utstillingarray) != 15)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($utstillingarray).", forventet 15."; 
		}
		
		$utstillingarray["raseId"] = $klubbId;

		$dbUtstilling = $this->_hentUtstilling($utstillingarray["utstillingId"], $utstillingarray["raseId"]);
		
		if ($dbUtstilling == null)
		{
			$this->database->insert('nkk_utstilling', $utstillingarray);
		}
		else if ($dbUtstilling["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive???";
		}
		else
		{
			$hvor = $this->database->quoteInto('raseId = ?', $utstillingarray["raseId"]).
			$this->database->quoteInto('AND utstillingId = ?', $utstillingarray["utstillingId"]);
			$this->database->update('nkk_utstilling', $utstillingarray, $hvor);

			return "Oppdatert";
		}
		
		return true;
	}
	
	private function _hentUtstilling($utstillingId, $klubbId)
	{
			$select = $this->database->select()
			->from('nkk_utstilling') 
			->where('utstillingId=?',$utstillingId)
			->where('raseId=?', $klubbId)
			->limit(1);
	
			return $this->database->fetchRow($select); 
	}

}