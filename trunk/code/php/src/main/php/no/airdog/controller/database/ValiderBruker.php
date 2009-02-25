<?php
require_once 'Tilkobling.php';
class ValiderBruker
{	
	public static function validerBrukeren($database, $brukerEpost, $brukerPassord)
	{
		$brk = $database->quoteInto('epost=?', $brukerEpost);
		$pass = $database->quoteInto('passord=?', $brukerPassord);
		
		$hent = $database->select()
		->from('ad_bruker', array('ad_bruker.*'))
		->where($brk)
		->where($pass);
		
		if($database->fetchRow($hent) != null)
		{
			return true;
		}
		
		return false;
	}	
	
	public static function validerBrukerRettighet($database, $brukerEpost, $brukerPassord, $klubbId, $rettighet)
	{
	
		if($this->validerBruker($database, $brukerEpost, $brukerPassord))
		{
			$brk = $database->quoteInto('a.ad_bruker_epost=?', $brukerEpost);
			$klb = $database->quoteInto('a.ad_klubb_id=?', $klubbId);
			
			$hent = $database->select()
			->from(array('a' => 'ad_bruker_klubb_rolle_link'), array('rr.ad_rettighet_navn'))
			->join(array('rr' => 'ad_rolle_rettighet_link'), 'rr.ad_rolle_navn = a.ad_rolle_navn', array())
			->where($brk)
			->where($klb);
			
			if($database->fetchRow($hent) != null)
			{
				return true;
			}
			
			return false;
		}
		
		return false;
		
	}	
}
