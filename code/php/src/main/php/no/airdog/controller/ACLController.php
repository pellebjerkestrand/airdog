<?php
require_once "no/airdog/controller/database/ACLDatabase.php";

class ACLController
{	
	public function __construct()
	{

	}
	
	public function hentBrukersKlubber($brukerEpost, $brukerPassord)
	{
		$db = new ACLDatabase();
		return $db->hentBrukersKlubber($brukerEpost, $brukerPassord);
	}
	
	public function hentBrukersRoller($brukerEpost, $brukerPassord, $klubbId)
	{
		$db = new ACLDatabase();
		return $db->hentBrukersRoller($brukerEpost, $brukerPassord, $klubbId);
	}

	public function hentBrukersRettigheter($brukerEpost, $brukerPassord, $klubbId)
	{	
		$db = new ACLDatabase();
		return $db->hentBrukersRettigheter($brukerEpost, $brukerPassord, $klubbId);
	}
}