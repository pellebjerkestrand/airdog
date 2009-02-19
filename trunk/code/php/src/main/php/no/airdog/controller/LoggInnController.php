<?php
require_once 'no/airdog/controller/database/Tilkobling.php';
require_once 'no/airdog/model/AmfBruker.php';
require_once 'no/airdog/model/AmfBrukerRettigheter.php';
require_once '../../com/Zend/Auth.php';
require_once '../../com/Zend/Acl.php';

/*
* LoggInnController
*
* Sjekker bruker rettigheter og sjekker roller mot ACL.
*
* @return Aksess rettigheter
*/
class LoggInnController {
	
	private $database;
	private $autentisering;
	
	/**
	* @return avhengigheter
	*/
	public function __construct() {
		
		//F�r en instanse av Zend_Auth
		$this->auth = Zend_Auth::getInstance();
		
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
		
	}
	
	/**
	*
	* Autensiterer brukeren
	*
	* @return avhengigheter
	*
	*/
	public function loggInn(AmfBruker $bruker) {		
		$brukerRolle="";
		
		// Configure the instance with constructor parameters�
		$autentisering = new Zend_Auth_Adapter_DbTable($this->database);
		$autentisering->setTableName('bruker')
			->setIdentityColumn('brukernavn')
			->setCredentialColumn('passord');
		
		$brk=htmlspecialchars($bruker->brukernavn);
		$pass=htmlspecialchars($bruker->passord);
		
		if($brk == ""){
			return "FEIL_BRUKERNAVN_PASSORD";
		}
		else
		{
			$autentisering->setIdentity($brk)->setCredential($pass);
		}
		
		$resultat = $autentisering->authenticate();
		
		switch ($resultat->getCode()) {
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
			$brukerRolle = "gjest";
				return "FEIL_BRUKERNAVN_PASSORD";
			break;
		
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
				$brukerRolle = "gjest";
				return "FEIL_BRUKERNAVN_PASSORD";
			break;
			
			case Zend_Auth_Result::FAILURE:
				$brukerRolle = 'gjest';
				return null;
			break;
			
			case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
				$brukerRolle = 'gjest';
				return null;
			break;
			
			case Zend_Auth_Result::FAILURE_UNCATEGORIZED:
				$brukerRolle = 'gjest';
				return null;
			break;
			
			case Zend_Auth_Result::SUCCESS:
				//Her returnerers den autentiserte rollen, denne skal vi bruke til Zend_Acl
				//getResultRowObject returnerer et stdClass objekt.
				$r=$autentisering->getResultRowObject(array('rolle'));
				$brukerRolle = $r->rolle;
			break;
			
			default:
				return "Noe skjedde feil! Hvis problemet vedvarer ta kontakt";
			break;
		}
		
		//Setter opp en Akksess kontroll liste (acl)
		$acl = new Zend_Acl();
		
		//Legger til grupper i rolle registreret ved hjelp av Zend_Acl_Role
		//Gjest arver ikke kontroll.
		//Her er det viktig � riktig rekkef�lge, fra den med minst rettigheter til den med mest
		$acl->addRole(new Zend_Acl_Role('gjest'));
		$acl->addRole(new Zend_Acl_Role('admin'), 'gjest');
		
		//Super arver ingenting og har tilgang til alle rettigheter
		$acl->addRole(new Zend_Acl_Role('Super'));
		
		//Setter opp alle rettighetene
		$acl->add(new Zend_Acl_Resource('seUI'));
		$acl->add(new Zend_Acl_Resource('seLogg'));
		
		//Gjest har ikke lov til � se noenting
		$acl->allow('gjest', null, null);
		
		// admin arver fra gjest og f�r disse
		$acl->allow('admin', null, array('seUI','seLogg'));
		
		// Super arver ingenting, men har lov til alt
		$acl->allow('Super');
		
		// AmfBrukerRettigheter til rettighets mapping
		$brukerRettigheter = new AmfBrukerRettigheter();
		$brukerRettigheter->brukerRolle = $brukerRolle;
		
		$brukerRettigheter->seUI = $acl->isAllowed($brukerRolle, null, 'seUI') ? 
		"allowed" : "denied";
		
		$brukerRettigheter->seLogg = $acl->isAllowed($brukerRolle, null, 'seLogg') ?
		"allowed" : "denied";
		
		return $brukerRettigheter;
	}
}