<?php
require_once "database/RolleRettighetDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class RolleRettighetController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleRoller($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "hentAlleRoller"))
		{
			$db = new RolleRettighetDatabase();
			return $db->hentAlleRoller();
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function hentAlleRettigheter($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "hentAlleRettigheter"))
		{
			$db = new RolleRettighetDatabase();
			return $db->hentAlleRettigheter();
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));

		return true;
	}
	
	public function hentRollersRettigheter($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "hentAlleRettigheter"))
		{
			$db = new RolleRettighetDatabase();
			
			$roller = $db->hentAlleRoller();
			
	   		foreach($roller as $rolle)
	   		{
	   			$rolle["rettighetere"] = $db->hentRolleSineRettigheter($rolle);
	   		}

			return $roller;
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
}
