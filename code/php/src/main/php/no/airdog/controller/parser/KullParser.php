<?php

require_once "no/airdog/controller/Verktoy.php";

class KullParser
{
	public function KullParser()
	{
	}
	
	public function getArray($enKull)
	{
		$kullArray = split('[|]', trim($enKull));
		
		if (sizeof($kullArray) == 7)
		{
			return array (
			"kullId" => $kullArray[0],
			"hundIdFar" => $kullArray[1],
			"hundIdMor" => $kullArray[2],
			"oppdretterId" => $kullArray[3],
			"endretDato" => Verktoy::konverterDatTilDatabaseDato($kullArray[4]),
			"fodt" => Verktoy::konverterDatTilDatabaseDato($kullArray[5]),
			"raseId" => $kullArray[6]
			);
		}
	}
	
	public function getlisteArray($kullliste)
	{
		$kullliste = str_replace("\r\n", "\n", $kullliste);
		$kulllisteArray = split("\n", $kullliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($kulllisteArray); $i++)
    	{
    		$ret[] = $this->getArray($kulllisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$kullliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($kullliste);
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
	
	public static function getDatabaseSomDat($kullArray)
	{
		$dat = $kullArray['kullId'] . '|' .
	 		$kullArray['hundIdFar'] . '|' .
	 		$kullArray['hundIdMor'] . '|' .
	 		$kullArray['oppdretterId'] . '|' .
	 		Verktoy::konverterDatabaseTilDatDato($kullArray['endretDato']) . '|' .
	 		Verktoy::konverterDatabaseTilDatDato($kullArray['fodt']) . '|' .
	 		$kullArray['raseId'];
			 			
		return $dat;
	}
}
?>