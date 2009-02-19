<?php
require_once "no/airdog/controller/database/ACLDatabase.php";

class ACLController extends Zend_Acl
{
	public function __construct()
	{
	}
	
	//kombinerer/filtrerer brukers roller og alle roller/rettigheter til en array av brukers rettigheter
	public function hentBrukersRettigheter($brukerEpost)
	{
		$db = new ACLDatabase();
		
		$roller = $db->hentRoller($brukerEpost);
		$rettigheter = $db->hentRettigheter();
		
		$brukersRettigheter = array();
		
		foreach($rettigheter as $rettighet)
		{
			for($i = 0; sizeof($roller) > $i; $i++)
			{
				if($rettighet["AD_rolle_navn"] == $roller[$i])
				{
					$brukersRettigheter = $rettighet["AD_rettighet_navn"];
				}
			}
		}
	}
}