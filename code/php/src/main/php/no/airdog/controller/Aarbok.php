<?php
header("Content-type: application/msword");
header("Content-disposition: inline; filename=aarBok");
header("Content-length: " . strlen($nyRTF));

require_once "no/airdog/controller/Verktoy.php";

$vars = array('dato'    =>	date("F d, Y"),
              'navn'	=>	'John Coggeshall',
              'adresse' =>	'1210 Hancock');
              
$nyRTF = Verktoy::fyll_RTF($vars, "../assets/mal.rtf");

if($nyRTF)
{
	echo $nyRTF;
}
else
{
	echo "Noe skjedde feil";
}


