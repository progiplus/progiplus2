<?php

if(!isset($_GET['id']))
{
	header('Location: /index.php');
}

require_once('../config.php');
$id = $_GET['id'];
$donneeLigneFacture = array();
$timeZone = new DateTimeZone('Europe/Paris');

$conn = $db = Database::connect();

$query = 'SELECT c.code_client, c.raison_sociale, f.id_facture, f.date_facture as "date", SUM(l.quantite * l.prixU) as "montant"
FROM facture f
INNER JOIN client c ON c.id_client = f.id_client
INNER JOIN ligne_facture_client l on l.id_facture = f.id_facture
INNER JOIN adresse a ON a.id_adresse = c.id_adresse_facturation
INNER JOIN ville v on v.id_ville = a.id_ville
WHERE f.id_facture = '.$id.'
GROUP BY f.id_facture, f.date_facture, c.code_client, c.raison_sociale';

$result = $conn->query($query); // 3
$donneeFacture = $result->fetchObject(); // 4
$result->closeCursor(); // 5

$query = "SELECT p.reference, p.designation, l.quantite, l.prixU as 'PU'
FROM facture as f
INNER JOIN ligne_facture_client as l on l.id_facture = f.id_facture
INNER JOIN produit as p on p.reference = l.reference
WHERE f.id_facture = ".$id.";";

$result = $conn->query($query); // 3
while($donneeLigneFacture[] = $result->fetchObject()){}// 4

$result->closeCursor(); // 5

$date = new DateTime($donneeFacture->date,$timeZone)

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
<p class="enTete">
<h1>Facture n°<?php echo $donneeFacture->id_facture; ?></h1>
<span class="tiers"><strong>Compte client : </strong><?php echo $donneeFacture->code_client; ?></span>
<span class="tiers"><strong>Client : </strong><?php echo $donneeFacture->raison_sociale; ?></span>
<span class="tiers"><strong>Date : </strong><?php echo $date->format("d/m/Y") ?></span>
</p>

<table>
	<tr>
		<th>Réf</th>
		<th>Désignation</th>
		<th>Quantité</th>
		<th>Prix unitaire</th>
		<th>Montant HT</th>
	</tr>
	<?php
	$html = "";
	for($i = 0; $i < count($donneeLigneFacture) - 1; $i++)
	{
		$html .= '<tr><td>'.$donneeLigneFacture[$i]->reference.'</td>';
		$html .= '<td>'.$donneeLigneFacture[$i]->designation.'</td>';
		$html .= '<td>'.$donneeLigneFacture[$i]->quantite.'</td>';
		$html .= '<td>'.$donneeLigneFacture[$i]->PU.'</td>';
		$html .= '<td>'.($donneeLigneFacture[$i]->quantite * $donneeLigneFacture[$i]->PU).'</td></tr>';
	}
	echo $html;
	
	?>
</table>
<br>
<div class="centre">
	<strong>TOTAL HT : <?php echo $donneeFacture->montant."€" ?></strong><br>
</div>
</section>
</div>
</body>
</html>