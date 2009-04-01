<?php
require_once "FilvaliderController.php";
require_once 'utf8Konverterer.php';

require_once "database/HundDatabase.php";
require_once "database/UtstillingDatabase.php";
require_once "database/PremieDatabase.php";
require_once "database/JaktproveDatabase.php";
require_once "database/PersonDatabase.php";
require_once "database/EierDatabase.php";
require_once "database/HdsykdomDatabase.php";
require_once "database/AasykdomDatabase.php";
require_once "database/OyesykdomDatabase.php";
require_once "database/VeterinerDatabase.php";

require_once "database/ValiderBruker.php";
require_once 'database/Tilkobling.php';

//require_once 'model/AmfOpplastningObjekt.php';

class importParserController
{
	private $database;
	private $svarListe = array();
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
		
		$this->svarListe[] = "";	// 0 = generelt søppel (Firefox hack ftw!!)
		$this->svarListe[] = "";	// 1 = generelt resultat
		$this->svarListe[] = "";	// 2 = filtype
		$this->svarListe[] = 0;		// 3 = antall oppdaterte
		$this->svarListe[] = 0;		// 4 = antall lagt til
		$this->svarListe[] = 0;		// 5 = antall ignorerte
	}

	public function lagreDb($filSti, $epost, $passord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $epost, $passord, $klubbId, "importerDatabase"))
		{
			$valider = new FilvaliderController();
			
			
			
			
//			$liste = fread($handle, filesize($filSti));
//			fclose($handle);
//
//			$liste = str_replace("\r\n", "\n", $liste);
//			
//			// utf8Konverterer::cp1252_to_utf8(
//			$listeArray = @split("[|]", $liste);
//			//echo $listeArray[0];
//			echo "---";
//			return;
//			
//			$size = sizeof($listeArray);
    		
			
			
			$handle = fopen($filSti, "r");
			if ($handle) 
			{
				$tekst = utf8Konverterer::cp1252_to_utf8(fgets($handle, 4096));
				$filtype = $valider->getFiltype($tekst);
				$ret = "";
				$this->svarListe[1] = $filtype;
			
				switch($filtype)
				{
					case "Eier":
						$ep = new EierParser();
						$hd = new EierDatabase();
				    	break;
						
					case "Fugl":
						$ep = new FuglParser();
						$hd = new JaktproveDatabase();
				    	break;
				    	
					case "Hdsykdom":
						$ep = new HdsykdomParser();
						$hd = new HdsykdomDatabase();
				    	break;
						
					case "Hund":
						$ep = new HundParser();
						$hd = new HundDatabase();
						break;
						
					case "Kull":
						return "Ikke implementert ennå.";
						
					case "Oppdrett":
						return "Ikke implementert ennå.";
						
					case "Person":
						$ep = new PersonParser();
						$hd = new PersonDatabase();
						break;
						
					case "Premie":
						$ep = new PremieParser();
						$hd = new PremieDatabase();
						break;
						
					case "Utstilling":
						$ep = new UtstillingParser();
						$hd = new UtstillingDatabase();
						break;
						
					case "Veteriner":
						$ep = new VeterinerParser();
						$hd = new VeterinerDatabase();
				    	break;
						
					case "Aasykdom":
						$ep = new AasykdomParser();
						$hd = new AasykdomDatabase();
				    	break;
						
					case "Oyesykdom":
						$ep = new OyesykdomParser();
						$hd = new OyesykdomDatabase();
				    	break;
						
					default:
						return "Dette er en ukjent .dat fil";
				}
			
				$x = 0;
		
			    while (!feof($handle)) 
			    {
			        $tekst = utf8Konverterer::cp1252_to_utf8(fgets($handle, 4096));
			        $tekst = str_replace("\r\n", "\n", $tekst);
			        $tekst = str_replace("\n", "", $tekst);
			        
			        $svar = $hd->settInn($ep->getArray($tekst), $klubbId);
		    		$this->velgHandling($svar, $tekst);
		    		
		    		if ($x > 100)	// Spytt ut firefox "søppel" hver 100 rad for at tilkoblingen ikke skal stoppe.
		    		{
		    			echo ' ----- ';
		    			$x = 0;
		    		}
		    		$x++;
			    }
			    
			    fclose($handle);
			}

			$ret = "";
			$splitter = "";
			foreach ($this->svarListe as $svar)
			{
				$ret .= $splitter . $svar;
				$splitter = "###";
			}
			
			return $ret;
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
/*	$this->svarListe[] = "";	// 0 = generelt søppel (Firefox hack ftw!!)
	$this->svarListe[] = "";	// 1 = generelt resultat
	$this->svarListe[] = "";	// 2 = filtype
	$this->svarListe[] = 0;		// 3 = antall oppdaterte
	$this->svarListe[] = 0;		// 4 = antall lagt til
	$this->svarListe[] = 0;		// 5 = antall ignorerte*/
		
	private function velgHandling($svar, $verdi)
	{
		switch($svar)
	    	{
	    		case "Lagt til":
	    			$this->svarListe[4]++;
	    			break;
	    			
    			case "Oppdatert":
	    			$this->svarListe[3]++;
	    			break;
	    			
    			case "Finnes alt i DATreferanser tabellen.": 
	    			$this->svarListe[5]++;
	    			break;
	    			
	    		case "Manuelt endret, vil du overskrive?":	    			
	    			$this->svarListe[] = $verdi;
	    			break;
	    			
	    		default:
	    			if ($verdi != "")
	    				$this->svarListe[1] .= "\r" . $svar;
    				break;
	    	}
	}
}