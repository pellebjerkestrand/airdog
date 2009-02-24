<?php 
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
	public function settInnHund($hundArray)
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

	//må testes
	public function oppdaterHund($hundArray, $endretAv)
	{
		if (sizeof($hundArray) != 20)
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray).", forventet 20."; 
		}
		
		if (!isset($hundArray["hundId"]) || $hundArray["hundId"] == "")
		{ 
			return "hundId-verdien mangler."; 
		}
		if (!isset($endretAv) || $endretAv == "")
		{
			return "endret av bruker mangler";
		}

		$hundArray["manueltEndretAv"] = $endretAv;
		$hundArray["manueltEndretDato"] = NOW();
		
		$hvor = $this->database->quoteInto('idNr = ?', $hundArray["idNr"]);
		
		$this->database->update('NKK_hund', $hundArray, $hvor);
		
		return true;
	}
	
	//må testes
	public function slettHund($hundId)
	{
		$hvor = $this->database->quoteInto('hundId = ?', $hundId);

		$this->database->delete('NKK_hund', $hvor);
	}
	
	public function finnesHund($hundId)
	{
		$hund = $this->hentHund($hundId);
		if (isset($hund["hundId"]))
			return true;
		
		return false;
	}
	
	public function sokHund($soketekst)
	{					
		$select = $this->database->select()
		->from(array('h'=>'NKK_hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*'))
		->joinLeft(array('hMor'=>'NKK_hund'),'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'NKK_hund'),'h.hundFarId = hFar.hundId', array())
		->where('h.navn LIKE "%'.$soketekst.'%" OR h.hundId LIKE "%'.$soketekst.'%"');
	
		return $this->database->fetchAll($select);
	}
	
	public function sokJaktprove($hundId)
	{
		$select = $this->database->select()
		->from('NKK_fugl') 
		->where('hundId=?',$hundId); 

		return $this->database->fetchAll($select); 
	}
	
	public function hentHund($hundId)
	{
		$select = $this->database->select()
		->from(array('h'=>'NKK_hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*'))
		->joinLeft(array('hMor'=>'NKK_hund'), 'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'NKK_hund'), 'h.hundFarId = hFar.hundId', array())
		->where('h.hundId=?', $hundId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function hentHunder()
	{
		$select = $this->database->select()
		->from('NKK_hund', array('NKK_hund.*'));
		
		return $this->database->fetchAll($select);
	}
}