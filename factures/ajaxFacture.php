<?php
require_once('../config.php');
require_once('../functions.php');

$action = checkInput($_POST['action']);

switch($action)
{
    case "importerDevis":
        importerDevis();
    break;
	case "exporterEnBl":
		exporterEnBl();
		break;
}

function importerDevis()
{
	$id = checkInput($_POST['idDevis']);
	$db = Database::connect();
	
	$state = $db->query(
	"select count(f.id_devis) as 'nb'
	from facture f
    where f.id_devis = ".$id.";");
	$nbFacture = $state->fetchObject()->nb;
	$state->closeCursor();
	
	if($nbFacture == 0)
	{
		$state = $db->query("call proc_devistofacture(".$id.");");
		$state->fetchObject();
		$state->closeCursor();
		echo "true";
	}
	else
	{
		echo "false";
	}
	
}

function exporterEnBl()
{
	$idFacture = checkInput($_POST['idFacture']);
	$idAdresse = checkInput($_POST['idAdresse']);
	
	$db = Database::connect();
	
	$state = $db->query(
		"select count(bl.id_bl) as 'nb'
	from bl
    where bl.id_facture = ".$idFacture.";");
	$nbBl = $state->fetchObject()->nb;
	$state->closeCursor();
	
	if($nbBl == 0)
	{
		$state = $db->query("call proc_facturetobl(".$idFacture.",".$idAdresse.");");
		$state->fetchObject();
		$state->closeCursor();
		echo "true";
	}
	else
	{
		echo "false";
	}
}
    
Database::disconnect();