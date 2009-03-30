<?php
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/controller/database/CupDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class CupController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentCupListe($fra, $til, $limit, $brukerEpost, $brukerPassord, $klubbId)
	{
		if($fra == '' || $til == '')
		{
			throw(new Exception('Fra- og tilfeltene må være fylt ut'));
		}
		
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$jd = new CupDatabase();
			$resultat = $jd->hentCupListeForPeriode($fra, $til);
			
			$ret = array();
			
			foreach($resultat as $rad)
			{
				$tmp = new AmfJaktprove();
				$tmp->proveNr = $rad['proveNr'];   	
		    	$tmp->proveDato = $rad['proveDato']; 
		    	$tmp->partiNr = $rad['partiNr'];   	
		    	$tmp->klasse = $rad['klasse'];
		    	$tmp->dommerId1 = $rad['dommerId1'];   	
		    	$tmp->dommerId2 = $rad['dommerId2'];   	
		    	$tmp->hundId = $rad['hundId'];
		    	$tmp->slippTid = $rad['slippTid'];
		    	$tmp->egneStand = $rad['egneStand']; 	
		    	$tmp->egneStokk = $rad['egneStokk'];
		    	$tmp->tomStand = $rad['tomStand']; 	
		    	$tmp->makkerStand = $rad['makkerStand'];
		    	$tmp->makkerStokk = $rad['makkerStokk']; 	
		    	$tmp->jaktlyst = $rad['jaktlyst'];
		    	$tmp->fart = $rad['fart']; 	
		    	$tmp->stil = $rad['stil'];
		    	$tmp->selvstendighet = $rad['selvstendighet']; 	
		    	$tmp->bredde = $rad['bredde'];
		    	$tmp->reviering = $rad['reviering']; 	
		    	$tmp->samarbeid = $rad['samarbeid'];
		    	$tmp->presUpresis = $rad['presUpresis']; 	
		    	$tmp->presNoeUpresis = $rad['presNoeUpresis'];
		    	$tmp->presPresis = $rad['presPresis']; 	
		    	$tmp->reisNekter = $rad['reisNekter'];
		    	$tmp->reisNoelende = $rad['reisNoelende']; 	
		    	$tmp->reisVillig = $rad['reisVillig'];
		    	$tmp->reisDjerv = $rad['reisDjerv']; 	
		    	$tmp->sokStjeler = $rad['sokStjeler'];
		    	$tmp->sokSpontant = $rad['sokSpontant']; 	
		    	$tmp->appIkkeGodkjent = $rad['appIkkeGodkjent'];
		    	$tmp->appGodkjent = $rad['appGodkjent']; 	
		    	$tmp->rappInnkalt = $rad['rappInnkalt'];
		    	$tmp->rappSpont = $rad['rappSpont']; 	
		    	$tmp->premiegrad = $rad['premiegrad'];
		    	$tmp->certifikat = $rad['certifikat']; 	
		    	$tmp->regAv = $rad['regAv'];
		    	$tmp->regDato = $rad['regDato']; 	
		    	$tmp->raseId = $rad['raseId'];
		    	$tmp->manueltEndretAv = $rad['manueltEndretAv']; 	
		    	$tmp->manueltEndretDato = $rad['manueltEndretDato'];
		    	$tmp->kritikk = $rad['kritikk'];
				
				$ret[] = $tmp;
			}
			return $ret;
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
}