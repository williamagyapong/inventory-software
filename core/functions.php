<?php
function escape($str)
{
  //$str =  mysql_real_escape_string($str);
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

function display($content)
{
	
}


function truncateString($string)
{
	$length = strlen($string);
	if($length >= 19)
	{
		return substr($string, 0,17)."...";
	}else{
		return $string;
	}
}

/*
* change the background color and text color of active page link
*/
function activePage($page){
	$script = $_SERVER["SCRIPT_NAME"];
	$base_url = explode('/', $script)[1];
	$page = '/'.$base_url.'/'.$page;
	if ($page == $script) {

		return "w3-white w3-text-red";
	}
}