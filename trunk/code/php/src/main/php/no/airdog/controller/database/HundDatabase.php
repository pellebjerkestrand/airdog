<?php 
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';
require_once 'DatReferanseDatabase.php';

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
	
	public function settInn($hundArray, $klubbId)
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
			return 'Arrayet er av feil størrelse. Fikk ' . sizeof($hundArray) . ', forventet 20.'; 
		}
		
		if (!isset($hundArray['hundId']) || $hundArray['hundId'] == '')
		{ 
			return 'hundId-verdien mangler.'; 
		}
		
		if (DatReferanseDatabase::hentReferanse(HundParser::getDatabaseSomDat($hundArray), $this->database) != null)
		{
			return 'Finnes alt i DATreferanser tabellen.';
		}
		
		$dbHund = $this->hentKunHund($hundArray['hundId'], $hundArray['raseId']);
		
		if ($dbHund == null)
		{
			$this->database->insert('nkk_hund', $hundArray);
			return 'Lagt til';
		}
		else if ($dbHund['manueltEndretAv'] != '')
		{
			return 'Manuelt endret, vil du overskrive?';
		}
		else
		{
			$hvor = $this->database->quoteInto('hundId = ?', $hundArray['hundId']) . $this->database->quoteInto('AND raseId = ?', $hundArray['raseId']);
			$this->database->update('nkk_hund', $hundArray, $hvor);
			return 'Oppdatert';
		}
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
	
	public function hentKunHund($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from('nkk_hund', array('hundId', 'raseId', 'navn', 'eierId', 'tittel', 'manueltEndretAv'))
		->where('hundId=?', $hundId)
		->where('raseId=?', $klubbId)
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
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(HundParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(HundParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('hundId = ?', $verdier['hundId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_hund', $verdier, $hvor);
	}
	
	public function hentAarbokHund($hundId, $kjonn, $aar, $klubbId)
	{
		$aar = $this->database->quoteInto('hFugl.proveDato LIKE ?', $aar.'%');
		$select = $this->database->select()
		->from(array('h'=>'nkk_hund'), array(
		'h.*',
		'hundMorNavn' => 'hMor.navn',
		'hundFarNavn' => 'hFar.navn',
		'mormor' => 'mMor.navn',
		'morfar' => 'mFar.navn',
		'farmor' => 'fMor.navn',
		'farfar' => 'fFar.navn',
		'eier' => 'eier.navn',
		'eieradresse' => 'eier.adresse1',
		'eierpostnummer' => 'eier.postNr',
		'eiersted' => 'eier.adresse3',
		'eiertlf' => 'eier.telefon1',
		'oppdretter' => 'oppdretter.navn',
		'oppdretteradresse' => 'oppdretter.adresse1',
		'oppdretterpostnummer' => 'oppdretter.postNr',
		'oppdrettersted' => 'oppdretter.adresse3',
		'oppdrettertlf' => 'oppdretter.telefon1',
		'vf' => '(6 * (hFugl.egneStand) / ((hFugl.makkerStand) + (hFugl.egneStand)))'))
		->joinLeft(array('hMor'=>'nkk_hund'),'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'nkk_hund'),'h.hundFarId = hFar.hundId', array())
		->joinLeft(array('mMor'=>'nkk_hund'),'hMor.hundMorId = mMor.hundId', array())
		->joinLeft(array('mFar'=>'nkk_hund'),'hMor.hundFarId = mFar.hundId', array())
		->joinLeft(array('fMor'=>'nkk_hund'),'hFar.hundMorId = fMor.hundId', array())
		->joinLeft(array('fFar'=>'nkk_hund'),'hFar.hundFarId = fFar.hundId', array())
		->joinLeft(array('eier'=>'nkk_person'),'h.eierId = eier.personId', array())
		->joinLeft(array('kull'=>'nkk_kull'),'h.kullId = kull.kullId', array())
		->joinLeft(array('oppdretter'=>'nkk_person'),'kull.oppdretterId = oppdretter.personId', array())
		->join(array('hFugl'=>'nkk_fugl'),'h.hundId = hFugl.hundId AND ' . $aar, array())
		->where('h.raseId=?', $klubbId)
		->group('h.hundId')
		->order('h.navn ASC');
		
		if ($hundId != "")
		{
			$select = $select->group('h.hundId')
			->where('h.hundId=?', $hundId)
			->limit(1);
		}
		else if ($kjonn != "alle")
		{
			$select = $select->where('h.kjonn=?', $kjonn);
		}
		
		// HUSK Å FJERNE
		$select = $select->limit(100);
		
		return $this->database->fetchAll($select);
	}
	
	public function hentAarbokKullHund($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('h'=>'nkk_hund'), array(
		'h.*',
		'hundMorNavn' => 'hMor.navn',
		'hundFarNavn' => 'hFar.navn'))
		->joinLeft(array('hMor'=>'nkk_hund'),'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'nkk_hund'),'h.hundFarId = hFar.hundId', array())
		->where('h.raseId=?', $klubbId)
		->group('h.hundId')
		->where('h.hundId=?', $hundId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
}