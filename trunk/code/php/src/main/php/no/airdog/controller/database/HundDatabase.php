<?php 
require_once 'Tilkobling.php';

class HundDatabase
{
	public function HundDatabase()
	{
	}
	
	public function settInnHund($hundArray)
	{
		if (sizeof($hundArray) != 20)
		{
			return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray)." forventet 20.";
		}
		
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
		if (sizeof($hundArray) != 20)
		{
			return "Arrayet er av feil størrelse. Fikk ".sizeof($hundArray)." forventet 20.";
		}
		
		mysql_query("UPDATE hund SET raseId='".$hundArray[""]."', kullId='".$hundArray[""]."', tittel='".$hundArray[""]."', navn='".$hundArray[""]."', hundFarId='".$hundArray[""]."', hundMorId='".$hundArray[""]."', idNr='".$hundArray[""]."', farge='".$hundArray[""]."', 
				fargeVariant='".$hundArray[""]."', oyesykdom='".$hundArray[""]."', hoftesykdom='".$hundArray[""]."', haarlag='".$hundArray[""]."', idMerke='".$hundArray[""]."', kjonn='".$hundArray[""]."', eierId='".$hundArray[""]."', 
				endretAv='".$hundArray[""]."', endretDato='".$hundArray[""]."', regDato='".$hundArray[""]."', storrelse='".$hundArray[""]."' 
			WHERE hundId='".$hundArray["hundId"]."' LIMIT 1") 
		or die(mysql_error()); 
		return true;
	}
	
	public function slettHund($hundId)
	{
		mysql_query("DELETE FROM hund WHERE hundId='".$hundId."' LIMIT 1") 
		or die(mysql_error()); 
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