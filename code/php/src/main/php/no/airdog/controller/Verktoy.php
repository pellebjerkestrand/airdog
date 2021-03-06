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
	
	// Inn: 2001-01-10
	// Ut:	10.01.2001
	public static function konverterDatabaseTilDatDato($dato)
	{
		$datoArray = split('[-]', trim($dato));
		
		if (!isset($datoArray[2]))
			return $dato;
		
		return $datoArray[2].".".$datoArray[1].".".$datoArray[0];
	}
	
	//FOR TREG testet på server
	public static function hvilkeUrl() 
	{
		 $url = 'http://';
		 
		 if ($_SERVER["SERVER_PORT"] != "80") 
		 {
		 	$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 }
		 else
		 {
		 	$url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $url;
	}
	
	//FOR TREG testet på server
	public static function hoppBakover($url, $antall)
	{	
		$url = str_replace("\\","/",$url);
		
		$url = split("/", $url);
		$sti = "";
		
		$strek = "";
		
		for ($i = 0; $i < sizeof($url) - $antall; $i++)
		{
			$sti .= $strek . $url[$i];
			$strek = "/";
		}
		
		return $sti;
	}
	
	public static function url_finnes($url) 
	{ 
    	$hd = @get_headers($url); 
    	return is_array($hd) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hd[0]) : false; 
	}
	
	public static function fjernFilEndelse($fil) 
	{ 
		$ext = strrchr($fil, '.'); 
	
		if($ext !== false) 
		{ 
			$fil = substr($fil, 0, -strlen($ext)); 
		} 
		
		return $fil; 
	} 
	
	
	public static function logging($var) 
	{
   		$filnavn = dirname(__FILE__) . PATH_SEPARATOR .'__logg.txt';

		if (!$fil = fopen($filnavn, 'a')) 
		{
			echo "Kan ikke lage filen ($filename)";
			return;
		}

	    $innhold = var_export($var, true);
	    fwrite($fil, "[" . date("y-m-d H:i:s") . "]");
	   	fwrite($fil, "\n");
	    fwrite($fil, $innhold);
	    fwrite($fil, "\n");
	    fclose($fil);
 	} 	
 	
	public static function fyll_RTF($variabler, $rtf_fil) 
	{                     
        $dokument = file_get_contents($rtf_fil);

        if(!$dokument) 
        {
            return false;
        }
		
//        $regex = array('\\' => "\\\\",
//       '{'  => "\{",
//       '}'  => "\}");   
		
        foreach($variabler as $nokkel => $v) 
        {
        	if (!is_array($v))
        	{
	            $sok = "%%".strtoupper($nokkel)."%%";
	                  
//            	//Gjør spesialtegn leslige
//            	foreach($regex as $verdi => $bytt) 
//            	{
//                	$v = str_replace($verdi, $bytt, $v);
//            	}

	            //$v = mb_convert_case($v, MB_CASE_TITLE, "UTF-8");

				$utf8 = array("æ", "ø", "å", "Æ", "Ø", "Å", "ö", "ä", "ô", "â", "Ö", "Ä", "Ô", "Â");
				$rtftegn   = array("\\'e6", "\\'f8", "\\'e5", "\\'c6", "\\'d8", "\\'c5", "\\'f6", "\\'e4", "\\'f4", "\\'e2", "\\'d6", "\\'c4", "\\'d4", "\\'c2");
	        	$v = str_replace($utf8,$rtftegn, $v);
				
	            $dokument = str_replace($sok, $v, $dokument);
        	}
        }
        
        $dokument = ereg_replace("%%[A-Z0-9]+%%", "", $dokument);
		
		return $dokument;

    }
}