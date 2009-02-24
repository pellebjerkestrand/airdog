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

	public function hundesok($soketekst)
    {
    	$hd = new HundDatabase();
    	$resultat = $hd->sokHund($soketekst);

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
			$ret[] = $tmp;
		}
    	
        return $ret;
    }
    
	public function hentHund($hundId)
    {
    	$hd = new HundDatabase();
    	$rad = $hd->hentHund($hundId);

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
		$ret[] = $tmp;
			
        return $tmp;
    }
    
    public function hentAvkom($hundId)
    {
    	$kd = new KullDatabase();
    	
	    $hundListe = $kd->hentAvkom($hundId);
	    $avkomHundListe = array();
	    
	    foreach($hundListe as $rad)
	   	{    	
			$tmp = new AmfHund();
			$tmp->hundId = $rad["hundId"];
			$tmp->tittel = $rad["tittel"];
			$tmp->navn = $rad["navn"];
			$tmp->bilde = "bilde";
/*			$tmp->morId = $rad["hundMorId"];
			$tmp->morNavn = $rad["hundMorNavn"];
			$tmp->farId = $rad["hundFarId"];
			$tmp->farNavn = $rad["hundFarNavn"];
			$tmp->oppdretterId = "oppdretterId";
			$tmp->oppdretter = "oppdretter";*/
			$tmp->eierId = $rad["eierId"];
			$tmp->eier = "eier";
			$tmp->kjonn = $rad["kjonn"];
			$tmp->rase = $rad["raseId"];
			$tmp->kullId = $rad["kullId"];
			$avkomHundListe[] = $tmp;
		}
    	
    	$kullListe = $kd->hentKull($hundId);
    	
    	foreach($kullListe as $kull)
    	{
			$avkom = new AmfAvkom();
			$avkom->med = "Rocky";
			$avkom->medId = "xxx";
			$avkom->kullId = "yyy";
			$avkom->liste = array();
			
			foreach($avkomHundListe as $hund)
			{
				if ($hund["kullId"] == $avkom->kullId)
				{
					$avkom->liste[] = $hund;
				}
			}
			
			$avkomListe[] = $avkom;
    	}
    	
    	$avkom = new AmfAvkom();
		$avkom->med = "";
		$avkom->medId = "";
		$avkom->kullId = "Ukjent";
		$avkom->liste = array();
		
		foreach($avkomHundListe as $hund)
		{
			if ($hund["kullId"] == "")
			{
				$avkom->liste[] = $hund;
			}
		}
		
		$avkomListe[] = $avkom;

        return $avkomListe;
    }
    
 	public function hentJaktprove($hundId)
    {
    	$hd = new HundDatabase();
    	$resultat = $hd->sokJaktprove($hundId);

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
