<?php
class AmfHund 
{
     public $id;
     public $tittel;
     public $navn;
     public $bilde;
     public $foreldre;
     public $oppdretter;
     public $eier;
}

class HundController
{
	public function HundController()
	{
	}

	public function getAlleHunder()
    {
    	$ret = array();
    	
    	for ($i = 0; $i < 1000; $i++)
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
?>