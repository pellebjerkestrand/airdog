<?php
header("Content-type: application/csv; charset=UTF-16LE"); 
header ("Content-Disposition: inline; filename=" . $_POST["navn"] . ".csv"); 

require_once 'utf8Konverterer.php';

$utf8String = utf8Konverterer::cp1252_to_utf8($_POST["tekst"]);
echo chr(255).chr(254).mb_convert_encoding($utf8String, 'UTF-16LE', 'UTF-8'); 