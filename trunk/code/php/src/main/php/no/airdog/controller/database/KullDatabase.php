<?php 
require_once 'Tilkobling.php';

class KullDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}

	public function hentKull($kullId, $klubbId)
	{	
		$select = $this->database->select()
		->from(array('p'=>'nkk_kull'), 'p.*')
		->where('p.kullId=?', $kullId)
		->where('p.raseId=?', $klubbId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function settInn($kullArray, $klubbId)
	{
		if ($kullArray["raseId"] == $klubbId)
		{
			return $this->_settInnKull($kullArray);
		}

		return "RaseID " . $kullArray["raseId"] . " stemmer ikke med klubbId $klubbId";
	}
	
	private function _settInnKull($kullArray)
	{
		if (sizeof($kullArray) != 7)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($kullArray).", forventet 7."; 
		}
		
		if (!isset($kullArray["kullId"]) || $kullArray["kullId"] == "")
		{ 
			return "kullId-verdien mangler."; 
		}
		
		if (DatReferanseDatabase::hentReferanse(KullParser::getDatabaseSomDat($kullArray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}
		
		$dbKull = $this->hentKull($kullArray["kullId"], $kullArray["raseId"]);
		
		if ($dbKull == null)
		{
			$this->database->insert('nkk_kull', $kullArray);
			return "Lagt til";
		}
		else if ($dbKull["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
		}
		else
		{
			$hvor = $this->database->quoteInto('kullId = ?', $kullArray["kullId"]) . 
				$this->database->quoteInto('AND raseId = ?', $kullArray["raseId"]);
			$this->database->update('nkk_kull', $kullArray, $hvor);
			return "Oppdatert";
		}
	}
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(KullParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(KullParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('kullId = ?', $verdier['kullId']).
			$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->update('nkk_kull', $verdier, $hvor);
	}
	
	public function oppdaterKull($kullArray, $endretAv)
	{
		if (sizeof($kullArray) != 7) 
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($kullArray)." forventet 7."; 
		}
		if (!isset($kullArray["kullId"]) || $kullArray["kullId"] == "") 
		{ 
			return "kullId-verdien mangler."; 
		}
		if (!isset($endretAv) || $endretAv == "")
		{
			return "endret av bruker mangler";
		}
		
		//mysql_query("UPDATE kull SET hundIdFar='".$kullArray["hundIdFar"]."', hundIdMor='".$kullArray["hundIdMor"]."', oppdretterId='".$kullArray["oppdretterId"]."', endretDato='".$kullArray["endretDato"]."', 
		//	fodt='".$kullArray["fodt"]."', raseId='".$kullArray["raseId"]."', manueltEndretAv='".$endretAv."', manueltEndretDato=NOW() 
		//	WHERE kullId='".$kullArray["kullId"]."' LIMIT 1") 
		//or die(mysql_error());

		$this->database->update('kull', $kullArray);
		return true;
	}
	
	public function slettKull($kullId)
	{
		//return mysql_query("DELETE FROM kull WHERE kullId='".$kullId."' LIMIT 1") 
		//or die(mysql_error());
		$this->database->delete('kull', 'kullId = $kullId');
	}
	
	public function finnesKull($kullId)
	{
		$kull = $this->hentKull($kullId);
		if (isset($kull["kullId"]))
			return true;
		
		return false;
	}
	
	public function hentAvkom($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('h'=>'nkk_hund'), array(
			'h.*', 
			'hundMorNavn'=>'hMor.navn', 
			'hundFarNavn'=>'hFar.navn',
			'start' => 'AVG(hFugl.slipptid)',
			'jl' => 'AVG(hFugl.jaktlyst)',
			'selv' => 'AVG(hFugl.selvstendighet)',
			'sok' => 'AVG(bredde)',
			'vf' => '(6 * SUM(hFugl.egneStand) / (SUM(hFugl.makkerStand) + SUM(hFugl.egneStand)))',
			'rev' => 'AVG(reviering)',
			'sam' => 'AVG(samarbeid)',
			'bestPlUk' => 'MIN(hFugl.premiegrad)',
			'bestPlAk' => '("0")'
		))
		->joinLeft(array('hMor' => 'nkk_hund'), 'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar' => 'nkk_hund'), 'h.hundFarId = hFar.hundId', array())
		->joinLeft(array('hFugl' => 'nkk_fugl'), 'h.hundId = hFugl.hundId', array())
		->where($this->database->quoteInto('h.hundFarId=?', $hundId) . ' OR ' . $this->database->quoteInto('h.hundMorId=?', $hundId))
		->where('h.raseId=?', $klubbId)
		->group('h.hundId');
	
		return $this->database->fetchAll($select);
	}
	
	public static function hentAarbokAvkom($hundId, $klubbId, $aar, $database)
	{
		$aar = $database->quoteInto('aarFugl.proveDato LIKE ?', $aar.'%');
		
		$select = $database->select()
		->from(array('h'=>'nkk_hund'), array(
			'h.*', 
			'hundMorNavn' => 'hMor.navn', 
			'hundFarNavn' => 'hFar.navn',
			'fodt' => 'kull.fodt',
			'AARVF' => '(6 * SUM(aarFugl.egneStand) / (SUM(aarFugl.makkerStand) + SUM(aarFugl.egneStand)))',
			'AARJAKTL' => 'AVG(aarFugl.jaktlyst)',
			'AARFART' => 'AVG(aarFugl.fart)',
			'AARSTIL' => 'AVG(aarFugl.stil)',
			'AARSELVST' => 'AVG(aarFugl.selvstendighet)',
			'AARSOKBR' => 'AVG(aarFugl.bredde)',
			'AARREV' => 'AVG(aarFugl.reviering)',
			'AARSAMAR' => 'AVG(aarFugl.samarbeid)',
			'TOTALVF' => '(6 * SUM(totalFugl.egneStand) / (SUM(totalFugl.makkerStand) + SUM(totalFugl.egneStand)))',
			'TOTALJAKTL' => 'AVG(totalFugl.jaktlyst)',
			'TOTALFART' => 'AVG(totalFugl.fart)',
			'TOTALSTIL' => 'AVG(totalFugl.stil)',
			'TOTALSELVST' => 'AVG(totalFugl.selvstendighet)',
			'TOTALSOKBR' => 'AVG(totalFugl.bredde)',
			'TOTALREV' => 'AVG(totalFugl.reviering)',
			'TOTALSAMAR' => 'AVG(totalFugl.samarbeid)',
			'avkomnavn' => 'h.navn',
			'avkomid' => 'h.hundId',
			'eiernavn' => 'eier.navn'  
		))
		->joinLeft(array('hMor' => 'nkk_hund'), 'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar' => 'nkk_hund'), 'h.hundFarId = hFar.hundId', array())
		->joinLeft(array('kull' => 'nkk_kull'), 'h.kullId = kull.kullId', array())
		->join(array('aarFugl' => 'nkk_fugl'), 'h.hundId = aarFugl.hundId AND ' . $aar, array())
		->join(array('totalFugl' => 'nkk_fugl'), 'h.hundId = totalFugl.hundId', array())
		->joinLeft(array('eier'=>'nkk_person'),'h.eierId = eier.personId', array())
		->where($database->quoteInto('h.hundFarId=?', $hundId) . ' OR ' . $database->quoteInto('h.hundMorId=?', $hundId))
		->where('h.raseId=?', $klubbId)
		->group('h.hundId');
	
		return $database->fetchAll($select);
	}
	
	public static function hentAarbokAvkomTittel($hundId, $klubbId, $aar, $database)
	{
		$select = $database->select()
		->from(array('h'=>'nkk_hund'), array(
			'h.*', 
			'hundMorNavn' => 'hMor.navn', 
			'hundFarNavn' => 'hFar.navn',
			'fodt' => 'kull.fodt',
			'avkomnavn' => 'h.navn',
			'avkomid' => 'h.hundId',
			'eiernavn' => 'eier.navn'  
		))
		->joinLeft(array('hMor' => 'nkk_hund'), 'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar' => 'nkk_hund'), 'h.hundFarId = hFar.hundId', array())
		->joinLeft(array('kull' => 'nkk_kull'), 'h.kullId = kull.kullId', array())
		->joinLeft(array('eier'=>'nkk_person'),'h.eierId = eier.personId', array())
		->where($database->quoteInto('h.hundFarId=?', $hundId) . ' OR ' . $database->quoteInto('h.hundMorId=?', $hundId))
		->where('h.raseId=?', $klubbId)
		->group('h.hundId');
	
		return $database->fetchAll($select);
	}
	
	public static function hentAarbokKullOppdretter($kullId, $klubbId, $database)
	{
		$select = $database->select()
		->from(array('k'=>'nkk_kull'), array(
			'OPPDRETTERNAVN' => 'p.navn', 
			'OPPDRETTERADRESSE' => 'p.adresse1', 
			'OPPDRETTERPOSTNR' => 'p.postNr',
			'OPPDRETTERSTED' => 'p.adresse3',
			'OPPDRETTERTLF' => 'p.telefon1'
		))
		->join(array('p'=>'nkk_person'),'k.oppdretterId = p.personId', array())
		->where('k.kullId=?', $kullId)
		->where('k.raseId=?', $klubbId)
		->limit(1);
	
		return $database->fetchRow($select);
	}
}