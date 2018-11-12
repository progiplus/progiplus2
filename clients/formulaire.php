<?php
	require_once('../config.php');

?>

<!DOCTYPE html>
<html>
    <head>
         <title>Formulaire</title>
         <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
         <meta charset="UTF-8">
    </head>

    <body>
        <div class="wrapper">
			<?php include('../nav.php'); ?>

			<section>
				<h1>Progiplus</h1>

	   <form name="tb" action="" method="post">

        <?php


          $nom = $prenom  ="";
          $db = Database::connect();
           // $db = Database::connect('mysql:host=localhost; port=3306; dbname=progiplus; charset=utf8', 'root', 'root');
            if(!empty($_GET))
            { //je recois quelque chose dans l'adresse
                if (isset($_GET['id']))//recuperer les donnees
                    //GET+POST modifier les donnees
                {
                    if(!empty($_POST)) //entrer les donnees
                    {
                        // MISE à JOUR
                        $idClient=$_POST['id_client'];
                        $nom=$_POST['user_name'];
                        $prénom=$_POST['user_firstname'];
                        $codeClient=$_POST['code_client'];
                        $raisonSocial=$_POST['raison_sociale'];
                        $service=$_POST['service'];
                    }
                    else
                    {

                        // SELECT
                        $SQLQuery = 'select * from client where id='.$_GET['id'];
                        $result =$db->query($SQLQuery);
                        if ($Row=$result->fetchObject())
                        {
                            $codeClient= $Row ->codeClient;
                            $raisonSocial = $Row->raisonSocial;
                        }
                        $result->closecursor();
                    }
                }
            }
            else
            {
                if(!empty($_POST))

                {
                        $codeClient=$_POST['code_client'];
                        $raisonSociale=$_POST['raison_sociale'];
                        $civilite=$_POST['gender'];
                        $nom=$_POST['user_name'];
                        $prenom=$_POST['user_firstname'];
                        $service=$_POST['service'];


                        $SQLQuery='INSERT INTO client (code_client, raison_sociale, gender, user_name, user_firstname, service)';
                        $SQLQuery.="VALUES('".$codeClient."','".$raisonSociale."')";
                        // SQLQuery = SQLQUery. "test"; SQLQuery .= "test";
                        echo $SQLQuery;
                        $result = $db->query($SQLQuery);
                        $result->fetchObject();
                        $result->closeCursor();
                }
            }

        ?>


        <h4>Ajouter un client</h4>
    <div>
        <label class="label"  for="code">Code client :</label>
        <input type="chifre" id="code_client" name="code_client">
    </div>
    <div>
        <label class="label"  for="">Raison sociale :</label>
        <input type="text" id="raison_sociale" name="raison_sociale" value="">
    </div>
            <br>
    <div>
        <label class="label" >Civilité:</label>
    	<select name="gender">
   	 	<option value="1">Monsieur</option>
    	<option value="2">Madame</option></select>
    </div>

    <div>
        <label class="label" for="name">Nom :</label>
        <input type="text" id="name" name="user_name" value="<?php echo $nom; ?>">

    </div>
    <div>
        <label class="label" for="name">Prénom :</label>
        <input type="text" id="firstname" name="user_firstname" value=" <?php echo $prenom;?>">
    </div>
    <div>
        <label class="label"  for="service">Service :</label>
        <input type="text" id="service" name="service">
    </div>

    <div>
       <button type="submit" onclick="afficherInfo()" value="valider">Valider</button>
       <button id="btCancel" type="reset" value="Annuler">Annuler</button>
    </div>
           	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		      <script type="text/javascript">
			$('form[name=tb]').submit(function(){
				return foncVerif();
			});

            function isValid(champ){
            if (champ.value.trim ()==''){
            champ.style.borderColor='red';
            champ.focus();
            return false;
            }
            else{
                champ.style.borderComor='initial';
                return true;
            }
          }

        function verifSaisie(){
            var radioCiv=document.getElementsByName("gender");
            if(!radioCiv[0].checked&&!radioCiv[1].checked){
                alert('vous devez choisir la civilité');
                radioCiv[0].focus();
                return false;
            }
        var Hnom = document.getElementById('nom');
        var Hprenom =document.getElementById('prenom');
            if(!isValid(Hnom)){
                alert('vous devez saisir un nom');
                return false;
            }
            if (!isValid(Hprenom)){
                alert('vous devez saisir un prenom!');
                return false;
            }
        }

           </script>

</form>
</section>
</div>
</body>
</html>
