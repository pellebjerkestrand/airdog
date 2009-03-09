<?php
require_once 'no/airdog/model/AmfBruker.php';
require_once 'no/airdog/controller/ACLController.php';

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
	
		// Configure the instance with constructor parameters�
		$autentisering = new Zend_Auth_Adapter_DbTable($this->database);
		
		$autentisering
			->setTableName('ad_bruker')
			->setIdentityColumn('epost')
			->setCredentialColumn('passord');
		
		$epost = htmlspecialchars($bruker->epost);
		$pass = htmlspecialchars($bruker->passord);
		
		if($epost == ""){
			return "FEIL_BRUKERNAVN_PASSORD";
		}
		else
		{
			$autentisering->setIdentity($epost)->setCredential($pass);
		}
		
		$resultat = $autentisering->authenticate();
		
		switch ($resultat->getCode()) {
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
				return "FEIL_BRUKERNAVN_PASSORD";
			break;
		
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
				return "FEIL_BRUKERNAVN_PASSORD";
			break;
			
			case Zend_Auth_Result::FAILURE:
				return null;
			break;
			
			case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
				return null;
			break;
			
			case Zend_Auth_Result::FAILURE_UNCATEGORIZED:
				return null;
			break;
			
			case Zend_Auth_Result::SUCCESS:
				//Her returnerers den autentiserte rollen, denne skal vi bruke til Zend_Acl
				//getResultRowObject returnerer et stdClass objekt.
				$r = $autentisering->getResultRowObject();
				$bruker->epost = $r->epost;
				$bruker->passord = $r->passord;
				
				//$acl = new ACLController();
				//$acl->hentBrukersRettigheter($bruker->epost);
				
				
				return $bruker; 
			break;
			
			default:
				return "Noe skjedde feil! Hvis problemet vedvarer ta kontakt";
			break;
		}
	}
	
	public function loggUt()
	{
		Zend_Auth::getInstance()->clearIdentity();
		return true;
	}
}