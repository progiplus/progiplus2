<?php
require_once('../config.php');
require_once('../functions.php');

$action = checkInput($_POST['action']);

switch($action)
{
    case"importerDevis":
        importerDevis();
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
	}
	
}
    
Database::disconnect();