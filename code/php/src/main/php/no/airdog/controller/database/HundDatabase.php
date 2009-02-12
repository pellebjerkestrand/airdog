<?php 
require_once 'Tilkobling.php';

class HundDatabase
{
	public function HundDatabase()
	{
	}
	
	public function settInnHund($hundArray)
	{
		if (sizeof($hundArray) != 20) { return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray)." forventet 20."; }
		if (!isset($hundArray["hundId"]) || $hundArray["hundId"] == "") { return "hundId-verdien mangler."; }
		
		mysql_query("INSERT INTO hund (raseId, kullId, hundId, tittel, navn, hundFarId, hundMorId, idNr, farge, 
				fargeVariant, oyesykdom, hoftesykdom, haarlag, idMerke, kjonn, eierId, endretAv, endretDato, regDato, storrelse) 
			VALUES('".$hundArray["raseId"]."', '".$hundArray["kullId"]."', '".$hundArray["hundId"]."', '".$hundArray["tittel"]."', 
				'".$hundArray["navn"]."', '".$hundArray["hundFarId"]."', '".$hundArray["hundMorId"]."', '".$hundArray["idNr"]."', 
				'".$hundArray["farge"]."', '".$hundArray["fargeVariant"]."', '".$hundArray["oyesykdom"]."', '".$hundArray["hoftesykdom"]."', 
				'".$hundArray["haarlag"]."', '".$hundArray["idMerke"]."', '".$hundArray["kjonn"]."', '".$hundArray["eierId"]."', 
				'".$hundArray["endretAv"]."', '".$hundArray["endretDato"]."', '".$hundArray["regDato"]."', '".$hundArray["storrelse"]."') ") 
		or die(mysql_error());  
			
		return true;
	}
	
	public function oppdaterHund($hundArray, $endretAv)
	{
		if (sizeof($hundArray) != 20) { return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray)." forventet 20."; }
		if (!isset($hundArray["hundId"]) || $hundArray["hundId"] == "") { return "hundId-verdien mangler."; }
		
		mysql_query("UPDATE hund SET raseId='".$hundArray["raseId"]."', kullId='".$hundArray["kullId"]."', tittel='".$hundArray["tittel"]."', navn='".$hundArray["navn"]."', hundFarId='".$hundArray["hundFarId"]."', hundMorId='".$hundArray["hundMorId"]."', idNr='".$hundArray["idNr"]."', farge='".$hundArray["farge"]."', 
				fargeVariant='".$hundArray["fargeVariant"]."', oyesykdom='".$hundArray["oyesykdom"]."', hoftesykdom='".$hundArray["hoftesykdom"]."', haarlag='".$hundArray["haarlag"]."', idMerke='".$hundArray["idMerke"]."', kjonn='".$hundArray["kjonn"]."', eierId='".$hundArray["eierId"]."', 
				endretAv='".$hundArray["endretAv"]."', endretDato='".$hundArray["endretDato"]."', regDato='".$hundArray["regDato"]."', storrelse='".$hundArray["storrelse"]."', manueltEndretAv='".$endretAv."', manueltEndretDato=NOW() 
			WHERE hundId='".$hundArray["hundId"]."' LIMIT 1") 
		or die(mysql_error()); 
		return true;
	}
	
	public function slettHund($hundId)
	{
		return mysql_query("DELETE FROM hund WHERE hundId='".$hundId."' LIMIT 1") 
		or die(mysql_error()); 
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
		$resultat = mysql_query("SELECT hund.*, hundMor.navn as hundMorNavn, hundFar.navn as hundFarNavn FROM hund LEFT JOIN hund AS hundMor ON hund.hundMorId = hundMor.hundId LEFT JOIN hund as hundFar ON hund.hundFarId = hundFar.hundId WHERE (hund.hundId LIKE '%".$soketekst."%' OR hund.navn LIKE '%".$soketekst."%')") 
		or die(mysql_error());  

		return $resultat;
	}
	
	public function sokJaktprove($hundId)
	{
		$resultat = mysql_query("SELECT * FROM fugl WHERE hundId='".$hundId."'") 
		or die(mysql_error());  

		return $resultat;
	}
	
	public function hentHund($hundId)
	{
		$resultat = mysql_query("SELECT * FROM hund WHERE hundId='".$hundId."' LIMIT 1") 
		or die(mysql_error());  

		return mysql_fetch_array( $resultat );
	}
	
	public function hentHunder()
	{
		return mysql_query("SELECT * FROM hund") 
		or die(mysql_error());  
	}
}
?>