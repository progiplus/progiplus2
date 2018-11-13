<?php
	require_once('../config.php');
	require_once('../functions.php');
	if(!empty($_GET)){
		if(isset($_GET)){
			$id=$_GET['id'];
			$db = Database::connect();
			$statement = $db->prepare('
				SELECT 	client.code_client AS code_cli,
						client.id_client,
						civilite.libelle,contact.nom,contact.prenom,
						devis.date_devis AS dateDevis,
						devis.id_devis
				FROM devis
				INNER JOIN client ON client.id_client = devis.id_client
				INNER JOIN contact ON client.id_client = contact.id_client
				INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite
				INNER JOIN ligne_devis_client ON devis.id_devis = ligne_devis_client.id_devis
				Where devis.id_devis = ?
				');
			$statement->execute(array($id));
			Database::disconnect();
			while($devis = $statement->fetchObject()){
				$numDevis = $devis->id_devis;
				$codeClient = $devis->code_cli;
				$civiliteClient = $devis->libelle;
				$nomClient = $devis->nom;
				$prenomClient = $devis->prenom;
				$date = dateFr($devis->dateDevis);
			}
		}
	}
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
			<h1>Devis num <?php print $numDevis ?></h1>
			<section id="devis">
				<form method="post" action="devis.php">
					<div id="info">
						<div id="infoEnt">
							<?php
								print $infoEnt;
							 ?>
						</div>

						<div id="infoClient">
							<label class="labelEnLigne">Code client : </label><input type="text" name="codeClient" id="codeClient" value="<?php print $codeClient?>" /><br>
							<input type="radio" name="rdciv" value="1" />Madame
							<input type="radio" name="rdciv" value="2" />Monsieur <br>
							<label class="labelEnLigne">Nom : </label><input type="text" name="nomClient" id="nomClient" value="<?php print $nomClient?>"/><br>
							<label class="labelEnLigne">Prenom : </label><input type="text" name="prenomClient" id="prenomClient" value="<?php print $prenomClient?>"/><br>
							<label class="labelEnLigne">rue : </label><input type="text" name="rue" id="rue" /><br>
							<label class="labelEnLigne">ville : </label><input type="text" name="ville" id="ville" /><br>
							<label class="labelEnLigne">tel : </label><input type="text" name="tel" id="tel" /><br>
						</div>
					</div>
					<div id="infoDevis">
						<div id="numDevis"> Devis Numero : <?php print $numDevis ?></div>
						<div id="dateDevis">
							<?php print 'Fait a '. $villeEnt.' le '. $date ?>
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

</html>
