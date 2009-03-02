<?php
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/controller/database/JaktproveDatabase.php";
class JaktproveController
{
	public function __construct()
	{
	}
	
	public function slettJaktprove($jaktproveId, $brukerEpost, $brukerPassord, $klubbId)
	{
		$hd = new JaktproveDatabase();
    	$resultat = $hd->slettJaktprove($jaktproveId, $brukerEpost, $brukerPassord, $klubbId);
	}
	
 	public function hentJaktprove($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$hd = new JaktproveDatabase();
    	$resultat = $hd->hentJaktprove($hundId, $brukerEpost, $brukerPassord, $klubbId);

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
			$ret[] = $tmp;
		}
		
        return $ret;
    }
    
    public function redigerJaktprove(AmfJaktprove $jaktprove, $brukerEpost, $brukerPassord, $klubbId)
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
    	$ret['manueltEndretAv'] = $brukerEpost; 	
    	$ret['manueltEndretDato'] = date("yyyy-mm-dd",time());
    	
    	$hd = new JaktproveDatabase();
    	$resultat = $hd->redigerJaktprove($ret, $brukerEpost, $brukerPassord, $klubbId);
    	
    	return $resultat;
    }
}