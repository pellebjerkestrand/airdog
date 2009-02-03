<?php

class EierParser
{
	public function EierParser()
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
		
		for ($i = 0; $i < sizeof($eierlisteArray); $i++)
    	{
    		$ret[] = $this->getEierArray($eierlisteArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>