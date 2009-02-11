<?php
require_once "no/airdog/model/AmfBruker.php";
session_start();
class BrukerController
{
	public function __construct()
	{
	}
	
	public function loggInn($loggInnVO)
	{
		if($loggInnVO->brukernavn == "admin" && $loggInnVO->passord == "admin"){
			$adminVO = new LoginVO();
            $adminVO->brukernavn = $loginVO->username;
            $adminVO->passord = $loginVO->password;
            			
			return $adminVO;
		}
		else{
			return false;
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