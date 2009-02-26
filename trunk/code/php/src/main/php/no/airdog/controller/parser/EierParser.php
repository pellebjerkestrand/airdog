<?php

class EierParser
{
	public function __construct()
	{
	}
	
	public function getEierArray($enEier)
	{
		$eierArray = split('[|]', trim($enEier));
		
		if (sizeof($eierArray) == 3)
		{
			return array (
			"eier" => $eierArray[0],
			"hundId" => $eierArray[1],
			"raseId" => $eierArray[2]
			);
		}
	}
	
	public function getEierlisteArray($eierliste)
	{
		$eierliste = str_replace("\r\n", "\n", $eierliste);
		$eierlisteArray = split("\n", $eierliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($eierlisteArray); $i++)
    	{
    		$ret[] = $this->getEierArray($eierlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getEierlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$eierliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getEierlisteArray($eierliste);
	}
	
	public function validerEierlisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerEierliste($innhold[0]);
	}
	
	public function validerEierliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "EIER|HUID|RAID")
		{
			return true;
		}
		
		return false;
	}
}
?>