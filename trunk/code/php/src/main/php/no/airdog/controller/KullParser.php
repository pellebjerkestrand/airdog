<?php

class KullParser
{
	public function KullParser()
	{
	}
	
	public function getKullArray($enKull)
	{
		$kullArray = split('[|]', trim($enKull));
		
		if (sizeof($kullArray) == 7)
		{
			return array (
			"kullId" => $kullArray[0],
			"hundIdFar" => $kullArray[1],
			"hundIdMor" => $kullArray[2],
			"oppdretterId" => $kullArray[3],
			"endretDato" => $kullArray[4],
			"fodt" => $kullArray[5],
			"raseId" => $kullArray[6]
			);
		}
	}
	
	public function getKulllisteArray($kullliste)
	{
		$kulllisteArray = split("\r\n", $kullliste);
		$ret = array();
		
		for ($i = 0; $i < sizeof($kulllisteArray); $i++)
    	{
    		$ret[] = $this->getKullArray($kulllisteArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>