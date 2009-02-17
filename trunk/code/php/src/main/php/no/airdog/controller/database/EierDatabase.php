<?php 
require_once 'Tilkobling.php';

class EierDatabase
{
	public function EierDatabase()
	{
	}
	
	public function settInnEier($eierArray)
	{
		if (sizeof($eierArray) != 3)
		{
			return "Arrayet er av feil størrelse.";
		}
		
		mysql_query("INSERT INTO eier (eier, hundId, raseId) ".
					"VALUES('".$eierArray["eier"]."', '".$eierArray["hundId"]."', '".$eierArray["raseId"]."') ") 
					or die(mysql_error());  
		return true;
	}
	
	public function oppdaterEier($eierArray, $endretAv)
	{
		if (sizeof($eierArray) != 3)
		{
			return "Arrayet er av feil størrelse.";
		}
		
		mysql_query("UPDATE eier SET hundId='22' WHERE age='21'") or die(mysql_error()); 
		return true;
	}
}
?>