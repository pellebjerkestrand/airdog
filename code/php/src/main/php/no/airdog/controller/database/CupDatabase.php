<?php
require_once 'Tilkobling.php';
require_once "no/airdog/model/AmfJaktprove.php";
require_once "no/airdog/model/AmfCup.php";

class CupDatabase
{
	private $database;
	
	public function __construct()
	{
		$tilkobling = new Tilkobling();
		$this->database = $tilkobling->getTilkobling();
	}
	
	//hund, eier, poeng, plass, prøver som er med
	public function hentJaktproverForPeriode($fra, $til)
	{	
		$hvor = $this->database->select()
				->from('nkk_fugl')
				->where('proveDato > ?', $fra)
				->where('proveDato < ?', $til)
				->where('premiegrad != 0')
				->order('hundId ASC');
		
		$resultat = $this->database->fetchAll($hvor);
		
		return $resultat;
	}
}

/*
$sql="Select r.navn,h.regnr, "
."sum(IF(r.premie like '%VK%',( "
."CASE r.premie "
."WHEN '1VK' then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 9 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 8 "
."ELSE 6 "
."END "
."WHEN '2VK' then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 8 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 7 "
."ELSE 5 "
."END "
."WHEN '3VK' then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 7 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 6 "
."ELSE 4 "
."END "
."WHEN '4VK' then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 6 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 5 "
."ELSE 3 "
."END "
."WHEN '5VK' then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 5 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 4 "
."ELSE 2 "
."END "
."WHEN '6VK' then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 4 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 3 "
."ELSE 1 "
."END "
."else "
."0 "
."end "
."+(CASE " 
."WHEN UCASE(r.Land) like '%SVERIGE%' then "
."If((UPPER(r.utmerkelse) like '%CERT%') or ((r.utmerkelse) like '%CK%'),4,0) " 
."ELSE "
."+ if((r.utmerkelse) like '%CACIT%' ,5,0) "
."+ if((r.utmerkelse) like '%CK%',4,0) "
."+ if((r.utmerkelse) like '%NM MESTER%',10,0) "
."END)),0)) + "
."sum(IF(r.premie like '%AK%', "
."(CASE r.premie "
."WHEN '1AK' then 3 "
."WHEN '2AK' then 2 "
."WHEN '3AK' then 1 "
."else 0 end),0)) AS FIELD_2,h.eier "
."from mos_pointer_resultat as r,mos_pointer as h "
."where "
."r.regnr=h.regnr and UCASE(r.utmerkelse) not like '%APPORT%' and UCASE(r.form) <> 'UTSTILLING' and UCASE(r.form) <> 'MANUELL' and UCASE(r.form) like '%$ty%' and r.dato > '$dlstr' and r.dato < '$dustr' and (h.distrikt <> 'Sverige' and h.distrikt <> 'Danmark' and h.distrikt <> 'Finland' and h.distrikt <> 'Island' and h.distrikt <> 'Andre') " 
."Group by h.regnr "
."ORDER BY FIELD_2 desc,h.navn ASC ";
Erlend Opdahl (30 Mar 2009, 2:48pm)
$sql="Select r.navn,h.regnr, "
."sum(IF(r.premie like '%UK%'," 
."(CASE r.premie "
."WHEN '1UK' then 3 " 
."WHEN '2UK' then 2 " 
."WHEN '3UK' then 1 " 
."else 0 " 
."end),0)) + "
."sum(IF(UCASE(r.utmerkelse) like '%PL%', "
."(CASE "
."WHEN INSTR(UCASE(r.utmerkelse),'1PL') > 0 then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then "
."(CASE "
."WHEN INSTR(UCASE(r.annledning),'DERBY') > 0 then 19 "
."ELSE 9 "
."END) "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 7 "
."ELSE 6 "
."END "
."WHEN INSTR(UCASE(r.utmerkelse),'2PL') > 0 then " 
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 8 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 6 "
."ELSE 5 "
."END "
."WHEN INSTR(UCASE(r.utmerkelse),'3PL') > 0 then " 
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 7 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 5 "
."ELSE 4 "
."END "
."WHEN INSTR(UCASE(r.utmerkelse),'4PL') > 0 then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 6 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 4 "
."ELSE 3 "
."END "
."WHEN INSTR(UCASE(r.utmerkelse),'5PL') > 0 then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 5 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 3 "
."ELSE 2 "
."END "
."WHEN INSTR(UCASE(r.utmerkelse),'6PL') > 0 then "
."CASE "
."WHEN UCASE(r.utmerkelse) like '%FIN%' then 4 "
."WHEN UCASE(r.utmerkelse) like '%SEMI%' then 2 "
."ELSE 1 "
."END "
."ELSE 0 "
."END),0)) AS FIELD_3,h.eier "
."from mos_pointer_resultat as r,mos_pointer as h "
."where "
."r.regnr=h.regnr and UCASE(r.utmerkelse) not like '%APPORT%' and UCASE(r.form) <> 'UTSTILLING' and UCASE(r.form) <> 'MANUELL' and r.dato >'$dlstr' and r.dato < '$dustr' and (h.distrikt <> 'Sverige' and h.distrikt <> 'Danmark' and h.distrikt <> 'Finland' and h.distrikt <> 'Island' and h.distrikt <> 'Andre') " 
."Group by h.regnr "
."ORDER BY FIELD_3 desc,h.navn ASC ";
*/