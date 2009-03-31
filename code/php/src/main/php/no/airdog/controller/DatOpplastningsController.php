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
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getEierArray($objekter[$i][0]);
				    		$svar = $hd->overskrivEier($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Fugl":
					$ep = new FuglParser();
					$hd = new JaktproveDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getFuglArray($objekter[$i][0]);
				    		$svar = $hd->overskrivJaktprove($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
			    	
				case "Hdsykdom":
					$ep = new HdsykdomParser();
					$hd = new HdsykdomDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getHdsykdomArray($objekter[$i][0]);
				    		$svar = $hd->overskrivHdsykdom($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Hund":
					$ep = new HundParser();
					$hd = new HundDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getHundArray($objekter[$i][0]);
				    		$svar = $hd->overskrivHund($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Kull":
					return;
					
				case "Oppdrett":
					return;
					
				case "Person":
					$ep = new PersonParser();
					$hd = new PersonDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getPersonArray($objekter[$i][0]);
				    		$svar = $hd->overskrivPerson($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Premie":
					$ep = new PremieParser();
					$hd = new PremieDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getPremieArray($objekter[$i][0]);
				    		$svar = $hd->overskrivPremie($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Utstilling":
					$ep = new UtstillingParser();
					$hd = new UtstillingDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getUtstillingArray($objekter[$i][0]);
				    		$svar = $hd->overskrivUtstilling($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Veteriner":
					$ep = new VeterinerParser();
					$hd = new VeterinerDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getVeterinerArray($objekter[$i][0]);
				    		$svar = $hd->overskrivVeteriner($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Aasykdom":
					$ep = new AasykdomParser();
					$hd = new AasykdomDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getAasykdomArray($objekter[$i][0]);
				    		$svar = $hd->overskrivAasykdom($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				case "Oyesykdom":
					$ep = new OyesykdomParser();
					$hd = new OyesykdomDatabase();
					for ($i = 0; $i < $size; $i++)
			    	{
			    		if ($objekter[$i][1] == "true")
			    		{
				    		$verdier = $ep->getOyesykdomArray($objekter[$i][0]);
				    		$svar = $hd->overskrivOyesykdom($verdier, $klubbId);
			    		}
			    		else if ($objekter[$i][1]== "false")
			    		{
		    				DatReferanseDatabase::settReferanse($objekter[$i][0], $epost, $this->database);
			    		}
			    	}
					return $size;
					
				default:
					return "Dette er en ukjent .dat fil";
			}
		}
		
		$feilkode = 1;	
     	throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
}