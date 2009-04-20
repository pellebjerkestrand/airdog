<?php
header("Content-type: application/msword; charset=UTF-16LE"); 
header("Content-Disposition: inline; filename=aarBok.doc"); //. $_POST["navn"] . ".csv"

set_time_limit(600);
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
ini_set('LimitRequestBody ', '16777216');

ini_set("include_path", ini_get("include_path") .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../com/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../no/' .
	PATH_SEPARATOR . dirname(__FILE__) . '/../../../'); 
	
require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

require_once "HundController.php";
require_once "Verktoy.php";

$varer = new HundController();

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

function hentHunder($aar, $kjonn)
{
	return array();
}

function hentHundArray($hundId, $aar)
{
	return array('hundId' => '');
}

function hentKullArray($hundId)
{
	return array();
}

function hentAvkomArray($etKull)
{
	return array();
}

function hentJaktproveArray($hundId, $aar)
{
	return array();
}


$hundId = $_POST['hundId'];
$aar = $_POST['aar'];
$kjonn = $_POST['kjonn'];

$nyRTF = "";
$hundeliste = array();


if (isset($hundId))
{
	$hundeliste[] = hentHundArray($hundId, $aar);
}
else
{
	$hundeliste = hentHunder($aar, $kjonn);
}


foreach ($hundeliste as $enHund)
{
	$kullArray = hentKullArray($enHund['hundId']);
	$enHund['kulltittelliste'] = "";
	$enHund['kulllisteutvidet'] = "";

	foreach($kullArray as $etKull)
	{   
		$avkomArray = hentAvkomArray($etKull);
		$etKull['avkom'] = "";
		
		foreach($avkomArray as $etAvkom)
		{
			$jaktproveArray = hentJaktproveArray($etAvkom, $aar);
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
	
	$nyRTF .= Verktoy::fyll_RTF($enHund, "../assets/hund.rtf");
}



if($nyRTF)
{
	echo $nyRTF;
}
else
{
	echo "Det har skjedd noe feil med genereringen av årboken";
}




