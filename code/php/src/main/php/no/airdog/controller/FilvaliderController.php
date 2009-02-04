<?php
require_once 'parser/EierParser.php';
require_once 'parser/FuglParser.php';
require_once 'parser/HdsykdomParser.php';
require_once 'parser/HundParser.php';
require_once 'parser/KullParser.php';
require_once 'parser/OppdrettParser.php';
require_once 'parser/PersonParser.php';
require_once 'parser/PremieParser.php';
require_once 'parser/UtstillingParser.php';
require_once 'parser/VeterinerParser.php';
require_once 'parser/AasykdomParser.php';

class FilvaliderController
{
	public function FilvaliderController()
	{
	}
	
	public function getFiltypeFraFil($filnavn)
	{
		$innhold = file($filnavn);		
		return $this->getFiltype($innhold[0]);
	}
	
	public function getFiltype($innhold)
	{
		$ep = new EierParser();
		if ($ep->validerEierliste($innhold)) { return "Eier"; }
		
		$ep = new FuglParser();
		if ($ep->validerFuglliste($innhold)) { return "Fugl"; }
		
		$ep = new HdsykdomParser();
		if ($ep->validerHdsykdomliste($innhold)) { return "Hdsykdom"; }
		
		$ep = new HundParser();
		if ($ep->validerHundeliste($innhold)) { return "Hund"; }
		
		$ep = new KullParser();
		if ($ep->validerKullliste($innhold)) { return "Kull"; }
		
		$ep = new OppdrettParser();
		if ($ep->validerOppdrettliste($innhold)) { return "Oppdrett"; }
		
		$ep = new PersonParser();
		if ($ep->validerPersonliste($innhold)) { return "Person"; }
		
		$ep = new PremieParser();
		if ($ep->validerPremieliste($innhold)) { return "Premie"; }
		
		$ep = new UtstillingParser();
		if ($ep->validerUtstillingliste($innhold)) { return "Utstilling"; }
		
		$ep = new VeterinerParser();
		if ($ep->validerVeterinerliste($innhold)) { return "Veteriner"; }
		
		$ep = new AasykdomParser();
		if ($ep->validerAasykdomliste($innhold)) { return "Aasykdom"; }
		
		return "Ukjent";
	}
}
?>