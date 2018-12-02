<?php
require_once('../config.php');
require_once('../functions.php');

$action = checkInput($_POST['action']);

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
	case "modifierMarque";
		modifierMarque();
	break;
	case "ajouterMarque";
		ajouterMarque();
	break;
	case "modifierGamme";
		modifierGamme();
	break;
	case "ajouterGamme";
		ajouterGamme();
	break;
	case "modifierCategorie";
		modifierCategorie();
	break;
	case "ajouterCategorie";
		ajouterCategorie();
	break;
}

function modifierCategorie(){
	if (!empty($_POST)){
		$db = Database::connect();
		$id_categorie = checkInput($_POST['selectC']);
		$libelle = checkInput($_POST['newCategorie']);
		$Query = "UPDATE categorie SET libelle = \"$libelle\" WHERE id_categorie = \"$id_categorie\"";
    $Statement=$db->query($Query);
    $Statement->fetchObject();
    $Statement->closeCursor();
		print "true";
	}else{
		print "false";
	}
}

function ajouterCategorie(){
	if (!empty($_POST)){
		$db = Database::connect();
		$libelle = checkInput($_POST['nomNewC']);
		$Query = 'INSERT INTO categorie(libelle, actif) VALUES ("'.$libelle.'", 1)';
    $Statement=$db->query($Query);
    $Statement->fetchObject();
    $Statement->closeCursor();
		print "true";
	}else{
		print "false";
	}
}

function modifierGamme(){
	if (!empty($_POST)){
		$db = Database::connect();
		$id_gamme = checkInput($_POST['selectG']);
		$libelle = checkInput($_POST['newGamme']);
		$Query = "UPDATE gamme SET libelle = \"$libelle\" WHERE id_gamme = \"$id_gamme\"";
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
		$libelle = checkInput($_POST['nomNewG']);
		$id_marque = checkInput($_POST['selectBindM']);
		$Query = 'INSERT INTO gamme(libelle, actif, id_marque) VALUES ("'.$libelle.'", 1, '.$id_marque.')';
    $Statement=$db->query($Query);
    $Statement->fetchObject();
    $Statement->closeCursor();
		print "true";
	}else{
		print "false";
	}
}

function modifierMarque(){
	if (!empty($_POST)){
		$db = Database::connect();
		$id_marque = checkInput($_POST['selectM']);
		$nom = checkInput($_POST['newMarque']);
		$Query = "UPDATE marque SET nom = \"$nom\" WHERE id_marque = \"$id_marque\"";
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
		$nom = checkInput($_POST['nomNewM']);
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
    $reference = checkInput($_POST['referenceProduit']);
    $designation = checkInput($_POST['designationProduit']);
    $prixht_produit = checkInput($_POST['prixht_produit']);
		$TVA = checkInput($_POST['tva']);
    $gammeProduit = checkInput($_POST['gammeProduit']);
    $catégorieProduit = checkInput($_POST['catégorieProduit']);
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
		$reference = checkInput($_POST['referenceProduit']);
		$designation = checkInput($_POST['designationProduit']);
		$prixht_produit = checkInput($_POST['prixht_produit']);
		$TVA = checkInput($_POST['tva']);
		$gammeProduit = checkInput($_POST['gammeProduit']);
		$catégorieProduit = checkInput($_POST['catégorieProduit']);
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
	$produit = checkInput($_POST['reference']);
	$apply = checkInput($_POST['apply']);
	$actif = Database::connect();
	$state = $actif->query("UPDATE produit
	SET actif = $apply
	where reference ='$produit'");
	Database::disconnect();
}

?>
