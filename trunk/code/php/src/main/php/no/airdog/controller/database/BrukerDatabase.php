<?php
require_once 'Tilkobling_.php';
class BrukerDatabase{
	private $database;
	
	/**
	* @return avhengigheter
	*/
	public function __construct() {
		$tilkobling = new Tilkobling_();
		$this->database = $tilkobling->getTilkobling();
	}
	
	
}
?>
