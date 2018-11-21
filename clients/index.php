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
        <?php include('../nav.php');
        require_once('modale_client.php');
        ?>

        <section>
            <h1>Progiplus</h1>
            <button id="bouton_ajouter" type="button">Ajouter un nouveau client</button>
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
                            print '<td><img class="boutonAppel" <img class="boutonAppel" data-code="'.$client->code.'" data-raison_sociale="'.$client->raisonsoc.'" data-nom_client="'.$client->nom_cli.'"  src="../includes/assets/pencil.png" title="Modifier un Client" alt="bouton_modifier" height="20"></td>


                            <td class="action"><a href="detail.php?id='.$client->id_client.'">

                            <img src="../includes/assets/zoom.png" class="petit_logo" alt="details" /></a></td>';
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
            <!--            <br><input type="button" name="lienForm" value="Ajouter un Client" onclick="self.location.href='formulaire.php'" style="background-color:#3cb371" style="color:white; font-weight:bold" onclick>-->



            <script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" src="../includes/scripts/datatables.js"></script>
            <script type="text/javascript" src="../includes/scripts/general.js"></script>
            <script type="text/javascript">
                var modaleGen = document.getElementById("modaleClient");

                function init() {
                    $('#table_client').DataTable({
                        "language": getLangageDataTable("client", false)
                    });
                }

                function displayModal() {
                    modaleGen.style.display = "block";
                }





                function closeModal() {
                    modaleGen.style.display = "none";
                }

                var closeModal = document.getElementsByClassName("close")[0];
                var cancelModal = document.getElementById("btnAnnuler");

                closeModal.onclick = closeModal;
                cancelModal.onclick = closeModal;


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
                    //var data = "id_client=" + id_client + "&apply=" + apply;
                    //xhr.open('post', 'ajax.php', true);
                    //xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded; charset=utf-8');
                    //xhr.send(data);



                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            id_client: id_client,
                            val: val,
                            apply: apply //,
                            //action: "changerActif"
                        }

                    });

                });


                $(".boutonAppel").on('click', function() {
                    $(".titreModale").text('Modifier la fiche client');
                    $(".")
                    $("#code").val($(this).data("code_client"));
                    $("#raison_sociale").val($(this).data("raison_sociale"));
                    $("#civilite").val($(this).data("civilite"));
                    $("#nom").val($(this).data("nom_contact"));
                    $("#prenom").val($(this).data("prenom_contact"));
                    $("#marqueProduit").val($(this).data("id_marque"));
                    $("#produitActif").prop("checked", $(this).data("actif") > 0);
                    displayModal();
                });
                $("#bouton_ajouter").on('click', function() {
                    $(".titreModale").text('Ajouter un Client');
                    $("#code").val("");
                    $("#raison_sociale").val("lol");
                    $("#civilite").val("");
                    $("#nom").val(0);
                    $("#prenom").val(0);
                     $("#service").val(0);
                     $("#id_adresse_facturation").val(0);
                     $("#id_adresse_comp").val(0);
                     $("#nomAdresse").val(0);
                    $("#postale").val(0);
                    $("#ville").val(0);
                    displayModal();
                });






                window.onload = init;

            </script>
        </section>
    </div>
</body>

</html>
