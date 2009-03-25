<?php
require_once "Verktoy.php";

class VeterinerParser
{
	public function VeterinerParser()
	{
	}
	
	public function getVeterinerArray($enVeteriner)
	{
		$veterinerArray = split('[|]', $enVeteriner);
		
		if (sizeOf($veterinerArray) == 12)
		{
			return array (
			"veterinerId" => $veterinerArray[0],
			"personId" => $veterinerArray[1],
			"adresse1" => $veterinerArray[2],
			"adresse2" => $veterinerArray[3],
			"adresse3" => $veterinerArray[4],
			"postNr" => $veterinerArray[5],
			"telefon" => $veterinerArray[6],
			"telefax" => $veterinerArray[7],
			"klinikkNavn" => $veterinerArray[8],
			"regDato" => Verktoy::konverterDatTilDatabaseDato($veterinerArray[9]),
			"regAv" => $veterinerArray[10],
			"endretAv" => $veterinerArray[11]
			);
		}
	}
	
	public function getVeterinerlisteArray($veterinerliste)
	{
		$veterinerliste = str_replace("\r\n", "\n", $veterinerliste);
		$veterinerlisteArray = split("\n", $veterinerliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($veterinerlisteArray); $i++)
    	{
    		$ret[] = $this->getVeterinerArray($veterinerlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getVeterinerlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$veterinerliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getVeterinerlisteArray($veterinerliste);
	}
	
	public function validerVeterinerlisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerVeterinerliste($innhold[0]);
	}
	
	public function validerVeterinerliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "VEID|PEID|Adresse1|Adresse2|Adresse3|Postnr|Telefon|Telefax|KlinikkNavn|RegDato|RegAv|EndretAv")
		{
			return true;
		}
		
		return false;
	}
}
?>