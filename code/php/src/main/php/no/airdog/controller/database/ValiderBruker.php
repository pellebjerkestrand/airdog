<?php
require_once 'Tilkobling.php';
class ValiderBruker
{	
	public static function sjekkBruker($brukerEpost, $passord)
	{
		$tilkobling = new Tilkobling();
		$database = $tilkobling->getTilkobling();
		
		$brk = $database->quoteInto('epost=?', $brukerEpost);
		$pass = $database->quoteInto('passord=?', $passord);
		
		$hent = $database->select()
		->from('AD_bruker', array('AD_bruker.*'))
		->where($brk)
		->where($pass);
		
		if($database->fetchRow($hent) != null)
		{
			return true;
		}
		
		return false;
	}	
}
