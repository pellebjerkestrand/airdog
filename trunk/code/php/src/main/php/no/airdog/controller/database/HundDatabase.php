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

	//må testes
	public function settInnHund($hundArray, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			if (sizeof($hundArray) != 20)
			{ 
				return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray).", forventet 20."; 
			}
			
			if (!isset($hundArray["hundId"]) || $hundArray["hundId"] == "")
			{ 
				return "hundId-verdien mangler."; 
			}
		
			$this->database->insert('NKK_hund', $hundArray);
				
			return true;
		}
		
		return false;
	}

	//må testes
	public function oppdaterHund($hundArray, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			if (sizeof($hundArray) != 20)
			{ 
				return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray).", forventet 20."; 
			}
			
			if (!isset($hundArray["hundId"]) || $hundArray["hundId"] == "")
			{ 
				return "hundId-verdien mangler."; 
			}
			if (!isset($brukerEpost) || $brukerEpost == "")
			{
				return "endret av bruker mangler";
			}
	
			$hundArray["manueltEndretAv"] = $brukerEpost;
			$hundArray["manueltEndretDato"] = NOW();
			
			$hvor = $this->database->quoteInto('idNr = ?', $hundArray["idNr"]);
			
			$this->database->update('NKK_hund', $hundArray, $hvor);
			
			return true;
		}
		
		return false;
	}
	
	//må testes
	public function slettHund($hundId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$hvor = $this->database->quoteInto('hundId = ?', $hundId);
	
			$this->database->delete('NKK_hund', $hvor);
		}
	}
	
	public function finnesHund($hundId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$hund = $this->hentHund($hundId);
			if (isset($hund["hundId"]))
				return true;
		}
		
		return false;
	}
	
	public function sokHund($soketekst, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{	
			$select = $this->database->select()
			->from(array('h'=>'NKK_hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*', 
			'vf' => '(6 * (hFugl.egneStand) / ((hFugl.makkerStand) + (hFugl.egneStand)))'))
			->joinLeft(array('hMor'=>'nkk_hund'),'h.hundMorId = hMor.hundId', array())
			->joinLeft(array('hFar'=>'nkk_hund'),'h.hundFarId = hFar.hundId', array())
			->joinLeft(array('hFugl'=>'nkk_fugl'),'h.hundId = hFugl.hundId', array())
			->group('h.hundId')
			->where('h.navn LIKE "%'.$soketekst.'%" OR h.hundId LIKE "%'.$soketekst.'%"')
//			propesed fix for æøå. doesn't work:(
//			->where('h.navn LIKE ? OR h.hundId LIKE ?', array($soketekst, $soketekst))
			->where('h.raseId=?', $klubbId);
	
			return $this->database->fetchAll($select);
		}
		
		return null;				
	}
	
	public function sokJaktprove($hundId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$select = $this->database->select()
			->from('NKK_fugl') 
			->where('hundId=?',$hundId)
			->where('raseId=?', $klubbId); 
	
			return $this->database->fetchAll($select); 
		}
		
		return null;
	}
	
	public function hentHund($hundId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$select = $this->database->select()
			->from(array('h'=>'NKK_hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*', 
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
		
		return null;
	}
	
	public function hentHunder($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$select = $this->database->select()
			->from('NKK_hund', array('NKK_hund.*'))
			->where('h.raseId=?', $klubbId);
			
			return $this->database->fetchAll($select);
		}
		
		return null;
	}
}