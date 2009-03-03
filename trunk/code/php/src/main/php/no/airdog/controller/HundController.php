<?php
require_once "no/airdog/model/AmfHund.php";
require_once "no/airdog/model/AmfAvkom.php";
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
			//$tmp->vf = sprintf("%.1f", $rad["vf"]);
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
			
        return $tmp;
    }
    
	public function hentStamtreHund($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$hd = new HundDatabase();
    	$rad = $hd->hentStamtreHund($hundId, $brukerEpost, $brukerPassord, $klubbId);

    	$tmp = new AmfHund();
    	
    	if ($rad != null)
    	{
			$tmp->hundId = $rad["hundId"];
			$tmp->tittel = $rad["tittel"];
			$tmp->navn = $rad["navn"];
			$tmp->bilde = "bilde";
			$tmp->morId = $rad["hundMorId"];
			$tmp->farId = $rad["hundFarId"];
			$tmp->kjonn = $rad["kjonn"];
    	}
        return $tmp;
    }
    
    public function redigerHund(AmfHund $hund, $brukerEpost, $brukerPassord, $klubbId)
    {
	  	$ret = array();
    	$ret['raseId'] = $hund->raseId;
    	$ret['kullId'] = $hund->kullId;
    	
    	$ret['hundId'] = $hund->hundId;
    	$ret['tittel'] = $hund->tittel;    	 
    	$ret['navn'] = $hund->navn;    	
    	$ret['hundFarId'] = $hund->farId;
    	$ret['hundMorId'] = $hund->morId;   	 
    	$ret['idNr'] = $hund->idNr;   
		$ret['farge'] = $hund->farge;		
    	$ret['fargeVariant'] = $hund->fargeVariant;
    	$ret['oyesykdom'] = $hund->oyesykdom;
    	$ret['hoftesykdom'] = $hund->hoftesykdom;
    	$ret['haarlag'] = $hund->haarlag;
    	$ret['idMerke'] = $hund->idMerke;
    	$ret['kjonn'] = $hund->kjonn;
    	$ret['eierId'] = $hund->eierId;  
    	$ret['endretAv'] = $hund->endretAv;
    	$ret['endretDato'] = $hund->endretDato;
    	$ret['regDato'] = $hund->regDato;
    	$ret['storrelse'] = $hund->storrelse;
    	$ret['manueltEndretAv'] = $hund->manueltEndretAv;
    	$ret['manueltEndretDato'] = $hund->manueltEndretDato;
    	
    	$hd = new HundDatabase();
    	$resultat = $hd->redigerHund($ret, $brukerEpost, $brukerPassord, $klubbId);
    	
    	return true;
    }
    
    public function hentStamtre($hundId, $dybde, $brukerEpost, $brukerPassord, $klubbId)
    {
    	return $this->lagStamtre($hundId, $dybde, $brukerEpost, $brukerPassord, $klubbId);
    }
    
    public function lagStamtre($hundId, $dybde, $brukerEpost, $brukerPassord, $klubbId)
    {
		$hund = $this->hentStamtreHund($hundId, $brukerEpost, $brukerPassord, $klubbId);
				
		if($hund && $dybde > 0)
		{	
			if($hund->farId)
			{
				$hund->far = $this->lagStamtre($hund->farId, $dybde - 1, $brukerEpost, $brukerPassord, $klubbId);
			}

			if($hund->morId)
			{
				$hund->mor = $this->lagStamtre($hund->morId, $dybde - 1, $brukerEpost, $brukerPassord, $klubbId);
			}
		}
		
		return $hund;
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
    
    public function sokArsgjennomsnitt($hund, $ar, $brukerEpost, $brukerPassord, $klubbId)
    {
    	$hd = new HundDatabase();
    	$resultat = $hd->sokArsgjennomsnitt($hund, $ar, $brukerEpost, $brukerPassord, $klubbId);

    	$ret = array();
    	
	   foreach($resultat as $rad) { 
			$tmp = array();
			$tmp["hundId"] = $rad["hundId"];
			$tmp["navn"] = $rad["navn"];
			$tmp["hundFarNavn"] = $rad["hundFarNavn"];
			$tmp["hundFarId"] = $rad["hundFarId"];
			$tmp["hundMorNavn"] = $rad["hundMorNavn"];
			$tmp["hundMorId"] = $rad["hundMorId"];
			
			if ($rad["es"] >> 0)
				$tmp["es"] = sprintf("%.1f", $rad["es"]);
				
			if ($rad["ms"] >> 0)
				$tmp["ms"] = sprintf("%.1f", $rad["ms"]);
				
			if ($rad["vf"] >> 0)
				$tmp["vf"] = sprintf("%.1f", $rad["vf"]);
				
			if ($rad["eso"] >> 0)
				$tmp["eso"] = sprintf("%.1f", $rad["eso"]);
				
			if ($rad["mso"] >> 0)
				$tmp["mso"] = sprintf("%.1f", $rad["mso"]);
				
			if ($rad["ts"] >> 0)
				$tmp["ts"] = sprintf("%.1f", $rad["ts"]);
			
	   		if ($rad["starter"] >> 0)
				$tmp["starter"] = sprintf("%u", $rad["starter"]);
				
			if ($rad["jl"] >> 0)
				$tmp["jl"] = sprintf("%.1f", $rad["jl"]);
				
			if ($rad["fa"] >> 0)
				$tmp["fa"] = sprintf("%.1f", $rad["fa"]);
				
			if ($rad["st"] >> 0)
				$tmp["st"] = sprintf("%.1f", $rad["st"]);
				
			if ($rad["selv"] >> 0)
				$tmp["ss"] = sprintf("%.1f", $rad["selv"]);
				
			if ($rad["sok"] >> 0)
				$tmp["sb"] = sprintf("%.1f", $rad["sok"]);
				
			if ($rad["rev"] >> 0)
				$tmp["rv"] = sprintf("%.1f", $rad["rev"]);
				
			if ($rad["sam"] >> 0)
				$tmp["sa"] = sprintf("%.1f", $rad["sam"]);
			
			if (sprintf("%u", $rad["bestePl"]) >> 0)
			{
				$tmp["bestePl"] = sprintf("%u", $rad["bestePl"]);
			}
			else
			{
				$tmp["bestePl"] = "-";
			}
			
			$ret[] = $tmp;
		}
		
        return $ret;
    }
}
