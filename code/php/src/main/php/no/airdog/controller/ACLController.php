<?php
require_once "no/airdog/controller/database/ACLDatabase.php";

class ACLController extends Zend_Acl
{
	public function __construct()
	{
		//maek acl lists: do want!
	}
	
	//brukers roller + alle roller/rettigheter = brukers rettigheter
	public function hentBrukersRettigheter($brukerEpost)
	{
		$db = new ACLDatabase();
		
		$roller = $db->hentRoller($brukerEpost);	//i can has ass.array: AD_bruker_epost AD_rolle_navn
		$rettigheter = $db->hentRettigheter();		//i can has ass.array: AD_rettighet_navn AD_rolle_navn
		
		$brukersRettigheter = array();
		
		//populere $brukersRettigheter med AD_rettighet_navn
		//der $roller.AD_rolle_navn == $rettigheter.AD_rolle_navn
		//do want!
		
		return $brukersRettigheter;
	}
}