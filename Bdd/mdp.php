<?php

function creerIdentifiant()
{
	$hote = 'localhost';
	$bdd = 'progiplus';
	$dbUser = 'root';
	$dbMdp = 'root';
	$port = "3306";
	
	define("DSN_BDD", 'mysql:host='.$hote.';port='.$port.';dbname='.$bdd);
	define("USER_BDD", $dbMdp);
	define("MDP_BDD", $dbUser);
}

creerIdentifiant();