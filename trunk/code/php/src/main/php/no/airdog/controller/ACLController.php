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
			$tmp->importerDatabase = true;
			$tmp->leggInnJaktprove = true;
			$tmp->slettJaktprove = true;
			$tmp->rollehandtering = true;
			$tmp->administrereBackup = true;
			$tmp->importerDatabase = true;
			$tmp->administrere = true;
  				
  			return $tmp;		
		}
		
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{	
			$db = new ACLDatabase();
			$rettigheter = $db->hentBrukersRettigheter($brukerEpost, $klubbId);
			
			$tmp = new AmfRettigheter();
			
			if($rettigheter) $tmp->administrere = true;
			
			foreach($rettigheter as $r)
	   		{   
	   			if($r['navn'] == "lese") $tmp->lese = true;
	   			if($r['navn'] == "redigerHund")	$tmp->redigerHund = true;
	   			if($r['navn'] == "redigerJaktprove") $tmp->redigerJaktprove = true;
	   			if($r['navn'] == "importerDatabase") $tmp->importerDatabase = true;
	   			if($r['navn'] == "leggInnJaktprove") $tmp->leggInnJaktprove = true;
	   			if($r['navn'] == "slettJaktprove") $tmp->slettJaktprove = true;
	   			if($r['navn'] == "rollehandtering")	$tmp->rollehandtering = true;
	   			if($r['navn'] == "administrereBackup") $tmp->administrereBackup = true;
	   			if($r['navn'] == "importerDatabase") $tmp->importerDatabase = true;
	   		}
	   		
			return $tmp;
		}
		$feilkode = 1;
		throw(new Exception('Du har ingen rettigheter', $feilkode));	
	}
}