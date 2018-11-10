<?php 
	require_once('../config.php');
	require_once('../includes/Models/client.php');
		
			$db = Database::connect();
			if (isset($_GET['id_client']) AND !empty($_GET)){
				$id = $_GET['id_client'];
				if ($id > 0){
				    $SQLQuery = "DELETE FROM clients WHERE id_client = :id_client";
					try{
					    $SQLStatement = $pdo->prepare($SQLQuery);
						$SQLStatement->bindValue(':id_client', $id);

						if ($SQLStatement->execute()){
							print('<script type="text/javascript">document.location.href=\'liste.php\';</script>');
						}else{
							print("Erreur d'exécution de la requête de suppression !<br />");
							var_dump($SQLStatement->errorInfo());
						}
					}catch (Exception $ex){
						print("Erreur de préparation de la requête de suppression !<br />");
                                    print($ex->getMessage());
					}
				}
			}
			
			$SQLQuery = "SELECT client.code_client,client.raison_sociale,civilite.libelle,contact.nom,contact.prenom,contact.service
            FROM contact
            INNER JOIN client ON client.id_client = contact.id_client
            INNER JOIN civilite ON contact.id_civilite = civilite.id_civilite"; 
			$script = '';
			$pdo = 1;

?>

<!DOCTYPE html>
<html>
    <head>
         <title> Accueil</title>
         <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
         <meta charset="UTF-8">    
    </head>
    
    <body>
        <div class="wrapper">
			<?php include('../nav.php'); ?>

			<section>
				<h1>Progiplus</h1>
			</section>
			<tbody>
			    <table id="table_client" class="display">
        <thead>
            <tr>
                <th>Code client</th>
                <th>Raison sociale</th>
                <th>Civilite</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Actions</th>
            </tr>
        </thead>
	<?php 
		
			
			//Exécution de la requête
			$SQLResult = $pdo->query($SQLQuery);
			//vardump($SQLResult);
			
			while ($SQLRow = $SQLResult->fetchObject()){
				$script .= '<tr>';
				$script .= '<td>'.$SQLRow->client.code_client.'</td>';
				$script .= '<td>'.$SQLRow->client.raison_sociale.'</td>';
				$script .= '<td>'.$SQLRow->civilite.libelle.'</td>';
				$script .= '<td>'.$SQLRow->contact.nom.'</td>';
				$script .= '<td>'.$SQLRow->contact.prenom.'</td>';
				$script .= '<td>'.$SQLRow->contact.service.'</td>';
				$script .= '<td>N.C.</td>';
				$script .= '<td class="action"><a href="fiche.php?id='.$SQLRow->id_client.'"><img src="includes/images/edit.png" alt="Modifier" /></a></td>';
				$script .= '<td class="action"><a href="liste.php?id='.$SQLRow->id_client.'" onclick="return confirm(\'Etes-vous sur ?\');"><img src="includes/images/delete.png" alt="Supprimer" /></a></td>';
				$script .= '<td class="action"><a href="devis.php?id='.$SQLRow->id_client.'"><img src="includes/images/details.png" alt="Supprimer" /></a></td>';
				$script .= '</tr>';
			}
                        print($script);
		
			$SQLResult->closeCursor();
			 Database::disconnect();
    ?>
	</tbody>
    </body> 
<script type="text/javascript"  src="../includes/scripts/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"  src="../includes/scripts/datatables.js"></script>
    
    <script type="text/javascript">
		function init()
		{
			$('#table_client').DataTable( {"language": getLangageDataTable("client", true)} );
		}
		
		window.onload = init;	
</html>