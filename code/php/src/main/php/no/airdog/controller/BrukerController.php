<?php
require_once "no/airdog/model/AmfBruker.php";
session_start();
class BrukerController
{
	public function __construct()
	{
	}
	
	public function loggInn($brukernavn, $passord)
	{
		return true;
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