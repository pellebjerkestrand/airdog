<?php
require_once "no/airdog/controller/database/ACLDatabase.php";

class ACLController
{	
	public function __construct()
	{

	}
	
	public function hentBrukersRoller($brukerEpost, $passord, $klubb)
	{
		$db = new ACLDatabase();
		return $db->hentRoller($brukerEpost, $passord, $klubb);
	}

	public function hentBrukersRettigheter($brukerEpost, $passord, $klubb)
	{	
		$db = new ACLDatabase();
		return $db->hentRettigheter($brukerEpost, $passord, $klubb);
	}
}