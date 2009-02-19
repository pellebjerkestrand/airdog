<?php
class OppdrettParser
{
	public function OppdrettParser()
	{
	}
	
	public function getOppdrettArray($enOppdrett)
	{
		$oppdrettArray = split('[|]', trim($enOppdrett));
		
		if (sizeof($oppdrettArray) == 3)
		{
			return array (
			"kullId" => $oppdrettArray[0],
			"oppdretter" => $oppdrettArray[1],
			"raseId" => $oppdrettArray[2],
			);
		}
	}
	
	public function getOppdrettlisteArray($oppdrettliste)
	{
		$oppdrettliste = str_replace("\r\n", "\n", $oppdrettliste);
		$oppdrettlisteArray = split("\n", $oppdrettliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($oppdrettlisteArray); $i++)
    	{
    		$ret[] = $this->getOppdrettArray($oppdrettlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getOppdrettlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$kullliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getOppdrettlisteArray($kullliste);
	}
	
	public function validerOppdrettlisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerOppdrettliste($innhold[0]);
	}
	
	public function validerOppdrettliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "KUID|Oppdretter|RAID")
		{
			return true;
		}
		
		return false;
	}
}
?>
