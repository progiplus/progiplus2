<?php
	require_once('../config.php');

	$db = Database::connect();

	$statement = $db->query('
	SELECT reference, designation, prix_unitaire_ht, produit.actif, marque.id_marque, gamme.id_gamme, categorie.id_categorie, categorie.libelle as libelleC, marque.nom as nomM, gamme.libelle as libelleG FROM produit
	INNER JOIN categorie ON categorie.id_categorie=produit.id_categorie
	INNER JOIN gamme ON gamme.id_gamme=produit.id_gamme
	INNER JOIN marque ON marque.id_marque=gamme.id_marque
	ORDER BY produit.reference
	');

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Produit</title>
    	<link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
			<link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/datatables.css">
      <meta charset="UTF-8">
  </head>

	<body>
  	<div class="wrapper">

			<?php
			include('../nav.php');
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
						<th>Statut</th>
				    <th>Actions</th>
				  </tr>
				</thead>
				<tbody>
					<?php

						while($produit = $statement->fetchObject()){
							print '<tr>';
								print '<td>' . $produit->reference . '</td>';
								print '<td>' . $produit->designation . '</td>';
								print '<td>' . $produit->prix_unitaire_ht . '</td>';
								print '<td>' . $produit->nomM . '</td>';
								print '<td>' . $produit->libelleG . '</td>';
								print '<td>' . $produit->libelleC . '</td>';
								print '<td><input type="checkbox" title="Activer ou Désactiver un Produit" data-id="'.$produit->reference.'" id="checkbox" value="actif"';
									if($produit->actif==1){
									print ("checked='checked'");
									}print '/></td>';
								print '<td><img class="boutonAppel" data-id="'.$produit->reference.'" data-designation="'.$produit->designation.'" data-prix_unitaire_ht="'.$produit->prix_unitaire_ht.'" data-id_marque="'.$produit->id_marque.'" data-id_gamme="'.$produit->id_gamme.'" data-id_categorie="'.$produit->id_categorie.'" data-actif="'.$produit->actif.'" src="../includes/assets/pencil.png" title="Modifier un Produit" alt="bouton_modifier" height="20"></td>';
							print '</tr>';
						}
							Database::disconnect();
							$statement->closeCursor();
					?>

				</tbody>
			</table>

				<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
				<script type="text/javascript" src="../includes/scripts/datatables.js"></script>
				<script type="text/javascript" src="../includes/scripts/general.js"></script>

				<script type="text/javascript">

				$(document).ready(function(){
					$('#table_produits').DataTable({
						"language": getLangageDataTable("produit", false)
					});
				});

				var modaleGen = document.getElementById("modaleProduit");

				function displayModal(){
					modaleGen.style.display = "block";
				}

				function hideModal(){
					modaleGen.style.display = "none";
				}

				var closeModal = document.getElementsByClassName("close")[0];
				var cancelModal = document.getElementById("btnAnnuler");

				closeModal.onclick = hideModal;
				cancelModal.onclick = hideModal;

				$(".boutonAppel").on('click', function(){
					$(".titreModale").text('Modifier la fiche Produit');
					$("#referenceProduit").prop("readonly", true);
					$('#btnAjouterProduit').hide();
					$('#btnModifierProduit').show();
					$("#referenceProduit").val($(this).data("id"));
					$("#designationProduit").val($(this).data("designation"));
					$("#prixht_produit").val($(this).data("prix_unitaire_ht"));
					$("#catégorieProduit").val($(this).data("id_categorie"));
					$("#gammeProduit").val($(this).data("id_gamme"));
					$("#marqueProduit").val($(this).data("id_marque"));
					$("#produitActif").prop("checked", $(this).data("actif") > 0);
					displayModal();
				});

				$("#bouton_ajouter").on('click', function(){
					$(".titreModale").text('Ajouter un Produit');
					$("#referenceProduit").prop("readonly", false);
					$('#btnAjouterProduit').show();
					$('#btnModifierProduit').hide();
					$("#referenceProduit").val("");
					$("#designationProduit").val("");
					$("#prixht_produit").val("");
					$("#catégorieProduit").val(0);
					$("#gammeProduit").val(0);
					$("#marqueProduit").val(0);
					$("#produitActif").prop("checked", true);
					displayModal();
				});

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
		        alert("Vous allez modifier le statut de ce produit.");
		        var reference = $(this).data("id");
		        console.log(reference);
		        var val = $(this).val();
		        console.log(val);
		        var apply = $(this).is(':checked') ? true : false;
		        console.log(apply);
		        var data = "reference=" + reference + "&apply=" + apply;
		        xhr.open('post', 'ajaxProduit.php', true);
		        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded; charset=utf-8');
		        xhr.send(data);

		        $.ajax({
		            type: "POST",
		            url: "ajaxProduit.php",
		            data: {
		                reference: reference,
		                val: val,
		                apply: apply
		            }
		        });
		    });

				</script>

			</section>
		</div>
    </body>
</html>
