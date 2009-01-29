<?php

class HundParser
{
	public function HundParser()
	{
	}
	
	public function getHundArray($enHund)
	{
		$hundArray = split("[|]", $enHund);
		
		return array (
		"raseId" => $hundArray[0],
		"kullId" => $hundArray[1],
		"hundId" => $hundArray[2],
		"tittel" => $hundArray[3],
		"navn" => $hundArray[4],
		"hundFarId" => $hundArray[5],
		"hundMorId" => $hundArray[6],
		"idNr" => $hundArray[7],
		"farge" => $hundArray[8],
		"fargeVariant" => $hundArray[9],
		"oyesykdom" => $hundArray[10],
		"hoftesykdom" => $hundArray[11],
		"haarlag" => $hundArray[12],
		"idMerke" => $hundArray[13],
		"kjonn" => $hundArray[14],
		"eierId" => $hundArray[15],
		"endretAv" => $hundArray[16],
		"endretDato" => $hundArray[17],
		"regDato" => $hundArray[18],
		"storrelse" => $hundArray[19]
		);
	}
	
	public function getHundelisteArray($hundeliste)
	{
		$hundelisteArray = split("\r\n", $hundeliste);
		$ret = array();
		
		for ($i = 0; $i < sizeof($hundelisteArray); $i++)
    	{
    		$ret[] = $this->getHundArray($hundelisteArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>