<?php
require_once "FilvaliderController.php";
require_once "database/HundDatabase.php";

class importParserController
{
	
	public function __construct()
	{
	}

	public function lagreDb($filSti, $epost, $passord, $klubbId)
	{
		$valider = new FilvaliderController();
		$filtype = $valider->getFiltypeFraFil($filSti);
		
		switch($filtype)
		{
			case "Eier":
				$ep = new EierParser();
				$ep->getEierlisteArrayFraFil($filSti);
				break;
			case "Fugl":
				$ep = new FuglParser();
				$ep->getFugllisteArrayFraFil($filSti);
				break;
			case "Hdsykdom":
				$ep = new HdsykdomParser();
				$ep->getHdsykdomlisteArrayFraFil($filSti);
				break;
			case "Hund":
				$ep = new HundParser();
				$hd = new HundDatabase();
				return $hd->settInnHundArray($ep->getHundelisteArrayFraFil($filSti), $epost, $passord, $klubbId);
				break;
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
}