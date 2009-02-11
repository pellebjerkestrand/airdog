<?php
session_start();
require_once "no/airdog/model/AmfBruker.php";
class BrukerController
{
	public function __construct()
	{
	}
	
	public function loggInn($brukernavn, $passord)
	{
		if($brukernavn == "admin" && $passord == "admin"){
			$_SESSION['bruker'] = 'admin';
			$_SESSION['niva'] = 1;
			return true;
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