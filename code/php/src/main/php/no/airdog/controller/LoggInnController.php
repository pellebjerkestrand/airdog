<?php
require_once 'no/airdog/model/AmfBruker.php';
require_once 'no/airdog/controller/database/Tilkobling.php';

class LoggInnController {
	
	private $database;
	private $autentisering;
	
	public function __construct() {
		
		$this->auth = Zend_Auth::getInstance();
		
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
		
	}
	
	public function loggInn(AmfBruker $bruker) {
	
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
				$r = $autentisering->getResultRowObject();
				$bruker->epost = $r->epost;
				$bruker->passord = $r->passord;

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