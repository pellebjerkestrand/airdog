<?php
header("Content-type: application/msword; charset=UTF-16LE"); 
header("Content-Disposition: inline; filename=aarBok.doc"); 

require_once "Verktoy.php";

/* hund.rft
 * %%HUNDNAVN%%, %%HUNDID%%, %%EIER%%, %%EIERADRESSE%%, %%EIERPOSTNUMMER%%, %%EIERSTED%%, %%EIERTLF%%,
 * %%OPPDRETTER%%, %%OPPDRETTERADRESSE%%, %%OPPDRETTERPOSTNUMMER%%, %%OPPDRETTERSTED%%, %%OPPDRETTERTLF%%
 * %%AVLSTALL, %%HOFTER%%, %%JAKTLYST%%, %%VILTFINNEREVNE%%, %%FAR%%, %%FARFAR%%, %%FARMOR%%, %%MOR%%, %%%MORFAR%%, %%MORMOR%%
 * %%HUNDENAVN%%, %%ANTALLVALPER%%, %%MOTSATTKJONN%%, %%GJNAVK%%, %%GJNVF%%, %%GJNJAKTLYST%%, %%GJNFART%%, %%GJNSTIL%%, %%GJNSELVST%%
 * %%GJNSOKBR%%, %%GJNREV%%, %%GJNSAMAR%%
 * 
 * %%KULLLISTE%% (en liste som genereres utifra filen kulltittel.rtf)
 * %%KULLLISTEUTVIDET%% (en liste som genereres utifra filen kullliste.rtf)
 * 
 * kulltittel.rtf
 * %%KULLBOKSTAV%%, %%PARTNERNAVN%%, %%PARTNERID%%, %%ANTALLVALPER%%, %%FODT%%
 * 
 * kullliste.rtf
 * %%KULLTITTEL%% (genereres utifra filen avkomtittel.rtf)
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
 */

$vars = array('hundnavn'    =>	'HUNDENHUNDENSKALduhete',
              'hundid'	=>	'233233/37336',
              'eier' =>	'Hans Magnus');
              
$nyRTF = Verktoy::fyll_RTF($vars, "../assets/hund.rtf");

if($nyRTF)
{
	echo $nyRTF;
}
else
{
	echo "Noe skjedde feil";
}


