<?php
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

function dateFr($dateAmericaine){
	$date = explode("-",$dateAmericaine);
	$nouvelleDate = $date[2].'-'.$date[1].'-'.$date[0];
	return $nouvelleDate;
}

?>
