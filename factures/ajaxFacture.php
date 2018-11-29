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
	$state = $db->query("call proc_devistofacture(".$id.");");
	$state->fetchObject();
	$state->closeCursor();
}
    
Database::disconnect();