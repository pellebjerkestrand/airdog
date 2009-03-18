<?php
require_once "no/airdog/model/AmfUtstilling.php";
require_once "no/airdog/controller/database/UtstillingDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class UtstillingController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function slettUtstilling($utstillingId, $brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "slettUtstilling"))
		{
			$hd = new UtstillingDatabase();
    		return $hd->slettUtstilling($utstillingId, $klubbId);
		}
		
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	public function hentUtstillingSammendrag($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
	    if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	$hd = new UtstillingDatabase();
			
			$sammendrag = $hd->hentUtstillingSammendrag($hundId, $klubbId);
			
			$tmp = new AmfUtstilling();	    	
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
    		
	    	$tmp->premiegrad = "Viltfinnerevne: " . sprintf("%.2f", $sammendrag['vf']) . ", Situasjoner: " . $sammendrag['situasjoner'];
			$ret[] = $tmp;
			
	        return $ret;
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
		
 	public function hentUtstillinger($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	$hd = new UtstillingDatabase();
	    	$resultat = $hd->hentUtstillinger($hundId, $klubbId);
	
    		$ret = array();
	    	
		   	foreach($resultat as $rad) { 
		   		$tmp = new AmfUtstilling();
		    	$tmp->utstillingId = $rad['utstillingId'];   
		    	$tmp->klasseId = $rad['klasseId'];   	
		    	$tmp->personId = $rad['personId'];   	
		    	$tmp->regDato = $rad['regDato'];   	
		    	$tmp->regAv = $rad['regAv'];   	
		    	$tmp->navn = $rad['navn'];   	
		    	$tmp->adresse1 = $rad['adresse1'];   	
		    	$tmp->adresse2 = $rad['adresse2'];   	
		    	$tmp->postNr = $rad['postNr'];     	
		    	$tmp->spesialAdresse = $rad['spesialAdresse'];   	
		    	$tmp->utstillingDato = $rad['utstillingDato'];   	
		    	$tmp->utstillingSted = $rad['utstillingSted'];   	
		    	$tmp->arrangorNavn1 = $rad['arrangorNavn1'];   	
		    	$tmp->arrangorNavn2 = $rad['arrangorNavn2'];   	
		    	$tmp->overfortDato = $rad['overfortDato'];   		
		    	$tmp->manueltEndretAv = $rad['manueltEndretAv']; 	
		    	$tmp->manueltEndretDato = $rad['manueltEndretDato'];
		    	$tmp->raseId = $rad['raseId'];
		    	
		    	$tmp->doId = $rad['doId'];
		    	$tmp->hundId = $rad['hundId'];
		    	$tmp->katalogNr = $rad['katalogNr'];
		    	$tmp->personIdDommer = $rad['personIdDommer'];
		    	$tmp->klasse = $rad['klasse'];
		    	$tmp->kjonn = $rad['kjonn'];
		    	$tmp->IM = $rad['IM'];
		    	$tmp->KIP = $rad['KIP'];
		    	$tmp->JK = $rad['JK'];
		    	$tmp->JKK = $rad['JKK'];
		    	$tmp->UK = $rad['UK'];
		    	$tmp->UKK = $rad['UKK'];
		    	$tmp->BK = $rad['BK'];
		    	$tmp->BKK = $rad['BKK'];
		    	$tmp->AK = $rad['AK'];
		    	$tmp->AKK = $rad['AKK'];
		    	$tmp->VK = $rad['VK'];
		    	$tmp->CHK = $rad['CHK'];
		    	$tmp->CHKK = $rad['CHKK'];
		    	$tmp->VTK = $rad['VTK'];
		    	$tmp->VTKK = $rad['VTKK'];
		    	$tmp->HP = $rad['HP'];
		    	$tmp->CK = $rad['CK'];
		    	$tmp->CC = $rad['CC'];
		    	$tmp->CA = $rad['CA'];
		    	$tmp->BIK = $rad['BIK'];
		    	$tmp->BIR = $rad['BIR'];
		    	$tmp->BIM = $rad['BIM'];
		    	
		    	$tmp->CERT = "-";
		    	$tmp->CK = "-";
		    	$tmp->CACIB = "-";
		    	$tmp->BHK = "-";
		    	
		    	if ($rad['CC'] == "1")
		    		$tmp->CERT = "X";
	    		else if ($rad['CC'] == "2")
		    		$tmp->CK = "X";
		    	
	    		if ($rad['CA'] == "1")
		    		$tmp->CACIB = "CACIB";
		    	else if ($rad['CA'] == "2")
		    		$tmp->CACIB = "RES CACIB";
		    		
	    		if ($tmp->kjonn = "H")
	    		{
	    			$tmp->BHK = $rad['BIK'];
	    			$tmp->BTK = "-";
	    		}
    			else
    			{
	    			$tmp->BTK = $rad['BIK'];	
	    			$tmp->BHK = "-";
    			}
    			
    			if ($tmp->klasse == "C" && $tmp->premie)
    			
/*HVIS Klasse == 'C' og premie == 7 : så er premien KIP
ELLERS HVIS premie == 4 : så er premien KIP
ELLERS HVIS premie == 6 : så er "premien" PLASS
ELLERS premie = premie OG
klasse =
J for JK
U for AUK
A for AK
C for CHK
V for VETK
B for BK*/
		    	
				$ret[] = $tmp;
			}
			
	        return $ret;
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
    public function redigerUtstilling(AmfUtstilling $utstilling, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerUtstilling"))
		{
	    	$ret = array();
	    	$ret['utstillingId'] = $utstilling->utstillingId;
	    	$ret['klasseId'] = $utstilling->klasseId;
	    	$ret['personId'] = $utstilling->personId;
	    	$ret['regDato'] = $utstilling->regDato;
	    	$ret['regAv'] = $utstilling->regAv;
	    	$ret['navn'] = $utstilling->navn;
	    	$ret['adresse1'] = $utstilling->adresse1;
	    	$ret['adresse2'] = $utstilling->adresse2;
	    	$ret['postNr'] = $utstilling->postNr;
	    	$ret['spesialAdresse'] = $utstilling->spesialAdresse;
	    	$ret['utstillingDato'] = $utstilling->utstillingDato;
	    	$ret['utstillingSted'] = $utstilling->utstillingSted;
	    	$ret['arrangorNavn1'] = $utstilling->arrangorNavn1;
	    	$ret['arrangorNavn2'] = $utstilling->arrangorNavn2;
	    	$ret['overfortDato'] = $utstilling->overfortDato;
	    	$ret['manueltEndretAv'] = $utstilling->manueltEndretAv;
	    	$ret['manueltEndretDato'] = $utstilling->manueltEndretDato; 
	    	$ret['raseId'] = $utstilling->raseId;   	
	    	
	    	$hd = new UtstillingDatabase();
	    	$resultat = $hd->redigerUtstilling($ret, $klubbId);
	    	
	    	return $resultat;
    	
    	}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
   	public function leggInnUtstilling(AmfUtstilling $utstilling, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerUtstilling"))
		{	
	    	$ret = array();
	    	$ret['utstillingId'] = $utstilling->utstillingId;
	    	$ret['klasseId'] = $utstilling->klasseId;
	    	$ret['personId'] = $utstilling->personId;
	    	$ret['regDato'] = $utstilling->regDato;
	    	$ret['regAv'] = $utstilling->regAv;
	    	$ret['navn'] = $utstilling->navn;
	    	$ret['adresse1'] = $utstilling->adresse1;
	    	$ret['adresse2'] = $utstilling->adresse2;
	    	$ret['postNr'] = $utstilling->postNr;
	    	$ret['spesialAdresse'] = $utstilling->spesialAdresse;
	    	$ret['utstillingDato'] = $utstilling->utstillingDato;
	    	$ret['utstillingSted'] = $utstilling->utstillingSted;
	    	$ret['arrangorNavn1'] = $utstilling->arrangorNavn1;
	    	$ret['arrangorNavn2'] = $utstilling->arrangorNavn2;
	    	$ret['overfortDato'] = $utstilling->overfortDato;
	    	$ret['manueltEndretAv'] = $utstilling->manueltEndretAv;
	    	$ret['manueltEndretDato'] = $utstilling->manueltEndretDato; 
	    	$ret['raseId'] = $utstilling->raseId;
	    	
	    	$hd = new UtstillingDatabase();
	    	$resultat = $hd->leggInnUtstilling($ret, $klubbId);
	    	
	    	return $resultat;
    	}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }   
}