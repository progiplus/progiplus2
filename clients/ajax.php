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
            $adresseF=$_POST['id_adresse_facturation'];
            $adresseC=$_POST['id_adresse_comp'];
            $nomAdresse=$_POST['nomAdresse'];
            $cPostale=$_POST['cPostale'];
            $ville = $_POST['ville'];

            $SQLville = 'INSERT INTO ville(nom_ville, cp_ville) VALUE ("'.$ville.'","'.$cPostale.'");';
            $result = $db->query($SQLville);
            $idVille = $db->lastInsertId();
            $result->fetchObject();
            $result->closeCursor();

            $SQLadresse = 'INSERT INTO adresse(ligne1, ligne2, id_ville) VALUE("'.$adresseF.'","'.$adresseC.'",'.$idVille.');';
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
            $adresseF=$_POST['id_adresse_facturation'];
            $adresseC=$_POST['id_adresse_comp'];
            $nomAdresse=$_POST['nomAdresse'];
            $cPostale=$_POST['cPostale'];
            $ville = $_POST['ville'];

            $SQLville = 'UPDATE ville(nom_ville, cp_ville) VALUE ("'.$ville.'","'.$cPostale.'");';
            $result = $db->query($SQLville);
            $idVille = $db->lastInsertId();
            $result->fetchObject();
            $result->closeCursor();

            $SQLadresse = 'UPDATE adresse(ligne1, ligne2, id_ville) VALUE("'.$adresseF.'","'.$adresseC.'",'.$idVille.');';
            $result = $db->query($SQLadresse);
            $idAdresse = $db->lastInsertId();
            $result->fetchObject();
            $result->closeCursor();

            $SQLclient = 'UPDATE client (code_client, raison_sociale, actif, id_adresse_facturation) VALUE("'.$codeClient.'","'.$raisonSociale.'",1,'.$idAdresse.');';
            $result = $db->query($SQLclient);
            $idClient = $db->lastInsertId();
            $result->fetchObject();
            $result->closeCursor();

            $SQLlisteadresse = 'UPDATE liste_adresse (libelle, actif, id_client, id_adresse) VALUE ("'.$nomAdresse.'",1, '.$idClient.', '.$idAdresse.');';
            $result = $db->query($SQLlisteadresse);
            $result->fetchObject();
            $result->closeCursor();

            $SQLcontact = 'UPDATE contact (nom, prenom, service,id_civilite, id_client) VALUE ("'.$nom.'","'.$prenom.'","'.$service.'",'.$civilite.','.$idClient.');';
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
}

Database::disconnect();

?>
