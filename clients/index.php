<?php
require_once('../config.php');
require_once('../includes/Models/client.php');
require_once('../includes/Models/moyenComm.php');
//require_once('../includes/Models/client.php');

$db = Database::connect();
//Supprimer un client (obsolete)
/*if (isset($_GET['id']) AND !empty($_GET)){
								$id = $_GET['id'];
								if ($id > 0){
								    $SQLQuery = "DELETE FROM client WHERE id_client = :id";
									try{
									    $SQLStatement = $db->prepare($SQLQuery);
										$SQLStatement->bindValue(':id', $id);

										if ($SQLStatement->execute()){
											print('<script type="text/javascript">document.location.href=\'index.php\';</script>');
                                        }else{
											print("Erreur d'exécution de la requête de suppression !<br />");
											var_dump($SQLStatement->errorInfo());
										}
									}catch (Exception $ex){
										print("Erreur de préparation de la requête de suppression !<br />");
                                        print($ex->getMessage());
									}
								}
							}
*/








$statement = $db->query(' SELECT client.id_client as id_client,
			client.code_client as code,
            client.raison_sociale as raisonsoc,
			CONCAT(civilite.libelle," ",contact.nom," ",contact.prenom)as nom_cli
            FROM contact
            inner JOIN client ON client.id_client = contact.id_client
			inner join civilite ON contact.id_civilite = civilite.id_civilite');
			$script = '';


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
                        <th>client</th>
                        <th>Actions</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					while($client = $statement->fetchObject()){
				$script .= '<tr>';
				$script .= '<td>'.$client->code.'</td>';
				$script .= '<td>'.$client->raisonsoc.'</td>';
				$script .= '<td>'.$client->nom_cli.'</td>';
				$script .= '<td class="action"><a href="formulaire.php?id='.$client->id_client.'"><img src="../includes/assets/pencil.png" class="petit_logo" alt="Modifier" /></a></td>';
				/*$script .= '<td class="action"><a href="liste.php?id='.$client->id_client.'" onclick="return confirm(\'Etes-vous sur ?\');"><img src="includes/images/delete.png" alt="Supprimer" /></a></td>';
				$script .= '<td class="action"><a href="index.php?id='.$client->id_client.'"><img src="../includes/assets/cancel.png "class="petit_logo" alt="actif/innactif" /></a></td>';
				$script .= '</tr>';*/
			}
                        print($script);
			 Database::disconnect();
					?>
                </tbody>
            </table>
            </br><input type="button" name="lienForm" value="Ajouter un Client" onclick="self.location.href='formulaire.php'" style="background-color:#3cb371" style="color:white; font-weight:bold" onclick>

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
