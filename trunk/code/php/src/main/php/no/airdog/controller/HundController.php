<?php
require_once "no/airdog/model/AmfHund.php";
class HundController
{
	public function __construct()
	{
	}

	public function hundesok($soketekst)
    {
    	$ret = array();
    	
	   	for ($i = 0; $i < 100; $i++)
		{
			$tmp = new AmfHund();
			$tmp->hundId = $i;
			$tmp->tittel = "$soketekst";
			$tmp->navn = "hund" . $i;
			$tmp->bilde = "bilde";
			$tmp->foreldre = "foreldre";
			$tmp->oppdretter = "oppdretter";
			$tmp->eier = "eier$i";
			$tmp->kjonn = "kjonn";
			$tmp->rase = "torelervik";
			$ret[] = $tmp;
		}
    	
    	if($soketekst == $ret[0]->eier){
 			return array($ret[0]);
    	}
    	
        return $ret;
    }
}
