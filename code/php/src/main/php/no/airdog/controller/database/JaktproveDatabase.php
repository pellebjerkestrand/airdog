<?php
require_once 'ValiderBruker.php';
require_once 'Tilkobling.php';
require_once "no/airdog/model/AmfJaktprove.php";
require_once 'no/airdog/controller/parser/FuglParser.php';

class JaktproveDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function redigerJaktprove(AmfJaktprove $gammelJaktprove, AmfJaktprove $jaktprove, $klubbId)
	{
		$gJakt = $this->lagJaktproveArray($gammelJaktprove);
		$nJakt = $this->lagJaktproveArray($jaktprove);
		
		$hvor = $this->database->quoteInto('proveNr = ? ', $gJakt['proveNr']).
				$this->database->quoteInto('AND hundId = ? ', $gJakt['hundId']).
				$this->database->quoteInto('AND proveDato = ?', $gJakt['proveDato']);
							
		return $this->database->update('nkk_fugl', $nJakt, $hvor);
	}
	
	public function leggInnJaktprove(AmfJaktprove $jaktprove, $klubbId)
	{	
		$inn = $this->lagJaktproveArray($jaktprove);
		
		return $this->database->insert('nkk_fugl', $inn);
	}
	
	public function slettJaktprove($jaktproveId, $hundId, $dato, $klubbId)
	{
		$hvor = $this->database->quoteInto('proveNr = ? ', $jaktproveId).
				$this->database->quoteInto('AND hundId = ? ', $hundId).
				$this->database->quoteInto('AND proveDato = ?', $dato).
				$this->database->quoteInto('AND raseId = ?', $klubbId);
		
		return $this->database->delete('nkk_fugl', $hvor);
	}
	
	public function hentJaktprover($hundId, $klubbId)
	{
		$select = $this->database->select()
		->from(array('f'=>'nkk_fugl'), array('navn'=>'a.navn', 'sted'=>'a.sted', 'f.*'))
		->joinLeft(array('a'=>'nkk_arrangement'),'f.proveNr = a.proveNr', array())
		->where('f.hundId=?',$hundId)
		->where('f.raseId=?', $klubbId)
		->order('f.proveDato DESC'); 
	
		return $this->database->fetchAll($select); 
	}
	
	public function hentAlleJaktproverAar($aar, $klubbId)
	{				
		$select = $this->database->select()
		->from(array('f'=>'nkk_fugl'), array('navn'=>'a.navn', 'sted'=>'a.sted', 'f.*'))
		->joinLeft(array('a'=>'nkk_arrangement'),'f.proveNr = a.proveNr', array())
		->where('proveDato LIKE ?', $aar.'%') 
		->where('f.raseId=?', $klubbId)
		->order('f.proveDato DESC'); 
		
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

	public function hentJaktproveSammendragAar($aar, $klubbId)
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
			'situasjoner' => 'SUM(egneStand) + SUM(makkerStand)', 
			'premiegrad' => 'AVG(premiegrad)',
			'starterTotalt' => 'COUNT(*)'
		))
		->where('proveDato LIKE ?', $aar.'%')
		->where('raseId=?', $klubbId);
		
		return $this->database->fetchRow($select); 
	}
	
	public function hentJaktproveSammendragAarKlasser($aar, $klubbId, $klasse)
	{
		$select = $this->database->select()
		->from('nkk_fugl', array(			
			'antall' => 'COUNT(*)'			
		))
		->where('proveDato LIKE ?', $aar.'%')
		->where('raseId=?', $klubbId)
		->where('klasse=?', $klasse);
		
		$antall = $this->database->fetchRow($select);
		
		return $antall['antall']; 		
	}
	
	public function hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, $klasse, $premiegrad)
	{    		
		$select = $this->database->select()
		->from('nkk_fugl', array(			
			'antall' => 'COUNT(*)'			
		))
		->where('proveDato LIKE ?', $aar.'%')
		->where('raseId=?', $klubbId)
		->where('klasse=?', $klasse)
		->where('premiegrad=?', $premiegrad);
		
		$antall = $this->database->fetchRow($select);

		return $antall['antall']; 
	}
	
	public function hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, $premiegrad)
	{    		
		
		$select = $this->database->select()
		->from('nkk_fugl', array(			
			'antall' => 'COUNT(*)'			
		))
		->where('proveDato LIKE ?', $aar.'%')
		->where('raseId=?', $klubbId)
		->where('premiegrad=?', $premiegrad);
		
		$antall = $this->database->fetchRow($select);

		return $antall['antall']; 
	}
	
	public function settInn($jaktarray, $klubbId)
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
		
		if (DatReferanseDatabase::hentReferanse(FuglParser::getDatabaseSomDat($jaktarray), $this->database) != null)
		{
			return "Finnes alt i DATreferanser tabellen.";
		}

		$dbJaktprove = $this->_hentJaktprove($jaktarray["proveNr"], $jaktarray["proveDato"], $jaktarray["hundId"], $jaktarray["raseId"]);
		
		if ($dbJaktprove == null)
		{
			$this->database->insert('nkk_fugl', $jaktarray);
		}
		else if ($dbJaktprove["manueltEndretAv"] != "")
		{
			return "Manuelt endret, vil du overskrive?";
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
	
	public function overskriv($verdier, $klubbId)
	{
		if (DatReferanseDatabase::hentReferanse(FuglParser::getDatabaseSomDat($verdier), $this->database) != null)
		{
			DatReferanseDatabase::slettReferanse(UtstillingParser::getDatabaseSomDat($verdier), $this->database);
		}
		
		$verdier['manueltEndretAv'] = "";
		$verdier['manueltEndretDato'] = "";
		
		$hvor = $this->database->quoteInto('proveNr = ?', $verdier["proveNr"]).
		$this->database->quoteInto('AND proveDato = ?', $verdier["proveDato"]).
		$this->database->quoteInto('AND raseId = ?', $klubbId).
		$this->database->quoteInto('AND hundId = ?', $verdier["hundId"]);
		
		return $this->database->update('nkk_fugl', $verdier, $hvor);
	}
	
	private function lagJaktproveArray(AmfJaktprove $jaktprove)
	{
		$ret = array();
    	$ret['proveNr'] = $jaktprove->proveNr;   	
    	$ret['proveDato'] = $jaktprove->proveDato; 
    	$ret['partiNr'] = $jaktprove->partiNr;   	
    	$ret['klasse'] = $jaktprove->klasse;
    	$ret['dommerId1'] = $jaktprove->dommerId1;   	
    	$ret['dommerId2'] = $jaktprove->dommerId2;   	
    	$ret['hundId'] = $jaktprove->hundId;
    	$ret['slippTid'] = $jaktprove->slippTid;
    	$ret['egneStand'] = $jaktprove->egneStand; 	
    	$ret['egneStokk'] = $jaktprove->egneStokk;
    	$ret['tomStand'] = $jaktprove->tomStand; 	
    	$ret['makkerStand'] = $jaktprove->makkerStand;
    	$ret['makkerStokk'] = $jaktprove->makkerStokk; 	
    	$ret['jaktlyst'] = $jaktprove->jaktlyst;
    	$ret['fart'] = $jaktprove->fart; 	
    	$ret['stil'] = $jaktprove->stil;
    	$ret['selvstendighet'] = $jaktprove->selvstendighet; 	
    	$ret['bredde'] = $jaktprove->bredde;
    	$ret['reviering'] = $jaktprove->reviering; 	
    	$ret['samarbeid'] = $jaktprove->samarbeid;
    	$ret['presUpresis'] = $jaktprove->presUpresis; 	
    	$ret['presNoeUpresis'] = $jaktprove->presNoeUpresis;
    	$ret['presPresis'] = $jaktprove->presPresis; 	
    	$ret['reisNekter'] = $jaktprove->reisNekter;
    	$ret['reisNoelende'] = $jaktprove->reisNoelende; 	
    	$ret['reisVillig'] = $jaktprove->reisVillig;
    	$ret['reisDjerv'] = $jaktprove->reisDjerv; 	
    	$ret['sokStjeler'] = $jaktprove->sokStjeler;
    	$ret['sokSpontant'] = $jaktprove->sokSpontant; 	
    	$ret['appIkkeGodkjent'] = $jaktprove->appIkkeGodkjent;
    	$ret['appGodkjent'] = $jaktprove->appGodkjent; 	
    	$ret['rappInnkalt'] = $jaktprove->rappInnkalt;
    	$ret['rappSpont'] = $jaktprove->rappSpont; 	
    	$ret['premiegrad'] = $jaktprove->premiegrad;
    	$ret['certifikat'] = $jaktprove->certifikat; 	
    	$ret['regAv'] = $jaktprove->regAv; 	
    	$ret['regDato'] = $jaktprove->regDato;
    	$ret['raseId'] = $jaktprove->raseId;
    	$ret['manueltEndretAv'] = $jaktprove->manueltEndretAv;
    	$ret['manueltEndretDato'] = $jaktprove->manueltEndretDato;
    	$ret['kritikk'] = $jaktprove->kritikk;
    	
    	return $ret;
	}
}