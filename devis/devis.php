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
							<th style="width:300px">Designation</th>
							<th class="quantiteProduit">quantite</th>
							<th style="width:70px">prixU</th>
							<th style="width:100px">Total</th>
						</thead>
						<tbody>
							<?php
								for($i=0; $i<10; $i++){
									print 	'<tr>
												<td><input class="codeProduit" type="text" name="codeProduit" id="codeProduit"/></td>
												<td></td>
												<td><input class="quantiteProduit" type="number"/></td>
												<td></td>
												<td></td>
											</tr>';
								}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"></td>
								<td>Total HT</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3"></td>
								<td>TVA</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3"></td>
								<td>Total TTC</td>
								<td></td>
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

<script type="text/javascript" >
	$(document).ready(function (){
		var client = false;
		var clientEnCours = 0;

		function getXhrReq(){
			var xhr;
			if(window.XMLHttpRequest){
				xhr = new  XMLHttpRequest();
			}else{
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			return xhr;
		}

		$('#codeClient').change(function(){
			xhr = getXhrReq();
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
					var obj = JSON.parse(xhr.responseText);
					console.log(obj);
					var codeClient = $('#codeClient').val();

					if(clientEnCours != codeClient){
						var adresse ="";
						if(obj.ligne2){
							adresse = obj.ligne1 + '<br>' + obj.ligne2;
						}else{
							adresse = obj.ligne1;
						}

						if(!client){
							clientEnCours = codeClient;

							if(obj.rs){
								$('.clientinfo').append('<p>'  + obj.rs + '<br>' + adresse +'<br>'+ obj.ville + '<br> Tel : ' + obj.valeur + '</p>');

							}
							else{
								$('.clientinfo').append('<p>'  + obj.nom_cli + '<br>' + adresse +'<br>'+ obj.ville + '<br> Tel : ' + obj.valeur + '</p>');
							}
							return client=true;
						}
						else{
							$('.clientinfo').empty();
							clientEnCours = codeClient;
								if(obj.rs){
									$('.clientinfo').append('<p>'  + obj.rs + '<br>' + adresse +'<br>'+ obj.ville + '<br> Tel : ' + obj.valeur + '</p>');
								}
								else{
									$('.clientinfo').append('<p>'  + obj.nom_cli + '<br>' + adresse +'<br>'+ obj.ville + '<br> Tel : ' + obj.valeur + '</p>');

								}
							return client=true;
						}
					}
				}
			}

			var data = "code=" + $(this).val();
			xhr.open('POST', '../includes/scripts/json/devisClient.php', true);
			xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
			xhr.send(data);
		});
	});
</script>

</html>
