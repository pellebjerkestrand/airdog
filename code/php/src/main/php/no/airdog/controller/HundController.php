<?php
require_once "no/airdog/model/AmfHund.php";
require_once "no/airdog/model/AmfAvkom.php";
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/controller/database/HundDatabase.php";
require_once "no/airdog/controller/database/KullDatabase.php";

class HundController
{
	public function __construct()
	{
	}

	public function sokHund($soketekst, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$hd = new HundDatabase();
    	$resultat = $hd->sokHund($soketekst, $brukerEpost, $brukerPassord, $klubbId);

    	$ret = array();
    	
	   	foreach($resultat as $rad)
	   	{    	
			$tmp = new AmfHund();
			$tmp->hundId = $rad["hundId"];
			$tmp->tittel = $rad["tittel"];
			$tmp->navn = $rad["navn"];
			$tmp->bilde = "bilde";
			$tmp->morId = $rad["hundMorId"];
			$tmp->morNavn = $rad["hundMorNavn"];
			$tmp->farId = $rad["hundFarId"];
			$tmp->farNavn = $rad["hundFarNavn"];
			$tmp->oppdretterId = "oppdretterId";
			$tmp->oppdretter = "oppdretter";
			$tmp->eierId = $rad["eierId"];
			$tmp->eier = "eier";
			$tmp->kjonn = $rad["kjonn"];
			$tmp->rase = $rad["raseId"];
			$tmp->kullId = $rad["kullId"];
			$tmp->vf = sprintf("%.1f", $rad["vf"]);
			$ret[] = $tmp;
		}
    	
        return $ret;
    }
    
	public function hentHund($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$hd = new HundDatabase();
    	$rad = $hd->hentHund($hundId, $brukerEpost, $brukerPassord, $klubbId);

		$tmp = new AmfHund();
		$tmp->hundId = $rad["hundId"];
		$tmp->tittel = $rad["tittel"];
		$tmp->navn = $rad["navn"];
		$tmp->bilde = "bilde";
		$tmp->morId = $rad["hundMorId"];
		$tmp->morNavn = $rad["hundMorNavn"];
		$tmp->farId = $rad["hundFarId"];
		$tmp->farNavn = $rad["hundFarNavn"];
		$tmp->oppdretterId = "oppdretterId";
		$tmp->oppdretter = "oppdretter";
		$tmp->eierId = $rad["eierId"];
		$tmp->eier = "eier";
		$tmp->kjonn = $rad["kjonn"];
		$tmp->rase = $rad["raseId"];
		$tmp->kullId = $rad["kullId"];
		$tmp->vf = sprintf("%.1f", $rad["vf"]);
		$ret[] = $tmp;
			
        return $tmp;
    }
    
    public function hentStamtre($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
		$hd = new HundDatabase();	
		$utgangspunkt = $hd->hentHund($hundId, $brukerEpost, $brukerPassord, $klubbId);
		
		if($utgangspunkt != null)
		{
			$tre = array();
				
			//gjør ting for å populere arrayen med hunder utgangspunktet stammer fra,
			//slik at de kan hentes ut og vises som stamtre i frontend
			
			return $tre;
		}
		
		return null;
    }
    
    public function hentAvkom($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$avkomListe = array();
    	$kd = new KullDatabase();
    	
	    $hundListe = $kd->hentAvkom($hundId, $brukerEpost, $brukerPassord, $klubbId);
	    $avkomHundListe = array();
	    
	    foreach($hundListe as $rad)
	   	{    	
			$tmp = new AmfHund();
			$tmp->hundId = $rad["hundId"];
			$tmp->tittel = $rad["tittel"];
			$tmp->navn = $rad["navn"];
			$tmp->bilde = "bilde";
			$tmp->morId = $rad["hundMorId"];
			$tmp->morNavn = $rad["hundMorNavn"];
			$tmp->farId = $rad["hundFarId"];
			$tmp->farNavn = $rad["hundFarNavn"];
			$tmp->eierId = $rad["eierId"];
			$tmp->eier = "eier";
			$tmp->kjonn = $rad["kjonn"];
			$tmp->rase = $rad["raseId"];
			$tmp->kullId = $rad["kullId"];
			$tmp->idNr = $rad["idNr"];
			
			$tmp->hd = $rad["hoftesykdom"];
			
			if ($rad["start"] >> 0)
				$tmp->start = sprintf("%u", $rad["start"]);
				
			if ($rad["jl"] >> 0)	
				$tmp->jl = sprintf("%.1f", $rad["jl"]);
			
			if ($rad["selv"] >> 0)	
				$tmp->selv = sprintf("%.1f", $rad["selv"]);
			
			if ($rad["sok"] >> 0)	
				$tmp->sok = sprintf("%.1f", $rad["sok"]);
			
			if ($rad["vf"] >> 0)	
				$tmp->vf = sprintf("%.1f", $rad["vf"]);
			
			if ($rad["rev"] >> 0)	
				$tmp->rev = sprintf("%.1f", $rad["rev"]);
			
			if ($rad["sam"] >> 0)	
				$tmp->sam = sprintf("%.1f", $rad["sam"]);
			
			
			if (sprintf("%u", $rad["bestPlUk"]) >> 0 && sprintf("%u", $rad["bestPlUk"]) << sprintf("%u", $rad["bestPlAk"]))
			{
				$tmp->bestPl = sprintf("%u", $rad["bestPlUk"]); // . ". UK";
			}
			else if (sprintf("%u", $rad["bestPlAk"]) >> 0)
			{
				$tmp->bestPl = sprintf("%u", $rad["bestPlAk"]) . ". AK";
			}
			else
			{
				$tmp->bestPl = "-";
			}
			
			$avkomFinnes = false;
			
			foreach($avkomListe as $avkom)
			{
				if ($avkom->kullId == $tmp->kullId && 
				($avkom->medId == $tmp->morId || $avkom->medId == $tmp->farId))
				{
					$avkomFinnes = true;
					$avkom->liste[] = $tmp;
				}
			}
			
			if (!$avkomFinnes)
			{
				$avkom = new AmfAvkom();
				
				if ($hundId == $tmp->morId)
				{
					$avkom->med = $tmp->farNavn;
					$avkom->medId = $tmp->farId;
				}
				else
				{
					$avkom->med = $tmp->morNavn;
					$avkom->medId = $tmp->morId;
				}
				$avkom->kullId = $tmp->kullId;
				$avkom->liste = array();
				
				$avkom->liste[] = $tmp;
				
				$avkomListe[] = $avkom;
			}
		}

        return $avkomListe;
    }
    
 	public function hentJaktprove($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$hd = new HundDatabase();
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
}
