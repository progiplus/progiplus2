<?php
	require_once('../config.php');
	require_once('../functions.php');


	$db = Database::connect();
		$statement = $db->query('
		SELECT 	id_client,code_client
		FROM client
		');
	$statement->execute();
	Database::disconnect();

?>

<!DOCTYPE html>
<html>

<head>
	<title> Devis</title>
	<link rel="stylesheet" type="text/css" href="../includes/styles/datatables.css">
	<link rel="stylesheet" type="text/css" href="../includes/styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="icon" href="../includes/assets/favicon.ico" />
	<script type="text/javascript" src="../includes/scripts/general.js"></script>
	<meta charset="UTF-8">
</head>

<body>
	<div class="wrapper">
		<?php include('../nav.php'); ?>

		<section>
			<h1>Nouveau devis Devis</h1>

			<section id="devis">
				<form method="post" action="devis.php">
					<div id="info">
						<div id="infoEnt">
							<?php
								print $infoEnt;
							 ?>
						</div>
						<div id="infoClient">
							<label>Code client : </label>
							<select type="text" name="codeClient" id="codeClient">
								<option value="0">---</option>
								<?php
								while($clients = $statement->fetchObject()){
									print ('<option class="data" value="'.$clients->code_client.'">'.$clients->code_client.'</option>');
								}
							?>
							</select>
							<div class="clientinfo"></div>

						</div>
					</div>
					<div id="infoDevis">
						<div id="numDevis"> Devis Numero : </div>
						<div id="dateDevis">
							<?php print 'Fait a '. $villeEnt.' le '. $dateActuel?>
						</div>
					</div>
					<table id="corpsDevis">
						<thead>
							<th class="codeProduit">Code</th>
							<th class="designation"> Designation</th>
							<th class="quantiteProduit">quantite</th>
							<th style="width:70px">prixU</th>
							<th>Total</th>
						</thead>
						<tbody>
						 	<tr>
								<td><input class="codeProduit" type="text" name="codeProduit" /></td>
								<td><input class="designation" type="text" readonly/> </td>
								<td><input class="quantiteProduit" type="number"/></td>
								<td><input class="prix" type="text" readonly/></td>
								<td><input class="totalHTLigne" type="text" readonly/></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"></td>
								<td>Total HT</td>
								<td ><input class="totalHT" type="text" readonly/></td>
							</tr>
							<tr>
								<td colspan="3"></td>
								<td>TVA</td>
								<td><input class="totalTva" type="text" readonly/></td>
							</tr>
							<tr>
								<td colspan="3"></td>
								<td>Total TTC</td>
								<td><input class="totalTTC" type="text" readonly/></td>
							</tr>
							<tr>
								<td colspan="3"></td>
								<td colspan="2"><button type="submit" class="btn-valide">Valider</button><button class="btn-warning">Annuler</button></td>
							</tr>
						</tfoot>
					</table>
				</form>
			</section>
		</section>
	</div>
</body>
<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../includes/scripts/datatables.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var client = false;
		var clientEnCours = 0;
		var idLigne = 0;
		var qt=0;
		var px=0;
		var tva=0;
		var tvaLigne=0;
		var totalHTLigne = 0;
		var totalHT = 0;
		var totalTva =0;
		var totalTTC = 0;

		function getXhrReq() {
			var xhr;
			if (window.XMLHttpRequest) {
				xhr = new XMLHttpRequest();
			} else {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			return xhr;
		}
		function updateContent(idLigne, chRefProduit){
			xhr = getXhrReq();
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					var obj = JSON.parse(xhr.responseText);
					console.log(obj);
					$('#corpsDevis>tbody>tr:eq(' + idLigne + ') .designation').val(obj.designation);
					$('#corpsDevis>tbody>tr:eq(' + idLigne + ') .prix').val(obj.prix_unitaire_ht);
					$('#corpsDevis>tbody>tr:eq(' + idLigne + ') .quantiteProduit').focus();
					tva = obj.taux;
				}
			}
			var data = "ref=" + chRefProduit;
			xhr.open('POST', '../includes/scripts/json/produitClient.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
			xhr.send(data);
		}

		function addNewLine(){
			$('#corpsDevis>tbody').append('<tr><td><input class="codeProduit" type="text" name="codeProduit" class="codeProduit" autofocus/></td><td><input class="designation" type="text" readonly/> </td><td><input class="quantiteProduit" type="number"/></td><td><input class="prix" type="text" readonly/></td><td><input class="totalHTLigne" type="text" value="0" readonly/></td></tr>');

			$('input.codeProduit:last').change(function (){
				idLigne = $(this).parent().parent().index();
				valCodePdt = $(this).val();
				updateContent(idLigne, valCodePdt);
			});

			$('input.quantiteProduit:last').change(function (){
				idLigne = $(this).parent().parent().index();
				if (idLigne == $('#corpsDevis>tbody>tr:last').index()){


					// calcul HT par ligne
					qt = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .quantiteProduit').val();
					px = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .prix').val();
					totalHTLigne = qt*px;
					$('#corpsDevis>tbody>tr:eq(' + idLigne + ') .totalHTLigne').val(totalHTLigne);

					//calul HT total
					totalHT=0;
					$(".totalHTLigne").each(function( index) {
						totalHTLigne = parseFloat($( this ).val());
						totalHT += totalHTLigne;
						$('#corpsDevis>tfoot>tr .totalHT').val(totalHT);
					});

					//Calcul de la tva total
					totalTva=0;
					$(".totalHTLigne").each(function( index) {
						tvaLigne = parseFloat($( this ).val()) * tva/100;
						totalTva += tvaLigne;
						$('#corpsDevis>tfoot>tr .totalTva').val(totalTva);
					});
					//calcul total TTC => totalHT + totalTva
					totalTTC = totalHT + totalTva;
					$('#corpsDevis>tfoot>tr .totalTTC').val(totalTTC);
					addNewLine();

				}else{
					// calcul HT par ligne
					qt = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .quantiteProduit').val();
					px = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .prix').val();
					totalHTLigne = qt*px;
					$('#corpsDevis>tbody>tr:eq(' + idLigne + ') .totalHTLigne').val(totalHTLigne);

					//calul HT total
					totalHT=0;
					$(".totalHTLigne").each(function( index) {
						totalHTLigne = parseFloat($( this ).val());
						totalHT += totalHTLigne;
						$('#corpsDevis>tfoot>tr .totalHT').val(totalHT);
					});

					//Calcul de la tva total
					totalTva=0;
					$(".totalHTLigne").each(function( index) {
						tvaLigne = parseFloat($( this ).val()) * tva/100;
						totalTva += tvaLigne;
						$('#corpsDevis>tfoot>tr .totalTva').val(totalTva);
					});

					//calcul total TTC => totalHT + totalTva
					totalTTC = totalHT + totalTva;
					$('#corpsDevis>tfoot>tr .totalTTC').val(totalTTC);
				}
			});
			$('input.codeProduit:last').focus();
		}

		$('#codeClient').change(function() {
			xhr = getXhrReq();
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					var obj = JSON.parse(xhr.responseText);
					console.log(obj);

					var codeClient = $('#codeClient').val();

					if (clientEnCours != codeClient) {
						var adresse = "";
						if (obj.ligne2) {
							adresse = obj.ligne1 + '<br>' + obj.ligne2;
						} else {
							adresse = obj.ligne1;
						}

						if (!client) {
							clientEnCours = codeClient;

							if (obj.rs) {
								$('.clientinfo').append('<p>' + obj.rs + '<br>' + adresse + '<br>' + obj.ville + '<br> Tel : ' + obj.valeur + '</p>');

							} else {
								$('.clientinfo').append('<p>' + obj.nom_cli + '<br>' + adresse + '<br>' + obj.ville + '<br> Tel : ' + obj.valeur + '</p>');
							}
							return client = true;
						} else {
							$('.clientinfo').empty();
							clientEnCours = codeClient;
							if (obj.rs) {
								$('.clientinfo').append('<p>' + obj.rs + '<br>' + adresse + '<br>' + obj.ville + '<br> Tel : ' + obj.valeur + '</p>');
							} else {
								$('.clientinfo').append('<p>' + obj.nom_cli + '<br>' + adresse + '<br>' + obj.ville + '<br> Tel : ' + obj.valeur + '</p>');

							}
							return client = true;
						}
					}
				}
			}

			var data = "code=" + $(this).val();
			xhr.open('POST', '../includes/scripts/json/devisClient.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
			xhr.send(data);
		});

		$('.codeProduit').change(function() {
			idLigne = $(this).parent().parent().index();
			valCodePdt = $(this).val();
			updateContent(idLigne, valCodePdt);
		});

		$('.quantiteProduit').change(function(){
			idLigne = $(this).parent().parent().index();
			if (idLigne == $('#corpsDevis>tbody>tr:last').index()){

				// calcul HT par ligne
				qt = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .quantiteProduit').val();
				px = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .prix').val();
				totalHTLigne = qt*px;
				$('#corpsDevis>tbody>tr:eq(' + idLigne + ') .totalHTLigne').val(totalHTLigne);

				//calul HT total
				totalHT=0;
				$(".totalHTLigne").each(function(index) {
					totalHTLigne = parseFloat($(this).val());
					totalHT += totalHTLigne;
					$('#corpsDevis>tfoot>tr .totalHT').val(totalHT);
				});

				//Calcul de la tva total
				totalTva=0;
				$(".totalHTLigne").each(function( index) {
					tvaLigne = parseFloat($( this ).val()) * tva/100;
					totalTva += tvaLigne;
					$('#corpsDevis>tfoot>tr .totalTva').val(totalTva);
				});

				//calcul total TTC => totalHT + totalTva
				totalTTC = totalHT + totalTva;
				$('#corpsDevis>tfoot>tr .totalTTC').val(totalTTC);

				addNewLine();
			}else{
				// calcul HT par ligne
				qt = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .quantiteProduit').val();
				px = $('#corpsDevis>tbody>tr:eq(' + idLigne + ') .prix').val();
				totalHTLigne = qt*px;
				$('#corpsDevis>tbody>tr:eq(' + idLigne + ') .totalHTLigne').val(totalHTLigne);

				//calul HT total
				totalHT=0;
				$(".totalHTLigne").each(function( index) {
					totalHTLigne = parseFloat($( this ).val());
					totalHT += totalHTLigne;
					$('#corpsDevis>tfoot>tr .totalHT').val(totalHT);
				});
				//Calcul de la tva total
				totalTva=0;
				$(".totalHTLigne").each(function( index) {
					tvaLigne = parseFloat($( this ).val()) * tva/100;
					totalTva += tvaLigne;
					$('#corpsDevis>tfoot>tr .totalTva').val(totalTva);
				});

				//calcul total TTC => totalHT + totalTva
				totalTTC = totalHT + totalTva;
				$('#corpsDevis>tfoot>tr .totalTTC').val(totalTTC);
			}
		});
	});
</script>

</html>
