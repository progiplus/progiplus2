<?php
require_once('../config.php');
require_once('../functions.php');


$db = Database::connect();
$statement = $db->query('
		SELECT client.code_client AS code_cli,
				client.id_client,
				client.raison_sociale AS rs,
				CONCAT(civilite.libelle," ",contact.nom," ",contact.prenom) AS nom_cli,
				bl.date_bl AS date,
				bl.id_bl AS numDevis,
		        f.id_facture AS numFacture
		FROM contact
		INNER JOIN client ON client.id_client = contact.id_client
		INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite
		INNER JOIN facture f ON client.id_client = f.id_client
		INNER JOIN bl ON bl.id_facture = f.id_facture
		GROUP BY bl.id_bl
        ORDER BY bl.id_bl ASC;
		');
Database::disconnect();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Bons de livraison</title>
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
        <h1>Liste des Bons de Livraison</h1>
        <table id="table_bl" class="display">
            <thead>
            <tr>
                <th style="width: 100px">N° BL</th>
                <th style="width: 100px">Code client</th>
                <th style="width: 200px">Clients</th>
                <th style="width: 100px">date BL</th>
                <th style="width: 100px">Actions</th>
            </tr>
            </thead>
            <tbody>
			<?php
			while($bl = $statement->fetchObject())
			{
				print '<tr>';
				print '<td>' . $bl->numDevis . '</td>';
				print '<td>' . $bl->code_cli . '</td>';
				print '<td>' . identiteClient($bl->rs,$bl->nom_cli) .'</td>';
				print '<td>' . dateFr($bl->date) . '</td>';
				print '<td>
                            <a href="../factures/detailFacture.php?id='.$bl->numFacture.'">
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
		$('#table_bl').DataTable({
			"language": getLangageDataTable("bon de livraison", true)
		});
	});
</script>
</html>
