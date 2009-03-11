<?php
require_once 'Tilkobling.php';
class ValiderBruker
{	
	public static function validerSuperadmin($database, $brukerEpost, $brukerPassord)
	{
		$brk = $database->quoteInto('epost=?', $brukerEpost);
		$pass = $database->quoteInto('passord=?', sha1($brukerPassord));
		
		$hent = $database->select()
		->from('ad_bruker', array('ad_bruker.*'))
		->where($brk)
		->where($pass)
		->where('superadmin=?', 1);
		
		if($database->fetchRow($hent) != null)
		{
			return true;
		}
		
		return false;
	}	
	
	public static function validerBrukeren($database, $brukerEpost, $brukerPassord)
	{
		if(ValiderBruker::validerSuperadmin($database, $brukerEpost, $brukerPassord))
		{
			return true;
		}
		
		$brk = $database->quoteInto('epost=?', $brukerEpost);
		$pass = $database->quoteInto('passord=?', sha1($brukerPassord));
		
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
		if(ValiderBruker::validerSuperadmin($database, $brukerEpost, $brukerPassord))
		{
			return true;
		}
		
		if(ValiderBruker::validerBrukeren($database, $brukerEpost, $brukerPassord))
		{
			$brk = $database->quoteInto('a.ad_bruker_epost=?', $brukerEpost);
			$klb = $database->quoteInto('a.ad_klubb_raseid=?', $klubbId);
			$rettighet = $database->quoteInto('rr.ad_rettighet_navn=?', $rettighet);
			
			$hent = $database->select()
			->from(array('a' => 'ad_bruker_klubb_rolle_link'), array('rr.ad_rettighet_navn'))
			->join(array('rr' => 'ad_rolle_rettighet_link'), 'rr.ad_rolle_navn = a.ad_rolle_navn', array())
			->where($rettighet)
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
