<?php
require_once "no/airdog/controller/database/ACLDatabase.php";

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
			$db = new ACLDatabase();
			return $db->hentAlleRettigheter($klubbId);			
		}
		
		if(ValiderBruker::validerBrukeren($this->database, $brukerEpost, $brukerPassord))
		{	
			$db = new ACLDatabase();
			return $db->hentBrukersRettigheter($brukerEpost, $klubbId);
		}
		$feilkode = 1;
		throw(new Exception('Du har ingen rettigheter', $feilkode));	
	}
}