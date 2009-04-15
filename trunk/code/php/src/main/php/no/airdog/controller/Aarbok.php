<?php
header("Content-type: application/msword; charset=UTF-16LE"); 
header("Content-Disposition: inline; filename=aarBok"); 

require_once "Verktoy.php";

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


