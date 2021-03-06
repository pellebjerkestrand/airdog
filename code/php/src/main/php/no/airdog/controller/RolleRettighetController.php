<?php
require_once "database/RolleRettighetDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class RolleRettighetController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleRettigheter($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "rolleRettighetHandtering"))
		{
			$db = new RolleRettighetDatabase();
			return $db->hentAlleRettigheter();
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));

		return true;
	}
	
	public function hentRollersRettigheter($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "rolleRettighetHandtering"))
		{
			$db = new RolleRettighetDatabase();
			$roller = $db->hentAlleRoller();
			$tmp = array();

	   		foreach($roller as $rolle)
	   		{   
	   			$rolle['rettigheter'] = $db->hentRollersRettigheter($rolle['navn']);
	   			$tmp[] = $rolle;
	   		}
			
			return $tmp;
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function leggtilRettighetPaRolle($rolle, $rettighet, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "rolleRettighetHandtering"))
		{
			$db = new RolleRettighetDatabase();
			$db->leggtilRettighetPaRolle($rolle, $rettighet);
			
			return $this->hentRollersRettigheter($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function slettRettighetPaRolle($rolle, $rettighet, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "rolleRettighetHandtering"))
		{
			$db = new RolleRettighetDatabase();
			$db->slettRettighetPaRolle($rolle, $rettighet);
			
			return $this->hentRollersRettigheter($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function leggInnNyRolle($rolle, $beskrivelse, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "rolleRettighetHandtering"))
		{
			$db = new RolleRettighetDatabase();
			$db->leggInnNyRolle($rolle, $beskrivelse);
			
			return $this->hentRollersRettigheter($brukerEpost, $brukerPassord, $klubbId);
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function slettRolle($rolle, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "rolleRettighetHandtering"))
		{
			$db = new RolleRettighetDatabase();
			if($db->slettRolle($rolle))
			{
				return $this->hentRollersRettigheter($brukerEpost, $brukerPassord, $klubbId);
			}
			
		}

		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	
}
