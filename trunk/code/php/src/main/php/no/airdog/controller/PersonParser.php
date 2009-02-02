<?php

class PersonParser
{
	public function PersonParser()
	{
	}
	
	public function getPersonArray($enPerson)
	{
		$personArray = split('[|]', trim($enPerson));
		
		if (sizeof($personArray) == 13)
		{
			return array (
			"personId" => $personArray[0],
			"navn" => $personArray[1],
			"adresse1" => $personArray[2],
			"adresse2" => $personArray[3],
			"adresse3" => $personArray[4],
			"postNr" => $personArray[5],
			"landkode" => $personArray[6],
			"raseId" => $personArray[7],
			"status" => $personArray[8],
			"telefon1" => $personArray[9],
			"endretDato" => $personArray[10],
			"regDato" => $personArray[11],
			"fodt" => $personArray[12]
			);
		}
	}
	
	public function getPersonlisteArray($personliste)
	{
		$personlisteArray = split("\r\n", $personliste);
		$ret = array();
		
		for ($i = 0; $i < sizeof($personlisteArray); $i++)
    	{
    		$ret[] = $this->getPersonArray($personlisteArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>