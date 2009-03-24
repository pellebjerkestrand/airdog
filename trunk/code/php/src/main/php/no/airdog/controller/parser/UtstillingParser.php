<?php

class UtstillingParser
{
	public function UtstillingParser()
	{
	}
	
	public function getUtstillingArray($enUtstilling)
	{
		$utstillingArray = split('[|]', trim($enUtstilling));
		
		if (sizeof($utstillingArray) == 15)
		{
			return array (
			"utstillingId" => $utstillingArray[0],
			"klasseId" => $utstillingArray[1],
			"personId" => $utstillingArray[2],
			"regDato" => Verktoy::konverterDatTilDatabaseDato($utstillingArray[3]),
			"regAv" => $utstillingArray[4],
			"navn" => $utstillingArray[5],
			"adresse1" => $utstillingArray[6],
			"adresse2" => $utstillingArray[7],
			"postNr" => $utstillingArray[8],
			"spesialAdresse" => $utstillingArray[9],
			"utstillingDato" => Verktoy::konverterDatTilDatabaseDato($utstillingArray[10]),
			"utstillingSted" => $utstillingArray[11],
			"arrangorNavn1" => $utstillingArray[12],
			"arrangorNavn2" => $utstillingArray[13],
			"overfortDato" => Verktoy::konverterDatTilDatabaseDato($utstillingArray[14])
			);
		}
	}

	
	public function getUtstillinglisteArray($utstillingliste)
	{
			$utstillingliste = str_replace("\r\n", "\n", $utstillingliste);
			$utstillingListeArray = split("\n", $utstillingliste);

			//$utstillingListeArray = split("\r\n", $utstillingliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($utstillingListeArray); $i++)
    	{
    		$ret[] = $this->getUtstillingArray($utstillingListeArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getUtstillinglisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$utstillingliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getUtstillinglisteArray($utstillingliste);
	}
	
	public function validerUtstillinglisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerUtstillingliste($innhold[0]);
	}
	
	public function validerUtstillingliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "UTID|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato")
		{
			return true;
		}
		
		return false;
	}
}
?>