<?php
require_once "no/airdog/model/AmfArrangement.php";
require_once "no/airdog/controller/database/ArrangementDatabase.php";
require_once "no/airdog/controller/Verktoy.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class ArrangementController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
    
	public function leggInnArrangement(AmfArrangement $arrangement, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "arrangementer"))
		{	
			$rad = array();
	   		$rad['proveNr'] = $arrangement->proveNr;
	   		$rad['sted'] = $arrangement->sted;
	   		$rad['navn'] = $arrangement->navn;
		   	
	    	$hd = new ArrangementDatabase();
	    	
	    	return $hd->settInn($rad);   	
		}
		
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
    public function hentArrangementer($brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "arrangementer"))
		{	
	    	$hd = new ArrangementDatabase();
	    	
	    	$resultat =  $hd->hentArrangementer();   

	    	$ret = array();
	    	
	    	foreach($resultat as $rad)
		   	{   
		   		$tmp = new AmfArrangement();
		   		$tmp->proveNr = $rad['proveNr'];
		   		$tmp->sted = $rad['sted'];
		   		$tmp->navn = $rad['navn'];
		   		
		   		$ret[] = $tmp;
		   	}
		   	
		   	return $ret;
		}
		
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function hentArrangement($proveNr, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "arrangementer"))
		{	
	    	$hd = new ArrangementDatabase();
	    	
	    	$rad = $hd->hentArrangement($proveNr); 

	    	$tmp = new AmfArrangement();
	   		$tmp->proveNr = $rad['proveNr'];
	   		$tmp->sted = $rad['sted'];
	   		$tmp->navn = $rad['navn'];
	   		
	   		return $tmp;
		}
		
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
    public function slettArrangement($proveNr, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "arrangementer"))
		{	
	    	$hd = new ArrangementDatabase();
	    	
	    	return $hd->slettArrangement($proveNr);   	
		}
		
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
}