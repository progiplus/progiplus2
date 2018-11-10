<?php
require_once('../includes/Models/devis.php');
	require_once('../includes/Models/client.php');

function checkInput($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}


function identiteClient($ent,$part){
	if(!empty($ent)){
		$result = print '<td>'.$ent.'</td>';
	}
	else{
		$result = print '<td>'.$part.'</td>';
	}
	return $result;
}
?>
