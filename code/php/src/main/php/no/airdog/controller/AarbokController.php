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
 */

require_once "database/HundDatabase.php";
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
	
	private function hentHunder($aar, $kjonn, $klubbId)
	{
		$hd = new HundDatabase();
		return $hd->sokHund("", $klubbId);
	}
	
	private function hentHundArray($hundId, $aar, $klubbId)
	{
		$hd = new HundDatabase();
		return $hd->hentHund($hundId, $klubbId);
	}
	
	private function hentKullArray($hundId)
	{
		return array();
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
				$hundeliste = $this->hentHunder($aar, $kjonn, $klubbId);
			}
			
			$sidedeler = "";
			foreach ($hundeliste as $enHund)
			{
				$kullArray = $this->hentKullArray($enHund['hundId']);
				$enHund['kulltittelliste'] = "";
				$enHund['kulllisteutvidet'] = "";
			
				foreach($kullArray as $etKull)
				{   
					$avkomArray = $this->hentAvkomArray($etKull);
					$etKull['avkom'] = "";
					
					foreach($avkomArray as $etAvkom)
					{
						$jaktproveArray = $this->hentJaktproveArray($etAvkom, $aar);
						$etAvkom['jaktproveliste'] = "";
						
						foreach($jaktproveArray as $enJaktprove)
						{
							$etAvkom['jaktproveliste'] .= Verktoy::fyll_RTF($enJaktprove, "../assets/jaktprove.rtf");
						}
						
						$etKull['avkom'] .= Verktoy::fyll_RTF($etAvkom, "../assets/avkom.rtf");
					}
					
					$enHund['kulltittelliste'] .= Verktoy::fyll_RTF($etKull, "../assets/kulltittel.rtf");
					$enHund['kulllisteutvidet'] .= Verktoy::fyll_RTF($etKull, "../assets/kullliste.rtf");
				}
				
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
