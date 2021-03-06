<?php
class OppdrettParser
{
	public function OppdrettParser()
	{
	}
	
	public function getArray($enOppdrett)
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
	
	public function getlisteArray($oppdrettliste)
	{
		$oppdrettliste = str_replace("\r\n", "\n", $oppdrettliste);
		$oppdrettlisteArray = split("\n", $oppdrettliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($oppdrettlisteArray); $i++)
    	{
    		$ret[] = $this->getArray($oppdrettlisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$kullliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($kullliste);
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
	
	public static function getDatabaseSomDat($oppdrettArray)
	{
		$dat = $oppdrettArray['kullId'] . '|' .
	 		$oppdrettArray['oppdretter'] . '|' .
	 		$oppdrettArray['raseId'];
			 			
			return $dat;
	}
}
?>
