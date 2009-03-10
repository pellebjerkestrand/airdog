<?php
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';
require_once 'no/airdog/controller/parser/FuglParser.php';

class JaktproveDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function redigerJaktprove($jaktprove, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerJaktprove"))
		{
			$hvor = $this->database->quoteInto('proveNr = ?', $jaktprove['proveNr']);			
			
			return $this->database->update('nkk_fugl', $jaktprove, $hvor);
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function leggInnJaktprove($jaktprove, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerJaktprove"))
		{			
			return $this->database->insert('nkk_fugl', $jaktprove);
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function slettJaktprove($jaktproveId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "slettJaktprove"))
		{
			$hvor = $this->database->quoteInto('proveNr = ?', $jaktproveId);
	
			return $this->database->delete('nkk_fugl', $hvor);
		}
		
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function hentJaktprove($hundId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$select = $this->database->select()
			->from('nkk_fugl') 
			->where('hundId=?',$hundId)
			->where('raseId=?', $klubbId); 
	
			return $this->database->fetchAll($select); 
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function settInnJaktproveArray($jaktproveArray, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$resultat = "";
			
			foreach($jaktproveArray as $jaktarray)
			{
				if ($jaktarray["raseId"] != $klubbId)
				{
					$resultat .= "\nRaseID stemmer ikke.";
				}
				else
				{
					$resultat .= $this->_settInnJaktprove($jaktarray);
				}
			}
			
			return $resultat;
		}
		
		return false;
	}
	
	public function settInnJaktproveFraFil($filsti, $brukerEpost, $brukerPassord, $klubbId)
	{
		
	}
	
	public function settInnJaktprove($jaktarray, $klubbId)
	{
		if ($jaktarray["raseId"] == $klubbId)
		{
			return $this->_settInnJaktprove($jaktarray);
		}

		return "RaseID " . $jaktarray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnJaktprove($jaktarray)
	{
		if (sizeof($jaktarray) != 38)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($jaktarray).", forventet 38."; 
		}
		
		if (!isset($jaktarray["proveNr"]) || $jaktarray["proveNr"] == "")
		{ 
			return "hundId-verdien mangler."; 
		}

		$dbJaktprove = $this->_hentJaktprove($jaktarray["proveNr"], $jaktarray["proveDato"], $jaktarray["hundId"], $jaktarray["raseId"]);
		
		if ($dbJaktprove == null)
		{
			$this->database->insert('nkk_fugl', $jaktarray);
		}
		else if ($dbJaktprove["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive???";
		}
		else
		{
			$hvor = $this->database->quoteInto('proveNr = ?', $jaktarray["proveNr"]).
			$this->database->quoteInto('AND proveDato = ?', $jaktarray["proveDato"]).
			$this->database->quoteInto('AND raseId = ?', $jaktarray["raseId"]).
			$this->database->quoteInto('AND hundId = ?', $jaktarray["hundId"]);
			$this->database->update('nkk_fugl', $jaktarray, $hvor);

			return "Oppdatert";
		}
		
		return true;
	}
	
	private function _hentJaktprove($proveNr, $proveDato, $hundId, $klubbId)
	{
			$select = $this->database->select()
			->from('nkk_fugl') 
			->where('proveNr=?',$proveNr)
			->where('proveDato=?', $proveDato)
			->where('hundId=?',$hundId)
			->where('raseId=?', $klubbId)
			->limit(1);
	
			return $this->database->fetchRow($select); 
	}

}