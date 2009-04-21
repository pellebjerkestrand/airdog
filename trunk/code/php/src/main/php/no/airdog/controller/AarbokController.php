<?php
//$varer->hentHund();

/* Parameter:
 * En eller alle hunder som har deltatt på en jaktprøve et valgt
 * År
 * Hann/Tispe/Alle
 * 
 * 
 * hund.rft
 * %%HUNDNAVN%%, %%HUNDID%%, %%EIER%%, %%EIERADRESSE%%, %%EIERPOSTNUMMER%%, %%EIERSTED%%, %%EIERTLF%%,
 * %%OPPDRETTER%%, %%OPPDRETTERADRESSE%%, %%OPPDRETTERPOSTNUMMER%%, %%OPPDRETTERSTED%%, %%OPPDRETTERTLF%%
 * %%AVLSTALL%%, %%HOFTER%%, %%JAKTLYST%%, %%VILTFINNEREVNE%%, %%FAR%%, %%FARFAR%%, %%FARMOR%%, %%MOR%%, %%%MORFAR%%, %%MORMOR%%
 * %%HUNDENAVN%%, %%ANTALLVALPER%%, %%MOTSATTKJONN%%, %%GJNAVK%%, %%GJNVF%%, %%GJNJAKTLYST%%, %%GJNFART%%, %%GJNSTIL%%, %%GJNSELVST%%
 * %%GJNSOKBR%%, %%GJNREV%%, %%GJNSAMAR%%
 * 
 * %%KULLTITTELLISTE%% (en liste som genereres utifra filen kulltittel.rtf)
 * %%KULLLISTEUTVIDET%% (en liste som genereres utifra filen kullliste.rtf)
 * 
 * kulltittel.rtf
 * %%KULLBOKSTAV%%, %%PARTNERNAVN%%, %%PARTNERID%%, %%ANTALLVALPER%%, %%FODT%%
 * 
 * kullliste.rtf
 * %%KULLTITTELLISTE%% (genereres utifra filen avkomtittel.rtf)
 * %%OPPDRETTERNAVN%%, %%OPPDRETTERPERSON%%, %%OPPDRETTERADRESSE%%, %%OPPDRETTERPOSTNR%%, %%OPPDRETTERSTED%%, %%OPPDRETTERTLF%%
 * %%KULLAVLSTALL%%, %%KULLHOFTER%%, %%KULLJAKTLYST%%, %%KULLVF%%, %%KULLFAR%%, %%KULLFARFAR%%, %%KULLFARMOR%%, %%KULLMOR%%
 * %%KULLMORFAR%%, %%KULLMORMOR%%
 * 
 * %%AVKOM%% (genereres utifra filen avkom.rtf)
 * 
 * avkom.rtf
 * %%AVKOMNAVN%%, %%AVKOMID%%, %%HDSTATUS%%, %%HQSTATUS, %%EIERNAVN%%
 * 
 * %%JAKTPROVELISTE%% (en liste genereres utifra jaktprove.rtf)
 * 
 * %%GJNVF%%, %%GJNJAKTLYST%%, %%GJNFART%%, %%GJNSTIL%%, %%GJNSELVST%%, %%GJNSOKBR%%, %%GJNREV%%, %%GJNSAMAR%%
 * 
 * jaktprove.rtf
 * IKKE FERDIG LAGET ENDA!
 * 
 * <hund>
 * <for:kull->kullltittelliste />
 * <for:kull->kulllisteutvidet>
 * 		<for:avkom->avkominfo>
 * 			<for:jaktprove->jaktproveliste />
 * 		</avkom>
 * </kulllisteutvidet>
 * </hund>
 * 
 * 
 * RTF Tegnsett:
 * å \'e5
 * Å \'c5
 * ø \'f8
 * Ø \'d8
 * æ \'e6
 * Æ \'c6
 */

require_once "database/HundDatabase.php";
require_once "database/KullDatabase.php";
require_once 'database/ValiderBruker.php';
require_once "Verktoy.php";

