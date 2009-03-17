<?php
require_once "database/RolleBrukerDatabase.php";
require_once "database/ACLDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class RolleBrukerController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleBrukere($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$db = new RolleBrukerDatabase();
			return $db->hentAlleBrukere();
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function hentAlleRollersBrukere($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$dbACL = new ACLDatabase();
			$klubber = $dbACL->hentAlleKlubber();
			
			$db = new RolleBrukerDatabase();			

	   		foreach($klubber as $klubb)
	   		{
	   			if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubb['raseid'], "Rollehåndtering"))
				{	   
		   			$tempRoller = array();
		   			$roller['roller'] = $db->hentKlubbsRoller($klubb['raseid']);
		   			
		   			foreach($roller['roller'] as $rolle)
		   			{
		   				$rolle['brukere'] = $db->hentRollesBrukere($rolle['ad_rolle_navn'], $klubb['raseid']);
		   				$tempRoller[] = $rolle;
		   			}
		   			
		   			$klubb['roller'] = $tempRoller;
		   			$tmp[] = $klubb;
				}
	   		}
			
			return $tmp;
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}

}
