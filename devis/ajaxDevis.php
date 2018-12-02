<?php
require_once('../config.php');
require_once('../functions.php');

$codeClient = $lignes = "";

if(!empty($_POST)){
	$isValid = true;
	$numDevis = 0;
	$codeClient = checkInput($_POST["codeClient"]);
	$lignes = $_POST['lignes'];

	for($i = 0; $i < count($lignes); $i++){
		$ref = checkInput($lignes[$i]['ref']);
		$qt = checkInput($lignes[$i]['quantite']);
	}

	if(empty($codeClient)){
		print('Code client ne peut pas etre vide');
		$isValid=false;
	}
	if(empty($lignes)){
		print('les lignes ne peut pas etre vide');
		$isValid=false;
	}

	if($isValid){
		// Recuperation de l'id du dernier devis
		$db = Database::connect();
			$statement = $db->query('
				SELECT MAX(id_devis) as devis FROM devis
			');
			while ($donnees = $statement->fetch())
				{
					$numDevis = $donnees['devis'] ;
					$numDevis ++;
				}
		Database::disconnect();

		// Recuperation INFO client suivant le code client
		$db = Database::connect();
			$statement = $db->prepare('
				SELECT id_client,id_adresse_facturation FROM client where code_client = ?
			');
			$statement->execute(array($codeClient));
			$idClient = $statement->fetch();
		Database::disconnect();

		// Ajout du devis
		$db = Database::connect();
			$statement = $db->prepare('
				INSERT INTO devis (date_devis,duree_validite,actif,id_client,id_adresse)
				VALUES(CURDATE(),30,1,?,?);
			');
			$statement->execute(array($idClient[0],$idClient[1]));
		Database::disconnect();

		// faire la requete ligne de devis avec une boucle for. Taille : $_POST ?
		$db = Database::connect();
			for($i = 0; $i < count($lignes); $i++)
			{
				if(!empty($lignes[$i]['ref'])){

					$statement = $db->prepare('SELECT reference,prix_unitaire_ht as pU,id_tva FROM produit where reference= ?');
					$statement->execute(array($lignes[$i]['ref']));
					$produit = $statement->fetch();


					$statement = $db->prepare('
						INSERT INTO ligne_devis_client (quantite,prixU,reference,id_tva,id_devis)
						VALUES(?,?,?,?,?);
					');
					$statement->execute(array((int)$lignes[$i]['quantite'],$produit['pU'],$produit['reference'],$produit['id_tva'],$numDevis));
				}
			}
		Database::disconnect();

	}
}

?>
