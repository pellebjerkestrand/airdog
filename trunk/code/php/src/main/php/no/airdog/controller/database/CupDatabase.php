<?php
require_once 'Tilkobling.php';
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/model/AmfCup.php";

class CupDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentJaktproverForPeriode($fra, $til)
	{	
		$hvor = $this->database->select()
				->from('nkk_fugl')
				->where('proveDato > ?', $fra)
				->where('proveDato < ?', $til)
				->where('premiegrad != 0')
				->order('hundId ASC');
		
		$resultat = $this->database->fetchAll($hvor);
		
		return $resultat;
	}
}