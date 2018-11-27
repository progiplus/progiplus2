<?php
require_once('../config.php');
require_once('../functions.php');

$action = $_POST['action'];

switch($action)
{
	case "changerActif":
		changerActifProduit();
	break;  
    case"ajouterClient":
        ajouterClient();
    break;
        
    case"modifierClient":
        modifierClient();
    break;
    case"modifierContact":
        modifierContact();
    break;
}

function changerActifProduit()
{
	$id = $_POST['id_client'];
	$val = $_POST['val'];
	$apply = $_POST['apply'];

	$actif = Database::connect();
	$state = $actif->query("UPDATE client
	SET actif = $apply
	where id_client =$id");
}

function ajouterClient()
{
    try
    {
        if(!empty($_POST))
        {
            $db = Database::connect();
            
            $codeClient=$_POST['code_client'];
            $raisonSociale=$_POST['raison_sociale'];
            $civilite=$_POST['civilite'];
            $nom=$_POST['nom'];
            $prenom=$_POST['prenom'];
            $service=$_POST['service'];
            $ligne1=$_POST['ligne1'];
            $ligne2=$_POST['ligne2'];
            $nomAdresse=$_POST['nomAdresse'];
            $cPostale=$_POST['cPostale'];
            $ville = $_POST['ville'];

            $SQLville = 'INSERT INTO ville(nom_ville, cp_ville) VALUE ("'.$ville.'","'.$cPostale.'");';
            $result = $db->query($SQLville);
            $idVille = $db->lastInsertId();
            $result->fetchObject();
            $result->closeCursor();

            $SQLadresse = 'INSERT INTO adresse(ligne1, ligne2, id_ville) VALUE("'.$ligne1.'","'.$ligne2.'",'.$idVille.');';
            $result = $db->query($SQLadresse);
            $idAdresse = $db->lastInsertId();
            $result->fetchObject();
            $result->closeCursor();

            $SQLclient = 'INSERT INTO client (code_client, raison_sociale, actif, id_adresse_facturation) VALUE("'.$codeClient.'","'.$raisonSociale.'",1,'.$idAdresse.');';
            $result = $db->query($SQLclient);
            $idClient = $db->lastInsertId();
            $result->fetchObject();
            $result->closeCursor();

            $SQLlisteadresse = 'INSERT INTO liste_adresse (libelle, actif, id_client, id_adresse) VALUE ("'.$nomAdresse.'",1, '.$idClient.', '.$idAdresse.');';
            $result = $db->query($SQLlisteadresse);
            $result->fetchObject();
            $result->closeCursor();

            $SQLcontact = 'INSERT INTO contact (nom, prenom, service,id_civilite, id_client) VALUE ("'.$nom.'","'.$prenom.'","'.$service.'",'.$civilite.','.$idClient.');';
            $result = $db->query($SQLcontact);
            $result->fetchObject();
            $result->closeCursor();
            print("true");
        }
        else
        {
            print("false");
        }
    }
    catch(Exception $e)
    {
        print("false");
    }
}
function modifierContact()
{
     try
    {
        if(!empty($_POST))
        {
            $db = Database::connect();

            $codeClient=$_POST['code_client'];
            $civilite=$_POST['civilite'];
            $nom=$_POST['nom'];
            $prenom=$_POST['prenom'];
            $service=$_POST['service'];
            $ligne1=$_POST['ligne1'];
            $ligne2=$_POST['ligne2'];
            $nomAdresse=$_POST['nomAdresse'];
            $cPostale=$_POST['cPostale'];
            $ville = $_POST['ville'];
            $idVille = $_POST['id_ville'];
            $idAdresseFacturation = $_POST['id_adresse_facturation'];
            $actif_client =$_POST['clientActif'];
            $idContact =$_POST['id_contact'];
            $idClient=$_POST['id_client'];

            $SQLville = "UPDATE ville SET nom_ville = '$ville', cp_ville='$cPostale'  WHERE id_ville = $idVille;";
            $result = $db->query($SQLville);
            $result->fetchObject();

            $result->closeCursor();

            $SQLadresse = "UPDATE adresse SET ligne1='$ligne1', ligne2='$ligne2'  WHERE id_adresse=$idAdresseFacturation;";
            $result = $db->query($SQLadresse);
            $result->fetchObject();
            $result->closeCursor();

            $SQLlisteadresse = "UPDATE liste_adresse SET libelle= '$nomAdresse' WHERE id_adresse=$idAdresseFacturation;";
            $result = $db->query($SQLlisteadresse);
            $result->fetchObject();
            $result->closeCursor();

            $SQLcontact = "UPDATE contact SET nom='$nom', prenom='$prenom', service='$service' , id_civilite=$civilite WHERE id_contact=$idContact;";
            $result = $db->query($SQLcontact);
            $result->fetchObject();
            $result->closeCursor();
            print("true");
        }
        else
        {
            print("false");
        }
    }
    catch(Exception $e)
    {
        print("false");
    }
}

Database::disconnect();



function modifierClient()
{
     try
    {
        if(!empty($_POST))
        {
            $db = Database::connect();
            
            $codeClient=$_POST['code_client'];
            $raisonSociale=$_POST['raison_sociale'];
            $civilite=$_POST['civilite'];
            $nom=$_POST['nom'];
            $prenom=$_POST['prenom'];
            $service=$_POST['service'];
            $ligne1=$_POST['ligne1'];
            $ligne2=$_POST['ligne2'];
            $nomAdresse=$_POST['nomAdresse'];
            $cPostale=$_POST['cPostale'];
            $ville = $_POST['ville'];
            $idVille = $_POST['id_ville'];
            $idAdresseFacturation = $_POST['id_adresse_facturation'];
            $actif_client =$_POST['clientActif'];
            $idContact =$_POST['id_contact'];
            $idClient=$_POST['id_client'];

            $SQLville = "UPDATE ville SET nom_ville = '$ville', cp_ville='$cPostale'  WHERE id_ville = $idVille;";
            $result = $db->query($SQLville);
            $result->fetchObject();

            $result->closeCursor();

            $SQLadresse = "UPDATE adresse SET ligne1='$ligne1', ligne2='$ligne2'  WHERE id_adresse=$idAdresseFacturation;";
            $result = $db->query($SQLadresse);
            $result->fetchObject();
            $result->closeCursor();

            $SQLclient ="UPDATE client SET code_client='$codeClient', raison_sociale='$raisonSociale', actif=$actif_client, id_adresse_facturation = $idAdresseFacturation WHERE id_client= $idClient;";
            $result = $db->query($SQLclient);
            $result->fetchObject();
            $result->closeCursor();

            $SQLlisteadresse = "UPDATE liste_adresse SET libelle= '$nomAdresse' WHERE id_adresse=$idAdresseFacturation;";
            $result = $db->query($SQLlisteadresse);
            $result->fetchObject();
            $result->closeCursor();

            $SQLcontact = "UPDATE contact SET nom='$nom', prenom='$prenom', service='$service' , id_civilite=$civilite WHERE id_contact=$idContact;";
            $result = $db->query($SQLcontact);
            $result->fetchObject();
            $result->closeCursor();
            print("true");
        }
        else
        {
            print("false");
        }
    }
    catch(Exception $e)
    {
        print("false");
    }
}

Database::disconnect();

?>


