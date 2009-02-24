<?php 
require_once 'Tilkobling.php';

class EierDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
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

		$this->database->insert('NKK_eier', $eierArray);
		
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

		$this->database->update('NKK_eier', $eierArray);
		
		return true;
	}
}