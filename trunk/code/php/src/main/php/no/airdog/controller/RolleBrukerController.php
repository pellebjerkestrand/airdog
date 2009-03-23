<?php
require_once "database/RolleBrukerDatabase.php";
require_once "database/ACLDatabase.php";
require_once "database/RolleRettighetDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class RolleBrukerController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleBrukere($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$db = new RolleBrukerDatabase();
			return $db->hentAlleBrukere();
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function hentRollersBrukere($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$dbACL = new ACLDatabase();
			
			$db = new RolleBrukerDatabase();
			
			$dbRR = new RolleRettighetDatabase();			

   			$tempRoller = array();
   			$roller = $dbRR->hentAlleRoller();
   			
   			foreach($roller as $rolle)
   			{
   				$rolle['brukere'] = $db->hentRollesBrukere($rolle['navn'], $klubbId);
   				$tmp[] = $rolle;
   			}
			
			return $tmp;
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function leggBrukerTilRolle($rolle, $bruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			
			$db = new RolleBrukerDatabase();
			$db->leggBrukerTilRollePaKlubb($klubbId, $rolle, $bruker);
			
			return $this->hentRollersBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	
	public function slettBrukerFraRolle($rolle, $bruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$db = new RolleBrukerDatabase();
			$db->slettBrukerFraRollePaKlubb($klubbId, $rolle, $bruker);
			
			return $this->hentRollersBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function slettBruker($epost, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$db = new RolleBrukerDatabase();
			$db->slettBruker($epost);
			
			return $this->hentAlleBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
		
	}
	
	public function leggInnBruker($bruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{		
			$ret = array();
	    	$ret['epost'] = $bruker->epost;
	    	$ret['fornavn'] = $bruker->fornavn;
	    	$ret['etternavn'] = $bruker->etternavn;
	    	$ret['passord'] = $bruker->passord;
	    	$ret['superadmin'] = $bruker->superadmin;  	

			$db = new RolleBrukerDatabase();
			$db->leggInnBruker($ret);
			
			return $this->hentAlleBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
		
	}
	
	public function redigerBruker($fraBruker, $tilBruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$fra = array();
	    	$fra['epost'] = $fraBruker->epost;
	    	$fra['fornavn'] = $fraBruker->fornavn;
	    	$fra['etternavn'] = $fraBruker->etternavn;
	    	$fra['superadmin'] = $fraBruker->superadmin; 
	    	
	    	$til = array();
	    	$til['epost'] = $tilBruker->epost;
	    	$til['fornavn'] = $tilBruker->fornavn;
	    	$til['etternavn'] = $tilBruker->etternavn;
	    	$til['passord'] = $tilBruker->passord;
	    	$til['superadmin'] = $tilBruker->superadmin; 	

			$db = new RolleBrukerDatabase();
			$db->redigerBruker($fra, $til);
			
			return $this->hentAlleBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
}
