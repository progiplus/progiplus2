<?php
require_once('../config.php');
require_once('../functions.php');

$id = $_POST['id_client'];
print('il y a '.$_POST['id_client']);
$val = $_POST['val'];
print ('$val');
$apply = $_POST['apply'];
print ('$apply');
$actif = Database::connect();
$state = $actif->query("UPDATE client
SET actif = $apply
where id_client =$id");
print("UPDATE client
SET actif = $apply
where id_client =$id");
Database::disconnect();

?>
