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
    		return $hd->slettJaktprove($jaktproveId, $hundId, $dato, $klubbId);
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
	    	$tmp->jaktlyst = number_format($sammendrag['jaktlyst'], 2, ',', '');
	    	$tmp->fart = number_format($sammendrag['fart'], 2, ',', '');	
	    	$tmp->stil = number_format($sammendrag['stil'], 2, ',', '');
	    	$tmp->selvstendighet = number_format($sammendrag['selvstendighet'], 2, ',', ''); 	
	    	$tmp->bredde = number_format($sammendrag['bredde'], 2, ',', '');
	    	$tmp->reviering = number_format($sammendrag['reviering'], 2, ',', ''); 	
	    	$tmp->samarbeid = number_format($sammendrag['samarbeid'], 2, ',', '');
    		$tmp->vf = number_format($sammendrag['vf'], 2, ',', '');
    		$tmp->premiegrad = number_format($sammendrag['premiegrad'], 2, ',', '');	
    		$tmp->starterTotalt = $sammendrag['starterTotalt'];	
    		
    		
			//klasser  		
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
			//premier

			$tmp->starterTotaltForste = $hd->hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, '1');
    		$tmp->starterUKForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '1', '1');
    		$tmp->starterAKForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '2', '1');
    		$tmp->starterUKAKForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '3', '1');
    		$tmp->starterVKForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '4', '1');
    		$tmp->starterVKSEMIFINALEForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '5', '1');
    		$tmp->starterVKFINALEForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '6', '1');
    		$tmp->starterUKKVALIKForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '7', '1');
    		$tmp->starterUKKFINALEForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '8', '1');
    		$tmp->starterDERBYKVALIKForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '9', '1');
    		$tmp->starterDERBYSEMIFINALEForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '10', '1');
    		$tmp->starterDERBYFINALEForste = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '11', '1');

			$tmp->starterTotaltAndre = $hd->hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, '2');
    		$tmp->starterUKAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '1', '2');
    		$tmp->starterAKAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '2', '2');
    		$tmp->starterUKAKAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '3', '2');
    		$tmp->starterVKAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '4', '2');
    		$tmp->starterVKSEMIFINALEAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '5', '2');
    		$tmp->starterVKFINALEAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '6', '2');
    		$tmp->starterUKKVALIKAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '7', '2');
    		$tmp->starterUKKFINALEAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '8', '2');
    		$tmp->starterDERBYKVALIKAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '9', '2');
    		$tmp->starterDERBYSEMIFINALEAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '10', '2');
    		$tmp->starterDERBYFINALEAndre = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '11', '2');

			$tmp->starterTotaltTredje = $hd->hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, '3');
    		$tmp->starterUKTredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '1', '3');
    		$tmp->starterAKTredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '2', '3');
    		$tmp->starterUKAKTredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '3', '3');
    		$tmp->starterVKTredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '4', '3');
    		$tmp->starterVKSEMIFINALETredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '5', '3');
    		$tmp->starterVKFINALETredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '6', '3');
    		$tmp->starterUKKVALIKTredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '7', '3');
    		$tmp->starterUKKFINALETredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '8', '3');
    		$tmp->starterDERBYKVALIKTredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '9', '3');
    		$tmp->starterDERBYSEMIFINALETredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '10', '3');
    		$tmp->starterDERBYFINALETredje = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '11', '3');
    		
    		$tmp->starterTotaltFjerde = $hd->hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, '4');
    		$tmp->starterUKFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '1', '4');
    		$tmp->starterAKFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '2', '4');
    		$tmp->starterUKAKFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '3', '4');
    		$tmp->starterVKFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '4', '4');
    		$tmp->starterVKSEMIFINALEFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '5', '4');
    		$tmp->starterVKFINALEFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '6', '4');
    		$tmp->starterUKKVALIKFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '7', '4');
    		$tmp->starterUKKFINALEFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '8', '4');
    		$tmp->starterDERBYKVALIKFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '9', '4');
    		$tmp->starterDERBYSEMIFINALEFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '10', '4');
    		$tmp->starterDERBYFINALEFjerde = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '11', '4');
    		    		    		
    		$tmp->starterTotaltFemte = $hd->hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, '5');
    		$tmp->starterUKFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '1', '5');
    		$tmp->starterAKFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '2', '5');
    		$tmp->starterUKAKFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '3', '5');
    		$tmp->starterVKFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '4', '5');
    		$tmp->starterVKSEMIFINALEFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '5', '5');
    		$tmp->starterVKFINALEFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '6', '5');
    		$tmp->starterUKKVALIKFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '7', '5');
    		$tmp->starterUKKFINALEFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '8', '5');
    		$tmp->starterDERBYKVALIKFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '9', '5');
    		$tmp->starterDERBYSEMIFINALEFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '10', '5');
    		$tmp->starterDERBYFINALEFemte = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '11', '5');
    		
    		$tmp->starterTotaltSjette = $hd->hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, '6');
    		$tmp->starterUKSjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '1', '6');
    		$tmp->starterAKSjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '2', '6');
    		$tmp->starterUKAKSjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '3', '6');
    		$tmp->starterVKSjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '4', '6');
    		$tmp->starterVKSEMIFINALESjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '5', '6');
    		$tmp->starterVKFINALESjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '6', '6');
    		$tmp->starterUKKVALIKSjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '7', '6');
    		$tmp->starterUKKFINALESjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '8', '6');
    		$tmp->starterDERBYKVALIKSjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '9', '6');
    		$tmp->starterDERBYSEMIFINALESjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '10', '6');
    		$tmp->starterDERBYFINALESjette = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '11', '6');
    		
	   		$tmp->starterTotaltUpremiert = $hd->hentJaktproveSammendragAarStarterTotaltPremie($aar, $klubbId, '0');
    		$tmp->starterUKUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '1', '0');
    		$tmp->starterAKUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '2', '0');
    		$tmp->starterUKAKUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '3','0');
    		$tmp->starterVKUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '4','0');
    		$tmp->starterVKSEMIFINALEUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '5','0');
    		$tmp->starterVKFINALEUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '6','0');
    		$tmp->starterUKKVALIKUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '7','0');
    		$tmp->starterUKKFINALEUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '8','0');
    		$tmp->starterDERBYKVALIKUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '9','0');
    		$tmp->starterDERBYSEMIFINALEUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '10','0');
    		$tmp->starterDERBYFINALEUpremiert = $hd->hentJaktproveSammendragAarStarterKlasserPremie($aar, $klubbId, '11','0');
    		
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
		    	
		    	$tmp->sted = $rad['sted'];
		    	$tmp->navn = $rad['navn'];
		    	
		    	if ($rad['sted'] != "")
		    		$tmp->proveTekst = $rad['sted'] . ' ' . $rad['navn'];
	    		else
		    		$tmp->proveTekst = $rad['proveNr'];
		    		
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
		    	
		    	$tmp->sted = $rad['sted'];
		    	$tmp->navn = $rad['navn'];
		    	
		    	if ($rad['sted'] != "")
		    		$tmp->proveTekst = $rad['sted'] . ' ' . $rad['navn'];
	    		else
		    		$tmp->proveTekst = $rad['proveNr'];
		    				
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
	    	
	    	$resultat = $hd->leggInnJaktprove($jaktprove, $klubbId);
	    	
	    	return $resultat;
    	}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
}