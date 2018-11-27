<?php
require_once('../config.php');
require_once('../functions.php');

$action = $_POST['action'];

switch($action){
	case "changerActif":
		changerActifProduit();
	break;
	case "modifierProduit":
		modifierProduit();
	break;
	case "ajouterProduit";
		ajouterProduit();
	break;
	case "ajouterMarque";
		ajouterMarque();
	break;
	case "ajouterGamme";
		ajouterGamme();
	break;
	case "ajouterCategorie";
		ajouterCategorie();
	break;
}

function ajouterCategorie(){
	if (!empty($_POST)){
		$db = Database::connect();
		$libelle = $_POST['nomNewC'];
		$Query = 'INSERT INTO categorie(libelle, actif) VALUES ("'.$libelle.'", 1)';
    $Statement=$db->query($Query);
    $Statement->fetchObject();
    $Statement->closeCursor();
		print "true";
	}else{
		print "false";
	}
}

function ajouterGamme(){
	if (!empty($_POST)){
		$db = Database::connect();
		$libelle = $_POST['nomNewG'];
		$Query = 'INSERT INTO gamme(libelle, actif, id_marque) VALUES ("'.$libelle.'", 1, //TODO//)';
    $Statement=$db->query($Query);
    $Statement->fetchObject();
    $Statement->closeCursor();
		print "true";
	}else{
		print "false";
	}
}

function ajouterMarque(){
	if (!empty($_POST)){
		$db = Database::connect();
		$nom = $_POST['nomNewM'];
		$Query = 'INSERT INTO marque(nom) VALUES ("'.$nom.'")';
    $Statement=$db->query($Query);
    $Statement->fetchObject();
    $Statement->closeCursor();
		print "true";
	}else{
		print "false";
	}
}

function modifierProduit(){
  if (!empty($_POST)){
		$db = Database::connect();
    $reference = $_POST['referenceProduit'];
    $designation = $_POST['designationProduit'];
    $prixht_produit = $_POST['prixht_produit'];
		$TVA = $_POST['tva'];
    $gammeProduit = $_POST['gammeProduit'];
    $catégorieProduit = $_POST['catégorieProduit'];
    $Query = "UPDATE produit SET designation = \"$designation\", prix_unitaire_ht = \"$prixht_produit\", id_tva = $TVA, id_gamme = $gammeProduit, id_categorie = $catégorieProduit WHERE reference = \"$reference\"";
    $Statement=$db->query($Query);
    $Statement->fetchObject();
    $Statement->closeCursor();
    print "true";
  }else{
    print "false";
  }
}

function ajouterProduit(){
	if (!empty($_POST)){
		$db = Database::connect();
		$reference = $_POST['referenceProduit'];
		$designation = $_POST['designationProduit'];
		$prixht_produit = $_POST['prixht_produit'];
		$TVA = $_POST['tva'];
		$gammeProduit = $_POST['gammeProduit'];
		$catégorieProduit = $_POST['catégorieProduit'];
		$Query = 'INSERT INTO produit(reference, designation, prix_unitaire_ht, actif, id_gamme, id_categorie, id_tva) VALUES ("'
			.$reference.'", "'.$designation.'", '.$prixht_produit.', 1, '.$gammeProduit.', '.$catégorieProduit.', '.$TVA.')';
		$Statement = $db->query($Query);
		$Statement->fetchObject();
		$Statement->closeCursor();
		print "true";
  }else{
    print "false";
  }
}

function changerActifProduit(){
	$produit = $_POST['reference'];
	$apply = $_POST['apply'];
	$actif = Database::connect();
	$state = $actif->query("UPDATE produit
	SET actif = $apply
	where reference ='$produit'");
	Database::disconnect();
}

?>
