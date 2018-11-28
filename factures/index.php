<?php
require_once('../config.php');
require_once('../functions.php');


$db = Database::connect();
$statement = $db->query('
		SELECT 	client.code_client AS code_cli,
				client.id_client,
				client.raison_sociale AS rs,
				CONCAT(civilite.libelle," ",contact.nom," ",contact.prenom) AS nom_cli,
				facture.date_facture AS date,
				facture.id_facture AS numDevis,
				SUM(ligne_facture_client.quantite * ligne_facture_client.prixU) AS montant
		FROM contact
		INNER JOIN client ON client.id_client = contact.id_client
		INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite
		INNER JOIN facture ON client.id_client = facture.id_client
		INNER JOIN ligne_facture_client ON facture.id_facture = ligne_facture_client.id_facture
		GROUP BY facture.id_facture,nom_cli;
		');
Database::disconnect();

?>

<!DOCTYPE html>
<html>
<head>
    <title> Devis</title>
    <link rel="stylesheet" type="text/css" href="../includes/styles/datatables.css">
    <link rel="stylesheet" type="text/css" href="../includes/styles/style.css">
    <link rel="icon" href="../includes/assets/favicon.ico" />
    <script type="text/javascript"  src="../includes/scripts/general.js"></script>
    <meta charset="UTF-8">
</head>

<body>
<div class="wrapper">
	<?php include('../nav.php'); ?>

    <section>
        <h1>Liste Factures</h1>
        <table id="table_facture" class="display">
            <thead>
            <tr>
                <th style="width: 100px">N Devis</th>
                <th style="width: 100px">Code client</th>
                <th style="width: 200px">Clients</th>
                <th style="width: 100px">date devis</th>
                <th style="width: 100px">Montant</th>
                <th style="width: 100px">Actions</th>
            </tr>
            </thead>
            <tbody>
			<?php
			while($factures = $statement->fetchObject())
			{
				print '<tr>';
				print '<td>' . $factures->numDevis . '</td>';
				print '<td>' . $factures->code_cli . '</td>';
				print '<td>' . identiteClient($factures->rs,$factures->nom_cli) .'</td>';
				print '<td>' . dateFr($factures->date) . '</td>';
				print '<td>' . $factures->montant . '</td>';
				print '<td>
                            <a href="view.php?id='.$factures->numDevis.'">
                                <img src="../includes/assets/zoom.png" class="imageTableau" title="Afficher Facture" alt="afficher facture"/>
                            </a>
							</td>';
				print '</tr>';
			}
			?>
            </tbody>
        </table>
    </section>
</div>
</body>
<script type="text/javascript"  src="../includes/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript"  src="../includes/scripts/datatables.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#table_facture').DataTable({
			"language": getLangageDataTable("facture", true)
		});
	});
</script>
</html>
