<?php
	require_once('../config.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title>Formulaire</title>
    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/style.css">
    <link rel="stylesheet" type="text/css" href="/progiplus2/includes/styles/clientFormulaire.css">

    <meta charset="UTF-8">
</head>

<body>
    <div class="wrapper">
        <?php include('../nav.php'); ?>

        <section>
            <h1>Progiplus</h1>

            <form id="tb" name="tb" action="" method="post">

                <?php
          $nom = $prenom  = $codeClient = $raisonSocial = $service = $ligne1 = $ligne2 = $cPostale = $ville = $nomAdresse = "";
          $db = Database::connect();
          

        ?>
                <fieldset>

                    <h2>Ajouter un client</h2>

                    <div id="container">

                        <div class="element"><label for="code">Code client :</label>
                            <input type="int" id="code_client" name="code_client" required value="<?php echo $codeClient; ?>"></div><br>


                        <div class="element"><label for="raison_social">Raison sociale :</label>
                            <input type="text" id="raison_sociale" name="raison_sociale" required value="<?php echo $raisonSocial; ?>"></div><br>


                        <div class="element" id="civilite"><span style="margin-left:20px;">Civilité : </span>
                            <label for="mme">Mme</label><input type="radio" name="gender" value="2" class="civilite" required />


                            <label for="mr">M.</label> <input type="radio" name="gender" value="1" class="civilite" required /></div><br>


                        <div class="element"> <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>"></div><br>


                        <div class="element"> <label for="prenom">Prénom :</label>
                            <input type="text" id="prenom" name="prenom" value="<?php echo $prenom;?>"></div><br><br>


                        <div class="element"> <label for="service">Service :</label>
                            <input type="text" id="service" name="service" value="<?php echo $service; ?>"></div><br>


                        <div class="element"> <label style="width:170px;" for="ligne2">Adresse de facturation :</label>
                            <input type="text" style="margin-right:34px;" id="ligne1" name="id_adresse_facturation" value="<?php echo $ligne1; ?>"></div><br>
                        <div class="element"> <label style="width:170px;" for="ligne2">Complément d'adresse :</label>
                            <input type="text" style="margin-right:34px;" id="ligne2" name="id_adresse_comp" value="<?php echo ligne2; ?>"></div><br>

                        <div class="element"> <label for="nomAdresse">Nom d'adresse :</label>
                            <input type="text" id="nomAdresse" name="nomAdresse" value="<?php echo $nomAdresse; ?>"></div> <br>


                        <div class="element"> <label for="cPostale">Code Postale :</label>
                            <input type="text" id="cPostale" name="postale" value="<?php echo $cPostale; ?>"></div> <br>

                        <div class="element"><label for="ville">Ville:</label>
                            <input type="text" id="ville" name="ville" value="<?php echo $ville; ?>"></div> <br><br>


                        <div class="element">
                            <input class="button" type="button" value="Ajouter" id="btnAjouterClient"><br>
                            <input class="button" type="reset" value="Annuler"></div><br>


                        

                    </div>
                </fieldset>
            </form>
        </section>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    
    // faire la verification de toute ma forme en JavaScript

    <script type="text/javascript">
        $('form[name=tb]').submit(function() {
            return foncVerif();
        });

        function isValid(champ) {
            if (champ.value.trim() == '') {
                champ.style.borderColor = 'red';
                champ.focus();
                return false;
            } else {
                champ.style.borderComor = 'initial';
                return true;
            }
        }

        function verifSaisie() {

            var radioCiv = document.getElementsByName("gender");
            if (!radioCiv[0].checked && !radioCiv[1].checked) {
                alert('vous devez choisir la civilité');
                radioCiv[0].focus();
                return false;
            }


            var codeClient = document.getElementById('code_client');
            var raisonSocial = document.getElementById('raison_sociale');
            var Hnom = document.getElementById('nom');
            var Hprenom = document.getElementById('prenom');
            var service = document.getElementById('service');
            var ligne1 = document.getElementById('ligne1');
            var ligne2 = document.getElementById('ligne2');
            var ville = document.getElementById('ville');
            var cPostale = document.getElementById('postale');
            var nomAdresse = document.getElementById('nomAdresse');


            if (!isValid(codeClient)) {
                alert('vous devez saisir votre code client');
                return false;
            }

            if (!isValid(raisonSocial)) {
                alert('vous devez saisir votre entreprise');
                return false;
            }

            if (!isValid(Hnom)) {
                alert('vous devez saisir un nom');
                return false;
            }
            if (!isValid(Hprenom)) {
                alert('vous devez saisir un prenom!');
                return false;
            }
            if (!isValid(service)) {
                alert('vous devez saisir le service');
                return false;
            }

            if (!isValid(ligne1)) {
                alert('vous devez saisir votre adresse de facturation');
                return false;
            }

            if (!isValid(ligne2)) {
                alert('vous devez saisir votre complement d\'adresse');
                return false;
            }
            
            return true;
        }

        //pour faire ajout et modif de clien dans le modal (модальное окно)
        
        function ajouterClient() { 
            if (verifSaisie()) {
                $.ajax({
                    
                    type: "POST",
                    url: "ajax.php",
                    data:{
                        action: "ajouterClient",
                        code_client: $('#code_client').val(),
                        raison_sociale: $('#raison_sociale').val(),
                        civilite: $('input[name="gender"]:checked').val(),
                        nom: $('#nom').val(),
                        prenom: $('#prenom').val(),
                        service: $('#service').val(),
                        ligne1: $('#ligne&').val(),
                        ligne2: $('#ligne2').val(),
                        nomAdresse: $('#nomAdresse').val(),
                        cPostale: $('#cPostale').val(),
                        ville: $('#ville').val()
                    },
                    success: verifierReponse
                });
            }
        }
        
        function verifierReponse(reponse)
        {
            if(reponse == "true")
            {
                window.location.href = '';
            }
            else
            {
                alert("Erreur d'enregistrement");
            }
        }

        function init() {
            $('#btnAjouterClient').click(ajouterClient);
        }

        $(document).ready(init);

    </script>
</body>

</html>
