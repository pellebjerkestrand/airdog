<?php
class PremieParser
{
	public function PremieParser()
	{
	}
	
	public function getPremieArray($enPremie)
	{
		$premieArray = split('[|]', trim($enPremie));
		
		if (sizeOf($premieArray) == 30)
		{
			return array (
			"DOID" => $premieArray[0],				//what does this field mean?
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
	
	public function getPremielisteArray($premieliste)
	{
		$premieliste = str_replace("\r\n", "\n", $premieliste);
		$premielisteArray = split("\n", $premieliste);
		$ret = array();
		
		for ($i = 0; $i < sizeof($premielisteArray); $i++)
    	{
    		$ret[] = $this->getPremieArray($premielisteArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>
