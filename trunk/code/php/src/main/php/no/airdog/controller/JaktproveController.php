<?php
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/controller/database/JaktproveDatabase.php";
class JaktproveController
{
	public function __construct()
	{
	}
	
 	public function hentJaktprove($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$hd = new JaktproveDatabase();
    	$resultat = $hd->sokJaktprove($hundId, $brukerEpost, $brukerPassord, $klubbId);

    	$ret = array();
    	
	   foreach($resultat as $rad) { 
			$tmp = new AmfJaktprove();
			$tmp->proveNr = $rad["proveNr"];
			$tmp->proveDato = $rad["proveDato"];
			$tmp->premiegrad = $rad["premiegrad"];
			$tmp->slippTid = $rad["slippTid"];
			$tmp->egneStand = $rad["egneStand"];
			$tmp->makkerStand = $rad["makkerStand"];
			$tmp->egneStokk = $rad["egneStokk"];
			$tmp->makkerStokk = $rad["makkerStokk"];
			$tmp->tomStand = $rad["tomStand"];
			$tmp->jaktlyst = $rad["jaktlyst"];
			$tmp->fart = $rad["fart"];
			$tmp->stil = $rad["stil"];
			$tmp->selvstendighet = $rad["selvstendighet"];
			$tmp->bredde = $rad["bredde"];
			$tmp->reviering = $rad["reviering"];
			$tmp->samarbeid = $rad["samarbeid"];
			$ret[] = $tmp;
		}
		
        return $ret;
    }
    
    public function lagreJaktprove(AmfJaktprove $jaktprove, $brukerEpost, $brukerPassord, $klubbId)
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
    	
    	$hd = new JaktproveDatabase();
    	$resultat = $hd->lagreJaktprove($ret, $brukerEpost, $brukerPassord, $klubbId);
    	
    	return $resultat;
    }
}