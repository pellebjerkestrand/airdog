<?php

require_once "no/airdog/controller/Verktoy.php";

class PersonParser
{
	public function PersonParser()
	{
	}
	
	public function getArray($enPerson)
	{
		$personArray = split('[|]', trim($enPerson));
		
		if (sizeof($personArray) == 13)
		{
			return array (
			"personId" => $personArray[0],
			"navn" => $personArray[1],
			"adresse1" => $personArray[2],
			"adresse2" => $personArray[3],
			"adresse3" => $personArray[4],
			"postNr" => $personArray[5],
			"landkode" => $personArray[6],
			"raseId" => $personArray[7],
			"status" => $personArray[8],
			"telefon1" => $personArray[9],
			"endretDato" => Verktoy::konverterDatTilDatabaseDato($personArray[10]),
			"regDato" => Verktoy::konverterDatTilDatabaseDato($personArray[11]),
			"fodt" => Verktoy::konverterDatTilDatabaseDato($personArray[12])
			);
		}
	}
	
	public function getlisteArray($personliste)
	{
		$personliste = str_replace("\r\n", "\n", $personliste);
		$personlisteArray = split("\n", $personliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($personlisteArray); $i++)
    	{
    		$ret[] = $this->getArray($personlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$personliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($personliste);
	}
	
	public function validerPersonlisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerPersonliste($innhold[0]);
	}
	
	public function validerPersonliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "PEID|Navn|Adresse1|Adresse2|Adresse3|Postnr|Landkode|RAID|Status|Telefon1|EndretDato|RegDato|Foedt")
		{
			return true;
		}
		
		return false;
	}
	
	public static function getDatabaseSomDat($personArray)
	{
		$dat = $personArray['personId'] . '|' .
	 		$personArray['navn'] . '|' .
	 		$personArray['adresse1'] . '|' .
	 		$personArray['adresse2'] . '|' .
	 		$personArray['adresse3'] . '|' .
	 		$personArray['postNr'] . '|' .
	 		$personArray['landkode'] . '|' .
	 		$personArray['raseId'] . '|' .
	 		$personArray['status'] . '|' .
	 		$personArray['telefon1'] . '|' .
	 		Verktoy::konverterDatabaseTilDatDato($personArray['endretDato']) . '|' .
	 		Verktoy::konverterDatabaseTilDatDato($personArray['regDato']) . '|' .
	 		Verktoy::konverterDatabaseTilDatDato($personArray['fodt']);
			 			
			return $dat;
	}
}