<?php
require_once "no/airdog/model/AmfPerson.php";
require_once "no/airdog/controller/database/PersonDatabase.php";

require_once 'database/Tilkobling.php';

class PersonController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentPerson($personId, $brukerEpost, $brukerPassord, $klubbId)
    {
//    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Lese"))
//		{	
	    	$pd = new PersonDatabase();
	    	$rad = $pd->hentPerson($personId, $klubbId);
			
			$tmp = new AmfPerson();
			$tmp->personId = $rad["personId"];
			$tmp->navn = $rad["navn"];
				
	        return $tmp;
//		}
//		$feilkode = 1;
//		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
}