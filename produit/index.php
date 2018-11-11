<?php
	require_once('../config.php');
	require '../modales.php';

	// $db = Database::connect();
	//
	// $statement = $db->query('
	//
	// 	SELECT 	client.code_client AS code_cli,
	// 			client.raison_sociale AS rs,
	// 			CONCAT(civilite.libelle," ",contact.nom," ",contact.prenom) AS nom_cli,
	// 			devis.date_devis AS date,
	// 			devis.id_devis AS numDevis,
	// 			SUM(ligne_devis_client.quantite * ligne_devis_client.prixU) AS montant
	// 	FROM contact
	// 	INNER JOIN client ON client.id_client = contact.id_client
	// 	INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite
	// 	INNER JOIN devis ON client.id_client = devis.id_client
	// 	INNER JOIN ligne_devis_client ON devis.id_devis = ligne_devis_client.id_devis
	// 	GROUP BY devis.id_devis,nom_cli
	// 	');
	// Database::disconnect();
?>

<!DOCTYPE html>
<html>
    <head>
         <title> Produit</title>
         <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
				 <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/datatables.css">
         <meta charset="UTF-8">
    </head>

    <body>
        <div class="wrapper">

			<?php include('../nav.php'); ?>

			<section>
				<h1>Progiplus</h1>

				<h1>Liste des Produits</h1>

				<button id="bouton_ajouter" type="button">Ajouter un nouveau produit</button>

				<!--<table id="table_produits" class="display">-->
				<table id="table_produits">
				  <thead>
				    <tr>
							<th>Référence</th>
							<th>Désignation</th>
				      <th>Prix unitaire</th>
							<th>Marque</th>
							<th>Gamme</th>
							<th>Catégorie</th>
				      <th>Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <td>---</td>
				      <td>---</td>
				      <td>---</td>
							<td>---</td>
							<td>---</td>
							<td>---</td>
				      <td><img class="modal_modif" src="../includes/assets/pencil.png" title="Modifier Profil produit" alt="bouton_modifier" height="20">
				          <a href="#"><img src="../includes/assets/cancel.png" title="Supprimer Profil produit" alt="bouton_supprimer" height="20"/></a></td>
				    </tr>
				    <tr>
				      <td>---</td>
				      <td>---</td>
				      <td>---</td>
							<td>---</td>
							<td>---</td>
							<td>---</td>
				      <td><img class="modal_modif" src="../includes/assets/pencil.png" title="Modifier Profil produit" alt="bouton_modifier" height="20">
				          <a href="#"><img src="../includes/assets/cancel.png" title="Supprimer Profil produit" alt="bouton_supprimer" height="20"/></a></td>
				    </tr>
				    <tr>
				      <td>---</td>
				      <td>---</td>
				      <td>---</td>
							<td>---</td>
							<td>---</td>
							<td>---</td>
				      <td><img class="modal_modif" src="../includes/assets/pencil.png" title="Modifier Profil produit" alt="bouton_modifier" height="20">
				          <a href="#"><img src="../includes/assets/cancel.png" title="Supprimer Profil produit" alt="bouton_supprimer" height="20"/></a></td>
				    </tr>
				  </tbody>
				</table>

				<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
				<script type="text/javascript" src="../includes/scripts/datatables.js"></script>

				<script type="text/javascript">

				var modal_modif = document.getElementById("modal_modif_produit");
				var btn_modif = document.getElementsByClassName("modal_modif");
				for(i=0; i<btn_modif.length; i++){
				  btn_modif[i].onclick = function() {
				    modal_modif.style.display = "block";
				  }
				}

				var modal_ajout = document.getElementById("modal_ajouter_produit");
				var btn_ajout = document.getElementById("bouton_ajouter");
				btn_ajout.onclick = function() {
				  modal_ajout.style.display = "block";
				}

				var span_ajout = document.getElementsByClassName("close")[0];
				var span_modif = document.getElementsByClassName("close")[1];

				span_ajout.onclick = function() {
				  modal_ajout.style.display = "none";
				}

				span_modif.onclick = function() {
				  modal_modif.style.display = "none";
				}

				window.onclick = function(event) {
				  if (event.target == modal) {
				    modal_ajout.style.display = "none";
				    modal_modif.style.display = "none";
				  }
				}

				$(document).ready( function () {
				    $('#table_produits').DataTable();
				} );

				</script>

			</section>
		</div>
    </body>
</html>
