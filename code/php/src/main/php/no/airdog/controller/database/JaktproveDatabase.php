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
	
	public function redigerJaktprove($jaktprove, $klubbId)
	{
		$hvor = $this->database->quoteInto('proveNr = ?', $jaktprove['proveNr']);			
		return $this->database->update('nkk_fugl', $jaktprove, $hvor);
	}
	
	public function leggInnJaktprove($jaktprove, $klubbId)
	{
			return $this->database->insert('nkk_fugl', $jaktprove);
	}
	
	public function slettJaktprove($jaktproveId, $klubbId)
	{
		$hvor = $this->database->quoteInto('proveNr = ?', $jaktproveId);
		return $this->database->delete('nkk_fugl', $hvor);
	}
	
	public function hentJaktprover($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from('nkk_fugl') 
		->where('hundId=?',$hundId)
		->where('raseId=?', $klubbId)
		->order('proveDato DESC'); 
	
		return $this->database->fetchAll($select); 
	}
	
	public function hentJaktproveSammendrag($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from('nkk_fugl', array(
			'slippTid' => 'AVG(slippTid)',
			'egneStand' => 'SUM(egneStand)',
			'egneStokk' => 'SUM(egneStokk)',
			'tomStand' => 'SUM(tomStand)',
			'makkerStand' => 'SUM(makkerStand)',
			'makkerStokk' => 'SUM(makkerStokk)',
			'jaktlyst' => 'AVG(jaktlyst)',
			'fart' => 'AVG(fart)',
			'stil' => 'AVG(stil)',
			'selvstendighet' => 'AVG(selvstendighet)',
			'bredde' => 'AVG(bredde)',
			'reviering' => 'AVG(reviering)',
			'samarbeid' => 'AVG(samarbeid)',
			'vf' => '(6 * SUM(egneStand) / (SUM(makkerStand) + SUM(egneStand)))',
			'situasjoner' => 'SUM(egneStand) + SUM(makkerStand)'
		))
		->where('hundId=?',$hundId)
		->where('raseId=?', $klubbId)
		->group('hundId');; 
	
		return $this->database->fetchRow($select); 
	}
	
//	public function settInnJaktproveArray($jaktproveArray, $brukerEpost, $brukerPassord, $klubbId)
//	{
//		$resultat = "";
//		
//		foreach($jaktproveArray as $jaktarray)
//		{
//			if ($jaktarray["raseId"] != $klubbId)
//			{
//				$resultat .= "\nRaseID stemmer ikke.";
//			}
//			else
//			{
//				$resultat .= $this->_settInnJaktprove($jaktarray);
//			}
//		}
//		
//		return $resultat;
//	}
	
	
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