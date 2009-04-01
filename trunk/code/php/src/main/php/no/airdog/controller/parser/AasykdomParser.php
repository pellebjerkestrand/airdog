<?php

require_once "Verktoy.php";

class AasykdomParser
{
	public function AasykdomParser()
	{
	}
	
	public function getArray($enAasykdom)
	{
		$aaSykdomArray = split('[|]', trim($enAasykdom));
		
		if (sizeof($aaSykdomArray) == 26)
		{
			return array (
			"veId" => $aaSykdomArray[0],
			"aaId" => $aaSykdomArray[1],
			"diagnoseKode" => $aaSykdomArray[2],
			"idmerketkode" => $aaSykdomArray[3],
			"lidelseKode" => $aaSykdomArray[4],
			"sekHoyreKode" => $aaSykdomArray[5],
			"sekVenstreKode" => $aaSykdomArray[6],
			"endretAv" => $aaSykdomArray[7],
			"regAv" => $aaSykdomArray[8],
			"avlestAv" => $aaSykdomArray[9],
			"betaling" => $aaSykdomArray[10],
			"diagnose" => $aaSykdomArray[11],
			"hundId" => $aaSykdomArray[12],
			"idFeil" => $aaSykdomArray[13],
			"idMerket" => $aaSykdomArray[14],
			"kode" => $aaSykdomArray[15],
			"lidelse" => $aaSykdomArray[16],
			"peId" => $aaSykdomArray[17],
			"purring" => $aaSykdomArray[18],
			"raseId" => $aaSykdomArray[19],
			"retur" => $aaSykdomArray[20],
			"sekHoyre" => $aaSykdomArray[21],
			"sekVenstre" => $aaSykdomArray[22],
			"sendes" => $aaSykdomArray[23],
			"avlestDato" => Verktoy::konverterDatTilDatabaseDato($aaSykdomArray[24]),
			"rontgenDato" => Verktoy::konverterDatTilDatabaseDato($aaSykdomArray[25])
			);
		}
	}
			//VEID|AAID|DiagnoseKode|IdMerkerKode|LidelseKode|SekHoyreKode|
			//SekVenstreKode|EndretAv|RegAv|AvlestAv|Betaling|Diagnose|HUID|
			//IdFeil|IdMerket|Kode|Lidelse|PEID|Purring|RAID|Retur|SekHoyre|
			//SekVenstre|Sendes|AvlestDato|RontgenDato
	
	public function getlisteArray($aaSykdomliste)
	{
			$aaSykdomliste = str_replace("\r\n", "\n", $aaSykdomliste);
			$aaSykdomListeArray = split("\n", $aaSykdomliste);

		$ret = array();
		
		for ($i = 1; $i < sizeof($aaSykdomListeArray); $i++)
    	{
    		$ret[] = $this->getArray($aaSykdomListeArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$aasykdomliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($aasykdomliste);
	}
	
	public function validerAasykdomlisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerAasykdomliste($innhold[0]);
	}
	
	public function validerAasykdomliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "VEID|AAID|DiagnoseKode|IdMerkerKode|LidelseKode|SekHoyreKode|SekVenstreKode|EndretAv|RegAv|AvlestAv|Betaling|Diagnose|HUID|IdFeil|IdMerket|Kode|Lidelse|PEID|Purring|RAID|Retur|SekHoyre|SekVenstre|Sendes|AvlestDato|RontgenDato")
		{
			return true;
		}
		
		return false;
	}
	
	public static function getDatabaseSomDat($aasykdomArray)
	{
		$dat = "$aasykdomArray[veId]|" .
			"$aasykdomArray[aaId]|" .
			"$aasykdomArray[diagnoseKode]|" .
			"$aasykdomArray[idmerketkode]|" .
			"$aasykdomArray[lidelseKode]|" .
			"$aasykdomArray[sekHoyreKode]|" .
			"$aasykdomArray[sekVenstreKode]|" .
			"$aasykdomArray[endretAv]|" .
			"$aasykdomArray[regAv]|" .
			"$aasykdomArray[avlestAv]|" .
			"$aasykdomArray[betaling]|" .
			"$aasykdomArray[diagnose]|" .
			"$aasykdomArray[hundId]|" .
			"$aasykdomArray[idFeil]|" .
			"$aasykdomArray[idMerket]|" .
			"$aasykdomArray[kode]|" .
			"$aasykdomArray[lidelse]|" .
			"$aasykdomArray[peId]|" .
			"$aasykdomArray[purring]|" .
			"$aasykdomArray[raseId]|" .
			"$aasykdomArray[retur]|" .
			"$aasykdomArray[sekHoyre]|" .
			"$aasykdomArray[sekVenstre]|" .
			"$aasykdomArray[sendes]|" .
			Verktoy::konverterDatabaseTilDatDato($aasykdomArray['avlestDato'])."|" .
			Verktoy::konverterDatabaseTilDatDato($aasykdomArray['rontgenDato']);
			 			
			return $dat;
	}
}
?>