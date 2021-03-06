<?php
class PremieParser
{
	public function PremieParser()
	{
	}
	
	public function getArray($enPremie)
	{
		$premieArray = split('[|]', trim($enPremie));
		
		if (sizeOf($premieArray) == 30)
		{
			return array (
			"doId" => $premieArray[0],				//what does this field mean?
			"utstillingId" => $premieArray[1],
			"hundId" => $premieArray[2],
			"katalogNr" => $premieArray[3],
			"personIdDommer" => $premieArray[4],
			"klasse" => $premieArray[5],
			"kjonn" => $premieArray[6],
			"raseId" => $premieArray[7],
			"IM" => $premieArray[8],				//for each line: what does this field mean?
			"KIP" => $premieArray[9],
			"JK" => $premieArray[10],
			"JKK" => $premieArray[11],
			"UK" => $premieArray[12],
			"UKK" => $premieArray[13],
			"BK" => $premieArray[14],
			"BKK" => $premieArray[15],
			"AK" => $premieArray[16],
			"AKK" => $premieArray[17],
			"VK" => $premieArray[18],
			"CHK" => $premieArray[19],
			"CHKK" => $premieArray[20],
			"VTK" => $premieArray[21],
			"VTKK" => $premieArray[22],
			"HP" => $premieArray[23],
			"CK" => $premieArray[24],
			"CC" => $premieArray[25],
			"CA" => $premieArray[26],
			"BIK" => $premieArray[27],
			"BIR" => $premieArray[28],
			"BIM" => $premieArray[29],				//end: what does this field mean?				
			);
		}
	}
	
	public function getlisteArray($premieliste)
	{
		$premieliste = str_replace("\r\n", "\n", $premieliste);
		$premielisteArray = split("\n", $premieliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($premielisteArray); $i++)
    	{
    		$ret[] = $this->getArray($premielisteArray[$i]);
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
	
	public function validerPremielisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerPremieliste($innhold[0]);
	}
	
	public function validerPremieliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "DOID|UTID|HUID|Katalognr|PEIDdommer|Klasse|Kjonn|RAID|IM|KIP|JK|JKK|UK|UKK|BK|BKK|AK|AKK|VK|CHK|CHKK|VTK|VTKK|HP|CK|CC|CA|BIK|BIR|BIM")
		{
			return true;
		}
		
		return false;
	}
	
	public static function getDatabaseSomDat($premieArray)
	{
		$dat = $premieArray['doId'] . '|' .
	 		$premieArray['utstillingId'] . '|' .
	 		$premieArray['hundId'] . '|' .
	 		$premieArray['katalogNr'] . '|' .
	 		$premieArray['personIdDommer'] . '|' .
	 		$premieArray['klasse'] . '|' .
	 		$premieArray['kjonn'] . '|' .
	 		$premieArray['raseId'] . '|' .
	 		$premieArray['IM'] . '|' .
	 		$premieArray['KIP'] . '|' .
	 		$premieArray['JK'] . '|' .
	 		$premieArray['JKK'] . '|' .
	 		$premieArray['UK'] . '|' .
	 		$premieArray['UKK'] . '|' .
	 		$premieArray['BK'] . '|' .
	 		$premieArray['BKK'] . '|' .
	 		$premieArray['AK'] . '|' .
	 		$premieArray['AKK'] . '|' .
	 		$premieArray['VK'] . '|' .
	 		$premieArray['CHK'] . '|' .
	 		$premieArray['CHKK'] . '|' .
	 		$premieArray['VTK'] . '|' .
	 		$premieArray['VTKK'] . '|' .
	 		$premieArray['HP'] . '|' .
	 		$premieArray['CK'] . '|' .
	 		$premieArray['CC'] . '|' .
	 		$premieArray['CA'] . '|' .
	 		$premieArray['BIK'] . '|' .
	 		$premieArray['BIR'] . '|' .
	 		$premieArray['BIM'];
			 			
			return $dat;
	}
}
