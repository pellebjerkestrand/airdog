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
		
		$this->svarListe[] = "";	// 0 = generelt resultat
		$this->svarListe[] = "";	// 1 = filtype
		$this->svarListe[] = 0;		// 2 = antall oppdaterte
		$this->svarListe[] = 0;		// 3 = antall lagt til
		$this->svarListe[] = 0;		// 4 = antall ignorerte
	}

	public function lagreDb($filSti, $epost, $passord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $epost, $passord, $klubbId, "importerDatabase"))
		{
			$valider = new FilvaliderController();
			$filtype = $valider->getFiltypeFraFil($filSti);
			
			$handle = fopen($filSti, "rb");
			$liste = utf8Konverterer::cp1252_to_utf8(fread($handle, filesize($filSti)));
			fclose($handle);
			
			$liste = str_replace("\r\n", "\n", $liste);
			$listeArray = split("\n", $liste);
			
			$ret = "";
			$size = sizeof($listeArray);
			
			$this->svarListe[1] = $filtype;
			
			switch($filtype)
			{
				case "Eier":
					$ep = new EierParser();
					$hd = new EierDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnEier($ep->getEierArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
			    	break;
					
				case "Fugl":
					$ep = new FuglParser();
					$hd = new JaktproveDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnJaktprove($ep->getFuglArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
			    	break;
			    	
				case "Hdsykdom":
					$ep = new HdsykdomParser();
					$hd = new HdsykdomDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnHdsykdom($ep->getHdsykdomArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
			    	break;
					
				case "Hund":
					$ep = new HundParser();
					$hd = new HundDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnHund($ep->getHundArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
					break;
					
				case "Kull":
					return "Ikke implementert ennå.";
					
				case "Oppdrett":
					return "Ikke implementert ennå.";
					
				case "Person":
					$ep = new PersonParser();
					$hd = new PersonDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnPerson($ep->getPersonArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
					break;
					
				case "Premie":
					$ep = new PremieParser();
					$hd = new PremieDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnPremie($ep->getPremieArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
					break;
					
				case "Utstilling":
					$ep = new UtstillingParser();
					$hd = new UtstillingDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnUtstilling($ep->getUtstillingArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
					break;
					
				case "Veteriner":
					$ep = new VeterinerParser();
					$hd = new VeterinerDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnVeteriner($ep->getVeterinerArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
			    	break;
					
				case "Aasykdom":
					$ep = new AasykdomParser();
					$hd = new AasykdomDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnAasykdom($ep->getAasykdomArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
			    	break;
					
				case "Oyesykdom":
					$ep = new OyesykdomParser();
					$hd = new OyesykdomDatabase();
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$svar = $hd->settInnOyesykdom($ep->getOyesykdomArray($listeArray[$i]), $klubbId);
			    		$this->velgHandling($svar, $listeArray[$i]);
			    	}
			    	break;
					
				default:
					return "Dette er en ukjent .dat fil";
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
	
/*	$this->svarListe[] = "";	// 0 = generelt resultat
	$this->svarListe[] = "";	// 1 = filtype
	$this->svarListe[] = 0;		// 2 = antall oppdaterte
	$this->svarListe[] = 0;		// 3 = antall lagt til
	$this->svarListe[] = 0;		// 4 = antall ignorerte*/
		
	private function velgHandling($svar, $verdi)
	{
		switch($svar)
	    	{
	    		case "Lagt til":
	    			$this->svarListe[3]++;
	    			break;
	    			
    			case "Oppdatert":
	    			$this->svarListe[2]++;
	    			break;
	    			
    			case "Finnes alt i DATreferanser tabellen.": 
	    			$this->svarListe[4]++;
	    			break;
	    			
	    		case "Manuelt endret, vil du overskrive?":	    			
	    			$this->svarListe[] = $verdi;
	    			break;
	    			
	    		default:
	    			if ($verdi != "")
	    				$this->svarListe[0] .= "\r" . $svar;
	    	}
	}
}