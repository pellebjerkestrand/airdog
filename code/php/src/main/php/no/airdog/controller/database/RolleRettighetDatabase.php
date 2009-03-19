<?php 
require_once 'Tilkobling.php';

class RolleRettighetDatabase
{
	private $database;
	
	public function __construct() {
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentAlleRoller()
	{
		$hent = $this->database->select()
		->from('ad_rolle', array('ad_rolle.*'))
		->order('navn');;
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentAlleRettigheter()
	{
		$hent = $this->database->select()
		->from('ad_rettighet', array('ad_rettighet.*'))
		->order('navn');
		
		return $this->database->fetchAll($hent);
	}
	
	public function hentRollersRettigheter($rolle)
	{
		$hent = $this->database->select()
		->from('ad_rolle_rettighet_link', array('ad_rettighet_navn'))
		->where('ad_rolle_navn =?', $rolle)
		->order('ad_rettighet_navn');
		
		return $this->database->fetchAll($hent);
	}
	
	public function leggtilRettighetPaRolle($rolle, $rettighet)
	{		
		if($this->finnesRettighetPaRolle($rolle, $rettighet))
		{
			
			$data = array(
	   			'ad_rolle_navn'	=> $rolle,
	    		'ad_rettighet_navn' => $rettighet
			);
	
			return $this->database->insert('ad_rolle_rettighet_link', $data);
		}
		
		throw(new Exception('Rettigheten finnes allerede på denne rollen', "1"));
	}
	
	public function slettRettighetPaRolle($rolle, $rettighet)
	{
		if(!$this->finnesRettighetPaRolle($rolle, $rettighet))
		{
			$hvor = $this->database->quoteInto('ad_rolle_navn = ? ', $rolle) . 'AND ' . $this->database->quoteInto('ad_rettighet_navn = ? ', $rettighet);
			return $this->database->delete('ad_rolle_rettighet_link', $hvor);
		}
		
		throw(new Exception('Rettigheten er allerede slettet på denne rollen', "1"));
	}
	
	public function finnesRettighetPaRolle($rolle, $rettighet)
	{
		$hent = $this->database->select()
		->from('ad_rolle_rettighet_link', array('ad_rettighet_navn'))
		->where('ad_rolle_navn =?', $rolle)
		->where('ad_rettighet_navn =?', $rettighet);
		
		$gyldig = $this->database->fetchRow($hent);
		
		if($gyldig)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function leggInnNyRolle($rolle, $beskrivelse)
	{
		if($this->finnesRolle($rolle))
		{		
			$data = array(
		    	'navn'	=> $rolle,
		    	'beskrivelse' => $beskrivelse
			);
		
		return $this->database->insert('ad_rolle', $data);
		}
		
		throw(new Exception('Denne rollen finnes allerede', "1"));

	}	
	
	public function slettRolle($rolle)
	{
		if(!$this->finnesRolle($rolle))
		{
			$link = $this->database->quoteInto('ad_rolle_navn = ? ', $rolle);
			$rolle = $this->database->quoteInto('navn = ? ', $rolle);
		
			$this->database->delete('ad_rolle_rettighet_link', $link);
			
			return $this->database->delete('ad_rolle', $rolle);
		}
		
		throw(new Exception('Denne rollen er slettet allerede', "1"));

	}	
	
	public function finnesRolle($rolle)
	{
		$hent = $this->database->select()
		->from('ad_rolle', array('navn'))
		->where('navn =?', $rolle);
		
		$gyldig = $this->database->fetchRow($hent);
		
		if($gyldig)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	
	
}
