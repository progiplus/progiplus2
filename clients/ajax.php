<?php
require_once('../config.php');
require_once('../functions.php');

$action = $_POST['action'];

switch($action)
{
	case "changerActif":
		changerActifClient();
	break;
    case"ajouterClient":
        ajouterClient();
    break;
    case"modifierClient":
        modifierClient();
    break;
	case"ajouterContact":
		ajouterContact();
		break;
    case"modifierContact":
        modifierContact();
    break;
    case"getAdresseClient":
        getAdresseClient();
    break;
    case"gererAdresse":
        gererAdresse();
    break;
}

function changerActifClient()
{
	$id = checkInput($_POST['id_client']);
	$val = checkInput($_POST['val']);
	$apply = checkInput($_POST['apply']);

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

            $codeClient=checkInput($_POST['code_client']);
            $raisonSociale=checkInput($_POST['raison_sociale']);
            $civilite=checkInput($_POST['civilite']);
            $nom=checkInput($_POST['nom']);
            $prenom=checkInput($_POST['prenom']);
            $service=checkInput($_POST['service']);
            $ligne1=checkInput($_POST['ligne1']);
            $ligne2=checkInput($_POST['ligne2']);
            $nomAdresse=checkInput($_POST['nomAdresse']);
            $cPostale=checkInput($_POST['cPostale']);
            $ville = checkInput($_POST['ville']);

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

            $SQLclient = 'INSERT INTO client (code_client, raison_sociale, actif, id_adresse_facturation) VALUE ("'.$codeClient.'","'.$raisonSociale.'",1,'.$idAdresse.');';
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

            $codeClient=checkInput($_POST['code_client']);
            $raisonSociale=checkInput($_POST['raison_sociale']);
            $civilite=checkInput($_POST['civilite']);
            $nom=checkInput($_POST['nom']);
            $prenom=checkInput($_POST['prenom']);
            $service=checkInput($_POST['service']);
            $ligne1=checkInput($_POST['ligne1']);
            $ligne2=checkInput($_POST['ligne2']);
            $nomAdresse=checkInput($_POST['nomAdresse']);
            $cPostale=checkInput($_POST['cPostale']);
            $ville = checkInput($_POST['ville']);
            $idVille = checkInput($_POST['id_ville']);
            $idAdresseFacturation = checkInput($_POST['id_adresse_facturation']);
            $actif_client =checkInput($_POST['clientActif']);
            $idContact =checkInput($_POST['id_contact']);
            $idClient=checkInput($_POST['id_client']);


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

function ajouterContact()
{
	try
	{
		if(!empty($_POST))
		{
			$db = Database::connect();
			
			$idClient=checkInput($_POST['idClient']);
			$civilite=checkInput($_POST['civilite_contact']);
			$nom=checkInput($_POST['nom_contact']);
			$prenom=checkInput($_POST['prenom_contact']);
			$service=checkInput($_POST['service_contact']);
			$tabMoyensCom = $_POST['moyensCom'];
			
			$SQLcontact = 'INSERT INTO contact (nom, prenom, service,id_civilite, id_client)
				VALUE ("'.$nom.'","'.$prenom.'","'.$service.'",'.$civilite.','.$idClient.');';
			$result = $db->query($SQLcontact);
			$result->fetchObject();
			$idContact = $db->lastInsertId();
			$result->closeCursor();
			
			$type = $valeur = $idMoyenCom = -1;
			
			$stmt = $db->prepare("INSERT INTO moyen_comm(valeur, id_type_moyen_comm) VALUES (:valeur, :type)");
			$stmt->bindParam(':type', $type);
			$stmt->bindParam(':valeur', $valeur);
			
			$stmt2 = $db->prepare("INSERT INTO contact_comm(id_contact, id_mcomm) VALUES (:idContact, :idMoyen)");
			$stmt2->bindParam(':idContact', $idContact);
			$stmt2->bindParam(':idMoyen', $idMoyenCom);
			
			foreach($tabMoyensCom as $moyen)
			{
				$type = checkInput($moyen['type']);
				$valeur = checkInput($moyen['valeur']);
				$stmt->execute();
				$idMoyenCom = $db->lastInsertId();
				$stmt2->execute();
			}
			
			$stmt->closeCursor();
			$stmt2->closeCursor();
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
			
			$civilite=checkInput($_POST['civilite']);
			$nom=checkInput($_POST['nom']);
			$prenom=checkInput($_POST['prenom']);
			$service=checkInput($_POST['service']);
			$ligne1=checkInput($_POST['ligne1']);
			$ligne2=checkInput($_POST['ligne2']);
			$nomAdresse=checkInput($_POST['nomAdresse']);
			$cPostale=checkInput($_POST['cPostale']);
			$ville = checkInput($_POST['ville']);
			$idVille = checkInput($_POST['id_ville']);
			$idAdresseFacturation = checkInput($_POST['id_adresse_facturation']);
			$idContact =checkInput($_POST['id_contact']);
			
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

function getAdresseClient()
{
    $db = Database::connect();
    $idClient = checkInput($_POST['idClient']);
    $SQL = "select  liste_adresse.libelle, adresse.id_adresse, adresse.ligne1, adresse.ligne2, ville.cp_ville, ville.nom_ville
    from liste_adresse
    inner join client on client.id_client = liste_adresse.id_client
    inner join adresse on adresse.id_adresse = liste_adresse.id_adresse
    inner join ville on ville.id_ville = adresse.id_ville
    where client.id_client = $idClient;";
    
    $result = $db->query($SQL);
    while($r = $result->fetchObject())
    {
        echo '<option value="'.$r->id_adresse.'">'.
            $r->libelle." : ".$r->ligne1." ".$r->ligne2." ".$r->cp_ville." ".$r->nom_ville
            .'</option>';
    }
    
    $result->closeCursor();
}

function gererAdresse(){
            $db = Database::connect();
            $ligne1=checkInput($_POST['ligne1']);
            $ligne2=checkInput($_POST['ligne2']);
            $nomAdresse=checkInput($_POST['nomAdresse']);
            $cPostale=checkInput($_POST['cPostale']);
            $ville = checkInput($_POST['ville']);
            $idAdresseFacturation = checkInput($_POST['id_adresse_facturation']);
            $idClient=checkInput($_POST['id_client']);

            $SQLclient = "update client 
            set id_adresse_facturation = $idAdresseFacturation
            where  id_client= $idClient;";
            $result = $db->query($SQLclient);
            $result->fetchObject();
            $result->closeCursor();

            //Verification: On ne fait pas le insert si il y a un de 3 n'est pas remplis
            if($ville != "" && $cPostale != "" && $ligne1 != "" && $nomAdresse != "")
            {
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

                $SQLlisteadresse = 'INSERT INTO liste_adresse (libelle, actif, id_client, id_adresse) VALUE ("'.$nomAdresse.'",1, '.$idClient.', '.$idAdresse.');';
                $result = $db->query($SQLlisteadresse);
                $result->fetchObject();
                $result->closeCursor();
            }
            print("true");
}
    
Database::disconnect();