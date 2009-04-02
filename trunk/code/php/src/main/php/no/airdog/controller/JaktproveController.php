<?php
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/model/AmfJaktproveSammendrag.php";
require_once "no/airdog/controller/database/JaktproveDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class JaktproveController
{
	private $database;
	
	private $klassenavn = array(
		'0' => '',
    	'1' => 'UK',
		'2' => 'AK',
		'3' => 'UK/AK',
		'4' => 'VK',
		'5' => 'VK SEMIFINALE',
		'6' => 'VK FINALE',
		'7' => 'UK KVALIK',
		'8' => 'UKK FINALE',
		'9' => 'DERBY KVALIK',
		'10' => 'DERBY SEMIFINALE',
		'11' => 'DERBY FINALE');
    	
    private $sertifikater = array(
    	'0' => '',
    	'1' => 'CK',
		'2' => 'CERT',
		'3' => 'CACIT',
		'4' => 'R CACIT',
		'5' => 'ÆP SKOG');
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function slettJaktprove($jaktproveId, $hundId, $dato, $brukerEpost, $brukerPassord, $klubbId)
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
    		$tmp->vf = sprintf("%.2f", $sammendrag['vf']);
	    	$tmp->premiegrad = "Viltfinnerevne: " . sprintf("%.2f", $sammendrag['vf']) . ", Situasjoner: " . $sammendrag['situasjoner'];
			$ret[] = $tmp;
						
	        return $ret;
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }

public function hentJaktproveSammendragAar($aar, $brukerEpost, $brukerPassord, $klubbId)
    {	    
    	
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	
			$hd = new JaktproveDatabase();
			
			$sammendrag = $hd->hentJaktproveSammendragAar($aar, $klubbId);
				
			$tmp = new AmfJaktproveSammendrag();	    	
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
    		$tmp->vf = sprintf("%.2f", $sammendrag['vf']);
    		$tmp->premiegrad = sprintf("%.2f", $sammendrag['premiegrad']);		
    		$tmp->starterTotalt = $sammendrag['starterTotalt'];
			    		
   			
    		$tmp->starterUK = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '1');
    		$tmp->starterAK = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '2');
    		$tmp->starterUKAK = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '3');
    		$tmp->starterVK = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '4');
    		$tmp->starterVKSEMIFINALE = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '5');
    		$tmp->starterVKFINALE = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '6');
    		$tmp->starterUKKVALIK = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '7');
    		$tmp->starterUKKFINALE = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '8');
    		$tmp->starterDERBYKVALIK = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '9');
    		$tmp->starterDERBYSEMIFINALE = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '10');
    		$tmp->starterDERBYFINALE = $hd->hentJaktproveSammendragAarKlasser($aar, $klubbId, '11');
    		    		
    		
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
		    	$tmp->premiegradTekst = $this->_hentPremiegrad($rad['premiegrad'], $rad['klasse'], $rad['certifikat'], $rad['proveDato']);
		    	
				$ret[] = $tmp;
			}
			
	        return $ret;
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function hentAlleJaktproverAar($aar, $brukerEpost, $brukerPassord, $klubbId)
    {    		
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	$hd = new JaktproveDatabase();
	    	$resultat = $hd->hentAlleJaktproverAar($aar, $klubbId);
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
		    	$tmp->premiegradTekst = $this->_hentPremiegrad($rad['premiegrad'], $rad['klasse'], $rad['certifikat'], $rad['proveDato']);
		    				
   				$ret[] = $tmp;   							
			}	        
			
			return $ret;
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
    private function _hentPremiegrad($premieGrad, $klasse, $sertifikat, $proveDato)
    {
    	$sert = "";
    	
    	if ($sertifikat != "")
    		$sert = " " . $this->sertifikater[$sertifikat];

    	return $premieGrad . "." . $this->klassenavn[$klasse] . $sert;
    }
    
    public function redigerJaktprove(AmfJaktprove $gammelJaktprove, AmfJaktprove $jaktprove, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerJaktprove"))
		{	
	    	$hd = new JaktproveDatabase();
	    	$hd->redigerJaktprove($gammelJaktprove, $jaktprove, $klubbId);
	    	
	    	return $this->hentJaktprover($jaktprove->hundId, $brukerEpost, $brukerPassord, $klubbId);
    	
    	}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
   	public function leggInnJaktprove(AmfJaktprove $jaktprove, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "leggInnJaktprove"))
		{	
	    	$hd = new JaktproveDatabase();
	    	
	    	//throw(new Exception('Jeg bor i JaktproveController.php', 1));
	    	
	    	$resultat = $hd->leggInnJaktprove($jaktprove, $klubbId);
	    	
	    	return $resultat;
    	}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
}