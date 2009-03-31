<?php
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';

class PremieDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
//	public function redigerPremie($premie, $klubbId)
//	{
//		$hvor = $this->database->quoteInto('proveNr = ?', $premie['proveNr']);			
//		return $this->database->update('nkk_premie', $premie, $hvor);
//	}
	
	public function leggInnPremie($premie, $klubbId)
	{
			return $this->database->insert('nkk_premie', $premie);
	}
	
	public function slettPremie($premieId, $klubbId)
	{
		$hvor = $this->database->quoteInto('proveNr = ?', $premieId);
		return $this->database->delete('nkk_premie', $hvor);
	}
	
	public function hentPremieer($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('p'=>'nkk_premie'), array('p.*', 'u.*'))
		->joinLeft(array('u'=>'nkk_premie'),'p.premieId = u.premieId', array())
		->where('p.raseId=?', $klubbId)
		->where('p.hundId=?', $hundId)
		->order('u.premieDato DESC');
	
		return $this->database->fetchAll($select); 
	}	
	
	public function settInnPremie($premiearray, $klubbId)
	{
		if ($premiearray["raseId"] == $klubbId)
		{
			return $this->_settInnPremie($premiearray);
		}

		return "RaseID " . $premiearray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnPremie($premiearray)
	{
		if (sizeof($premiearray) != 30)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($premiearray).", forventet 30."; 
		}
		
		if (DatReferanseDatabase::hentReferanse(PremieParser::getPremieDatabaseSomDat($premiearray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}

		$dbPremie = $this->_hentPremie($premiearray["utstillingId"], $premiearray["hundId"], $premiearray["raseId"]);
		
		if ($dbPremie == null)
		{
			$this->database->insert('nkk_premie', $premiearray);
			return "Lagt til";
		}
		else if ($dbPremie["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('utstillingId = ?', $premiearray["utstillingId"]).
			$this->database->quoteInto('AND raseId = ?', $premiearray["raseId"]).
			$this->database->quoteInto('AND hundId = ?', $premiearray["hundId"]);
			$this->database->update('nkk_premie', $premiearray, $hvor);

			return "Oppdatert";
		}
	}
	
	private function _hentPremie($utstillingId, $hundId, $klubbId)
	{
			$select = $this->database->select()
			->from('nkk_premie') 
			->where('utstillingId=?', $utstillingId)
			->where('hundId=?',$hundId)
			->where('raseId=?', $klubbId)
			->limit(1);
	
			return $this->database->fetchRow($select); 
	}
	
	public function overskrivPremie($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(PremieParser::getPremieDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(PremieParser::getPremieDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";

		$hvor = $this->database->quoteInto('utstillingId = ?', $verdier['utstillingId']).
			$this->database->quoteInto('AND hundId = ?', $verdier['hundId']).
			$this->database->quoteInto('AND raseId = ?', $verdier['raseId']);			
		return $this->database->update('nkk_premie', $verdier, $hvor);
	}

}