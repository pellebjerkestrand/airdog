<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'airdog';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Klarer ikke koble til MySQL-serveren');
mysql_select_db($dbname) or die ('Klarer ikke koble til databasen airdog');
?>