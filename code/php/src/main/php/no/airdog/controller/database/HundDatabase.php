<?php 
require_once 'Tilkobling.php';
require_once 'Tilkobling_.php';

class HundDatabase
{
	private $database;

	public function __construct() {
		$tilkobling = new Tilkobling_();
		$this->database = $tilkobling->getTilkobling();
	}
	
//	SQL->ZendDB
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
		
//		mysql_query("INSERT INTO hund (raseId, kullId, hundId, tittel, navn, hundFarId, hundMorId, idNr, farge, fargeVariant, oyesykdom, hoftesykdom, haarlag, idMerke, kjonn, eierId, endretAv, endretDato, regDato, storrelse) " . 
//					"VALUES('".$hundArray["raseId"]."', " .
//							"'".$hundArray["kullId"]."', " .
//							"'".$hundArray["hundId"]."', " .
//							"'".$hundArray["tittel"]."', " .
//							"'".$hundArray["navn"]."', " .
//							"'".$hundArray["hundFarId"]."', " .
//							"'".$hundArray["hundMorId"]."', " .
//							"'".$hundArray["idNr"]."', " .
//							"'".$hundArray["farge"]."', " .
//							"'".$hundArray["fargeVariant"]."', " .
//							"'".$hundArray["oyesykdom"]."', " .
//							"'".$hundArray["hoftesykdom"]."', " . 
//							"'".$hundArray["haarlag"]."', " .
//							"'".$hundArray["idMerke"]."', " .
//							"'".$hundArray["kjonn"]."', " .
//							"'".$hundArray["eierId"]."', " . 
//							"'".$hundArray["endretAv"]."', " .
//							"'".$hundArray["endretDato"]."', " .
//							"'".$hundArray["regDato"]."', " .
//							"'".$hundArray["storrelse"]."') ") 
//		or die(mysql_error());
		
//		må testes!
		$this->database->insert('hunder', $hundArray);  
			
		return true;
	}
	
//	SQL->ZendDB
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
		
//		mysql_query("UPDATE hund " .
//					"SET raseId='".$hundArray["raseId"]."', " .
//						"kullId='".$hundArray["kullId"]."', " .
//						"tittel='".$hundArray["tittel"]."', " .
//						"navn='".$hundArray["navn"]."', " .
//						"hundFarId='".$hundArray["hundFarId"]."', " .
//						"hundMorId='".$hundArray["hundMorId"]."', " .
//						"idNr='".$hundArray["idNr"]."', " .
//						"farge='".$hundArray["farge"]."', " .
//						"fargeVariant='".$hundArray["fargeVariant"]."', " .
//						"oyesykdom='".$hundArray["oyesykdom"]."', " .
//						"hoftesykdom='".$hundArray["hoftesykdom"]."', " .
//						"haarlag='".$hundArray["haarlag"]."', " .
//						"idMerke='".$hundArray["idMerke"]."', " .
//						"kjonn='".$hundArray["kjonn"]."', " .
//						"eierId='".$hundArray["eierId"]."', " . 
//						"endretAv='".$hundArray["endretAv"]."', " .
//						"endretDato='".$hundArray["endretDato"]."', " .
//						"regDato='".$hundArray["regDato"]."', " .
//						"storrelse='".$hundArray["storrelse"]."', " .
//						"manueltEndretAv='".$endretAv."', " .
//						"manueltEndretDato=NOW()" . 
//						"WHERE hundId='".$hundArray["hundId"]."' " .
//						"LIMIT 1") 
//		or die(mysql_error());
		
//		må testes!	
		$hundArray["manueltEndretAv"] = $endretAv;
		$hundArray["manueltEndretDato"] = NOW();
		
		$this->database->update('hund', $hundArray, "idNr = ".$hundArray["idNr"]);
		
		return true;
	}
	
	public function slettHund($hundId)
	{
//		må testes!
		$this->database->delete('hund', 'hundId = '."$hundId");
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
		->from(array('h'=>'hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*'))
		->joinLeft(array('hMor'=>'hund'),'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'hund'),'h.hundFarId = hFar.hundId', array())
		->where('h.navn LIKE "%'.$soketekst.'%" OR h.hundId LIKE "%'.$soketekst.'%"');
	
		return $this->database->fetchAll($select);
	}
	
	public function sokJaktprove($hundId)
	{
		$select = $this->database->select()
		->from('fugl') 
		->where('hundId=?',$hundId); 

		return $this->database->fetchAll($select); 
	}
	
	public function hentHund($hundId)
	{
		$select = $this->database->select()
		->from(array('h'=>'hund'), array('hundMorNavn'=>'hMor.navn', 'hundFarNavn'=>'hFar.navn', 'h.*'))
		->joinLeft(array('hMor'=>'hund'), 'h.hundMorId = hMor.hundId', array())
		->joinLeft(array('hFar'=>'hund'), 'h.hundFarId = hFar.hundId', array())
		->where('h.hundId=?', $hundId)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function hentHunder()
	{
		$select = $this->database->select()
		->from('hund', array('hund.*'));
		
		return $this->database->fetchAll($select);
	}
}
?>