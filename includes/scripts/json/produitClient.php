<?php
include_once ('../../../config.php');
if (isset($_POST['ref'])){
	$id=$_POST['ref'];

	$db = Database::connect();
	$statement = $db->prepare('
		SELECT reference,designation,prix_unitaire_ht,actif
		FROM produit
		WHERE reference = ? AND actif = 1;
	');
	$statement->execute(array($id));

	$article = $statement->fetchObject();
	Database::disconnect();

	print(json_encode($article));
}else{
    print('La reference du produit n existe pas');
}

?>
