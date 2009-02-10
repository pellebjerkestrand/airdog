<?php
require_once "no/airdog/model/AmfHund.php";
class HundController
{
	public function __construct()
	{
	}

	public function getAlleHunder()
    {
    	$ret = array();
    	
    	for ($i = 0; $i < 10; $i++)
    	{
			$tmp = new AmfHund();
			$tmp->id = $i;
			$tmp->tittel = "tittel";
			$tmp->navn = "hund" . $i;
			$tmp->bilde = "bilde";
			$tmp->foreldre = "foreldre";
			$tmp->oppdretter = "oppdretter";
			$tmp->eier = "eier";
			$ret[] = $tmp;
		}

        return $ret;
    }
}
