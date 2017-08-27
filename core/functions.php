<?php
function escape($str)
{
  $str =  mysql_real_escape_string($str);
  //$str =  strip_tags($str);
  //$str =  htmlentities($str);

  return $str;
}


function print_array($array)
{
	echo "<pre>";
	 print_r($array);
	echo "</pre>";
}