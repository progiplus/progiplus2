<?php

function creerIdentifiant()
{
	$hote = 'localhost';
	$bdd = 'progiplus';
	$dbUser = 'root';
	$dbMdp = 'Rugbyman47';
	$port = "3306";
	
	define("DSN_BDD", 'mysql:host='.$hote.';port='.$port.';dbname='.$bdd);
	define("USER_BDD", $dbUser);
	define("MDP_BDD", $dbMdp);
}

creerIdentifiant();
