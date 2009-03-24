<?php
require_once "no/airdog/controller/database/ACLDatabase.php";
require_once "no/airdog/model/AmfRettigheter.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class ACLController
{	
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentBrukersKlubber($brukerEpost, $brukerPassord)
	{
		$db = new ACLDatabase();
		if(ValiderBruker::validerSuperadmin($this->database, $brukerEpost, $brukerPassord))
		{
			return $db->hentAlleKlubber();
		}

		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{
			return $db->hentBrukersKlubber($brukerEpost);
		}

		$feilkode = 1;
		throw(new Exception('Du har ingen klubber', $feilkode));		
	}
	
	public function hentBrukersRoller($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{	
			$db = new ACLDatabase();
			return $db->hentBrukersRoller($brukerEpost, $klubbId);	
		}
		$feilkode = 1;
		throw(new Exception('Du har ingen roller', $feilkode));		
	}

	public function hentBrukersRettigheter($brukerEpost, $brukerPassord, $klubbId)
	{	
		if(ValiderBruker::validerSuperadmin($this->database, $brukerEpost, $brukerPassord))
		{		
			$tmp = new AmfRettigheter();
			
			$tmp->lese = true;
			$tmp->redigerHund = true;
			$tmp->redigerJaktprove = true;
			$tmp->redigerUtstilling = true;
			$tmp->importerDatabase = true;
			$tmp->leggInnJaktprove = true;
			$tmp->slettJaktprove = true;
			$tmp->rolleRettighetHandtering = true;
			$tmp->klubbRolleBrukerHandtering = true;
			$tmp->administrereBackup = true;
			$tmp->importerDatabase = true;
			$tmp->redigerEgenBruker = true;
			
			$tmp->administrere = true;
  				
  			return $tmp;		
		}
		
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{	
			$db = new ACLDatabase();
			$rettigheter = $db->hentBrukersRettigheter($brukerEpost, $klubbId);
			
			$tmp = new AmfRettigheter();
			
			foreach($rettigheter as $r)
	   		{   
	   			if($r['navn'] == "lese") $tmp->lese = true;
	   			if($r['navn'] == "redigerHund")	$tmp->redigerHund = true;
	   			if($r['navn'] == "redigerJaktprove") $tmp->redigerJaktprove = true;
	   			if($r['navn'] == "redigerUtstilling") $tmp->redigerUtstilling = true;
	   			if($r['navn'] == "importerDatabase") $tmp->importerDatabase = true;
	   			if($r['navn'] == "leggInnJaktprove") $tmp->leggInnJaktprove = true;
	   			if($r['navn'] == "slettJaktprove") $tmp->slettJaktprove = true;
	   			if($r['navn'] == "rolleRettighetHandtering") $tmp->rolleRettighetHandtering = true;
	   			if($r['navn'] == "klubbRolleBrukerHandtering") $tmp->klubbRolleBrukerHandtering = true;
	   			if($r['navn'] == "administrereBackup") $tmp->administrereBackup = true;
	   			if($r['navn'] == "importerDatabase") $tmp->importerDatabase = true;
	   			if($r['navn'] == "redigerEgenBruker") $tmp->redigerEgenBruker = true;
	   			
	   		}
	   		
	   		if($tmp->redigerHund || $tmp->importerDatabase || $tmp->leggInnJaktprove ||
	   		$tmp->rolleRettighetHandtering || $tmp->klubbRolleBrukerHandtering  || 
	   		$tmp->administrereBackup || $tmp->importerDatabase) $tmp->administrere = true;
	   		
			return $tmp;
		}
		$feilkode = 1;
		throw(new Exception('Du har ingen rettigheter', $feilkode));	
		
	}
	
	public function redigerEgenBruker($fraBruker, $tilBruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerEgenBruker"))
		{
			$db = new ACLDatabase();

			return $db->redigerEgenBruker($fraBruker, $tilBruker, $brukerPassord);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
}