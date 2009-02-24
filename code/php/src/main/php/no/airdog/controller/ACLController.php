<?php
require_once "no/airdog/controller/database/ACLDatabase.php";

class ACLController
{	
	public function __construct()
	{

	}
	
	public function hentBrukersRoller($brukerEpost)
	{
		$db = new ACLDatabase();
		return $db->hentRoller($brukerEpost);
	}

	public function hentBrukersRettigheter($brukerEpost)
	{	
		$db = new ACLDatabase();
		return $db->hentRettigheter($brukerEpost);
	}
}