<?php

function creerIdentifiant()
{
	$hote = 'localhost';
	$bdd = 'progiplus';
	$dbUser = 'root';
	$dbMdp = 'root';
	$port = "8889";
	
	define("DSN_BDD", 'mysql:host='.$hote.';port='.$port.';dbname='.$bdd);
	define("USER_BDD", $dbUser);
	define("MDP_BDD", $dbMdp);
}

creerIdentifiant();