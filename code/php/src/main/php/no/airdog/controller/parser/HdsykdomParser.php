<?php
class HdsykdomParser
{
	public function HdsykdomParser()
	{
	}
	
	public function getHdsykdomArray($enHdsykdom)
	{
		$hdsykdomArray = split('[|]', trim($enHdsykdom));
		
		if (sizeof($hdsykdomArray) == 23)
		{
			return array (
			"avlestAv" => $hdsykdomArray[0],
			"betaling" => $hdsykdomArray[1],
			"diagnose" => $hdsykdomArray[2],
			"diagnoseKode" => $hdsykdomArray[3],
			"endretAv" => $hdsykdomArray[4],
			"hofteDyId" => $hdsykdomArray[5],
			"hundeId" => $hdsykdomArray[6],
			"idmerket" => $hdsykdomArray[7],
			"idmerketkode" => $hdsykdomArray[8],
			"kode" => $hdsykdomArray[9],
			"lidelse" => $hdsykdomArray[10],
			"lidelsekode" => $hdsykdomArray[11],
			"personId" => $hdsykdomArray[12],
			"raseId" => $hdsykdomArray[13],
			"registrertAv" => $hdsykdomArray[14],
			"sekHoyre" => $hdsykdomArray[15],
			"sekHoyreKode" => $hdsykdomArray[16],
			"sekVenstre" => $hdsykdomArray[17],
			"sekVenstreKode" => $hdsykdomArray[18],
			"sendes" => $hdsykdomArray[19],
			"veterinerId" => $hdsykdomArray[20],
			"rontgenDato" => $hdsykdomArray[21],
			"avlestDato" => $hdsykdomArray[22]
			);
		}
	}
	
	public function getHdsykdomlisteArray($hdsykdomliste)
	{
		$hdsykdomliste = str_replace("\r\n", "\n", $hdsykdomliste);
		$hdsykdomlisteArray = split("\n", $hdsykdomliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($hdsykdomlisteArray); $i++)
    	{
    		$ret[] = $this->getHdsykdomArray($hdsykdomlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getHdsykdomlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$hdsykdomliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getHdsykdomlisteArray($hdsykdomliste);
	}
	
	public function validerHdsykdomlisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerHdsykdomliste($innhold[0]);
	}
	
	public function validerHdsykdomliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "AvlestAv|Betaling|Diagnose|DiagnoseKode|EndretAv|HDID|HUID|IdMerket|IdMerkerKode|Kode|Lidelse|LidelseKode|PEID|RAID|RegAv|SekHoyre|SekHoyreKode|SekVenstre|SekVenstreKode|Sendes|VEID|RontgenDato|AvlestDato")
		{
			return true;
		}
		
		return false;
	}
}
?>