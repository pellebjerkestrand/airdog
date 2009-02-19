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


		
//		//Setter opp en Akksess kontroll liste (acl)
//		$acl = new Zend_Acl();
//		
//		//Legger til grupper i rolle registreret ved hjelp av Zend_Acl_Role
//		//Gjest arver ikke kontroll.
//		//Her er det viktig � riktig rekkef�lge, fra den med minst rettigheter til den med mest
//		$acl->addRole(new Zend_Acl_Role('gjest'));
//		$acl->addRole(new Zend_Acl_Role('admin'), 'gjest');
//		
//		//Super arver ingenting og har tilgang til alle rettigheter
//		$acl->addRole(new Zend_Acl_Role('Super'));
//		
//		//Setter opp alle rettighetene
//		$acl->add(new Zend_Acl_Resource('seUI'));
//		$acl->add(new Zend_Acl_Resource('seLogg'));
//		
//		//Gjest har ikke lov til � se noenting
//		$acl->allow('gjest', null, null);
//		
//		// admin arver fra gjest og f�r disse
//		$acl->allow('admin', null, array('seUI','seLogg'));
//		
//		// Super arver ingenting, men har lov til alt
//		$acl->allow('Super');
//		
//		// AmfBrukerRettigheter til rettighets mapping
//		$brukerRettigheter = new AmfBrukerRettigheter();
//		$brukerRettigheter->brukerRolle = $brukerRolle;
//		
//		$brukerRettigheter->seUI = $acl->isAllowed($brukerRolle, null, 'seUI') ? 
//		"allowed" : "denied";
//		
//		$brukerRettigheter->seLogg = $acl->isAllowed($brukerRolle, null, 'seLogg') ?
//		"allowed" : "denied";
//		
//		return $brukerRettigheter;