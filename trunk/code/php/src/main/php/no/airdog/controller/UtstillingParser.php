

<?php
//UTID|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|
//UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato
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
			"UTID" => $utstillingArray[0],
			"KLID" => $utstillingArray[1],
			"PEID" => $utstillingArray[2],
			"RegDato" => $utstillingArray[3],
			"RegAv" => $utstillingArray[4],
			"Navn" => $utstillingArray[5],
			"Adresse1" => $utstillingArray[6],
			"Adresse2" => $utstillingArray[7],
			"Postnr" => $utstillingArray[8],
			"SpesialAdresse" => $utstillingArray[9],
			"UtstillingDato" => $utstillingArray[10],
			"UtstillingSted" => $utstillingArray[11],
			"ArrangoerNavn1" => $utstillingArray[12],
			"ArrangoerNavn2" => $utstillingArray[13],
			"OverfoertDato" => $utstillingArray[14]
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