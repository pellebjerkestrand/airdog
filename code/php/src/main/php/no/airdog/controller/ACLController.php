<?php
require_once "no/airdog/controller/database/ACLDatabase.php";

class ACLController
{	
	public function __construct()
	{

	}
	
	public function hentBrukersKlubber($brukerEpost, $passord)
	{
		$db = new ACLDatabase();
		return $db->hentBrukersKlubber($brukerEpost, $passord);
	}
	
	public function hentBrukersRoller($brukerEpost, $passord, $klubbId)
	{
		$db = new ACLDatabase();
		return $db->hentBrukersRoller($brukerEpost, $passord, $klubbId);
	}

	public function hentBrukersRettigheter($brukerEpost, $passord, $klubbId)
	{	
		$db = new ACLDatabase();
		return $db->hentBrukersRettigheter($brukerEpost, $passord, $klubbId);
	}
}