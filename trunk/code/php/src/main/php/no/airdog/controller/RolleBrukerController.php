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
	
	public function hentKlubbersRollersBrukere($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$dbACL = new ACLDatabase();
			$klubber = $dbACL->hentAlleKlubber();
			
			$db = new RolleBrukerDatabase();
			
			$dbRR = new RolleRettighetDatabase();			

	   		foreach($klubber as $klubb)
	   		{
	   			if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubb['raseid'], "Rollehåndtering"))
				{	   
		   			$tempRoller = array();
		   			$roller['roller'] = $dbRR->hentAlleRoller();
		   			
		   			foreach($roller['roller'] as $rolle)
		   			{
		   				$rolle['brukere'] = $db->hentRollesBrukere($rolle['navn'], $klubb['raseid']);
		   				$tempRoller[] = $rolle;
		   			}
		   			
		   			$klubb['roller'] = $tempRoller;
		   			$tmp[] = $klubb;
				}
	   		}
			
			return $tmp;
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function leggBrukerTilRollePaKlubb($klubb, $rolle, $bruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$db = new RolleBrukerDatabase();
			$db->leggBrukerTilRollePaKlubb($klubb, $rolle, $bruker);
			
			return $this->hentKlubbersRollersBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	
	public function slettBrukerFraRollePaKlubb($klubb, $rolle, $bruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{
			$db = new RolleBrukerDatabase();
			$db->slettBrukerFraRollePaKlubb($klubb, $rolle, $bruker);
			
			return $this->hentKlubbersRollersBrukere($brukerEpost, $brukerPassord, $klubbId);
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
	    	$ret['passord'] = $bruker->etternavn;
	    	$ret['superadmin'] = $bruker->superadmin;  	

			$db = new RolleBrukerDatabase();
			$db->leggInnBruker($ret);
			
			return $this->hentAlleBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
		
	}
	
	public function redigerBruker($bruker, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Rollehåndtering"))
		{		
			$ret = array();
	    	$ret['epost'] = $bruker->epost;
	    	$ret['fornavn'] = $bruker->fornavn;
	    	$ret['etternavn'] = $bruker->etternavn;
	    	$ret['passord'] = $bruker->etternavn;
	    	$ret['superadmin'] = $bruker->superadmin;  	

			$db = new RolleBrukerDatabase();
			$db->redigerBruker($ret);
			
			return $this->hentAlleBrukere($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
		
	}
	

}
