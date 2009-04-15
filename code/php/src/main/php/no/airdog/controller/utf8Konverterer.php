<?php
class utf8Konverterer
{
	public static function cp1252_to_utf8($str)
	{
		$cur_encoding = mb_detect_encoding($str);
		
		if($cur_encoding == "UTF-8" && mb_check_encoding($str,"UTF-8"))
			return $str;
		else
			return utf8_encode($str); 
	}
}
?>