<?php
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/model/AmfCup.php";
require_once "no/airdog/controller/database/HundDatabase.php";
require_once "no/airdog/controller/database/PersonDatabase.php";
require_once "no/airdog/controller/database/CupDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class CupController
{
	private $database;
	
	private $klassenavn = array(
		'0' => '',
    	'1' => 'UK',
		'2' => 'AK',
		'3' => 'UK/AK',
		'4' => 'VK',
		'5' => 'VK SEMIFINALE',
		'6' => 'VK FINALE',
		'7' => 'UK KVALIK',
		'8' => 'UKK FINALE',
		'9' => 'DERBY KVALIK',
		'10' => 'DERBY SEMIFINALE',
		'11' => 'DERBY FINALE');
    	
    private $sertifikater = array(
    	'0' => '',
    	'1' => 'CK',
		'2' => 'CERT',
		'3' => 'CACIT',
		'4' => 'R CACIT',
		'5' => 'ÆP SKOG');
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentCupListe($fra, $til, $brukerEpost, $brukerPassord, $klubbId)
	{
		if($fra == '' || $til == '')
		{
			throw(new Exception('Fra- og tilfeltene må være fylt ut'));
		}
		
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$prover = $this->_hentJaktproverForPeriode($fra, $til);
			$cupliste = $this->_lagCuplisteFraProver($prover, $klubbId);
			$cupliste = $this->_leggTilPoeng($cupliste, $prover);
			
			return $cupliste;
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	private function _hentJaktproverForPeriode($fra, $til)
	{
		$cd = new CupDatabase();
		$resultat = $cd->hentJaktproverForPeriode($fra, $til);
		$ret = array();
	    	
	   	foreach($resultat as $rad) { 
	   		$tmp = new AmfJaktprove();
	    	$tmp->proveNr = $rad['proveNr'];   	
	    	$tmp->proveDato = $rad['proveDato']; 
	    	$tmp->partiNr = $rad['partiNr'];   	
	    	$tmp->klasse = $rad['klasse'];  	
	    	$tmp->hundId = $rad['hundId']; 	
	    	$tmp->premiegrad = $rad['premiegrad'];
	    	$tmp->certifikat = $rad['certifikat']; 	
	    	$tmp->premiegradTekst = $this->_hentPremiegrad($rad['premiegrad'], $rad['klasse'], $rad['certifikat']);
	    	
			$ret[] = $tmp;
		}
		
        return $ret;
	}
	
	private function _lagCuplisteFraProver($prover, $klubbId)
	{
		$hd = new HundDatabase();
		$pd = new PersonDatabase();
		
		$cupliste = array();
		
		//går gjennom prøvene
		foreach($prover as $prove)
		{
			$proveliste = array();
			$finnes = false;
			
			//går gjennom lista over hunder som allerede er i cuplista
			foreach($cupliste as $cup)
			{
				if($prove->hundId == $cup->hundId)
				{
					$finnes = true;
				}
			}
			
			//legger til hunden i cuplista hvis den ikke finnes der fra før
			if(!$finnes)
			{
				$tmp = new AmfCup();
				$tmp->hundId = $prove->hundId;
				
				$hund = $hd->hentKunHund($prove->hundId, $klubbId);
				$tmp->hundNavn = $hund['navn'];
				$tmp->tittel = $hund['tittel'];
				
				$tmp->prover = $proveliste;
				
				if($hund['eierId'] != '')
				{
					$pdres = $pd->hentPerson($hund['eierId'], $klubbId);
					$tmp->eier = $pdres['navn'];	
				}
				
				if($tmp->hundNavn != '')
				{
					$cupliste[] = $tmp;	
				}
			}
		}
		return $cupliste;
	}
	
	private function _leggTilPoeng($cupliste, $prover)
	{	
		foreach($cupliste as $cup)
		{	
			foreach($prover as $prove)
			{
				if($cup->hundId == $prove->hundId)
				{
					$tekst = $prove->premiegradTekst;
					$cup->prover[] = $prove->proveDato . ", " . $tekst;
					
					if(stripos($tekst, 'VK') !== false)
					{
						if(strpos($tekst, '1') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 8;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 9;
							}
							else
							{
								$cup->poeng += 6;
							}
						}
						else if(stripos($tekst, '2') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 7;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 8;	
							}
							else
							{
								$cup->poeng += 5;
							}
						}
						else if(stripos($tekst, '3') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 6;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 7;
							}
							else
							{
								$cup->poeng += 4;
							}
						}
						else if(stripos($tekst, '4') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 5;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 6;
							}
							else
							{
								$cup->poeng += 3;
							}
						}
						else if(stripos($tekst, '5') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 4;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 5;
							}
							else
							{
								$cup->poeng += 2;
							}
						}
						else if(stripos($tekst, '6') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 3;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 4;
							}
							else
							{
								$cup->poeng += 1;
							}
						}
					}
					
					if(stripos($tekst, 'AK') !== false || stripos($tekst, 'UK') !== false)
					{
						if(stripos($tekst, '1') !== false)
						{
							$cup->poeng += 3;
						}
						else if(stripos($tekst, '2') !== false)
						{
							$cup->poeng += 2;
						}
						else if(stripos($tekst, '3') !== false)
						{
							$cup->poeng += 1;
						}
					}
					
					if(stripos($tekst, 'CACIT') !== false)
					{
						$cup->poeng += 5;
					}
					if(stripos($tekst, 'CK') !== false)
					{
						$cup->poeng += 4;
					}
					if(stripos($tekst, 'NM MESTER') !== false)
					{
						$cup->poeng += 10;
					}
					
					if(stripos($tekst, 'PL') !== false)
					{
						if(stripos($tekst, '1') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 7;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								if(stripos($tekst, 'derby') !== false)
								{
									$cup->poeng += 19;	
								}
								else
								{
									$cup->poeng += 9;
								}
							}
							else
							{
								$cup->poeng += 6;
							}
						}
						else if(stripos($tekst, '2') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 6;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 8;
							}
							else
							{
								$cup->poeng += 5;
							}
						}
						else if(stripos($tekst, '3') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 5;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 7;
							}
							else
							{
								$cup->poeng += 4;	
							}
						}
						else if(stripos($tekst, '4') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 4;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 6;
							}
							else
							{
								$cup->poeng += 3;
							}
						}
						else if(stripos($tekst, '5') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 3;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 5;
							}
							else
							{
								$cup->poeng += 2;
							}
						}
						else if(stripos($tekst, '6') !== false)
						{
							if(stripos($tekst, 'semi') !== false)
							{
								$cup->poeng += 2;
							}
							else if(stripos($tekst, 'fin') !== false)
							{
								$cup->poeng += 4;
							}
							else
							{
								$cup->poeng += 1;
							}
						}
					}
				}
			}
		}
		return $cupliste;
	}
	
	private function _hentPremiegrad($premieGrad, $klasse, $sertifikat)
    {
    	$sert = "";
    	
    	if ($sertifikat != "")
    		$sert = " " . $this->sertifikater[$sertifikat];

    	return $premieGrad . "." . $this->klassenavn[$klasse] . $sert;
    }
}