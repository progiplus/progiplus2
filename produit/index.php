<?php
	require_once('../config.php');

	$db = Database::connect();

	$statement = $db->query('
	SELECT reference, designation, prix_unitaire_ht, produit.actif, categorie.libelle as libelleC, marque.nom as nomM, gamme.libelle as libelleG FROM produit
	INNER JOIN categorie ON categorie.id_categorie=produit.id_categorie
	INNER JOIN gamme ON gamme.id_gamme=produit.id_gamme
	INNER JOIN marque ON marque.id_marque=gamme.id_marque
	ORDER BY produit.reference
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

			<?php include('../nav.php');
require_once('../modales.php');
			?>

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
									print '<td><img class="boutonAppel" src="../includes/assets/pencil.png" title="Modifier un Produit" alt="bouton_modifier" height="20">
						          	 <input type="checkbox" title="Activer ou Désactiver un Produit" name= "actOrDeact" onclick="return confirm(\'Etes-vous sûr ?\');"/></td>';
								print '</tr>';
							}
							Database::disconnect();



							?>

				  </tbody>
				</table>

				<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
				<script type="text/javascript" src="../includes/scripts/datatables.js"></script>

				<script type="text/javascript">

				var modaleGen = document.getElementById("modaleProduit");

				function displayModal(){
					modaleGen.style.display = "block";
				}

				var span_ajout = document.getElementsByClassName("close")[0];

				span_ajout.onclick = function() {
				  modaleGen.style.display = "none";
				}

				window.onclick = function(event) {
				  if (event.target == modaleGen) {
				    modaleGen.style.display = "none";
				  }
				}

				$(".boutonAppel").on('click', function(){
					$(".titreModale").text('Modifier la fiche Produit');
					displayModal();
				});

				$("#bouton_ajouter").on('click', function(){
					$(".titreModale").text('Ajouter un Produit');
					displayModal();
				});

				$(document).ready( function () {
					$('#table_produits').DataTable();
				});

				</script>

			</section>
		</div>
    </body>
</html>
