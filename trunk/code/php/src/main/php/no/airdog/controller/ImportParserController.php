<?php
require_once "FilvaliderController.php";
require_once "database/HundDatabase.php";

class importParserController
{
	
	public function __construct()
	{
	}

	public function lagreDb($filSti)
	{
		$valider = new FilvaliderController();
		$filtype = $valider->getFiltypeFraFil($filSti);
		
		switch($filtype)
		{
			case "Eier":
				$ep = new EierParser();
				$ep->getEierlisteArrayFraFil($filtype);
				break;
			case "Fugl":
				$ep = new FuglParser();
				$ep->getFugllisteArrayFraFil($filtype);
				break;
			case "Hdsykdom":
				$ep = new HdsykdomParser();
				$ep->getHdsykdomlisteArrayFraFil($filtype);
				break;
			case "Hund":
				$ep = new HundParser();
				//$hd = new HundDatabase();
				//return $hd->settInnHund($ep->getHundelisteArrayFraFil($filtype));
				break;
			case "Kull":
				$ep = new KullParser();
				$ep->getKulllisteArrayFraFil($filtype);
				break;
			case "Oppdrett":
				$ep = new OppdrettParser();
				$ep->getOppdrettlisteArrayFraFil($filtype);
				break;
			case "Person":
				$ep = new PersonParser();
				$ep->getPersonlisteArrayFraFil($filtype);
				break;
			case "Premie":	
				$ep = new PremieParser();
				$ep->getPremielisteArrayFraFil($filtype);
				break;
			case "Utstilling":
				$ep = new UtstillingParser();
				$ep->getUtstillinglisteArrayFraFil($filtype);
				break;
			case "Veteriner":
				$ep = new VeterinerParser();
				$ep->getVeterinerlisteArrayFraFil($filtype);
				break;
			case "Aasykdom":
				$ep = new AasykdomParser();
				$ep->getAasykdomlisteArrayFraFil($filtype);
				break;
			case "Oyesykdom":
				$ep = new OyesykdomParser();
				$ep->getOyesykdomlisteArrayFraFil($filtype);
				break;
			default:
				return "Dette er en ukjent .dat fil";
			
		}
		
		return "En feil har oppstŒtt";
	}
}