<?php

class HundParser
{
	public function HundParser()
	{
	}
	
	public function getHundArray($enHund)
	{
		$hundArray = split('[|]', trim($enHund));
		
		if (sizeof($hundArray) == 20)
		{
			$ret = array();
			$ret["raseId"] = $hundArray[0];
			$ret["kullId"] = $hundArray[1];
			$ret["hundId"] = $hundArray[2];
			$ret["tittel"] = $hundArray[3];
			$ret["navn"] = $hundArray[4];
			$ret["hundFarId"] = $hundArray[5];
			$ret["hundMorId"] = $hundArray[6];
			$ret["idNr"] = $hundArray[7];
			$ret["farge"] = $hundArray[8];
			$ret["fargeVariant"] = $hundArray[9];
			$ret["oyesykdom"] = $hundArray[10];
			$ret["hoftesykdom"] = $hundArray[11];
			$ret["haarlag"] = $hundArray[12];
			$ret["idMerke"] = $hundArray[13];
			$ret["kjonn"] = $hundArray[14];
			$ret["eierId"] = $hundArray[15];
			$ret["endretAv"] = $hundArray[16];
			$ret["endretDato"] = $hundArray[17];
			$ret["regDato"] = $hundArray[18];
			$ret["storrelse"] = $hundArray[19];
			
			return $ret;
		}
		
		return null;
	}
	
	public function getHundelisteArray($hundeliste)
	{
		$hundeliste = str_replace("\r\n", "\n", $hundeliste);
		$hundelisteArray = split("\n", $hundeliste);
		$ret = array();
	
		// Hopper over den første linjen da denne inneholder kun tabellinformasjon.
		for ($i = 1; $i < sizeof($hundelisteArray); $i++)
    	{
    		$ret[] = $this->getHundArray($hundelisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getHundelisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$hundeliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getHundelisteArray($hundeliste);
	}
	
	public function validerHundelisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerHundeliste($innhold[0]);
	}
	
	public function validerHundeliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "RAID|KUID|HUID|Tittel|Navn|HUIDFar|HUIDMor|IDNR|FargeBeskrivelse|FargeVariant|AD|HD|Haarlag|IDMerk|Kjoenn|PEID|EndretAv|EndretDato|RegDato|Stoerrelse")
		{
			return true;
		}
		
		return false;
	}
}
?>