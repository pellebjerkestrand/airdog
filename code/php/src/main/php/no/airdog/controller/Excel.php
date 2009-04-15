<?php
header("Content-type: application/csv; charset=UTF-16LE"); 
header ("Content-Disposition: inline; filename=Regneark.csv"); 

require_once 'utf8Konverterer.php';

$utf8String = utf8Konverterer::cp1252_to_utf8($_POST["htmltable"]);
echo chr(255).chr(254).mb_convert_encoding($utf8String, 'UTF-16LE', 'UTF-8'); 