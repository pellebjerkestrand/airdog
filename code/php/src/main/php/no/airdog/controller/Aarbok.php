<?php
header("Content-type: application/msword");
header("Content-disposition: inline; filename=aarBok");
header("Content-length: " . strlen($nyRTF));

require_once "no/airdog/controller/Verktoy.php";

$vars = array('dato'    =>	date("F d, Y"),
              'navn'	=>	'Hans Magnus',
              'adresse' =>	'0356 KULT');
              
$nyRTF = Verktoy::fyll_RTF($vars, "../assets/mal_funk.rtf");

if($nyRTF)
{
	echo $nyRTF;
}
else
{
	echo "Noe skjedde feil";
}


