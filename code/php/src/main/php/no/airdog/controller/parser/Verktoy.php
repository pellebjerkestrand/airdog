<?php 
class Verktoy
{	
	// Inn: 10.01.2001
	// Ut:	2001-01-10
	public static function konverterDatTilDatabaseDato($dato)
	{
		$datoArray = split('[.]', trim($dato));
		
		if (!isset($datoArray[2]))
			return $dato;
		
		return $datoArray[2]."-".$datoArray[1]."-".$datoArray[0];
	}
}