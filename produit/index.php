<?php
	require_once('../config.php');
	require '../modales.php';

	$db = Database::connect();

	$statement = $db->query('
	SELECT reference, designation, prix_unitaire_ht, categorie.libelle as libelleC, marque.nom as nomM, gamme.libelle as libelleG FROM produit
	INNER JOIN categorie ON categorie.id_categorie=produit.id_categorie
	INNER JOIN gamme ON gamme.id_gamme=produit.id_gamme
	INNER JOIN marque ON marque.id_marque=gamme.id_marque
	GROUP BY produit.reference, produit.designation;
	');

	Database::disconnect();
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

				<h1>Liste des Produits</h1>

				<button id="bouton_ajouter" type="button">Ajouter un nouveau produit</button>

				<table id="table_produits" class="display">
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
						<?php
							while($produit = $statement->fetchObject())
							{
								print '<tr>';
									print '<td>' . $produit->reference . '</td>';
									print '<td>' . $produit->designation . '</td>';
									print '<td>' . $produit->prix_unitaire_ht . '</td>';
									print '<td>' . $produit->nomM . '</td>';
									print '<td>' . $produit->libelleG . '</td>';
									print '<td>' . $produit->libelleC . '</td>';
									print '<td><img class="modal_modif" src="../includes/assets/pencil.png" title="Modifier Produit" alt="bouton_modifier" height="20">
						          <a href="#"><img src="../includes/assets/cancel.png" title="Supprimer Produit" alt="bouton_supprimer" height="20"/></a></td>';
								print '</tr>';
							}
							Database::disconnect();
							?>
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
