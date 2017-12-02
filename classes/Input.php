<?php
class Input 
 {
 	public static function exist($index=null, $type = 'post') {
 		switch($type) {
 			case 'post':
 			    if($index) {
 			    	 return (!empty($_POST)&&isset($_POST[$index]))? true : false;
 			    }
 			     return (!empty($_POST))? true : false;
 			break;

 			case 'get':
 			    if($index) {
 			    	return (!empty($_GET)&&isset($_GET[$index])) ? true : false;
 			    }
 			    return (!empty($_GET)) ? true : false;
 			break;

 			default:
 			    return false;
 			break;
 		}
 	}


 	public static function get($item) {
 		if(isset($_POST[$item])) {

 			return trim($_POST[$item]);

 		} elseif(isset($_GET[$item])) {

 			return trim($_GET[$item]);

 		} else {
 			return '';
 		}
 	}
 }
 