<?php 
	require_once('../config.php');
	require_once('../functions.php');
	require_once('../includes/Models/devis.php');


	$db = Database::connect();
//SQL liste devis : Code client, Civilite Nom prenom ou raison social, date devis, montant 

	$statement = $db->query(' 

		SELECT 	client.code_client AS code_cli,
				client.raison_sociale AS rs,
				CONCAT(civilite.libelle," ",contact.nom," ",contact.prenom) AS nom_cli,
				devis.date_devis AS date,
				devis.id_devis AS numDevis,
				SUM(ligne_devis_client.quantite * ligne_devis_client.prixU) AS montant
		FROM contact
		INNER JOIN client ON client.id_client = contact.id_client
		INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite
		INNER JOIN devis ON client.id_client = devis.id_client
		INNER JOIN ligne_devis_client ON devis.id_devis = ligne_devis_client.id_devis
		GROUP BY devis.id_devis,nom_cli
		');
	Database::disconnect();
	
?>

<!DOCTYPE html>
<html>
    <head>
         <title> Devis</title>
         <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
         <meta charset="UTF-8">    
    </head>
    
    <body>
        <div class="wrapper">
			<?php include('../nav.php'); ?>

			<section>
				<h1>Liste Devis</h1>
				<table id="table_client" class="display">
					<thead>
						<tr>
							<th style="width: 100px">N Devis</th>
							<th style="width: 100px">Code client</th>
							<th style="width: 200px">Raison sociale ou Civilite/Nom/prenom</th>
							<th style="width: 100px">date devis</th>
							<th style="width: 100px">Montant</th>
							<th style="width: 100px" colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody>
			 	<?php 
					while($devis = $statement->fetchObject())
					{

						print '<tr>';
							print '<td>' . $devis->numDevis . '</td>';
							print '<td>' . $devis->code_cli . '</td>';
							identiteClient($devis->rs,$devis->nom_cli);
							print '<td>' . dateFr($devis->date) . '</td>';
							print '<td>' . $devis->montant . '</td>';
							print '<td>
										<a href="#"><img src="../includes/assets/pencil.png" class="imageTableau" title="Modifier Devis" alt="bouton_modifier"/></a>
							   			<a href="#"><img src="../includes/assets/cancel.png" class="imageTableau" title="Supprimer Profil client" alt="bouton_supprimer"/></a>
							   			<a href="#"><img src="#" class="imageTableau" title="Supprimer Profil client" alt="voir"/></a>
							   			<a href="#"><img src="#" class="imageTableau" title="Supprimer Profil client" alt="Facture"/></a>
							</td>';
						print '</tr>';
					}
					Database::disconnect();
					?>
					</tbody>
				</table>
			</section>
		</div>
    </body>    
</html>
