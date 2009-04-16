<?php 
set_time_limit(600);
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
ini_set('LimitRequestBody ', '16777216');

ini_set("include_path", ini_get("include_path") .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../../com/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../../no/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../../'); 
	
require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

require_once 'Tilkobling.php';
require_once "no/airdog/controller/Verktoy.php";

class Backup
{	
	private $sti;
	
	public function __construct()
	{
		date_default_timezone_set('Europe/Oslo');
		mysql_connect("localhost", "airdog", "air123dog") or die(mysql_error());
		mysql_select_db("airdog") or die(mysql_error());	
		
		$this->sti = Verktoy::hoppBakover(dirname(__FILE__),4) . "/backup/";

	}
	
	private function lagKopi($tabell, $navn)
	{
		$mappe = $this->sti . date("d-m-Y") . " - $navn/";
		
		if  (!file_exists($mappe))
		{
			mkdir($mappe);
			chmod($mappe, 0777);
		}

		$filnavn = $mappe . $tabell . ".sql";
		
		if (file_exists($filnavn))
			unlink ($filnavn);
			
		$filnavn = str_replace("\\", "\\\\", $filnavn);
		return mysql_query("SELECT * FROM $tabell INTO OUTFILE '$filnavn'");
	}
	
	public function lagFullKopi($navn)
	{
		foreach ($this->hentTabeller() as $tabell)
		{
			$this->lagKopi($tabell, $navn);
		}
	}
	
	public function lastKopi($tabell, $mappe)
	{
		$filnavn = $this->sti . $mappe . "/" . $tabell . ".sql";
			
		if (!file_exists($filnavn))
			return "Finner ikke filen: $filnavn";
		
		
		$filnavn = str_replace("\\", "\\\\", $filnavn);
		mysql_query("TRUNCATE $tabell");
		return mysql_query("LOAD DATA INFILE '$filnavn' INTO TABLE $tabell");
	}
	
	public function lastKopier($tabeller, $mappe)
	{
		foreach($tabeller as $tabell)
		{
			$this->lastKopi($tabell, $mappe);
		}
	}
	
	public function hentTabeller()
	{
		$ret = array();
		
		$query = mysql_query("SHOW TABLES");
		
		while ($tabell = mysql_fetch_array($query))
		{
			$ret[] = $tabell["Tables_in_airdog"];
		}
		
		return $ret;
	}
	
	public function hentKopier()
	{
		$handle = opendir($this->sti);
		
		$ret = array();
		
		while ($fil = readdir($handle)) 
		{
			if ($fil != "." && $fil != ".." && is_dir($this->sti . $fil))
	        	$ret[] = $fil;
	    }
	    
	    return $ret;
	}
	
	public function hentFiler($mappe)
	{
		$mappe = $this->sti . $mappe . "/";
		
		if (!file_exists($mappe))
			return "Finner ikke mappen: $mappe";
		
		$handle = opendir($mappe);
		
		$ret = array();
		
		while ($fil = readdir($handle)) 
		{
			if (is_file($mappe . $fil))
	        	$ret[] = substr($fil, 0, -strlen(strrchr($fil, '.')));
	    }
	    
	    return $ret;
	}
}