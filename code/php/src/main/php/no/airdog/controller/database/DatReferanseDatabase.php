<?php 

class DatReferanseDatabase
{
	public static function hentReferanse($tekst, $database)
	{
		$select = $database->select()
		->from(array('d'=>'ad_datreferanse'), array())
		->where('d.hash=?', sha1($tekst))
		->limit(1);
		
		return $database->fetchRow($select);
	}
}