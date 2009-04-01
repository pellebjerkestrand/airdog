<?php
require_once "FilvaliderController.php";

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

class DatOpplastningsController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}

	public function overskrivDatInnlegg($objekter, $objektType, $epost, $passord, $klubbId)
	{  	
		if(ValiderBruker::validerBrukerRettighet($this->database, $epost, $passord, $klubbId, "importerDatabase"))
		{	
			$size = sizeof($objekter);
			
			switch($objektType)
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
					return;
					
				case "Oppdrett":
					return;
					
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
			
			for ($i = 0; $i < $size; $i++)
	    	{
	    		if ($objekter[$i][1] == "true")
	    		{
		    		$verdier = $ep->getArray($objekter[$i][0]);
		    		$svar = $hd->overskriv($verdier, $klubbId);
	    		}
	    		else if ($objekter[$i][1]== "false")
	    		{
    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
	    		}
	    	}
	    	
			return $size;
		}
		
		$feilkode = 1;	
     	throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
}