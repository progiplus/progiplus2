<?php
	require_once('../config.php');
	require_once('../functions.php');


?>

<!DOCTYPE html>
<html>
    <head>
         <title> Devis</title>
         <link rel="stylesheet" type="text/css" href="../includes/styles/datatables.css">
         <link rel="stylesheet" type="text/css" href="../includes/styles/style.css">
         <link rel="stylesheet" type="text/css" href="styles.css">
         <link rel="icon" href="../includes/assets/favicon.ico" />
         <script type="text/javascript"  src="../includes/scripts/general.js"></script>
         <meta charset="UTF-8">
    </head>

    <body>
        <div class="wrapper">
			<?php include('../nav.php'); ?>

			<section>
				<h1>Nouveau devis Devis</h1>

				<section id="devis">
					<form>
						<div id="info">
							<div id="infoEnt">
							<?php
								print $infoEnt;
							 ?>
							</div>
							<div id="infoClient">
								<input type="radio" name="rdciv" value="1" />Madame
								<input type="radio" name="rdciv" value="2" />Monsieur <br>
								<label class="labelEnLigne">Nom : </label><input type="text" name="nomClient" id="nomClient"/><br>
								<label class="labelEnLigne">Prenom : </label><input type="text" name="prenomClient" id="prenomClient"/><br>
								<label class="labelEnLigne">rue : </label><input type="text" name="rue" id="rue"/><br>
								<label class="labelEnLigne">ville : </label><input type="text" name="ville" id="ville"/><br>
								<label class="labelEnLigne">tel : </label><input type="text" name="tel" id="tel"/><br>
							</div>
						</div>
						<div id="infoDevis">
							<div id="numDevis"> Devis Numero : </div>
							<div id="dateDevis"><?php print "Fait a  $villeEnt le Date"?></div>
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
									<td colspan="2"><button class="btn-valide">Valider</button><button class="btn-warning">Annuler</button></td>

								</tr>
							</tfoot>
						</table>
					</form>
				</section>

			</section>
		</div>
    </body>
    <script type="text/javascript"  src="../includes/scripts/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"  src="../includes/scripts/datatables.js"></script>
</html>
