<?php
require_once "no/airdog/model/AmfBruker.php";
class BrukerController
{
	public function __construct()
	{
	}
	
	public function loggInn($loggInnVO)
	{
		if($loggInnVO->brukernavn == "admin" && $loggInnVO->passord == "admin"){
			$adminVO = new AmfBruker();
			
			$rolle = array();
			
			//TestArray
			$rolle["admin"] = true;
			$rolle["bruker"] = true;
			
            $adminVO->brukernavn = $loggInnVO->brukernavn;
            $adminVO->passord = $loggInnVO->passord;
            $adminVO->rolle = $rolle;
            			
			return $adminVO;
		}
		else{
			return null;
		}
	}
}