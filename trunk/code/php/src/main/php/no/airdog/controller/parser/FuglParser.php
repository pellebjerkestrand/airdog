<?php

require_once "Verktoy.php";

class FuglParser
{
	public function FuglParser()
	{
	}
	
	public function getArray($enFugl)
	{
		$fuglArray = split('[|]', trim($enFugl));
		
		if (sizeof($fuglArray) == 38)
		{
			$ret = array (
			"proveNr" => $fuglArray[0],
			"proveDato" => Verktoy::konverterDatTilDatabaseDato($fuglArray[1]),
			"partiNr" => $fuglArray[2],
			"klasse" => $fuglArray[3],
			"dommerId1" => $fuglArray[4],
			"dommerId2" => $fuglArray[5],
			"hundId" => $fuglArray[6],
			"slippTid" => $fuglArray[7],
			"egneStand" => $fuglArray[8],
			"egneStokk" => $fuglArray[9],
			"tomStand" => $fuglArray[10],
			"makkerStand" => $fuglArray[11],
			"makkerStokk" => $fuglArray[12],
			"jaktlyst" => $fuglArray[13],
			"fart" => $fuglArray[14],
			"stil" => $fuglArray[15],
			"selvstendighet" => $fuglArray[16],
			"bredde" => $fuglArray[17],
			"reviering" => $fuglArray[18],
			"samarbeid" => $fuglArray[19],
			"presUpresis" => $fuglArray[20],
			"presNoeUpresis" => $fuglArray[21],
			"presPresis" => $fuglArray[22],
			"reisNekter" => $fuglArray[23],
			"reisNoelende" => $fuglArray[24],
			"reisVillig" => $fuglArray[25],
			"reisDjerv" => $fuglArray[26],
			"sokStjeler" => $fuglArray[27],
			"sokSpontant" => $fuglArray[28],
			"appIkkeGodkjent" => $fuglArray[29],
			"appGodkjent" => $fuglArray[30],
			"rappInnkalt" => $fuglArray[31],
			"rappSpont" => $fuglArray[32],
			"premiegrad" => $fuglArray[33],
			"certifikat" => $fuglArray[34],
			"regAv" => $fuglArray[35],
			"regDato" => Verktoy::konverterDatTilDatabaseDato($fuglArray[36]),
			"raseId" => $fuglArray[37]
			);
			
			unset($fuglArray);
			return $ret;
		}
	}
	
	public function getlisteArray($fuglliste)
	{
		$fuglliste = str_replace("\r\n", "\n", $fuglliste);
		$fugllisteArray = split("\n", $fuglliste);
		$ret = array();
		
		for ($i = 1; $i < sizeof($fugllisteArray); $i++)
    	{
    		$ret[] = $this->getArray($fugllisteArray[$i]);
    	}
    	
    	return $ret;
	}
	
	public function getlisteArrayFraFil($filnavn)
	{
		$handle = fopen($filnavn, "rb");
		$fuglliste = fread($handle, filesize($filnavn));
		fclose($handle);

		return $this->getlisteArray($fuglliste);
	}
	
	public function validerFugllisteFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->validerFuglliste($innhold[0]);
	}
	
	public function validerFuglliste($innhold)
	{
		// Sjekker at første linje inneholder riktig tabellinformasjon
		if (trim($innhold) == "ProeveNr|ProveDato|PartiNr|Klasse|PEID_Domm1|PEID_Domm2|HUID|SlippTid|EgneStand|EgneStoekk|TomStand|MakkerStand|MakkerStoekk|JaktLyst|Fart|Stil|Selvstendighet|Bredde|Reviering|Samarbeid|Pres_Upresis|Pres_NoeUpresis|Pres_Presis|Reis_Nekter|Reis_Noelende|Reis_Villig|Reis_Djerv|Sek_Stjeler|Sek_Spontan|App_IkkeGodkj|App_Godkj|Rapp_Innkalt|Rapp_Spont|Premiegrad|CERTIFIKAT|RegAv|RegDato|RAID")
		{
			return true;
		}
		
		return false;
	}
	
	public static function getDatabaseSomDat($fuglArray)
	{
		$dat = "$fuglArray[proveNr]|" .
	 		Verktoy::konverterDatabaseTilDatDato($fuglArray['proveDato'])."|" .
	 		"$fuglArray[partiNr]|" .
	 		"$fuglArray[klasse]|" .
	 		"$fuglArray[dommerId1]|" .
	 		"$fuglArray[dommerId2]|" .
	 		"$fuglArray[hundId]|" .
	 		"$fuglArray[slippTid]|" .
	 		"$fuglArray[egneStand]|" .
	 		"$fuglArray[egneStokk]|" .
	 		"$fuglArray[tomStand]|" .
	 		"$fuglArray[makkerStand]|" .
	 		"$fuglArray[makkerStokk]|" .
	 		"$fuglArray[jaktlyst]|" .
	 		"$fuglArray[fart]|" .
	 		"$fuglArray[stil]|" .
	 		"$fuglArray[selvstendighet]|" .
	 		"$fuglArray[bredde]|" .
	 		"$fuglArray[reviering]|" .
	 		"$fuglArray[samarbeid]|" .
	 		"$fuglArray[presUpresis]|" .
	 		"$fuglArray[presNoeUpresis]|" .
	 		"$fuglArray[presPresis]|" .
	 		"$fuglArray[reisNekter]|" .
	 		"$fuglArray[reisNoelende]|" .
	 		"$fuglArray[reisVillig]|" .
	 		"$fuglArray[reisDjerv]|" .
	 		"$fuglArray[sokStjeler]|" .
	 		"$fuglArray[sokSpontant]|" .
	 		"$fuglArray[appIkkeGodkjent]|" .
	 		"$fuglArray[appGodkjent]|" .
	 		"$fuglArray[rappInnkalt]|" .
	 		"$fuglArray[rappSpont]|" .
	 		"$fuglArray[premiegrad]|" .
	 		"$fuglArray[certifikat]|" .
	 		"$fuglArray[regAv]|" .	 		
	 		Verktoy::konverterDatabaseTilDatDato($fuglArray['regDato'])."|" .
	 		"$fuglArray[raseId]";
	 		
	 		return $dat;
	 					 			
	}
}