<?php
require_once "no/airdog/controller/database/RolleRettighetDatabase.php";
class RolleRettighetController
{
	public function __construct()
	{
	}
	
	public function hentRolleRettighetLink($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
		}
	}
}
