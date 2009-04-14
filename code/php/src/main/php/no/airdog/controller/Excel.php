<?php
header('Content-type: application/msexcel');
header('Content-disposition: attachment; filename="excelark.xls"');

echo $_POST["htmltable"];