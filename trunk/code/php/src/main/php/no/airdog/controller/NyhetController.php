<?php
require_once "no/airdog/model/AmfNyhet.php";
require_once "no/airdog/controller/database/NyhetDatabase.php";

require_once 'database/ValiderBruker.php';
require_once 'database/Tilkobling.php';

class NyhetController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	public function hentNyheter($brukerEpost, $brukerPassord, $klubbId)
	{
		if(ValiderBruker::validerBrukerRettighet($this->database, $brukerEpost, $brukerPassord, $klubbId, "lese"))
		{
			$nd	= new NyhetDatabase();
			$rss = $nd->hentRSS($klubbId);
			$ret = array();
			
			if($rss['rss'] == null)
			{
				return null;
			}
			
			try
			{
				$feed = Zend_Feed::import($rss['rss']);	
			}
			catch (Zend_Feed_Exception $e)
			{
				echo "Feil ved importering av klubbens RSS";
				exit;	
			}
			
			foreach($feed as $nyhet)
			{
				$tmp = new AmfNyhet();
				$tmp->tittel = $nyhet->title();
				if(trim($nyhet->description) != '')
				{
					$tmp->tekst = substr(trim(strip_tags($nyhet->description)), 0, 197).'...';	
				}
				else
				{
					$tmp->tekst = null;
				}
				$tmp->dato = $nyhet->published();
				$tmp->url = $nyhet->link();
				
				$ret[] = $tmp;
			}
			
			return $ret;
		}
	}
}