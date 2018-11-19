<?php
require_once('../../config.php');
require_once('../../functions.php');

$produit = $_POST['reference'];
print('il y a '.$_POST['reference']);
//$val = $_POST['val'];
//print ('$val');
$apply = $_POST['apply'];
print ($apply);
$actif = Database::connect();
$state = $actif->query("UPDATE produit
SET actif = $apply
where reference ='$produit'");
print("UPDATE produit
SET actif = $apply
where reference ='$produit'");
Database::disconnect();

?>
