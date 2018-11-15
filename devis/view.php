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
					client.raison_sociale AS rs,
					CONCAT(civilite.libelle," ",contact.nom," ",contact.prenom) AS nom_cli,
					moyen_comm.valeur, type_moyen_comm.libelle,
					liste_adresse.libelle AS libAdresse, CONCAT(adresse.ligne1," ",adresse.ligne2) AS adresse,
					CONCAT(ville.cp_ville," ",ville.nom_ville)AS ville,devis.id_devis,devis.date_devis
			FROM contact
			INNER JOIN client ON client.id_client = contact.id_client
			INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite
			INNER JOIN contact_comm ON contact_comm.id_contact = contact.id_contact
			INNER JOIN moyen_comm ON moyen_comm.id_mcomm = contact_comm.id_mcomm
			INNER JOIN type_moyen_comm ON type_moyen_comm.id_type_moyen_comm = moyen_comm.id_type_moyen_comm
			INNER JOIN liste_adresse ON client.id_client = liste_adresse.id_client
			INNER JOIN adresse ON liste_adresse.id_adresse = adresse.id_adresse
			INNER JOIN ville ON adresse.id_ville = ville.id_ville
			INNER JOIN devis ON devis.id_client=client.id_client
			WHERE client.id_client = ? AND liste_adresse.libelle = "facturation"
			');
			$statement->execute(array($id));
			Database::disconnect();

			$db = Database::connect();
			$statementDevis = $db->prepare('
			SELECT 	client.id_client, (prixU * quantite) AS totalLigne,
					devis.date_devis,devis.duree_validite,
					devis.id_devis,
					ligne_devis_client.quantite,
					ligne_devis_client.prixU,
					tva.taux,produit.reference,produit.designation
			FROM client
			INNER JOIN devis ON devis.id_client=client.id_client
			INNER JOIN ligne_devis_client ON ligne_devis_client.id_devis = devis.id_devis
			INNER JOIN tva ON tva.id_tva= ligne_devis_client.id_tva
			INNER JOIN produit ON produit.reference = ligne_devis_client.reference
			WHERE client.id_client = ?
			');
			$statementDevis->execute(array($id));
			Database::disconnect();

			while($devis = $statement->fetchObject()){

				$codeClient = $devis->code_cli;
				$nomClient = $devis->nom_cli;
				$adresse = $devis->adresse;
				$ville = $devis->ville;
				$numDevis = $devis->id_devis;
				$dateDevis = dateFr($devis->date_devis);

				if(!empty($devis->libelle)){
					if($devis->libelle == "telephone"){
						 $fixe = $devis->valeur;
					}
					elseif($devis->libelle == "Mobile"){
						 $mobile = $devis->valeur;
					}
					elseif($devis->libelle == "Fax"){
						$fax = $devis->valeur;
					}elseif($devis->libelle == "email"){
						$email = $devis->valeur;
					}
				}else{
					$fixe = $mobile = $fax = $email = " ";
				}
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
			<h1>Devis num </h1>
			<section id="devis">

					<div id="info">
						<div id="infoEnt">
							<?php
								print $infoEnt;
							 ?>
						</div>

						<div id="infoClient">
							Code client : <?php print $codeClient?><br>

							<?php print $nomClient.'<br>'.
										$adresse.'<br>'.
										$ville .'<br>'?>

							Tel : <?php print $fixe ?><br>
							Mobile : <?php print $mobile ?><br>
							Fax : <?php print $fax ?><br>
							Email : <?php print $email ?><br>
						</div>
					</div>
					<div id="infoDevis">
						<div id="numDevis"> Devis Numero : <?php print $numDevis ?></div>
						<div id="dateDevis">
							<?php print 'Fait a '. $villeEnt.' le '. $dateDevis ?>
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
								while($corpsDevis = $statementDevis->fetchObject()){
									print 	'<tr>
												<td class="codeProduit">'.$corpsDevis->reference .'</td>
												<td>'.$corpsDevis->designation .'</td>
												<td class="quantiteProduit" >'.$corpsDevis->quantite.'</td>
												<td>'.$corpsDevis->prixU.'</td>
												<td>'.$corpsDevis->totalLigne.'</td>
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
								<td colspan="2"><button type="submit" class="btn-xl btn-valide">Facturation</button><button class="btn-xl btn-warning">Annulation</button></td>
							</tr>
						</tfoot>
					</table>

			</section>
		</section>
	</div>
</body>
<script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../includes/scripts/datatables.js"></script>

</html>
