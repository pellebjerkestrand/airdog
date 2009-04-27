<?php
require_once "no/airdog/model/AmfNyhet.php";
require_once "no/airdog/controller/database/NyhetDatabase.php";
require_once "com/RSS_PHP/rss_php.php";

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
			$rssSti = $nd->hentRSS($klubbId);
			
			if($rssSti['rss'] == null)
			{
				return null;
			}
			
			$rss = new rss_php;
    		$rss->load($rssSti['rss']);
			$nyheter = $rss->getItems();
			$ret = array();
			
			foreach($nyheter as $index => $nyhet)
			{
				$tmp = new AmfNyhet();
				$tmp->tittel = $nyhet['title'];
				if(trim($nyhet['description']) != '')
				{
					$tmp->tekst = substr(trim(strip_tags($nyhet['description'])), 0, 197).'...';	
				}
				else
				{
					$tmp->tekst = null;
				}
				$tmp->dato = $nyhet['pubDate'];
				$tmp->url = $nyhet['link'];
				
				$ret[] = $tmp;
			}
			
			return $ret;
		}
	}
	
	public function hentNyheterZend($brukerEpost, $brukerPassord, $klubbId)
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
				$feed = new Zend_Feed_Rss($rss['rss']);	
			}
			catch (Zend_Feed_Exception $e)
			{
				throw new Exception("Feil ved importering av klubbens RSS\n{$e->getMessage()}");
				exit;	
			}
			catch (Zend_Exception $e)
			{
				throw new Exception("Feil ved importering av klubbens RSS\n{$e->getMessage()}");
				exit;
			}
			catch (Exception $e)
			{
				throw new Exception("Feil ved importering av klubbens RSS\n{$e->getMessage()}");
				exit;
			}
			
			foreach($feed as $nyhet)
			{
				$tmp = new AmfNyhet();
				$tmp->tittel = $nyhet->title();
				if(trim($nyhet->description()) != '')
				{
					$tmp->tekst = substr(trim(strip_tags($nyhet->description())), 0, 197).'...';	
				}
				else
				{
					$tmp->tekst = null;
				}
				$tmp->dato = $nyhet->pubDate();
				$tmp->url = $nyhet->link();
				
				$ret[] = $tmp;
			}
			
			return $ret;
		}
	}
}