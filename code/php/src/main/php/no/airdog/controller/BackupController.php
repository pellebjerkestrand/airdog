<?php

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';
require_once 'database/Backup.php';

class BackupController
{
	private $database;
	private $backup;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
		$this->backup = new Backup();
	}

	public function hentTabeller($brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "administrereBackup"))
		{	
	    	return $this->backup->hentTabeller();
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function hentKopier($brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "administrereBackup"))
		{	
	    	return $this->backup->hentKopier();
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
//	public function lagKopi($tabell, $brukerEpost, $brukerPassord, $klubbId)
//    {
//    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "Administrere backup"))
//		{	
//	    	return $this->backup->lagKopi($tabell);
//		}
//		$feilkode = 1;
//		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
//    }
    
	public function lagFullKopi($navn, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "administrereBackup"))
		{	
	    	return $this->backup->lagFullKopi($navn);
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function hentFiler($mappe, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "administrereBackup"))
		{	
	    	return $this->backup->hentFiler($mappe);
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function lastKopi($tabell, $mappe, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "administrereBackup"))
		{	
	    	return $this->backup->lastKopi($tabell, $mappe);
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function lastKopier($tabeller, $mappe, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "administrereBackup"))
		{	
	    	return $this->backup->lastKopier($tabeller, $mappe);
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
}