<?php 
require_once 'core/init.php';

if(Input::exist('mat_autocomplete', 'get'))
{
	$term = Input::get('term');
	$result = [];
	$materials = DBHandler::getInstance()->select("SELECT name FROM materials WHERE name REGEXP '{$term}' ")->results();
	foreach($materials as $material) {
		$result[] =  $material->name;
	}
	//print_r($materials);
	echo json_encode($result);
}