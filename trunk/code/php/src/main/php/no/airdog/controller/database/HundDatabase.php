<?php 
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';

class HundDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
//	public function settInnHundArray($hunderArray, $klubbId)
//	{
//		$resultat = "";
//		
//		foreach($hunderArray as $hundArray)
//		{
//			if ($hundArray["raseId"] != $klubbId)
//			{
//				$resultat .= "\nRaseID stemmer ikke.";
//			}
//			else
//			{
//				$resultat .= $this->_settInnHund($hundArray);
//			}
//		}
//		
//		return $resultat;
//	}
	
	public function settInnHund($hundArray, $klubbId)
	{
		if ($hundArray["raseId"] == $klubbId)
		{
			return $this->_settInnHund($hundArray);
		}

		return "RaseID " . $hundArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnHund($hundArray)
	{
		if (sizeof($hundArray) != 20)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray).", forventet 20."; 
		}
		
		if (!isset($hundArray["hundId"]) || $hundArray["hundId"] == "")
		{ 
			return "hundId-verdien mangler."; 
		}
		
		$dbHund = $this->hentHund($hundArray["hundId"], $hundArray["raseId"]);
		
		if ($dbHund == null)
		{
			$this->database->insert('nkk_hund', $hundArray);
		}
		else if ($dbHund["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive???";
		}
		else
		{
			$hvor = $this->database->quoteInto('hundId = ?', $hundArray["hundId"]) . $this->database->quoteInto('AND raseId = ?', $hundArray["raseId"]);
			$this->database->update('nkk_hund', $hundArray, $hvor);
			return "Oppdatert";
		}
		
		return true;
	}
	
//	//må testes
//	public function slettHund($hundId, $klubbId)
//	{
//			$hvor = $this->database->quoteInto('hundId = ?', $hundId);
//	
//			$this->database->delete('nkk_hund', $hvor);
//	}
//	

	
	public function sokHund($soketekst, $klubbId)
	{		
		$select = $this->database->select()
		->from(array('h'=>'nkk_hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*'))
		->joinLeft(array('hMor'=>'nkk_hund'),'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'nkk_hund'),'h.hundFarId = hFar.hundId', array())
		->where('h.raseId=?', $klubbId)
		->where('h.navn LIKE "%"?"%" OR h.hundId LIKE "%"?"%"', $soketekst)
		->limit(500, 0)
		->order('h.navn ASC');

		return $this->database->fetchAll($select);
	}
	
	public function sokArsgjennomsnitt($hund, $ar, $klubbId)
	{
		$select = $this->database->select()
		->from(array('h'=>'nkk_hund'), array(
			'h.*', 
			'hundMorNavn'=>'hMor.navn', 
			'hundFarNavn'=>'hFar.navn',
			'starter' => 'COUNT(hFugl.hundId)',
			'es' => 'AVG(hFugl.egneStand)',
			'ms' => 'AVG(hFugl.makkerStand)',
			'eso' => 'AVG(hFugl.egneStokk)',
			'mso' => 'AVG(hFugl.makkerStokk)',
			'ts' => 'AVG(hFugl.tomStand)',
			'jl' => 'AVG(hFugl.jaktlyst)',
			'fa' => 'AVG(hFugl.fart)',
			'st' => 'AVG(hFugl.stil)',
			'selv' => 'AVG(hFugl.selvstendighet)',
			'sok' => 'AVG(bredde)',
			'vf' => '(6 * SUM(hFugl.egneStand) / (SUM(hFugl.makkerStand) + SUM(hFugl.egneStand)))',
			'rev' => 'AVG(reviering)',
			'sam' => 'AVG(samarbeid)',
			'bestePl' => 'MIN(hFugl.premiegrad)'
		))
		->joinLeft(array('hMor' => 'nkk_hund'), 'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar' => 'nkk_hund'), 'h.hundFarId = hFar.hundId', array())
		->joinLeft(array('hFugl' => 'nkk_fugl'), 'h.hundId = hFugl.hundId', array())
		->where('h.raseId=?', $klubbId)
		->where('h.navn LIKE "%"?"%" OR h.hundId LIKE "%"?"%"', $hund)
		->where('hFugl.proveDato LIKE "%"?"%"', $ar)
		->group('h.hundId');
	
		return $this->database->fetchAll($select);
	}
	
	public function hentHund($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('h'=>'nkk_hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*', 
		'vf' => '(6 * (hFugl.egneStand) / ((hFugl.makkerStand) + (hFugl.egneStand)))'))
		->joinLeft(array('hMor'=>'nkk_hund'),'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'nkk_hund'),'h.hundFarId = hFar.hundId', array())
		->joinLeft(array('hFugl'=>'nkk_fugl'),'h.hundId = hFugl.hundId', array())
		->group('h.hundId')
		->where('h.hundId=?', $hundId)
		->where('h.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
//	private function _hentHund($hundId, $klubbId)
//	{
//		$select = $this->database->select()
//		->from(array('h'=>'nkk_hund'), array('h.*'))
//		->where('h.hundId=?', $hundId)
//		->where('h.raseId=?', $klubbId)
//		->limit(1);
//		
//		return $this->database->fetchRow($select);
//	}
	
	public function hentStamtreHund($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('h'=>'nkk_hund'), array('h.*'))
		->where('h.hundId=?', $hundId)
		->where('h.raseId=?', $klubbId)
		->limit(1);
		
		$ret = $this->database->fetchRow($select);
		$this->database->closeConnection(); 
		return $ret;
	}
	
//	public function hentHunder($klubbId)
//	{
//		$select = $this->database->select()
//		->from('nkk_hund', array('nkk_hund.*'))
//		->where('h.raseId=?', $klubbId);
//		
//		return $this->database->fetchAll($select);
//	}
	
	public function redigerHund($hund)
	{
		$hvor = $this->database->quoteInto('hundId = ?', $hund['hundId']);
		
		return $this->database->update('nkk_hund', $hund, $hvor);
	}
}