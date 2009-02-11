<?php
require_once "no/airdog/model/AmfBruker.php";
session_start();
class BrukerController
{
	public function __construct()
	{
	}
	
	public function loggInn(AmfBruker $loggInnVO)
	{
		if($loggInnVO->brukernavn == "admin" && $loggInnVO->passord == "admin"){
			$adminVO = new LoginVO();
            $adminVO->brukernavn = $loginVO->brukernavn;
            $adminVO->passord = $loginVO->passord;
            			
			return $adminVO;
		}
		else{
			throw new Exception("Feil brukernavn eller passord.");
		}
	}
	
	public function sjekkInnloggetStatus()
	{
		if(isset($_SESSION['bruker']) && $_SESSION['bruker'] == 'admin'){
			return true;
		}
		else{
			return false;
		}
	}
}