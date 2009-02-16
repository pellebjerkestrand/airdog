<?php
class Tilkobling_
{
	private $dbServer;
	private $dbNavn;
	private $dbBrukernavn;
	private $dbPassord;
	
   public function __construct() 
   {
       $this->dbServer='localhost';
       $this->dbNavn='airdog';
       $this->dbBrukernavn ='root';
       $this->dbPassord = '';
   }
   
   public function getTilkobling(){
   		//Lager database tilkobling
		try {
			$database = Zend_Db::factory('Mysqli',array(
			'host' => $this->dbServer,
			'dbname' => $this->dbNavn,
			'username' => $this->dbBrukernavn,
			'password' => $this->dbPassord));
			
			return $database;
		}
		catch ( Zend_database_Exception $e){
			return "Oppkobling feil: " . get_class($e) . "\n Melding: " . $e->getMessage() . "\n";
		}
   	
   }
}
?>