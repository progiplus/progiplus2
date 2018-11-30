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

$query = 'SELECT c.code_client, c.raison_sociale, f.id_facture, f.date_facture as "date",
f.id_adresse as "idAdresse", SUM(l.quantite * l.prixU) as "montant"
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

$date = new DateTime($donneeFacture->date,$timeZone);


$state = $db->query(
    "select count(bl.id_bl) as 'nb'
from bl
where bl.id_facture = ".$id.";");
$nbBl = $state->fetchObject()->nb;
$state->closeCursor();


?>

<!DOCTYPE html>
<html>
<head>
	<title>Produit</title>
	<link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
	<link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/datatables.css">
	<link rel="stylesheet" type="text/css" href="/progiplus2/factures/detailFacture.css">
	<meta charset="UTF-8">
</head>

<body>
<div class="wrapper">

<?php include('../nav.php'); ?>
<section>

<h1>Facture n°<?php echo $donneeFacture->id_facture; ?></h1>
<div id="cadre"><span class="tiers"><strong>Compte client : </strong><?php echo $donneeFacture->code_client; ?></span>
<span class="tiers"><strong>Client : </strong><?php echo $donneeFacture->raison_sociale; ?></span>
<span class="tiers"><strong>Date : </strong><?php echo $date->format("d/m/Y") ?></span></div> 

<h3></h3>
<table>
    <thead>
	<tr>
		<th>Réf</th>
		<th>Désignation</th>
		<th>Quantité</th>
		<th>Prix unitaire</th>
		<th>Montant HT</th>
	</tr>
	</thead>
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
<div id="centre">
	<strong>TOTAL HT : <?php echo $donneeFacture->montant."€" ?></strong><br>
</div>
<input id="idFacture" type="hidden" value="<?php echo $id; ?>">
    <input id="idAdresse" type="hidden" value="<?php echo $donneeFacture->idAdresse; ?>">
    <?php
    if($nbBl == 0)
    {
        echo '<button id="btnCreationBL">Créer un BL</button>';
    }
    ?>
    <script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
    <script>
		function verifierReponse(reponse) {
			console.log(reponse);
			if (reponse  == "true") {
				alert("BL créé");
				$('#btnCreationBL').remove();
			} else {
				alert("Erreur, un BL est probablement déjà créé pour cette facture");
			}
		}
        
        function creerBL()
        {
        	var idFacture = $('#idFacture').val();
        	var idAdresse = $('#idAdresse').val();
        	console.log(idFacture + " " + idAdresse);
			$.ajax({
				type: "POST",
				url: "../factures/ajaxFacture.php",
				data: {
					idFacture: idFacture,
					idAdresse: idAdresse,
					action: "exporterEnBl"
				},
                success: verifierReponse
			});
			
        }
        
        $('#btnCreationBL').click(creerBL);
    </script>
</section>
</body>
</html>