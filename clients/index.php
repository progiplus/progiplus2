<?php
require_once('../config.php');
require_once('../functions.php');
require_once('../includes/Models/client.php');
require_once('../includes/Models/moyenComm.php');
//require_once('../includes/Models/client.php');

$db = Database::connect();
$statement = $db->query(' SELECT client.id_client as id_client,
			client.code_client as code,
            client.raison_sociale as raisonsoc,
			CONCAT(civilite.libelle," ",contact.nom," ",contact.prenom)as nom_cli, actif
            FROM contact
            inner JOIN client ON client.id_client = contact.id_client
			inner join civilite ON contact.id_civilite = civilite.id_civilite order by actif desc ');
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
                        <th colspan="2">Actions</th>
                        <th>Actif?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $script ='';
					while($client = $statement->fetchObject()){
                       // $script .= '<tr data-id="'.$client->id_client.'">';
                            print '<td>'.$client->code.'</td>';
                            print '<td>'.identiteClient($client->raisonsoc,$client->nom_cli).'</td>';
                            print '<td class="action"><a href="formulaire.php?id='.$client->id_client.'"><img src="../includes/assets/pencil.png" class="petit_logo" alt="Modifier" /></a></td>
                            <td class="action"><a href="detail.php?id='.$client->id_client.'"><img src="../includes/assets/zoom.png" class="petit_logo" alt="details" /></a></td>';
                            print '<td class="data" data-id="'.$client->id_client.'"><input type="checkbox" name="checkbox" data-id="'.$client->id_client.'" id="checkbox" value="actif"  ';
                                if($client->actif== 1){
                                print ("checked='checked'");
                                }print "/></td></tr>";
                        print '';
                        print ($script);
                    }


					?>
                </tbody>
            </table>
            <br><input type="button" name="lienForm" value="Ajouter un Client" onclick="self.location.href='formulaire.php'" style="background-color:#3cb371" style="color:white; font-weight:bold" onclick>

        </section>

    </div>
</body>

<script type="text/javascript" src="../includes/scripts/general.js"></script>
<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../includes/scripts/datatables.js"></script>
<script type="text/javascript">
    $("input:checkbox").on("change", function() {
        var xhr;
        if (window.XMLHttpRequest)
            xhr = new XMLHttpRequest();
        else
            xhr = new ActiveXObject("microsoft.Xmlhttp");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                var retourAjax = xhr.responseText;
                console.log(retourAjax);
            }
        }
        alert("Vous changez le statut de ce client");
        var id_client = $(this).data("id");
        console.log(id_client);
        var val = $(this).val();
        console.log(val);
        var apply = $(this).is(':checked') ? true : false;
        console.log(apply);
        var data = "id_client=" + id_client + "&apply=" + apply;
        xhr.open('post', 'ajax.php', true);
        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded; charset=utf-8');
        xhr.send(data);



        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                id_client: id_client,
                val: val,
                apply: apply
            }

        });

    });

    function init() {
        $('#table_client').DataTable({
            "language": getLangageDataTable("client", true)
        });
    }



    window.onload = init;

</script>
</html>
