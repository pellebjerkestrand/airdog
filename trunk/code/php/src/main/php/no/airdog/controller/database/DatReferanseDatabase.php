<?php 
class DatReferanseDatabase
{
	public static function hentReferanse($tekst, $database)
	{
		$select = $database->select()
		->from(array('d'=>'ad_datreferanser'), array('d.*'))
		->where('d.hash=?', sha1($tekst))
		->limit(1);
		
		return $database->fetchRow($select);
	}
	
	public static function settReferanse($tekst, $endretAv, $database)
	{
		date_default_timezone_set('Europe/Oslo');
		
		$array = array();
		$array["hash"] = sha1($tekst);
		$array["tekst"] = $tekst;
		$array["endretAv"] = $endretAv;
		$array["endretDato"] = date("Y-m-d");
		
		if (DatReferanseDatabase::hentReferanse($tekst, $database) == null)
			$database->insert('ad_datreferanser', $array);
	}
	
	public static function slettReferanse($tekst, $database)
	{		
		$hvor = $database->quoteInto('hash = ?', sha1($tekst));
		$database->delete('ad_datreferanser', $hvor);
	}
}