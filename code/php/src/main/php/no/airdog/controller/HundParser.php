<?php

class HundParser
{
	public function HundParser()
	{
	}
	
	public function getHundArray($tekst)
	{
		$array = split('[|]', $tekst);
		
		return array (
		"raseId" => $array[0],
		"kullId" => $array[1],
		"hundId" => $array[2],
		"tittel" => $array[3],
		"navn" => $array[4],
		"hundFarId" => $array[5],
		"hundMorId" => $array[6],
		"idNr" => $array[7],
		"farge" => $array[8],
		"fargeVariant" => $array[9],
		"oyesykdom" => $array[10],
		"hoftesykdom" => $array[11],
		"haarlag" => $array[12],
		"idMerke" => $array[13],
		"kjonn" => $array[14],
		"eierId" => $array[15],
		"endretAv" => $array[16],
		"endretDato" => $array[17],
		"regDato" => $array[18],
		"storrelse" => $array[19]
		);
	}
}
?>