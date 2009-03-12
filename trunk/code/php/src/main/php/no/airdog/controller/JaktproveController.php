<?php
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/controller/database/JaktproveDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class JaktproveController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function slettJaktprove($jaktproveId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "slettJaktprove"))
		{
			$hd = new JaktproveDatabase();
    		return $hd->slettJaktprove($jaktproveId, $klubbId);
		}
		
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function hentJaktproveSammendrag($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
	    if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	$hd = new JaktproveDatabase();
			
			$sammendrag = $hd->hentJaktproveSammendrag($hundId, $klubbId);
			
			$tmp = new AmfJaktprove();	    	
	    	$tmp->slippTid = sprintf("%u", $sammendrag['slippTid']);
	    	$tmp->egneStand = $sammendrag['egneStand']; 	
	    	$tmp->egneStokk = $sammendrag['egneStokk'];
	    	$tmp->tomStand = $sammendrag['tomStand']; 	
	    	$tmp->makkerStand = $sammendrag['makkerStand'];
	    	$tmp->makkerStokk = $sammendrag['makkerStokk']; 	
	    	$tmp->jaktlyst = sprintf("%.2f", $sammendrag['jaktlyst']);
	    	$tmp->fart = sprintf("%.2f", $sammendrag['fart']); 	
	    	$tmp->stil = sprintf("%.2f", $sammendrag['stil']);
	    	$tmp->selvstendighet = sprintf("%.2f", $sammendrag['selvstendighet']); 	
	    	$tmp->bredde = sprintf("%.2f", $sammendrag['bredde']);
	    	$tmp->reviering = sprintf("%.2f", $sammendrag['reviering']); 	
	    	$tmp->samarbeid = sprintf("%.2f", $sammendrag['samarbeid']);
    		
	    	$tmp->premiegrad = "VF: " . sprintf("%.2f", $sammendrag['vf']) . ", Situasjoner: " . $sammendrag['situasjoner'];
			$ret[] = $tmp;
			
	        return $ret;
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
		
 	public function hentJaktprover($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	$hd = new JaktproveDatabase();
	    	$resultat = $hd->hentJaktprover($hundId, $klubbId);
	
    		$ret = array();
	    	
		   	foreach($resultat as $rad) { 
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
    
    public function redigerJaktprove(AmfJaktprove $jaktprove, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerJaktprove"))
		{
	    	$ret = array();
	    	$ret['proveNr'] = $jaktprove->proveNr;   	
	    	$ret['proveDato'] = $jaktprove->proveDato; 
	    	$ret['partiNr'] = $jaktprove->partiNr;   	
	    	$ret['klasse'] = $jaktprove->klasse;
	    	$ret['dommerId1'] = $jaktprove->dommerId1;   	
	    	$ret['dommerId2'] = $jaktprove->dommerId2;   	
	    	$ret['hundId'] = $jaktprove->hundId;
	    	$ret['slippTid'] = $jaktprove->slippTid;
	    	$ret['egneStand'] = $jaktprove->egneStand; 	
	    	$ret['egneStokk'] = $jaktprove->egneStokk;
	    	$ret['tomStand'] = $jaktprove->tomStand; 	
	    	$ret['makkerStand'] = $jaktprove->makkerStand;
	    	$ret['makkerStokk'] = $jaktprove->makkerStokk; 	
	    	$ret['jaktlyst'] = $jaktprove->jaktlyst;
	    	$ret['fart'] = $jaktprove->fart; 	
	    	$ret['stil'] = $jaktprove->stil;
	    	$ret['selvstendighet'] = $jaktprove->selvstendighet; 	
	    	$ret['bredde'] = $jaktprove->bredde;
	    	$ret['reviering'] = $jaktprove->reviering; 	
	    	$ret['samarbeid'] = $jaktprove->samarbeid;
	    	$ret['presUpresis'] = $jaktprove->presUpresis; 	
	    	$ret['presNoeUpresis'] = $jaktprove->presNoeUpresis;
	    	$ret['presPresis'] = $jaktprove->presPresis; 	
	    	$ret['reisNekter'] = $jaktprove->reisNekter;
	    	$ret['reisNoelende'] = $jaktprove->reisNoelende; 	
	    	$ret['reisVillig'] = $jaktprove->reisVillig;
	    	$ret['reisDjerv'] = $jaktprove->reisDjerv; 	
	    	$ret['sokStjeler'] = $jaktprove->sokStjeler;
	    	$ret['sokSpontant'] = $jaktprove->sokSpontant; 	
	    	$ret['appIkkeGodkjent'] = $jaktprove->appIkkeGodkjent;
	    	$ret['appGodkjent'] = $jaktprove->appGodkjent; 	
	    	$ret['rappInnkalt'] = $jaktprove->rappInnkalt;
	    	$ret['rappSpont'] = $jaktprove->rappSpont; 	
	    	$ret['premiegrad'] = $jaktprove->premiegrad;
	    	$ret['certifikat'] = $jaktprove->certifikat; 	
	    	$ret['regAv'] = $jaktprove->regAv;
	    	$ret['regDato'] = $jaktprove->regDato; 	
	    	$ret['raseId'] = $jaktprove->raseId;
	    	$ret['manueltEndretAv'] = $jaktprove->manueltEndretAv; 	
	    	$ret['manueltEndretDato'] = $jaktprove->manueltEndretDato;
	    	$ret['kritikk'] = $jaktprove->kritikk;
	    	
	    	$hd = new JaktproveDatabase();
	    	$resultat = $hd->redigerJaktprove($ret, $klubbId);
	    	
	    	return $resultat;
    	
    	}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
   	public function leggInnJaktprove(AmfJaktprove $jaktprove, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerJaktprove"))
		{	
	    	$ret = array();
	    	$ret['proveNr'] = $jaktprove->proveNr;   	
	    	$ret['proveDato'] = $jaktprove->proveDato; 
	    	$ret['partiNr'] = $jaktprove->partiNr;   	
	    	$ret['klasse'] = $jaktprove->klasse;
	    	$ret['dommerId1'] = $jaktprove->dommerId1;   	
	    	$ret['dommerId2'] = $jaktprove->dommerId2;   	
	    	$ret['hundId'] = $jaktprove->hundId;
	    	$ret['slippTid'] = $jaktprove->slippTid;
	    	$ret['egneStand'] = $jaktprove->egneStand; 	
	    	$ret['egneStokk'] = $jaktprove->egneStokk;
	    	$ret['tomStand'] = $jaktprove->tomStand; 	
	    	$ret['makkerStand'] = $jaktprove->makkerStand;
	    	$ret['makkerStokk'] = $jaktprove->makkerStokk; 	
	    	$ret['jaktlyst'] = $jaktprove->jaktlyst;
	    	$ret['fart'] = $jaktprove->fart; 	
	    	$ret['stil'] = $jaktprove->stil;
	    	$ret['selvstendighet'] = $jaktprove->selvstendighet; 	
	    	$ret['bredde'] = $jaktprove->bredde;
	    	$ret['reviering'] = $jaktprove->reviering; 	
	    	$ret['samarbeid'] = $jaktprove->samarbeid;
	    	$ret['presUpresis'] = $jaktprove->presUpresis; 	
	    	$ret['presNoeUpresis'] = $jaktprove->presNoeUpresis;
	    	$ret['presPresis'] = $jaktprove->presPresis; 	
	    	$ret['reisNekter'] = $jaktprove->reisNekter;
	    	$ret['reisNoelende'] = $jaktprove->reisNoelende; 	
	    	$ret['reisVillig'] = $jaktprove->reisVillig;
	    	$ret['reisDjerv'] = $jaktprove->reisDjerv; 	
	    	$ret['sokStjeler'] = $jaktprove->sokStjeler;
	    	$ret['sokSpontant'] = $jaktprove->sokSpontant; 	
	    	$ret['appIkkeGodkjent'] = $jaktprove->appIkkeGodkjent;
	    	$ret['appGodkjent'] = $jaktprove->appGodkjent; 	
	    	$ret['rappInnkalt'] = $jaktprove->rappInnkalt;
	    	$ret['rappSpont'] = $jaktprove->rappSpont; 	
	    	$ret['premiegrad'] = $jaktprove->premiegrad;
	    	$ret['certifikat'] = $jaktprove->certifikat; 	
	    	$ret['regAv'] = $jaktprove->regAv; 	
	    	$ret['regDato'] = $jaktprove->regDato;
	    	$ret['raseId'] = $jaktprove->raseId;
	    	$ret['manueltEndretAv'] = $jaktprove->manueltEndretAv;
	    	$ret['manueltEndretDato'] = $jaktprove->manueltEndretDato;
	    	$ret['kritikk'] = $jaktprove->kritikk;
	    	
	    	$hd = new JaktproveDatabase();
	    	$resultat = $hd->leggInnJaktprove($ret, $klubbId);
	    	
	    	return $resultat;
    	}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
}