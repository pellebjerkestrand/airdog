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
		return $db->hentBrukersRettigheter($brukerEpost, $passord);
	}
	
	public function hentBrukersRoller($brukerEpost, $passord, $klubb)
	{
		$db = new ACLDatabase();
		return $db->hentBrukersRoller($brukerEpost, $passord, $klubb);
	}

	public function hentBrukersRettigheter($brukerEpost, $passord, $klubb)
	{	
		$db = new ACLDatabase();
		return $db->hentBrukersRettigheter($brukerEpost, $passord, $klubb);
	}
}