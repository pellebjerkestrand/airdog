<?php
header("Content-type: application/rtf; charset=UTF-16LE"); 
header ("Content-Disposition: inline; filename=aarBok.rtf"); 

require_once "no/airdog/controller/Verktoy.php";

$vars = array('dato'    =>	date("F d, Y"),
              'navn'	=>	'John Coggeshall',
              'adresse' =>	'1210 Hancock');

$nyRTF = Verktoy::fyll_RTF($vars, "no/airdog/assets/mal.rtf");
$dokument = fopen('no/airdog/assets/aarBok.rtf', 'w');
fwrite($dokument, $nyRTF);
fclose($dokument);