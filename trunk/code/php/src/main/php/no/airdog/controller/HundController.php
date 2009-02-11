<?php
require_once "no/airdog/model/AmfHund.php";
require_once "no/airdog/controller/database/HundDatabase.php";

class HundController
{
	public function __construct()
	{
	}

	public function hundesok($soketekst)
    {
    	    	
     /* public $hundId;
     public $tittel;
     public $navn;
     public $bilde;
     public $morId;
     public $morNavn;
     public $farId;
     public $farNavn;
     public $oppdretterId;
     public $oppdretter;
     public $eierId;
     public $eier;
     public $kjonn;
     public $rase;
     public $kullId; */
    	$hd = new HundDatabase();
    	$resultat = $hd->sokHund($soketekst);

     
    	$ret = array();
    	
	   	while($rad = mysql_fetch_array($resultat))
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
}
