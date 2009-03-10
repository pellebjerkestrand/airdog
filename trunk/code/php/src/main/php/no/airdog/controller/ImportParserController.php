<?php
require_once "FilvaliderController.php";
require_once "database/HundDatabase.php";
require_once "database/JaktproveDatabase.php";
require_once "database/ValiderBruker.php";
require_once 'database/Tilkobling.php';

class importParserController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}

	public function lagreDb($filSti, $epost, $passord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $epost, $passord, $klubbId, "lese"))
		{
			$valider = new FilvaliderController();
			$filtype = $valider->getFiltypeFraFil($filSti);
			
			$handle = fopen($filSti, "rb");
			$liste = fread($handle, filesize($filSti));
			fclose($handle);
			
			$liste = str_replace("\r\n", "\n", $liste);
			$listeArray = split("\n", $liste);
			
			$ret = "";
			
			
			switch($filtype)
			{
				case "Eier":
					$ep = new EierParser();
					$ep->getEierlisteArrayFraFil($filSti);
					break;
				case "Fugl":
					$ep = new FuglParser();
					$hd = new JaktproveDatabase();
					$size = sizeof($listeArray);
					
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$ret .= "\r" . $hd->settInnJaktprove($ep->getFuglArray($listeArray[$i]), $klubbId);
			    	}
			    	
			    	return $ret;
				case "Hdsykdom":
					$ep = new HdsykdomParser();
					$ep->getHdsykdomlisteArrayFraFil($filSti);
					break;
				case "Hund":
					$ep = new HundParser();
					$hd = new HundDatabase();
					$size = sizeof($listeArray);
					
					for ($i = 1; $i < $size; $i++)
			    	{
			    		$ret .= "\r" . $hd->settInnHund($ep->getHundArray($listeArray[$i]), $klubbId);
			    	}
			    	
					return $ret;
				case "Kull":
					$ep = new KullParser();
					$ep->getKulllisteArrayFraFil($filSti);
					break;
				case "Oppdrett":
					$ep = new OppdrettParser();
					$ep->getOppdrettlisteArrayFraFil($filSti);
					break;
				case "Person":
					$ep = new PersonParser();
					$ep->getPersonlisteArrayFraFil($filSti);
					break;
				case "Premie":	
					$ep = new PremieParser();
					$ep->getPremielisteArrayFraFil($filSti);
					break;
				case "Utstilling":
					$ep = new UtstillingParser();
					$ep->getUtstillinglisteArrayFraFil($filSti);
					break;
				case "Veteriner":
					$ep = new VeterinerParser();
					$ep->getVeterinerlisteArrayFraFil($filSti);
					break;
				case "Aasykdom":
					$ep = new AasykdomParser();
					$ep->getAasykdomlisteArrayFraFil($filSti);
					break;
				case "Oyesykdom":
					$ep = new OyesykdomParser();
					$ep->getOyesykdomlisteArrayFraFil($filSti);
					break;
				default:
					return "Dette er en ukjent .dat fil";
				
			}
			
			return "En feil har oppstått";
		}
		
		$feilkode = 1;	
   		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
}