<?php
require_once('../config.php');
require_once('../functions.php');
require_once('../includes/Models/client.php');
require_once('../includes/Models/moyenComm.php');
//require_once('../includes/Models/client.php');


$db = Database::connect();
$id = isset($_GET['id'])?$_GET['id']:0;
//print ($id);
$statement = $db->query("SELECT client.id_client as id_client,
			client.code_client as code,
            client.raison_sociale as raisonsoc,
			CONCAT(civilite.libelle,' ', contact.nom,' ',contact.prenom, contact.service ,civilite.libelle )as nom_cli,
            client.actif, CONCAT(devis.id_devis,' date :',devis.date_devis,' Duree validité',devis.duree_validite,' actif:',devis.actif )as devis_cli,
            CONCAT(type_moyen_comm.libelle,' ',moyen_comm.valeur) as moyen_comm
            FROM contact
            inner join civilite on civilite.id_civilite = contact.id_civilite
            inner join client ON client.id_client = contact.id_client
            inner join contact_comm on contact.id_contact = contact_comm.id_contact
            inner join moyen_comm on moyen_comm.id_mcomm = contact_comm.id_mcomm
            inner join type_moyen_comm on type_moyen_comm.id_type_moyen_comm = moyen_comm.id_type_moyen_comm
            inner join devis on devis.id_client = client.id_client where client.id_client=$id");
Database::disconnect();

?>


<!DOCTYPE html>
<html>

<head>
    <title> Client</title>
    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
    <link rel="stylesheet" type="text/css" href="clientstyle.css">
    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/datatables.css">
    <meta charset="UTF-8">
</head>

<body>
    <div class="wrapper">
        <?php include('../nav.php'); ?>

        <section>
            <h1>Progiplus</h1>
            <table id="table_client" class="display">
                <thead>
                    <tr>
                        <th>Code client</th>
                        <th>Raison sociale</th>
                         <th>Devis clients</th>
                         <th>Moyen de communication</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $loop = 0;
					while($client = $statement->fetchObject()){
                        print '<tr>';
                            print '<td>'.$client->code.'</td>';
                            print '<td>'.identiteClient($client->raisonsoc,$client->nom_cli).'</td>';
                            print '<td>'.$client->devis_cli.'</td>';
                            print '<td>'.$client->moyen_comm.'</td>';
                            print '<td class="action"><a href="detail.php?id='.$client->id_client.'"><img src="../includes/assets/pencil.png" class="petit_logo" alt="Modifier" /></a></td></tr>';

                        print '';
                    }


					?>
                </tbody>
            </table>
            <br><input type="button" name="lienForm" value="Ajouter un Client" onclick="self.location.href='formulaire.php'" style="background-color:#3cb371" style="color:white; font-weight:bold" onclick>
            <br><input type="button" name="lienForm" value="revenir a la liste" onclick="self.location.href='index.php'" style="background-color:#3cb371" style="color:white; font-weight:bold" onclick>

        </section>

    </div>
</body>

<script type="text/javascript" src="../includes/scripts/general.js"></script>
<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../includes/scripts/datatables.js"></script>
<script type="text/javascript">
    function init() {
        $('#table_client').DataTable({
            "language": getLangageDataTable("client", true)
        });
    }

    window.onload = init;

</script>

</html>
