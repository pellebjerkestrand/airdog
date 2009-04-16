<?php
require_once "no/airdog/model/AmfHund.php";
require_once "no/airdog/model/AmfAvkom.php";
require_once "no/airdog/controller/database/HundDatabase.php";
require_once "no/airdog/controller/database/KullDatabase.php";
require_once "no/airdog/controller/database/PersonDatabase.php";
require_once "no/airdog/controller/Verktoy.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class HundController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}

	public function sokHund($soketekst, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{	
	    	$hd = new HundDatabase();
	    	$resultat = $hd->sokHund($soketekst, $klubbId);
			
			$pd = new PersonDatabase();
			
	    	$ret = array();
	    	
		   	foreach($resultat as $rad)
		   	{   
		   		$bildeAdresse = "/images/" . $rad['raseId'] . "/" . eregi_replace('[^a-zA-Z0-9]','_',$rad['hundId']) . "_thumb.jpg";
		   		
		   		//For treg testet på server
		   		$bilde = Verktoy::hoppBakover(Verktoy::hvilkeUrl(), 3) . $bildeAdresse;
		   		
				$tmp = new AmfHund();
				$tmp->hundId = $rad["hundId"];
				$tmp->tittel = $rad["tittel"];
				$tmp->navn = $rad["navn"];
				
				if (file_exists(Verktoy::hoppBakover(dirname(__FILE__), 3) . $bildeAdresse))
				{
					$tmp->bilde = $bilde;
				}
				else
				{
					$tmp->bilde = "";
				}
			
				$tmp->morId = $rad["hundMorId"];
				$tmp->morNavn = $rad["hundMorNavn"];
				$tmp->farId = $rad["hundFarId"];
				$tmp->farNavn = $rad["hundFarNavn"];
				$tmp->idNr = $rad["idNr"];
				$tmp->oppdretterId = "oppdretterId";
				$tmp->oppdretter = "oppdretter";
				$tmp->eierId = $rad["eierId"];
				
				$pdres = $pd->hentPerson($rad["eierId"], $klubbId);
				$tmp->eier = $pdres["navn"];
				
				$tmp->kjonn = $rad["kjonn"];
				$tmp->raseId = $rad["raseId"];
				$tmp->kullId = $rad["kullId"];
				$tmp->farge = $rad["farge"];
				$tmp->fargeVariant = $rad["fargeVariant"];
				$tmp->oyesykdom = $rad["oyesykdom"];
				$tmp->hoftesykdom = $rad["hoftesykdom"];
				$tmp->haarlag = $rad["hoftesykdom"];
				$tmp->idMerke = $rad["idMerke"];
				$tmp->endretAv = $rad["endretAv"];
				$tmp->endretDato = $rad["endretDato"];
				$tmp->regDato = $rad["regDato"];
				$tmp->storrelse = $rad["storrelse"];
				$tmp->manueltEndretAv = $rad["manueltEndretAv"];
				$tmp->manueltEndretDato = $rad["manueltEndretDato"];
				
				//$tmp->vf = number_format($rad["vf"]);
				$ret[] = $tmp;
			}
	    	
	        return $ret;
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function hentHund($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{	
	    	$hd = new HundDatabase();
	    	$pd = new PersonDatabase();
	    	
	    	$rad = $hd->hentHund($hundId, $klubbId);   	
			
			$bildeAdresse = "/images/" . $rad['raseId'] . "/" . eregi_replace('[^a-zA-Z0-9]','_',$rad['hundId']) . ".jpg?id=".rand(1,1000);
		   		
	   		//For treg testet på server
	   		$bilde = Verktoy::hoppBakover(Verktoy::hvilkeUrl(), 3) . $bildeAdresse;;
			
			$tmp = new AmfHund();
			$tmp->hundId = $rad["hundId"];
			$tmp->tittel = $rad["tittel"];
			$tmp->navn = $rad["navn"];
			
			if (file_exists(Verktoy::hoppBakover(dirname(__FILE__), 3) . $bildeAdresse))
			{
				$tmp->bilde = $bilde;
			}
			else
			{
				$tmp->bilde = "";
			}
			
			$tmp->morId = $rad["hundMorId"];
			$tmp->morNavn = $rad["hundMorNavn"];
			$tmp->farId = $rad["hundFarId"];
			$tmp->farNavn = $rad["hundFarNavn"];
			$tmp->idNr = $rad["idNr"];
			$tmp->oppdretterId = "oppdretterId";
			$tmp->oppdretter = "oppdretter";
			$tmp->eierId = $rad["eierId"];
			
			if($tmp->eierId != null)
			{
				$pdres = $pd->hentPerson($tmp->eierId, $klubbId);
				$tmp->eier = $pdres["navn"];	
			}
			
			$tmp->kjonn = $rad["kjonn"];
			$tmp->raseId = $rad["raseId"];
			$tmp->kullId = $rad["kullId"];
			$tmp->farge = $rad["farge"];
			$tmp->fargeVariant = $rad["fargeVariant"];
			$tmp->oyesykdom = $rad["oyesykdom"];
			$tmp->hoftesykdom = $rad["hoftesykdom"];
			$tmp->haarlag = $rad["hoftesykdom"];
			$tmp->idMerke = $rad["idMerke"];
			$tmp->endretAv = $rad["endretAv"];
			$tmp->endretDato = $rad["endretDato"];
			$tmp->regDato = $rad["regDato"];
			$tmp->storrelse = $rad["storrelse"];
			$tmp->manueltEndretAv = $rad["manueltEndretAv"];
			$tmp->manueltEndretDato = $rad["manueltEndretDato"];
			$tmp->vf = number_format($rad["vf"]);
				
	        return $tmp;
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
    public function redigerHund(AmfHund $hund, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "redigerHund"))
		{	
		  	$ret = array();
	    	$ret['raseId'] = $klubbId;
	    	$ret['kullId'] = $hund->kullId;    	
	    	$ret['hundId'] = $hund->hundId;
	    	$ret['tittel'] = $hund->tittel;    	 
	    	$ret['navn'] = $hund->navn;    	
	    	$ret['hundFarId'] = $hund->farId;
	    	$ret['hundMorId'] = $hund->morId;   	 
	    	$ret['idNr'] = $hund->idNr;   
			$ret['farge'] = $hund->farge;		
	    	$ret['fargeVariant'] = $hund->fargeVariant;
	    	$ret['oyesykdom'] = $hund->oyesykdom;
	    	$ret['hoftesykdom'] = $hund->hoftesykdom;
	    	$ret['haarlag'] = $hund->haarlag;
	    	$ret['idMerke'] = $hund->idMerke;
	    	$ret['kjonn'] = $hund->kjonn;
	    	$ret['eierId'] = $hund->eierId;  
	    	$ret['endretAv'] = $hund->endretAv;
	    	$ret['endretDato'] = $hund->endretDato;
	    	$ret['regDato'] = $hund->regDato;
	    	$ret['storrelse'] = $hund->storrelse;
	    	$ret['manueltEndretAv'] = $hund->manueltEndretAv;
	    	$ret['manueltEndretDato'] = $hund->manueltEndretDato;
	    	
	    	$hd = new HundDatabase();
	    	
	    	
	    	return $resultat = $hd->redigerHund($ret);
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	public function hentFiktivtStamtre($hundIdFar, $hundIdMor, $dybde, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{	
			$dybde--;
			$hd = new HundDatabase();
			
			if ($hd->hentHund($hundIdFar, $klubbId) == null)
			{
				$feilkode = 2;
				throw(new Exception('Hunden ' . $hundIdFar . ' ble ikke funnet.', $feilkode));
			} 
			else if ($hd->hentHund($hundIdMor, $klubbId) == null)
			{
				$feilkode = 2;
				throw(new Exception('Hunden ' . $hundIdMor . ' ble ikke funnet.', $feilkode));
			}
			else
			{
				$tmp = new AmfHund();
				
				$tmp->navn = "Fiktiv";
				$tmp->tittel = "";
				$tmp->hundId = "";
				
				$tmp->far = $this->lagStamtre($hundIdFar, $dybde, $klubbId);
				$tmp->mor = $this->lagStamtre($hundIdMor, $dybde, $klubbId);
				
				return $tmp;
			}
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
    public function hentStamtre($hundId, $dybde, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{	
    		return $this->lagStamtre($hundId, $dybde, $klubbId);
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
	private function hentStamtreHund($hundId, $klubbId)
    {
    	$hd = new HundDatabase();
    	$rad = $hd->hentStamtreHund($hundId, $klubbId);

    	$tmp = new AmfHund();
    	
    	if ($rad != null)
    	{
			$tmp->hundId = $rad["hundId"];
			$tmp->tittel = $rad["tittel"];
			$tmp->navn = $rad["navn"];
			$tmp->bilde = "";
			$tmp->morId = $rad["hundMorId"];
			$tmp->farId = $rad["hundFarId"];
			$tmp->kjonn = $rad["kjonn"];
    	}
        return $tmp;
    }
    
    private function lagStamtre($hundId, $dybde, $klubbId)
    {
		$hund = $this->hentStamtreHund($hundId, $klubbId);
				
		if($hund && $dybde > 0)
		{	
			if($hund->farId)
			{
				$hund->far = $this->lagStamtre($hund->farId, $dybde - 1, $klubbId);
			}

			if($hund->morId)
			{
				$hund->mor = $this->lagStamtre($hund->morId, $dybde - 1, $klubbId);
			}
		}
		
		return $hund;
    }
    
    public function hentAvkom($hundId, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	$avkomListe = array();
	    	$kd = new KullDatabase();
	    	
	    	$pd = new PersonDatabase();
	    	
		    $hundListe = $kd->hentAvkom($hundId, $klubbId);
		    $avkomHundListe = array();
		    
		    foreach($hundListe as $rad)
		   	{    	
				$tmp = new AmfHund();
				$tmp->hundId = $rad["hundId"];
				$tmp->tittel = $rad["tittel"];
				$tmp->navn = $rad["navn"];
				$tmp->bilde = "";
				$tmp->morId = $rad["hundMorId"];
				$tmp->morNavn = $rad["hundMorNavn"];
				$tmp->farId = $rad["hundFarId"];
				$tmp->farNavn = $rad["hundFarNavn"];
				$tmp->eierId = $rad["eierId"];
				
				$pdres = $pd->hentPerson($rad["eierId"], $klubbId);
				$tmp->eier = $pdres["navn"];
				
				$tmp->kjonn = $rad["kjonn"];
				$tmp->rase = $rad["raseId"];
				$tmp->kullId = $rad["kullId"];
				$tmp->idNr = $rad["idNr"];
				
				$tmp->hd = $rad["hoftesykdom"];
				
				if ($rad["start"] >> 0)
					$tmp->start = sprintf("%u", $rad["start"]);
					
				if ($rad["jl"] >> 0)	
					$tmp->jl = number_format($rad["jl"], 1, ',', '');
				
				if ($rad["selv"] >> 0)	
					$tmp->selv = number_format($rad["selv"], 1, ',', '');
				
				if ($rad["sok"] >> 0)	
					$tmp->sok = number_format($rad["sok"], 1, ',', '');
				
				if ($rad["vf"] >> 0)	
					$tmp->vf = number_format($rad["vf"], 1, ',', '');
				
				if ($rad["rev"] >> 0)	
					$tmp->rev = number_format($rad["rev"], 1, ',', '');
				
				if ($rad["sam"] >> 0)	
					$tmp->sam = number_format($rad["sam"], 1, ',', '');
				
				
				if (sprintf("%u", $rad["bestPlUk"]) >> 0 && sprintf("%u", $rad["bestPlUk"]) << sprintf("%u", $rad["bestPlAk"]))
				{
					$tmp->bestPl = sprintf("%u", $rad["bestPlUk"]); // . ". UK";
				}
				else if (sprintf("%u", $rad["bestPlAk"]) >> 0)
				{
					$tmp->bestPl = sprintf("%u", $rad["bestPlAk"]) . ". AK";
				}
				else
				{
					$tmp->bestPl = "-";
				}
				
				$avkomFinnes = false;
				
				foreach($avkomListe as $avkom)
				{
					if ($avkom->kullId == $tmp->kullId && 
					($avkom->medId == $tmp->morId || $avkom->medId == $tmp->farId))
					{
						$avkomFinnes = true;
						$avkom->liste[] = $tmp;
					}
				}
				
				if (!$avkomFinnes)
				{
					$avkom = new AmfAvkom();
					
					if ($hundId == $tmp->morId)
					{
						$avkom->med = $tmp->farNavn;
						$avkom->medId = $tmp->farId;
					}
					else
					{
						$avkom->med = $tmp->morNavn;
						$avkom->medId = $tmp->morId;
					}
					$avkom->kullId = $tmp->kullId;
					$avkom->liste = array();
					
					$avkom->liste[] = $tmp;
					
					$avkomListe[] = $avkom;
				}
			}
	
	        return $avkomListe;
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
    
    public function sokArsgjennomsnitt($hund, $ar, $brukerEpost, $brukerPassord, $klubbId)
    {
    	if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
	    	$hd = new HundDatabase();
	    	$resultat = $hd->sokArsgjennomsnitt($hund, $ar, $klubbId);
	
	    	$ret = array();
	    	
		   foreach($resultat as $rad) { 
				$tmp = array();
				$tmp["hundId"] = $rad["hundId"];
				$tmp["navn"] = $rad["navn"];
				$tmp["hundFarNavn"] = $rad["hundFarNavn"];
				$tmp["hundFarId"] = $rad["hundFarId"];
				$tmp["hundMorNavn"] = $rad["hundMorNavn"];
				$tmp["hundMorId"] = $rad["hundMorId"];
				
				if ($rad["es"] >> 0)
					$tmp["es"] = number_format($rad["es"], 1, ',', '');
					
				if ($rad["ms"] >> 0)
					$tmp["ms"] = number_format($rad["ms"], 1, ',', '');
					
				if ($rad["vf"] >> 0)
					$tmp["vf"] = number_format($rad["vf"], 1, ',', '');
					
				if ($rad["eso"] >> 0)
					$tmp["eso"] = number_format($rad["eso"], 1, ',', '');
					
				if ($rad["mso"] >> 0)
					$tmp["mso"] = number_format($rad["mso"], 1, ',', '');
					
				if ($rad["ts"] >> 0)
					$tmp["ts"] = number_format($rad["ts"], 1, ',', '');
				
		   		if ($rad["starter"] >> 0)
					$tmp["starter"] = sprintf("%u", $rad["starter"]);
					
				if ($rad["jl"] >> 0)
					$tmp["jl"] = number_format($rad["jl"], 1, ',', '');
					
				if ($rad["fa"] >> 0)
					$tmp["fa"] = number_format($rad["fa"], 1, ',', '');
					
				if ($rad["st"] >> 0)
					$tmp["st"] = number_format($rad["st"], 1, ',', '');
					
				if ($rad["selv"] >> 0)
					$tmp["ss"] = number_format($rad["selv"], 1, ',', '');
					
				if ($rad["sok"] >> 0)
					$tmp["sb"] = number_format($rad["sok"], 1, ',', '');
					
				if ($rad["rev"] >> 0)
					$tmp["rv"] = number_format($rad["rev"], 1, ',', '');
					
				if ($rad["sam"] >> 0)
					$tmp["sa"] = number_format($rad["sam"], 1, ',', '');
				
				if (sprintf("%u", $rad["bestePl"]) >> 0)
				{
					$tmp["bestePl"] = sprintf("%u", $rad["bestePl"]);
				}
				else
				{
					$tmp["bestePl"] = "-";
				}
				
				$ret[] = $tmp;
			}
			
	        return $ret;
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
    }
}