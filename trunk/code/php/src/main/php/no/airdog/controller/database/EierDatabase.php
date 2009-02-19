<?php 
require_once 'Tilkobling.php';

class EierDatabase
{
	private $database;
	
	public function EierDatabase()
	{
	}
	
	public function settInnEier($eierArray)
	{
		if (sizeof($eierArray) != 3)
		{
			return "Arrayet er av feil størrelse.";
		}
		if (!isset($eierArray["eier"]) || $eierArray["eier"] == "")
		{
			return "eiers id mangler";
		}
		
		//mysql_query("INSERT INTO eier (eier, hundId, raseId) ".
		//			"VALUES('".$eierArray["eier"]."', '".$eierArray["hundId"]."', '".$eierArray["raseId"]."') ") 
		//			or die(mysql_error());

		$this->database->insert('eier', $eierArray);
		
		return true;
	}
	
	public function oppdaterEier($eierArray, $endretAv)
	{
		if (sizeof($eierArray) != 3)
		{
			return "Arrayet er av feil størrelse.";
		}
		if (!isset($eierArray["eier"]) || $eierArray["eier"] == "")
		{
			return "eiers id mangler";
		}
		if (!isset($endretAv) || $endretAv == "")
		{
			return "endret av bruker mangler";
		}
		
		//mysql_query("UPDATE eier SET hundId='22' WHERE age='21'") or die(mysql_error());

		$this->database->update('eier', $eierArray);
		
		return true;
	}
}
?>