

<?php

class AaSykdomParser
{
	public function AaSykdomParser()
	{
	}
	
	public function getAaSykdomArray($enAaSykdom)
	{
		$aaSykdomArray = split('[|]', trim($enAaSykdom));
		
		if (sizeof($aaSykdomArray) == 26)
		{
			return array (
			"veId" => $aaSykdomArray[0],
			"aaId" => $aaSykdomArray[1],
			"diagnoseKode" => $aaSykdomArray[2],
			"idMerkerKode" => $aaSykdomArray[3],
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
			"avlestDato" => $aaSykdomArray[24],
			"rontgenDato" => $aaSykdomArray[25]
			);
		}
	}
			//VEID|AAID|DiagnoseKode|IdMerkerKode|LidelseKode|SekHoyreKode|
			//SekVenstreKode|EndretAv|RegAv|AvlestAv|Betaling|Diagnose|HUID|
			//IdFeil|IdMerket|Kode|Lidelse|PEID|Purring|RAID|Retur|SekHoyre|
			//SekVenstre|Sendes|AvlestDato|RontgenDato
	
	public function getAaSykdomListeArray($aaSykdomliste)
	{
			$aaSykdomliste = str_replace("\r\n", "\n", $aaSykdomliste);
			$aaSykdomListeArray = split("\n", $aaSykdomliste);

		$ret = array();
		
		for ($i = 0; $i < sizeof($aaSykdomListeArray); $i++)
    	{
    		$ret[] = $this->getAaSykdomArray($aaSykdomListeArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>