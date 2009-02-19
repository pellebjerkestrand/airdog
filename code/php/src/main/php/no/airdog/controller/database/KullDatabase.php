<?php 
require_once 'Tilkobling.php';

class KullDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling_();
		$this->database = $tilkobling->getTilkobling();
	}
		
	public function KullDatabase()
	{
	}
	
	public function settInnKull($kullArray)
	{
		if (sizeof($kullArray) != 7) 
		{ 
			return "Arrayet er av feil størrelse. Fikk ".sizeof($kullArray)." forventet 7."; 
		}
		if (!isset($kullArray["kullId"]) || $kullArray["kullId"] == "") 
		{ 
			return "kullId-verdien mangler."; 
		}
		
		//mysql_query("INSERT INTO kull (kullId, hundIdFar, hundIdMor, oppdretterId, endretDato, fodt, raseId) 
		//	VALUES('".$kullArray["kullId"]."', '".$kullArray["hundIdFar"]."', '".$kullArray["hundIdMor"]."', '".$kullArray["oppdretterId"]."', '".$kullArray["endretDato"]."', 
		//		'".$kullArray["fodt"]."', '".$kullArray["raseId"]."') ") 
		//or die(mysql_error());  
		
		$this->database->insert('kull', $kullArray);
					
		return true;
	}
	
	public function oppdaterKull($kullArray, $endretAv)
	{
		if (sizeof($kullArray) != 7) 
		{ 
			return "Arrayet er av feil stÃ¸rrelse. Fikk ".sizeof($kullArray)." forventet 7."; 
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
	
	public function hentKull($kullId)
	{
		//$resultat = mysql_query("SELECT * FROM kull WHERE kullId='".$kullId."' LIMIT 1") 
		//or die(mysql_error());  

		
		return mysql_fetch_array( $resultat );
	}
	
	public function hentKuller()
	{
		return mysql_query("SELECT * FROM kull") 
		or die(mysql_error());  
	}
}
?>