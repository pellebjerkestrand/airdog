<?php 
require_once 'Tilkobling.php';

class HundDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function settInn($arrangementArray)
	{
		if (sizeof($arrangementArray) != 3)
		{ 
			return 'Arrayet er av feil størrelse. Fikk ' . sizeof($arrangementArray) . ', forventet 3.'; 
		}
		
		if (!isset($arrangementArray['proveNr']) || $arrangementArray['proveNr'] == '')
		{ 
			return 'proveNr-verdien mangler.'; 
		}
		
		$dbArrangement = $this->hentArrangement($arrangementArray['proveNr']);
		
		if ($dbArrangement == null)
		{
			$this->database->insert('nkk_arrangement', $arrangementArray);
			return 'Lagt til';
		}
		else
		{
			$hvor = $this->database->quoteInto('proveNr = ?', $arrangementArray['proveNr']);
			$this->database->update('nkk_arrangement', $arrangementArray, $hvor);
			return 'Oppdatert';
		}
	}
	
	public function hentArrangementer()
	{
		$select = $this->database->select()
		->from(array('a'=>'nkk_arrangement'), array('a.*'));
		
		return $this->database->fetchRow($select);
	}
	
	public function hentArrangement($proveNr)
	{
		$select = $this->database->select()
		->from(array('a'=>'nkk_arrangement'), array('a.*'))
		->where('a.proveNr=?', $proveNr)
		->limit(1);
		
		return $this->database->fetchRow($select);
	}
	
	public function slettArrangement($proveNr)
	{
		$hvor = $this->database->quoteInto('proveNr = ? ', $proveNr);
		
		return $this->database->delete('nkk_arrangement', $hvor);
	}
}