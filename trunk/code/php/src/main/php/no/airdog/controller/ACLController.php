<?php
require_once "no/airdog/controller/database/ACLDatabase.php";
require_once 'no/airdog/model/AmfBrukerRettigheter.php';

class ACLController extends Zend_Acl
{	
	public function __construct()
	{
		
	}
	
	public function lagRoller()
	{
		$db = new ACLDatabase();
		$roller = $db->hentAlleRoller();
        
        foreach($roller as $rolle)
        {
        	$this->addRole(new Zend_Acl_Role($rolle['navn']));
        }	
	}
	
	public function lagRettigheter()
	{
		$db = new ACLDatabase();
		$rettigheter = $db->hentAlleRettigheter();
		
		foreach ($rettigheter as $rettighet)
		{ 
			$this->add(new Zend_Acl_Resource($rettighet['navn']));  
        } 
	}
	
	public function lagRollerRettigheter()
	{
		$db = new ACLDatabase();
		$roller = $db->hentAlleRoller();
		
		foreach($roller as $rolle)
		{
			$rettigheter = $db->hentRollesRettigheter($rolle);
			
			if($rettigheter != null)
			{
				foreach ($rettigheter as $rettighet)
				{
					$this->allow($rolle['navn'], $rettighet['AD_rettighet_navn']);
				}
			}
		}
	}

	
	public function harBrukerLov($brukerEpost, $rettighet, $lov) 
    { 
        return ($this->isAllowed($brukerEpost, $rettighet, $lov)); 
    } 
	
	
	public function hentBrukersRoller($brukerEpost)
	{
		$db = new ACLDatabase();
		
		return $db->hentRoller($brukerEpost);
	}
	
	//brukers roller + alle roller/rettigheter = brukers rettigheter
	public function hentBrukersRettigheter($brukerEpost)
	{
		//SKAL RETURNERE ALLE MEN MED ET FELT ALLOWED ELLER DENIED		
		$db = new ACLDatabase();
		return $db->hentRettigheter($brukerEpost);
	}
}


//
//                //Loop roles and put them in an assoc array by ID
//                $roleArray = array();
//                foreach($roles as $r)
//                {
//                        $role = new Zend_Acl_Role($r['name']);
//
//                        //If inherit_name isn't null, have the role
//                        //inherit from that, otherwise no inheriting
//                        if($r['inherit_name'] !== null)
//                                $this->addRole($role,$r['inherit_name']);
//                        else
//                                $this->addRole($role);
//
//                        $roleArray[$r['id']] = $role;
//                }
//
//                foreach($resources as $r)
//                {

//                        $resource = new Zend_Acl_Resource($r['name']);
//
//                        $role = $roleArray[$r['role_id']];
//
//                        $this->add($resource);
//                        $this->allow($role,$resource);
//                }





		
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