<?php

class KullParser
{
	public function KullParser()
	{
	}
	
	public function getKullArray($enKull)
	{
		$kullArray = split('[|]', trim($enKull));
		
		if (sizeof($kullArray) == 7)
		{
			return array (
			"kullId" => $kullArray[0],
			"hundIdFar" => $kullArray[1],
			"hundIdMor" => $kullArray[2],
			"oppdretterId" => $kullArray[3],
			"endretDato" => $kullArray[4],
			"fodt" => $kullArray[5],
			"raseId" => $kullArray[6]
			);
		}
	}
	
	public function getKulllisteArray($kullliste)
	{
		$kullliste = str_replace("\r\n", "\n", $kullliste);
		$kulllisteArray = split("\n", $kullliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($kulllisteArray); $i++)
    	{
    		$ret[] = $this->getKullArray($kulllisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getKulllisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$kullliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getKulllisteArray($kullliste);
	}
	
	public function validerKulllisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerKullliste($innhold[0]);
	}
	
	public function validerKullliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "KUID|HUIDFar|HUIDMor|PEIDOppdretter|EndretDato|Foedt|RAID")
		{
			return true;
		}
		
		return false;
	}
}
?>