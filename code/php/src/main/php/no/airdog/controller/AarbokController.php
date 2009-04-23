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
require_once "database/JaktproveDatabase.php";
require_once "JaktproveController.php";
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
		return HundDatabase::hentAarbokHund("", $kjonn, $aar, $klubbId, $this->database);
	}
	
	private function hentHundArray($hundId, $aar, $klubbId)
	{
		return HundDatabase::hentAarbokHund($hundId, "", $aar, $klubbId, $this->database);
	}
	
	private function hentKullTittelArray($hundId, $klubbId, $aar)
	{
		$hundListe = KullDatabase::hentAarbokAvkomTittel($hundId, $klubbId, $aar, $this->database);
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
				
				$avkomListe[] = $avkom;
			}
		}
		
		$kullbokstav = "A";
		for($i = 0; $i < sizeof($avkomListe); $i++)
		{
		    $avkomListe[$i]['kullbokstav'] = $kullbokstav++;
		}
		
        return $avkomListe;
	}
	
	
	
	private function hentKullArray($hundId, $klubbId, $aar)
	{
		$hundListe = KullDatabase::hentAarbokAvkom($hundId, $klubbId, $aar, $this->database);
		$avkomListe = array();
		
	    foreach($hundListe as $tmp)
	   	{    	
	   		if ($tmp['AARVF'] != "")	
				$tmp['AARVF'] = number_format($tmp['AARVF'], 1, ',', '');
					
			if ($tmp['AARJAKTL'] != "")	
				$tmp['AARJAKTL'] = number_format($tmp['AARJAKTL'], 1, ',', '');
				
			if ($tmp['AARFART'] != "")	
				$tmp['AARFART'] = number_format($tmp['AARFART'], 1, ',', '');
				
			if ($tmp['AARSTIL'] != "")	
				$tmp['AARSTIL'] = number_format($tmp['AARSTIL'], 1, ',', '');
				
			if ($tmp['AARSELVST'] != "")	
				$tmp['AARSELVST'] = number_format($tmp['AARSELVST'], 1, ',', '');
				
			if ($tmp['AARSOKBR'] != "")	
				$tmp['AARSOKBR'] = number_format($tmp['AARSOKBR'], 1, ',', '');
				
			if ($tmp['AARREV'] != "")	
				$tmp['AARREV'] = number_format($tmp['AARREV'], 1, ',', '');
				
			if ($tmp['AARSAMAR'] != "")	
				$tmp['AARSAMAR'] = number_format($tmp['AARSAMAR'], 1, ',', '');
				
				
			if ($tmp['TOTALVF'] != "")	
				$tmp['TOTALVF'] = number_format($tmp['TOTALVF'], 1, ',', '');
					
			if ($tmp['TOTALJAKTL'] != "")	
				$tmp['TOTALJAKTL'] = number_format($tmp['TOTALJAKTL'], 1, ',', '');
				
			if ($tmp['TOTALFART'] != "")	
				$tmp['TOTALFART'] = number_format($tmp['TOTALFART'], 1, ',', '');
				
			if ($tmp['TOTALSTIL'] != "")	
				$tmp['TOTALSTIL'] = number_format($tmp['TOTALSTIL'], 1, ',', '');
				
			if ($tmp['TOTALSELVST'] != "")	
				$tmp['TOTALSELVST'] = number_format($tmp['TOTALSELVST'], 1, ',', '');
				
			if ($tmp['TOTALSOKBR'] != "")	
				$tmp['TOTALSOKBR'] = number_format($tmp['TOTALSOKBR'], 1, ',', '');
				
			if ($tmp['TOTALREV'] != "")	
				$tmp['TOTALREV'] = number_format($tmp['TOTALREV'], 1, ',', '');
				
			if ($tmp['TOTALSAMAR'] != "")	
				$tmp['TOTALSAMAR'] = number_format($tmp['TOTALSAMAR'], 1, ',', '');
				
			
			$total = JaktproveDatabase::hentAarbokJaktproverTotalt($tmp['hundId'], $klubbId, $this->database);
			$tmp['TOTALSTART'] = $total['total'];
	
				
			$tmp['aar'] = $aar;
	   					
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
					$avkom['partnertittel'] = $tmp['hundFarTittel'];
					$avkom['partnerid'] = $tmp['hundFarId'];
					$avkom['morId'] = $tmp['hundMorId'];
				}
				else
				{
					$avkom['partnernavn'] = $tmp['hundMorNavn'];
					$avkom['partnertittel'] = $tmp['hundMorTittel'];
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
		
		$kullbokstav = "A";
		for($i = 0; $i < sizeof($avkomListe); $i++)
		{
		    $avkomListe[$i]['kullbokstav'] = $kullbokstav++;
		    
		    if (isset($avkomListe[$i]['morId']) && $hundId == $avkomListe[$i]['morId'])
		    {
		   		$far = HundDatabase::hentAarbokKullHund($avkomListe[$i]['partnerid'], $klubbId, $this->database);
		   		$mor = HundDatabase::hentAarbokKullHund($hundId, $klubbId, $this->database);
		    }
		    else
		    {
		    	$far = HundDatabase::hentAarbokKullHund($hundId, $klubbId, $this->database);
		   		$mor = HundDatabase::hentAarbokKullHund($avkomListe[$i]['partnerid'], $klubbId, $this->database);
		    }
		    
		    $avkomListe[$i]['kullfarfar'] = $far['hundFarNavn'];
		    $avkomListe[$i]['kullfarmor'] = $far['hundMorNavn'];
		    $avkomListe[$i]['kullmormor'] = $mor['hundFarNavn'];
		    $avkomListe[$i]['kullmorfar'] = $mor['hundMorNavn'];

		    $kull = KullDatabase::hentAarbokKullOppdretter($avkomListe[$i]['kullId'], $klubbId, $this->database);
		    
		    if ($kull != null)
		    {
		    	$avkomListe[$i]['OPPDRETTERNAVN'] = $kull['OPPDRETTERNAVN'];
		    	$avkomListe[$i]['OPPDRETTERADRESSE'] = $kull['OPPDRETTERADRESSE'];
		    	$avkomListe[$i]['OPPDRETTERPOSTNR'] = $kull['OPPDRETTERPOSTNR'];
		    	$avkomListe[$i]['OPPDRETTERSTED'] = $kull['OPPDRETTERSTED'];
		    	$avkomListe[$i]['OPPDRETTERTLF'] = $kull['OPPDRETTERTLF'];
		    }
		}
		
        return $avkomListe;
	}
	
	private function hentJaktproveArray($hundId, $aar, $klubbId)
	{
		$jaktprover = JaktproveDatabase::hentAarbokJaktprover($hundId, $aar, $klubbId, $this->database);
		return $jaktprover;
	}
	
	public function lag_RTF($hundId, $klubbId, $aar, $kjonn)
	{
		$nyRTF = Verktoy::fyll_RTF(array(), "../assets/header.rtf");
		$hundeliste = array();
		$jc = new JaktproveController();
		
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
				$kullArray = $this->hentKullArray($enHund['hundId'], $klubbId, $aar);
				$kullTittelArray = $this->hentKullTittelArray($enHund['hundId'], $klubbId, $aar);
				$enHund['kulltittelliste'] = "";
				$enHund['kulllisteutvidet'] = "";
				$enHund['aar'] = $aar;
				$enHund['gjstart'] = 0;
				$enHund['gjavk'] = 0;
					
				if ($enHund['kjonn'] == "H")	
					$enHund['motsattkjonn'] = "tispene";
				else
					$enHund['motsattkjonn'] = "hannene";
					
			if ($enHund['GJVF'] != "")	
				$enHund['GJVF'] = number_format($enHund['GJVF'], 1, ',', '');
					
			if ($enHund['GJJAKTL'] != "")	
				$enHund['GJJAKTL'] = number_format($enHund['GJJAKTL'], 1, ',', '');
				
			if ($enHund['GJFART'] != "")	
				$enHund['GJFART'] = number_format($enHund['GJFART'], 1, ',', '');
				
			if ($enHund['GJSTIL'] != "")	
				$enHund['GJSTIL'] = number_format($enHund['GJSTIL'], 1, ',', '');
				
			if ($enHund['GJSELVST'] != "")	
				$enHund['GJSELVST'] = number_format($enHund['GJSELVST'], 1, ',', '');
				
			if ($enHund['GJSOKBR'] != "")	
				$enHund['GJSOKBR'] = number_format($enHund['GJSOKBR'], 1, ',', '');
				
			if ($enHund['GJREV'] != "")	
				$enHund['GJREV'] = number_format($enHund['GJREV'], 1, ',', '');
				
			if ($enHund['GJSAMAR'] != "")	
				$enHund['GJSAMAR'] = number_format($enHund['GJSAMAR'], 1, ',', '');
					
				$antallvalper = 0;
					
				foreach($kullArray as $etKull)
				{   					
					$etKull['avkom'] = "";
					$enHund['gjavk'] += sizeof($etKull['liste']);
					
					foreach($etKull['liste'] as $etAvkom)
					{
						$jaktproveArray = $this->hentJaktproveArray($etAvkom['hundId'], $aar, $klubbId);
						$etAvkom['jaktproveliste'] = "";
						$etAvkom['AARSTART'] = sizeof($jaktproveArray);
						$enHund['gjstart'] += $etAvkom['AARSTART'];
						
						foreach($jaktproveArray as $enJaktprove)
						{
							if ($enJaktprove['kritikk'] != null && $enJaktprove['kritikk'] != "")
								$enJaktprove['kritikk'] = "\\line " . $enJaktprove['kritikk'];
								
							if (isset($enJaktprove['sted']))
								$enJaktprove['sted'] = $enJaktprove['sted'] . " " . $enJaktprove['navn'];
							else
								$enJaktprove['sted'] = $enJaktprove['proveNr'];
								
							$enJaktprove['premiegrad'] = $jc->hentPremiegrad($enJaktprove['premiegrad'], $enJaktprove['klasse'], $enJaktprove['certifikat'], $enJaktprove['proveDato']);
							
							$etAvkom['jaktproveliste'] .= Verktoy::fyll_RTF($enJaktprove, "../assets/jaktprove.rtf");
						}
						
						$etKull['avkom'] .= Verktoy::fyll_RTF($etAvkom, "../assets/avkom.rtf");
					}
					
					$etKull['kulltittel'] = $etKull['partnertittel'] . " " . $etKull['partnernavn'] . " " . 
						$etKull['partnerid'] . ", " . 
						$etKull['antallvalper'] . " valp(er) - " . 
						$etKull['fodt'];
						
					$enHund['kulllisteutvidet'] .= Verktoy::fyll_RTF($etKull, "../assets/kullliste.rtf");
				}
				
				foreach($kullTittelArray as $etKull)
				{   
					$antallvalper += $etKull['antallvalper'];
					
					$enHund['kulltittelliste'] .= Verktoy::fyll_RTF($etKull, "../assets/kulltittel.rtf");
				}
				
				$enHund['antallvalper'] = $antallvalper;
				
				if ($enHund['kulllisteutvidet'] != "")
				{
					$nyRTF .= $sidedeler . Verktoy::fyll_RTF($enHund, "../assets/hund.rtf");
					$sidedeler = '\par';
				}
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
