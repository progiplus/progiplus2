<?php 
	require_once('../config.php');
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
                <table id="table_client" class="display">
                    <thead>
                        <tr>
                            <td>Nom</td>
                            <td>Prenom</td>

                        </tr>
                    </thead>
                </table>
			</section>
		</div>
    </body>
</html>
