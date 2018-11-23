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
            client.actif,
            client.id_client,
            client.id_adresse_facturation,
			civilite.libelle as civilite,
            civilite.id_civilite as idcivilite,
            contact.id_contact,
            contact.nom as nom_cli,
            contact.prenom as prenom_cli,
            contact.service as service,
            adresse.ligne1 as ligne1,
            adresse.ligne2 as ligne2,
            liste_adresse.libelle as libelle_adresse,
            ville.id_ville,
            ville.cp_ville as code_postal,
            ville.nom_ville as nom_ville
            FROM contact
            inner JOIN client ON client.id_client = contact.id_client
            inner join liste_adresse on liste_adresse.id_client = client.id_client
            inner join adresse on adresse.id_adresse = liste_adresse.id_adresse
            inner join ville on adresse.id_ville = ville.id_ville
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
                        <th></th><th></th>
                        <th>Actif?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $script ='';
					while($client = $statement->fetchObject()){
                       // $script .= '<tr data-id="'.$client->id_client.'">';
                            print '<td>'.$client->code.'</td>';
                            print '<td>'.identiteClient($client->raisonsoc,$client->civilite." ".$client->prenom_cli." ".$client->nom_cli).'</td>';
                            print '<td><img class="boutonAppel" <img class="boutonAppel" data-code="'.$client->code.'" data-raison_sociale="'.$client->raisonsoc.'" data-clientActif="'.$client->actif.'" data-nom_client="'.$client->nom_cli.'"data-prenom_client="'.$client->prenom_cli.'" data-civilite="'.$client->idcivilite.'" data-ligne1="'.$client->ligne1.'"data-service="'.$client->service.'" data-ligne1="'.$client->ligne1.'"
     data-ligne2="'.$client->ligne2.'" data-libelle_adresse="'.$client->libelle_adresse.'" data-code_postal="'.$client->code_postal.'"data-id_contact="'.$client->id_contact.'"data-id_ville="'.$client->id_ville.'"data-id_adresse_facturation="'.$client->id_adresse_facturation.'"data-id_client="'.$client->id_client.'"
     data-nom_ville="'.$client->nom_ville.'" src="../includes/assets/pencil.png" title="Modifier un Client" alt="bouton_modifier" height="20"></td>


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
                var cancelModal = document.getElementById("btnAnnulerClient");

              closeModal.onclick = function() {
				  modaleGen.style.display = "none";
				}

				cancelModal.onclick = function() {
				  modaleGen.style.display = "none";
				}


                $("#table_client input:checkbox").on("change", function()
                {
                    let confirm = confirm("êtes vous sur");

                        alert( checkbox );
                    if (prompt = true){
                    alert("Vous changez le statut de ce client");
                    var id_client = $(this).data("id");
                    console.log(id_client);
                    var val = $(this).val();
                    console.log(val);
                    var apply = $(this).is(':checked') ? true : false;
                    console.log(apply);
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            id_client: id_client,
                            val: val,
                            apply: apply ,
                            action: "changerActif"
                        }

                    });
                    }else{
                        
                    }

                });


                $(".boutonAppel").on('click', function() {
                    $("#btnAjouterClient").hide();
                    $("#btnModifierClient").show();
                    $(".titreModale").text('Modifier la fiche client');
                    $("#id_client").val($(this).data("id_client"));
                    $("#code_client").val($(this).data("code"));
                    $("#code_client").prop("disabled", true);
                    $("#raison_sociale").val($(this).data("raison_sociale"));
                    $("#service").val($(this).data("service"));
                    $('input[name=gender][value='+ $(this).data("civilite") +']').prop('checked', 'checked');
                    $("#id_contact").val($(this).data("id_contact"));
                    $("#nom").val($(this).data("nom_client"));
                    $("#prenom").val($(this).data("prenom_client"));
                    $("#id_adresse_facturation").val($(this).data("id_adresse_facturation"));
                    $("#nomAdresse").val($(this).data("libelle_adresse"));
                    $("#ligne1").val($(this).data("ligne1"));
                    $("#ligne2").val($(this).data("ligne2"));
                    $("#cPostale").val($(this).data("code_postal"));
                    $("#ville").val($(this).data("nom_ville"));
                    $("#id_ville").val($(this).data("id_ville"));
                    $('#clientActif').prop('checked', $(this).data("clientActif") == 1);
                    displayModal();
                });
                $("#bouton_ajouter").on('click', function() {
                    $("#btnAjouterClient").show();
                    $("#btnModifierClient").hide();
                    $(".titreModale").text('Ajouter un Client');
                    $("#code_client").val("");
                    $("#code_client").prop("disabled", false);
                    $("#raison_sociale").val("");
                    $("#civilite").val("");
                    $("#nom").val("");
                    $("#prenom").val("");
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
