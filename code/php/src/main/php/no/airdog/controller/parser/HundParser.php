<?php
require_once "no/airdog/controller/utf8Konverterer.php";
require_once "no/airdog/controller/Verktoy.php";

class HundParser
{
	public function HundParser()
	{
	}
	
	public function getArray($enHund)
	{
		$hundArray = split('[|]', utf8Konverterer::cp1252_to_utf8(trim($enHund)));
		
		if (sizeof($hundArray) == 20)
		{
			return array (
	           "raseId" => $hundArray[0],
	           "kullId" => $hundArray[1],
	           "hundId" => $hundArray[2],
	           "tittel" => $hundArray[3],
	           "navn" => $hundArray[4],
	           "hundFarId" => $hundArray[5],
	           "hundMorId" => $hundArray[6],
	           "idNr" => $hundArray[7],
	           "farge" => $hundArray[8],
	           "fargeVariant" => $hundArray[9],
	           "oyesykdom" => $hundArray[10],
	           "hoftesykdom" => $hundArray[11],
	           "haarlag" => $hundArray[12],
	           "idMerke" => $hundArray[13],
	           "kjonn" => $hundArray[14],
	           "eierId" => $hundArray[15],
	           "endretAv" => $hundArray[16],
	           "endretDato" => Verktoy::konverterDatTilDatabaseDato($hundArray[17]),
	           "regDato" => Verktoy::konverterDatTilDatabaseDato($hundArray[18]),
	           "storrelse" => $hundArray[19]
	    	);
		}
	}
	
	public function getlisteArray($hundeliste)
	{
		$hundeliste = str_replace("\r\n", "\n", $hundeliste);
		$hundelisteArray = split("\n", $hundeliste);
		$ret = array();
		
		// Hopper over den første linjen da denne inneholder kun tabellinformasjon.
		for ($i = 1; $i < sizeof($hundelisteArray); $i++)
    	{
    		$ret[] = $this->getArray($hundelisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$hundeliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($hundeliste);
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
	
	public static function getDatabaseSomDat($hundArray)
	{
		$dat = $hundArray['raseId'] . '|' .
	 		$hundArray['kullId'] . '|' .
	 		$hundArray['hundId'] . '|' .
	 		$hundArray['tittel'] . '|' .
	 		$hundArray['navn'] . '|' .
	 		$hundArray['hundFarId'] . '|' .
	 		$hundArray['hundMorId'] . '|' .
	 		$hundArray['idNr'] . '|' .
	 		$hundArray['farge'] . '|' .
	 		$hundArray['fargeVariant'] . '|' .
	 		$hundArray['oyesykdom'] . '|' .
	 		$hundArray['hoftesykdom'] . '|' .
	 		$hundArray['haarlag'] . '|' .
	 		$hundArray['idMerke'] . '|' .
	 		$hundArray['kjonn'] . '|' .
	 		$hundArray['eierId'] . '|' .
	 		$hundArray['endretAv'] . '|' .
	 		Verktoy::konverterDatabaseTilDatDato($hundArray['endretDato']) . '|' .
	 		Verktoy::konverterDatabaseTilDatDato($hundArray['regDato']) . '|' .
	 		$hundArray['storrelse'];
			 			
			return $dat;
	}

		
}