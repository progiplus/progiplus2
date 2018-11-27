<?php
	require_once('../config.php');
  require_once('modaleProduit.php');

	$db = Database::connect();

	$statement = $db->query('
	SELECT reference, designation, prix_unitaire_ht, produit.actif, marque.id_marque, gamme.id_gamme, categorie.id_categorie, categorie.libelle as libelleC, marque.nom as nomM, gamme.libelle as libelleG, tva.id_tva, tva.taux as taux FROM produit
	INNER JOIN categorie ON categorie.id_categorie=produit.id_categorie
	INNER JOIN gamme ON gamme.id_gamme=produit.id_gamme
	INNER JOIN marque ON marque.id_marque=gamme.id_marque
	INNER JOIN tva on tva.id_tva=produit.id_tva
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

			<?php include('../nav.php'); ?>

		<section>

			<h1>Liste des Produits</h1>

			<div class="boutonsP">
				<div class="boutonNouveauP">
				<button id="boutonNouveauP" type="button">Produit</button>
			</div>
			<div class="boutonNouveauMGC">
				<button id="boutonNouvelleM" type="button">Marque</button>
				<button id="boutonNouvelleG" type="button">Gamme</button> <!--associer une marque-->
				<button id="boutonNouvelleC" type="button">Catégorie</button>
			</div>
			</div>

			<table id="table_produits" class="display">
				<thead>
					<tr>
						<th>Référence</th>
						<th>Désignation</th>
				    <th>Prix unitaire</th>
						<th>Marque</th>
						<th>Gamme</th>
						<th>Catégorie</th>
						<th></th>
				    <th></th>
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
								print '<td><img class="boutonAppel" data-id="'.$produit->reference.'" data-designation="'.$produit->designation.'" data-prix_unitaire_ht="'.$produit->prix_unitaire_ht.'" data-id_tva="'.$produit->id_tva.'" data-id_marque="'.$produit->id_marque.'" data-id_gamme="'.$produit->id_gamme.'" data-id_categorie="'.$produit->id_categorie.'" data-actif="'.$produit->actif.'" src="../includes/assets/pencil.png" title="Modifier un Produit" alt="bouton_modifier" height="20"></td>';
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
					//modaleGen.style.display = "block";
				}

				var closeModal = document.getElementsByClassName("close")[0];
				var cancelModal = document.getElementById("btnAnnuler");

				closeModal.onclick = function() {
				  modaleGen.style.display = "none";
				}

				cancelModal.onclick = function() {
				  modaleGen.style.display = "none";
				}

				function verifEnvoi(data){
					if (data=="true"){
						document.location.href='index.php';
					}else{
						alert("L'envoi a échoué.");
					}
				}
//bouton pour moi//
				$(".boutonAppel").on('click', function(){
					$(".titreModale").text('Modifier la fiche Produit');
					$("#referenceProduit").prop("readonly", true);
					$("#referenceProduit").val($(this).data("id"));
					$("#designationProduit").val($(this).data("designation"));
					$("#prixht_produit").val($(this).data("prix_unitaire_ht"));
					$("#tva").val($(this).data("id_tva"));
					$("#catégorieProduit").val($(this).data("id_categorie"));
					$("#gammeProduit").val($(this).data("id_gamme"));
					$("#marqueProduit").val($(this).data("id_marque"));
					$("#produitActif").prop("checked", $(this).data("actif") > 0);
					$('#btnAjouterProduit').hide();
					$('#btnModifierProduit').show();
					displayModal();
				});

				$("#btnModifierProduit").on('click', function(){
					$.ajax({
					 type: "POST",
					 url: "ajaxProduit.php",
					 data:{
						referenceProduit: $("#referenceProduit").val(),
			    	designationProduit: $("#designationProduit").val(),
			    	prixht_produit: $("#prixht_produit").val(),
						tva: $('#tva').val(),
			    	gammeProduit: $("#gammeProduit").val(),
			    	catégorieProduit: $("#catégorieProduit").val(),
						action: "modifierProduit"
					},
					success: verifEnvoi
	    	})
			});

			$("#btnAjouterProduit").on('click', function(){
				$.ajax({
						type: "POST",
						url: "ajaxProduit.php",
						data:{
							referenceProduit: $("#referenceProduit").val(),
							designationProduit: $("#designationProduit").val(),
							prixht_produit: $("#prixht_produit").val(),
							tva: $('#tva').val(),
							gammeProduit: $("#gammeProduit").val(),
							catégorieProduit: $("#catégorieProduit").val(),
							action: "ajouterProduit"
						},
						success: verifEnvoi
				})
			});

			$("#boutonNouveauP").on('click', function(){
				$(".titreModale").text('Ajouter un Produit');
				$("#referenceProduit").prop("readonly", false);
				$("#referenceProduit").val("");
				$("#designationProduit").val("");
				$("#prixht_produit").val("");
				$("#tva").val(0);
				$("#catégorieProduit").val(0);
				$("#gammeProduit").val(0);
				$("#marqueProduit").val(0);
				$("#produitActif").prop("checked", true);
				$('#btnAjouterProduit').show();
				$('#btnModifierProduit').hide();
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
	        var data = "action=changerActif&reference=" + reference + "&apply=" + apply;
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
