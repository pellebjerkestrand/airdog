<?php
require_once 'EierParser.php';
require_once 'FuglParser.php';
require_once 'HdsykdomParser.php';
require_once 'HundParser.php';
require_once 'KullParser.php';
require_once 'OppdrettParser.php';
require_once 'PersonParser.php';
require_once 'PremieParser.php';
require_once 'UtstillingParser.php';
require_once 'VeterinerParser.php';
require_once 'AasykdomParser.php';

class Filvalider
{
	public function Filvalider()
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