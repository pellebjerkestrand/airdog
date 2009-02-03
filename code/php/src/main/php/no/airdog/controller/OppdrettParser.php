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
		$oppdrettlisteArray = split("\r\n", "\n", $oppdrettliste);
		$ret = array();
		
		for ($i = 0; $i < sizeof($oppdrettlisteArray); $i++)
    	{
    		$ret[] = $this->getOppdrettArray($oppdrettlisteArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>
