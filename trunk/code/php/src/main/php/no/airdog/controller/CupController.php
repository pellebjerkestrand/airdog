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
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentCupListe($fra, $til, $limit, $brukerEpost, $brukerPassord, $klubbId)
	{
		if($fra == '' || $til == '')
		{
			throw(new Exception('Fra- og tilfeltene må være fylt ut'));
		}
		
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$prover = $this->_hentJaktproverForPeriode($fra, $til);
			$cupliste = $this->_lagCuplisteFraProver($prover, $klubbId);
			
			//trenger poeng og plassering
			
			return $cupliste;
		}
		$feilkode = 1;
		throw(new Exception('Du har ikke denne rettigheten', $feilkode));
	}
	
	private function _hentJaktproverForPeriode($fra, $til)
	{
		$cd = new CupDatabase();
		return $cd->hentJaktproverForPeriode($fra, $til);
	}
	
	private function _lagCuplisteFraProver($prover, $klubbId)
	{
		$hd = new HundDatabase();
		$pd = new PersonDatabase();
			
		$cupliste = array();
		
		foreach($prover as $prove)
		{
			$proveliste = array();
			$finnes = false;
			
			foreach($cupliste as $cup)
			{
				if($prove['hundId'] == $cup->hundId)
				{
					$finnes = true;
				}
			}
			
			if(!$finnes)
			{
				$tmp = new AmfCup();
				$tmp->hundId = $prove['hundId'];
				
				$hund = $hd->hentKunHund($prove['hundId'], $klubbId);
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
}