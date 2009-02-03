<?php

// VEID|PEID|Adresse1|Adresse2|Adresse3|Postnr|Telefon|Telefax|KlinikkNavn|RegDato|RegAv|EndretAv

class VeterinerParser
{
	public function VeterinerParser()
	{
	}
	
	public function getVeterinerArray($enVeteriner)
	{
		$veterinerArray = split('[|]', $enVeteriner);
		
		if (sizeOf($veterinerArray) == 12)
		{
			return array (
			"veterinerId" => $veterinerArray[0],
			"personId" => $veterinerArray[1],
			"adresse1" => $veterinerArray[2],
			"adresse2" => $veterinerArray[3],
			"adresse3" => $veterinerArray[4],
			"postNr" => $veterinerArray[5],
			"telefon" => $veterinerArray[6],
			"telefax" => $veterinerArray[7],
			"klinikkNavn" => $veterinerArray[8],
			"regDato" => $veterinerArray[9],
			"regAv" => $veterinerArray[10],
			"endretAv" => $veterinerArray[11]
			);
		}
	}
	
	public function getVeterinerlisteArray($veterinerliste)
	{
		$veterinerlisteArray = split("\n", $veterinerliste);
		$ret = array();
		
		for ($i = 0; $i < sizeof($veterinerlisteArray); $i++)
    	{
    		$ret[] = $this->getVeterinerArray($veterinerlisteArray[$i]);
    	}
    	
    	return $ret;
	}
}

?>
