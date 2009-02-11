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
			
			$roller = array();
			
			//TestArray
			$roller["admin"] = true;
			$roller["bruker"] = true;
			
            $adminVO->brukernavn = $loggInnVO->brukernavn;
            $adminVO->passord = $loggInnVO->passord;
            $adminVO->roller = $roller;
            			
			return $adminVO;
		}
		else{
			return null;
		}
	}
}