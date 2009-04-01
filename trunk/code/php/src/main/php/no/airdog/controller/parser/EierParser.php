<?php

class EierParser
{
	public function __construct()
	{
	}
	
	public function getArray($enEier)
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
	
	public function getlisteArray($eierliste)
	{
		$eierliste = str_replace("\r\n", "\n", $eierliste);
		$eierlisteArray = split("\n", $eierliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($eierlisteArray); $i++)
    	{
    		$ret[] = $this->getArray($eierlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$eierliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($eierliste);
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
	
	public static function getDatabaseSomDat($personArray)
	{
		$dat = "$personArray[eier]|" .
	 		"$personArray[hundId]|" .
	 		"$personArray[raseId]";
			 			
			return $dat;
	}
}
?>