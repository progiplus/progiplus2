<?php

class Database
{
    private static $hote = 'localhost;port=3306' ;
    private static $bdd = 'progiplus';
    private static $dbUser = 'root';
    private static $dbMdp = 'azertysio';


    private static $pdo = null;

    public static function connect()
    {
        try
        {
            self::$pdo = new PDO('mysql:host=' . self::$hote. ';dbname=' . self::$bdd,self::$dbUser,self::$dbMdp);
        }
        catch (PDOException $e)
        {
            die($e-> getMessage());
            exit();
        }
        return self::$pdo;
    }

    public static function disconnect()
    {
        self::$pdo = null;
    }
}

/**
*
* INFO ENTREPRISE UTILISATRICE
*
**/

$nomEnt = "Progiplus";
$telFixeEnt = "05 05 05 05 05";
$telMobileEnt = "06 06 06 06 06";
$emailEnt = "contact@progiplus.fr";
$rueEnt = "22 rue des Genies";
$codePostalEnt = "33000";
$villeEnt = "Bordeaux";
$siret = "1234567890123";
$infoEnt =
	$nomEnt .'</br>
	Tel : '. $telFixeEnt.'</br>
	Mobile : '.$telMobileEnt.'</br>
	Email : '.$emailEnt.'</br>
	'.$rueEnt.'</br>
	'.$codePostalEnt.' '. $villeEnt .'</br>
	Siret : '.$siret;

$dateActuel = date("d/m/Y");

?>
