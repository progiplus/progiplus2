<?php
require_once('../config.php');
require_once('../functions.php');
require_once('../includes/Models/client.php');
require_once('../includes/Models/moyenComm.php');


$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;

$sclient = $db->query("  select code_client as code, raison_sociale as rs , actif, adresse.ligne1, adresse.ligne2, ville.cp_ville as cp, ville.nom_ville as ville
 from client
 inner join adresse on client.id_adresse_facturation = adresse.id_adresse
  inner join ville on adresse.id_ville = ville.id_ville
 where id_client= $id");
Database::disconnect();


$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;

$contact = $db->query("select client.code_client as code_cli , civilite.libelle as civilite, contact.nom as nom, contact.prenom as prenom, contact.service as service
from contact
right outer JOIN client ON client.id_client = contact.id_client
#eft outer join contact_comm on contact.id_contact = contact_comm.id_contact
inner join civilite on civilite.id_civilite = contact.id_civilite where client.id_client= $id");
Database::disconnect();

$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;

$adresse = $db->query("select adresse.ligne1 as ligne1, adresse.ligne2 as ligne2,ville.cp_ville as cp,  ville.nom_ville as ville 
from adresse
inner join liste_adresse on adresse.id_adresse = liste_adresse.id_adresse
inner join ville on ville.id_ville = adresse.id_ville
inner join client on liste_adresse.id_client = client.id_client
where client.id_client =$id");
Database::disconnect();

$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;

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

$comm = $db->query("select type_moyen_comm.libelle as type, moyen_comm.valeur as valeur ,CONCAT(civilite.libelle,' ',contact.nom ,' ', contact.prenom) as contact
from type_moyen_comm
inner join moyen_comm on moyen_comm.id_type_moyen_comm = type_moyen_comm.id_type_moyen_comm
inner join contact_comm on contact_comm.id_mcomm = moyen_comm.id_mcomm
inner join contact on contact.id_contact = contact_comm.id_contact
inner join client on client.id_client = contact.id_client
inner join civilite on civilite.id_civilite = contact.id_civilite
 where client.id_client= $id");
Database::disconnect();

$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
$deviss = $db->query("select  devis.id_devis as reference, devis.date_devis as date, sum(ligne_devis_client.prixU * ligne_devis_client.quantite )as Prix_Total
from devis
inner join ligne_devis_client on ligne_devis_client.id_devis = devis.id_devis
inner join client on devis.id_client = client.id_client where client.id_client= $id
group by devis.id_devis;");
Database::disconnect();


?>


<!DOCTYPE html>
<html>

<head>
    <title> Client</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
    <link rel="stylesheet" type="text/css" href="styledetail.css">
    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/datatables.css">
    <meta charset="UTF-8">
</head>

<body>
    <div class="wrapper">
        <?php include('../nav.php'); ?>

        <section>

            <div id="info">
                <h2>Informations Client:</h2>

                <div id="cadre">

                    <p>

                        <?php

					$client = $sclient->fetchObject();
                            print 'Code client :'.$client->code.'';
                            print '</br>Raison Sociale: '.$client->rs.'';
                            print '</br>Actif ou non actif: '.$client->actif.'';
                            print '</br><Adresse de Facturation: >'.$client->ligne1.', '.$client->ligne2.', '.$client->cp.' '.$client->ville.'';
                        print '';


					?>
                    </p>
                </div>
            </div>

            <div class="container">
                <div class="table-responsive">
                    <h3>Contact</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code client</th>
                                <th>Civilité</th>
                                <th>Nom client</th>
                                <th>Prenom client</th>
                                <th>Service</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

					while($client = $contact->fetchObject()){
                        print '<tr>';
                            print '<td class="col-xs-2">'.$client->code_cli.'</td>';
                            print '<td class="col-xs-2">'.$client->civilite.'</td>';
                            print '<td class="col-xs-2">'.$client->nom.'</td>';
                            print '<td class="col-xs-2">'.$client->prenom.'</td>';
                            print '<td class="col-xs-2">'.$client->service.'</td></tr>';

                        print '';
                    }


					?>
                        </tbody>
                    </table>
                </div>

                <br>

                <div class="table-responsive">
                    <h3>Adresse</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="col-xs-2">Ligne 1</th>
                                <th class="col-xs-2">Ligne 2</th>
                                <th class="col-xs-2">CP</th>
                                <th class="col-xs-2">Ville</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

					while($client = $adresse->fetchObject()){
                        print '<tr>';
                            print '<td class="col-xs-2">'.$client->ligne1.'</td>';
                            print '<td class="col-xs-2">'.$client->ligne2.'</td>';
                            print '<td class="col-xs-2">'.$client->cp.'</td>';
                            print '<td class="col-xs-2">'.$client->ville.'</td></tr>';

                        print '';
                   }


					?>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <h3>Communication</h3>
                    <table>
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
                            print '<td>'.$client->valeur.'</td>';
                            print '<td>'.$client->contact.'</td></tr>';
                        print '';
                   }


					?>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <br>
                    <h3>Devis</h3>
                    <table id="table_devis" class="display">
                        <thead>
                            <tr>
                                <th>reference</th>
                                <th>date</th>
                                <th>prix total</th>


                            </tr>
                        </thead>


                        <tbody>
                            <?php


					while($client = $deviss->fetchObject()){
                        print '<tr>';
                            print '<td class="col-xs-2">'.$client->reference.'</td>';
                            print '<td class="col-xs-2">'.$client->date.'</td>';
                            print '<td class="col-xs-2">'.$client->Prix_Total.'</td></tr>';


                        print '';
                    }


					?>

                        </tbody>
                    </table>
                </div>
                <div id="inputs">
                    <br><input style="margin-left:4px;" class="button" type="button" name="lienForm" value="Ajouter" onclick="self.location.href='formulaire.php'">
                    <br><input class="button" type="button" name="lienForm" value="Revenir" onclick="self.location.href='index.php'">
                </div>

            </div>
        </section>
    </div>

</body>


<script type="text/javascript" src="../includes/scripts/general.js"></script>
<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../includes/scripts/datatables.js"></script>
<script type="text/javascript">
    function init() {

    }

    window.onload = init;

</script>

</html>