class AarbokController
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	private function hentHunder($kjonn, $aar, $klubbId)
	{
		$hd = new HundDatabase();
		return $hd->hentAarbokHund("", $kjonn, $aar, $klubbId);
	}
	
	private function hentHundArray($hundId, $aar, $klubbId)
	{
		$hd = new HundDatabase();
		return $hd->hentAarbokHund($hundId, "", $aar, $klubbId);
	}
	
	private function hentKullArray($hundId, $klubbId)
	{
		$kd = new KullDatabase();
		$hundListe = $kd->hentAarbokAvkom($hundId, $klubbId);
		$avkomListe = array();
		
	    foreach($hundListe as $tmp)
	   	{    				
			$avkomFinnes = false;
			
			for($i = 0; $i < sizeof($avkomListe); $i++)
			{
				if ($avkomListe[$i]['kullId'] == $tmp['kullId'] && 
				($avkomListe[$i]['partnerid'] == $tmp['hundMorId'] || $avkomListe[$i]['partnerid'] == $tmp['hundFarId']))
				{
					$avkomFinnes = true;
					$avkomListe[$i]['liste'][] = $tmp;
					$avkomListe[$i]['antallvalper']++;
				}
			}
			
			if (!$avkomFinnes)
			{
				$avkom = array();
				
				if ($hundId == $tmp['hundMorId'])
				{
					$avkom['partnernavn'] = $tmp['hundFarNavn'];
					$avkom['partnerid'] = $tmp['hundFarId'];
					$avkom['morId'] = $tmp['hundMorId'];
				}
				else
				{
					$avkom['partnernavn'] = $tmp['hundMorNavn'];
					$avkom['partnerid'] = $tmp['hundMorId'];
					$avkom['farId'] = $tmp['hundFarId'];
				}
				
				$avkom['kullfar'] = $tmp['hundFarNavn'];
				$avkom['kullmor'] = $tmp['hundMorNavn'];
				
				$avkom['fodt'] = Verktoy::konverterDatabaseTilDatDato($tmp['fodt']);
				$avkom['kullId'] = $tmp['kullId'];
				$avkom['liste'] = array();
				$avkom['antallvalper'] = 1;
				$avkom['liste'][] = $tmp;
				
				$avkomListe[] = $avkom;
			}
		}
		
		$hd = new HundDatabase();
		$kullbokstav = "A";
		for($i = 0; $i < sizeof($avkomListe); $i++)
		{
		    $avkomListe[$i]['kullbokstav'] = $kullbokstav++;
		    
		    if ($hundId == $avkomListe[$i]['morId'])
		    {
		   		$far = $hd->hentAarbokKullHund($avkomListe[$i]['partnerid'], $klubbId);
		   		$mor = $hd->hentAarbokKullHund($hundId, $klubbId);
		    }
		    else
		    {
		    	$far = $hd->hentAarbokKullHund($hundId, $klubbId);
		   		$mor = $hd->hentAarbokKullHund($avkomListe[$i]['partnerid'], $klubbId);
		    }
		    
		    $avkomListe[$i]['kullfarfar'] = $far['hundFarNavn'];
		    $avkomListe[$i]['kullfarmor'] = $far['hundMorNavn'];
		    $avkomListe[$i]['kullmormor'] = $mor['hundFarNavn'];
		    $avkomListe[$i]['kullmorfar'] = $mor['hundMorNavn'];
		}
		
        return $avkomListe;
	}
	
	private function hentAvkomArray($etKull)
	{
		return array();
	}
	
	private function hentJaktproveArray($hundId, $aar)
	{
		return array();
	}
	
	public function lag_RTF($hundId, $klubbId, $aar, $kjonn)
	{
		$nyRTF = Verktoy::fyll_RTF(array(), "../assets/header.rtf");
		$hundeliste = array();
		
		
		if(ValiderBruker::validerBrukerRettighet($this->database, $_POST['brukerEpost'], $_POST['brukerPassord'], $klubbId, "lagAarbok"))
		{
			if ($hundId != "")
			{
				$hundeliste = $this->hentHundArray($hundId, $aar, $klubbId);
			}
			else
			{
				$hundeliste = $this->hentHunder($kjonn, $aar, $klubbId);
			}
			
			$sidedeler = "";
			foreach ($hundeliste as $enHund)
			{
				$kullArray = $this->hentKullArray($enHund['hundId'], $klubbId);
				$enHund['kulltittelliste'] = "";
				$enHund['kulllisteutvidet'] = "";
				
				if ($enHund['vf'] >= 0)	
					$enHund['vf'] = number_format($enHund['vf'], 1, ',', '');
					
				if ($enHund['kjonn'] == "H")	
					$enHund['motsattkjonn'] = "tispene";
				else
					$enHund['motsattkjonn'] = "hannene";
					
				$antallvalper = 0;
					
				foreach($kullArray as $etKull)
				{   
					$antallvalper += sizeof($etKull['liste']);
					
					$etKull['avkom'] = "";
					
					foreach($etKull['liste'] as $etAvkom)
					{
						$jaktproveArray = array(); //$this->hentJaktproveArray($etAvkom, $aar);
						$etAvkom['jaktproveliste'] = "";
						
						foreach($jaktproveArray as $enJaktprove)
						{
							$etAvkom['jaktproveliste'] .= Verktoy::fyll_RTF($enJaktprove, "../assets/jaktprove.rtf");
						}
						
						$etKull['avkom'] .= Verktoy::fyll_RTF($etAvkom, "../assets/avkom.rtf");
						
						$etKull['kulltittel'] = $etKull['kullbokstav'] . ". " . $etKull['partnernavn'] . " " . 
						$etKull['partnerid'] . ", " . $etKull['antallvalper'] . " valp(er) - " . $etKull['fodt'];
					}
					
					$enHund['kulltittelliste'] .= Verktoy::fyll_RTF($etKull, "../assets/kulltittel.rtf");
					$enHund['kulllisteutvidet'] .= Verktoy::fyll_RTF($etKull, "../assets/kullliste.rtf");
				}
				
				$enHund['antallvalper'] = $antallvalper;
				
				$nyRTF .= $sidedeler . Verktoy::fyll_RTF($enHund, "../assets/hund.rtf");
				$sidedeler = '\page';
			}	
			
			$nyRTF .= Verktoy::fyll_RTF(array(), "../assets/footer.rtf");
			
			if($nyRTF)
			{
				return $nyRTF;
			}
			else
			{
				return "Det har skjedd noe feil med genereringen av årboken";
			}
			
		}
		else
		{
		return "Ingen tilgang";
		}
	}
}
