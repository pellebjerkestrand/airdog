<?php 
require_once 'Tilkobling.php';

class Verktoy
{
	public function Verktoy()
	{
	}
	
	public function tomTabeller()
	{
		$this->tomTabell("Eier");
		$this->tomTabell("Fugl");		
		$this->tomTabell("Hdsykdom");		
		$this->tomTabell("Hund");		
		$this->tomTabell("Kull");		
		$this->tomTabell("Oppdrett");		
		$this->tomTabell("Person");		
		$this->tomTabell("Premie");		
		$this->tomTabell("Utstilling");	
		$this->tomTabell("Veteriner");	
		$this->tomTabell("Aasykdom");		
		$this->tomTabell("Rase");		
	}
	
	public function tomTabell($tabell)
	{
		return mysql_query("DELETE FROM ".$tabell);
	}
}
?>