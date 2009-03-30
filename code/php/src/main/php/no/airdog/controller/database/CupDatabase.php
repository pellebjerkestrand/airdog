<?php
require_once 'Tilkobling.php';
require_once "no/airdog/model/AmfJaktprove.php";

class CupDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentCupListeForPeriode($fra, $til)
	{	
		$hvor = $this->database->select()
				->from('nkk_fugl')
				->where('proveDato > ?', $fra)
				->where('proveDato < ?', $til)
				->where('premiegrad != 0')
				->order('hundId ASC');
		
		return $this->database->fetchAll($hvor);
	}
}