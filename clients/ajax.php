<?php
require_once('../config.php');
require_once('../functions.php');

$action = $_POST['action'];

switch($action)
{
	case "changerActif":
		changerActifProduit();
	break;
}

function changerActifProduit()
{
	$id = $_POST['id_client'];
	$val = $_POST['val'];
	$apply = $_POST['apply'];

	$actif = Database::connect();
	$state = $actif->query("UPDATE client
	SET actif = $apply
	where id_client =$id");
}

Database::disconnect();

?>
