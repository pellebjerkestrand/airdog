<?php

class UtstillingParser
{
	public function UtstillingParser()
	{
	}
	
	public function getUtstillingArray($enUtstilling)
	{
		$utstillingArray = split('[|]', trim($enUtstilling));
		
		if (sizeof($utstillingArray) == 15)
		{
			return array (
			"utstillingId" => $utstillingArray[0],
			"klasseId" => $utstillingArray[1],
			"peId" => $utstillingArray[2],
			"regDato" => $utstillingArray[3],
			"regAv" => $utstillingArray[4],
			"navn" => $utstillingArray[5],
			"adresse1" => $utstillingArray[6],
			"adresse2" => $utstillingArray[7],
			"postNr" => $utstillingArray[8],
			"spesialAdresse" => $utstillingArray[9],
			"utstillingDato" => $utstillingArray[10],
			"utstillingSted" => $utstillingArray[11],
			"arrangoerNavn1" => $utstillingArray[12],
			"arrangoerNavn2" => $utstillingArray[13],
			"overfoertDato" => $utstillingArray[14]
			);
		}
	}

	
	public function getUtstillingListeArray($utstillingliste)
	{
			$utstillingliste = str_replace("\r\n", "\n", $utstillingliste);
			$utstillingListeArray = split("\n", $utstillingliste);

			//$utstillingListeArray = split("\r\n", $utstillingliste);
		$ret = array();
		
		for ($i = 0; $i < sizeof($utstillingListeArray); $i++)
    	{
    		$ret[] = $this->getUtstillingArray($utstillingListeArray[$i]);
    	}
    	
    	return $ret;
	}
}
?>