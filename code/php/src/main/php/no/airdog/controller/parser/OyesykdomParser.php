<?php

require_once "no/airdog/controller/Verktoy.php";

class OyesykdomParser
{
	public function OyesykdomParser()
	{
	}
	
	public function getArray($enOyesykdom)
	{
		$oyesykdomArray = split('[|]', trim($enOyesykdom));
		
		if (sizeof($oyesykdomArray) == 27)
		{
			return array (
			"oyId" => $oyesykdomArray[0],
			"hundId" => $oyesykdomArray[1],
			"veterinerId" => $oyesykdomArray[2],
			"oyeVeteriner" => $oyesykdomArray[3],
			"lystDato" => Verktoy::konverterDatTilDatabaseDato($oyesykdomArray[4]),
			"idmerketKode" => $oyesykdomArray[5],
			"idmerket" => $oyesykdomArray[6],
			"idfeil" => $oyesykdomArray[7],
			"raseId" => $oyesykdomArray[8],
			"sendtEierDato" => Verktoy::konverterDatTilDatabaseDato($oyesykdomArray[9]),
			"longAnnet" => $oyesykdomArray[10],
			"diagnoseKode1" => $oyesykdomArray[11],
			"diagnoseGrad1" => $oyesykdomArray[12],
			"diagnoseKode2" => $oyesykdomArray[13],
			"diagnoseGrad2" => $oyesykdomArray[14],
			"diagnoseKode3" => $oyesykdomArray[15],
			"diagnoseGrad3" => $oyesykdomArray[16],
			"regAv" => $oyesykdomArray[17],
			"regDato" => Verktoy::konverterDatTilDatabaseDato($oyesykdomArray[18]),
			"endretAv" => $oyesykdomArray[19],
			"endretDato" => Verktoy::konverterDatTilDatabaseDato($oyesykdomArray[20]),
			"personId" => $oyesykdomArray[21],
			"sendtVetDato" => Verktoy::konverterDatTilDatabaseDato($oyesykdomArray[22]),
			"sendtKlubbDato" => Verktoy::konverterDatTilDatabaseDato($oyesykdomArray[23]),
			"longAnnet1" => $oyesykdomArray[24],
			"longAnnet2" => $oyesykdomArray[25],
			"inaktiv" => $oyesykdomArray[26]
			);
		}
	}
	
	public function getlisteArray($oyesykdomliste)
	{
		$oyesykdomliste = str_replace("\r\n", "\n", $oyesykdomliste);
		$oyesykdomlisteArray = split("\n", $oyesykdomliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($oyesykdomlisteArray); $i++)
    	{
    		$ret[] = $this->getArray($oyesykdomlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$oyesykdomliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($oyesykdomliste);
	}
	
	public function validerOyesykdomlisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerOyesykdomliste($innhold[0]);
	}
	
	public function validerOyesykdomliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "OYID|HUID|VEID|OYEVET|LystDato|IdMerketKode|IdMerket|IdFeil|RAID|SendtEierDato|long_Annet|DiagnoseKode1|DiagnoseGrad1|DiagnoseKode2|DiagnoseGrad2|DiagnoseKode3|DiagnoseGrad3|RegAv|RegDato|EndretAv|EndretAv|PEID|SendtVetDato|SendtKlubbDato|long_Annet1|long_Annet2|Inaktiv")
		{
			return true;
		}
		
		return false;
	}
	
	public static function getDatabaseSomDat($oyesykdomArray)
	{
		$dat = $oyesykdomArray['oyId'] . '|' .
			$oyesykdomArray['hundId'] . '|' .
			$oyesykdomArray['veterinerId'] . '|' .
			$oyesykdomArray['oyeVeteriner'] . '|' .
			Verktoy::konverterDatabaseTilDatDato($oyesykdomArray['lystDato']) . '|' .
			$oyesykdomArray['idmerketKode'] . '|' .
			$oyesykdomArray['idmerket'] . '|' .
			$oyesykdomArray['idfeil'] . '|' .
			$oyesykdomArray['raseId'] . '|' .
			Verktoy::konverterDatabaseTilDatDato($oyesykdomArray['sendtEierDato']) . '|' .
			$oyesykdomArray['longAnnet'] . '|' .
			$oyesykdomArray['diagnoseKode1'] . '|' .
			$oyesykdomArray['diagnoseGrad1'] . '|' .
			$oyesykdomArray['diagnoseKode2'] . '|' .
			$oyesykdomArray['diagnoseGrad2'] . '|' .
			$oyesykdomArray['diagnoseKode3'] . '|' .
			$oyesykdomArray['diagnoseGrad3'] . '|' .
			$oyesykdomArray['regAv'] . '|' .
			Verktoy::konverterDatabaseTilDatDato($oyesykdomArray['regDato']) . '|' .
			$oyesykdomArray['endretAv'] . '|' .
			Verktoy::konverterDatabaseTilDatDato($oyesykdomArray['endretDato']) . '|' .
			$oyesykdomArray['personId'] . '|' .
			Verktoy::konverterDatabaseTilDatDato($oyesykdomArray['sendtVetDato']) . '|' .
			Verktoy::konverterDatabaseTilDatDato($oyesykdomArray['sendtKlubbDato']) . '|' .
			$oyesykdomArray['longAnnet1'] . '|' .
			$oyesykdomArray['longAnnet2'] . '|' .
			$oyesykdomArray['inaktiv'];
			 			
			return $dat;
	}
}
?>