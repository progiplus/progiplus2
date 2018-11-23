<?php
require_once('../config.php');
require_once('../functions.php');
require_once('../includes/Models/client.php');
require_once('../includes/Models/moyenComm.php');
//require_once('../includes/Models/client.php');


$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
//print ($id);
//  informations clients
$sclient = $db->query("  select code_client as code, raison_sociale as rs , actif, adresse.ligne1, adresse.ligne2, ville.cp_ville as cp, ville.nom_ville as ville
 from client
 inner join adresse on client.id_adresse_facturation = adresse.id_adresse
  inner join ville on adresse.id_ville = ville.id_ville
 where id_client= $id");
Database::disconnect();


$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
//print ($id);
//  informations client
$contact = $db->query("select client.code_client as code_cli , civilite.libelle as civilite, contact.nom as nom, contact.prenom as prenom, contact.service as service
from contact
right outer JOIN client ON client.id_client = contact.id_client
#eft outer join contact_comm on contact.id_contact = contact_comm.id_contact
inner join civilite on civilite.id_civilite = contact.id_civilite where client.id_client= $id");
Database::disconnect();

$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
//print ($id);
//  informations adresses
$adresse = $db->query("select adresse.ligne1 as ligne1, adresse.ligne2 as ligne2,ville.cp_ville as cp,  ville.nom_ville as ville
from adresse
inner join liste_adresse on adresse.id_adresse = liste_adresse.id_adresse
inner join ville on ville.id_ville = adresse.id_ville
inner join client on liste_adresse.id_client = client.id_client
where client.id_client = $id");
Database::disconnect();

$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
//print ($id);
//  informations contacts
$comm = $db->query("select type_moyen_comm.libelle as type, moyen_comm.valeur as valeur
from type_moyen_comm
inner join moyen_comm on moyen_comm.id_type_moyen_comm = type_moyen_comm.id_type_moyen_comm
inner join contact_comm on contact_comm.id_mcomm = moyen_comm.id_mcomm
inner join contact on contact.id_contact = contact_comm.id_contact
inner join client on client.id_client = contact.id_client
 where client.id_client= $id");
Database::disconnect();

$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
//print ($id);
//  informations contacts
$comm = $db->query("select type_moyen_comm.libelle as type, moyen_comm.valeur as valeur
from type_moyen_comm
inner join moyen_comm on moyen_comm.id_type_moyen_comm = type_moyen_comm.id_type_moyen_comm
inner join contact_comm on contact_comm.id_mcomm = moyen_comm.id_mcomm
inner join contact on contact.id_contact = contact_comm.id_contact
inner join client on client.id_client = contact.id_client
 where client.id_client= $id");
Database::disconnect();

$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
//print ($id);
//  informations contacts
$devis = $db->prepare(" SELECT client.code_client AS code_cli,
                client.id_client,
                client.raison_sociale AS rs,
                CONCAT(civilite.libelle,' ',contact.nom,' ',contact.prenom) AS nom_cli,
                devis.date_devis AS date,
                devis.id_devis AS numDevis,
                SUM(ligne_devis_client.quantite * ligne_devis_client.prixU) AS montant
        FROM contact
        INNER JOIN client ON client.id_client = contact.id_client
        INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite
        INNER JOIN devis ON client.id_client = devis.id_client
        INNER JOIN ligne_devis_client ON devis.id_devis = ligne_devis_client.id_devis
         where client.id_client = $id
        GROUP BY devis.id_devis,nom_cli
        ");
Database::disconnect();


?>


<!DOCTYPE html>
<html>

<head>
    <title> Client</title>
    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
    <link rel="stylesheet" type="text/css" href="styledetail.css">
    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/datatables.css">
    <meta charset="UTF-8">
</head>

<body>
    <div class="wrapper">
        <?php include('../nav.php'); ?>

        <section>
            <h1>Progiplus</h1>
            <br><input type="button" name="lienForm" value="revenir a la liste" onclick="self.location.href='index.php'" style="background-color:#3cb371" style="color:white; font-weight:bold" onclick>

            <br>
            <h2>Informations Client:</h2>
            <div class="cadre">

                <p>

                    <?php
                   // select type_moyen_comm.libelle as type, moyen_comm.valeur as valeur
					$client = $sclient->fetchObject();
                            print 'Code client :'.$client->code.'';
                            print '</br>Raison Sociale: '.$client->rs.'';
                            print '</br>Actif ou non actif: '.$client->actif.'';
                            print '</br><Adresse de Facturation: >'.$client->ligne1.', '.$client->ligne2.', '.$client->cp.' '.$client->ville.'';
                        print '';


					?>
                </p>
            </div>

            <br>
            <div id="container">
            <div class="contact">
            <h2>Contact</h2>
            <table id="table_contact" class="display">
                <thead>
                    <tr id="katya">
                        <th>Code client</th>
                        <th>Civilité</th>
                        <th>Nom client</th>
                        <th>Prenom client</th>
                        <th>Service</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //select client.code_client as code_cli , civilite.libelle as civilite, contact.nom as nom, contact.prenom as prenom, contact.service as service
					while($client = $contact->fetchObject()){
                        print '<tr>';
                            print '<td>'.$client->code_cli.'</td>';
                            print '<td>'.$client->civilite.'</td>';
                            print '<td>'.$client->nom.'</td>';
                            print '<td>'.$client->prenom.'</td>';
                            print '<td>'.$client->service.'</td></tr>';
                           // print '<td class="action"><a href="detail.php?id='.$client->id_client.'"><img src="../includes/assets/pencil.png" class="petit_logo" alt="Modifier" /></a></td></tr>';

                        print '';
                    }


					?>
                </tbody>
            </table>
            <br>
            </div>
            <div class = "contact">
            <h2>Adresse</h2>
            <table id="table_adresse" class="display">
                <thead>
                    <tr>
                        <th>Ligne 1</th>
                        <th>Ligne 2</th>
                        <th>CP</th>
                        <th>Ville</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   // select adresse.ligne1, adresse.ligne2,ville.cp_ville,  ville.nom_ville
					while($client = $adresse->fetchObject()){
                        print '<tr>';
                            print '<td>'.$client->ligne1.'</td>';
                            print '<td>'.$client->ligne2.'</td>';
                            print '<td>'.$client->cp.'</td>';
                            print '<td>'.$client->ville.'</td></tr>';

                        print '';
                   }


					?>
                </tbody>
            </table>
            </div>
            </div>
            <br>
            <div id="communication">
            <h2>Communication</h2>
            <table id="table_comm" class="display">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Valeur</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   // select type_moyen_comm.libelle as type, moyen_comm.valeur as valeur
					while($client = $comm->fetchObject()){
                        print '<tr>';
                            print '<td>'.$client->type.'</td>';
                            print '<td>'.$client->valeur.'</td></tr>';
                        print '';
                   }


					?>
                </tbody>
            </table>
            </div>
            <div class = "contact">
            <br>
            <h2>Devis</h2>
            <table id="table_devis" class="display">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Durée</th>
                        <th>Actif</th>
                        <th>Quantité LD</th>
                        <th>Prix</th>
                        <th>Reference</th>
                        <th>TVA</th>

                    </tr>
                </thead>
               

                <tbody>
                    <?php
                   //select devis.id_devis as id, devis.date_devis as date, devis.duree_validite as dv, devis.actif , ligne_devis_client.quantite, ligne_devis_client.prixU, ligne_devis_client.reference,tva.taux
					while($client = $devis->fetchObject()){
                        print '<tr>';
                            print '<td>'.$client->date.'</td>';
                            print '<td>'.$client->dv.'</td>';
                            print '<td>'.$client->actif.'</td>';
                            print '<td>'.$client->quantiteld.'</td>';
                        print '<td>'.$client->prix.'</td>';
                        print '<td>'.$client->reference.'</td>';
                            print '<td>'.$client->tva.'</td></tr>';
                           // print '<td class="action"><a href="detail.php?id='.$client->id_client.'"><img src="../includes/assets/pencil.png" class="petit_logo" alt="Modifier" /></a></td></tr>';

                        print '';
                    }


					?>
                </tbody>
            </table>
                    </div>
                          
               
            <br><input class="button" type="button" name="lienForm" value="Ajouter un Client" onclick="self.location.href='formulaire.php'" >
            <br><input class="button" type="button" name="lienForm" value="Revenir" onclick="self.location.href='index.php'" >

        </section>
    </div>
</body>
   

<script type="text/javascript" src="../includes/scripts/general.js"></script>
<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../includes/scripts/datatables.js"></script>
<script type="text/javascript">
    function init() {
        /*$('#table_comm').DataTable({
            "language": getLangageDataTable("Moyens communication")
        });
        $('#table_adresse').DataTable({
            "language": getLangageDataTable("adresse", true)
        });
        $('#table_contact').DataTable({
            "language": getLangageDataTable("contact")
        });
        $('#table_devis').DataTable({
            "language": getLangageDataTable("devi")
        });*/
    }

    window.onload = init;

</script>

</html>
