<?php

function creerIdentifiant()
{
	$hote = 'localhost';
	$bdd = 'progiplus';
	$dbUser = 'root';
<<<<<<< HEAD

	$dbMdp = 'azertysio';
	$port = "3306";
	
=======
	$dbMdp = 'assbutt33';
	$port = "3308";

>>>>>>> elodie
	define("DSN_BDD", 'mysql:host='.$hote.';port='.$port.';dbname='.$bdd);
	define("USER_BDD", $dbUser);
	define("MDP_BDD", $dbMdp);
}

creerIdentifiant();
<<<<<<< HEAD


?>

=======
>>>>>>> elodie
