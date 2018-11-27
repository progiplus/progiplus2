<?php
	require_once('../config.php');

          $nom = $prenom  = $codeClient = $raisonSocial = $service = $ligne1 = $ligne2 = $cPostale = $ville = $nomAdresse = "";
          $db = Database::connect();
          //je recois quelque chose dans l'adresse

?>

<div id="modaleClient" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class="titreModale"></h2>
        </div>
        <div class="modal-body">
            <br>
            <div id="container">

                <div class="element"><label for="code">Code client :</label>
                    <input type="int" id="code_client" name="code_client" required value=""></div><br>


                <div class="element"><label for="raison_social">Raison sociale :</label>
                    <input type="text" id="raison_sociale" name="raison_sociale" required value=""></div><br>

                <div class="element"><label for="clientActif">Actif :</label>
                    <input type="checkbox" id="clientActif" name="clientActif" required value=""></div><br>

                <div class="element" id="civilite"><span style="margin-left:20px;">Civilité : </span>
                    <label for="mme">Mme</label><input type="radio" name="gender" value="2" class="civilite" required />


                    <label for="mr">M.</label> <input type="radio" name="gender" value="1" class="civilite" required /></div><br>


                <div class="element"> <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value=""></div><br>


                <div class="element"> <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value=""></div><br><br>


                <div class="element"> <label for="service">Service :</label>
                    <input type="text" id="service" name="service" value=""></div><br>


                <div class="element"> <label style="width:170px;" for="ligne2">Adresse de facturation :</label>
                    <input type="text" style="margin-right:34px;" id="ligne1" name="id_adresse_facturation" value=""></div><br>
                <div class="element"> <label style="width:170px;" for="ligne2">Complément d'adresse :</label>
                    <input type="text" style="margin-right:34px;" id="ligne2" name="id_adresse_comp" value=""></div><br>

                <div class="element"> <label for="nomAdresse">Nom d'adresse :</label>
                    <input type="text" id="nomAdresse" name="nomAdresse" value=""></div> <br>


                <div class="element"> <label for="cPostale">Code Postale :</label>
                    <input type="text" id="cPostale" name="postale" value=""></div> <br>

                <div class="element"><label for="ville">Ville:</label>
                    <input type="text" id="ville" name="ville" value=""></div> <br><br>

                <input id="id_client" type="hidden" value="">
                <input id="id_adresse_facturation" type="hidden" value="">
                <input id="id_contact" type="hidden" value="">
                <input id="id_ville" type="hidden" value="">


                <div class="element centrer">
                    <input class="button" type="button" value="Ajouter" id="btnAjouterClient">
                    <input class="button" type="button" value="Modifier" id="btnModifierClient">
                    <input class="button" type="reset" value="Annuler" id="btnAnnulerClient">
                    <input class="button" type="button" value="Ajouter un contact" id="btnAjouterContact">
                    <input class="button" type="button" value="Modifier un contact" id="btnModifierContact"></div>





            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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

                //            if (!isValid(raisonSocial)) {
                //                alert('vous devez saisir votre entreprise');
                //                return false;
                //            }

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

                //            if (!isValid(ligne2)) {
                //                alert('vous devez saisir votre complement d\'adresse');
                //                return false;
                //            }

                return true;
            }

            //pour faire ajout et modif de clien dans le modal (модальное окно)

            function ajouterClient() {
                if (verifSaisie()) {
                    $.ajax({

                        type: "POST",
                        url: "ajax.php",
                        data: {
                            action: "ajouterClient",
                            code_client: $('#code_client').val(),
                            raison_sociale: $('#raison_sociale').val(),
                            civilite: $('input[name="gender"]:checked').val(),
                            nom: $('#nom').val(),
                            prenom: $('#prenom').val(),
                            service: $('#service').val(),
                            ligne1: $('#ligne1').val(),
                            ligne2: $('#ligne2').val(),
                            nomAdresse: $('#nomAdresse').val(),
                            cPostale: $('#cPostale').val(),
                            ville: $('#ville').val()
                        },
                        success: verifierReponse
                    });
                }
            }

            function modifierClient() {
                if (verifSaisie()) {
                    $.ajax({

                        type: "POST",
                        url: "ajax.php",
                        data: {
                            action: "modifierClient",
                            id_client: $('#id_client').val(),
                            code_client: $('#code_client').val(),
                            raison_sociale: $('#raison_sociale').val(),
                            civilite: $('input[name="gender"]:checked').val(),
                            id_contact: $('#id_contact').val(),
                            nom: $('#nom').val(),
                            prenom: $('#prenom').val(),
                            service: $('#service').val(),
                            id_adresse_facturation: $('#id_adresse_facturation').val(),
                            nomAdresse: $('#nomAdresse').val(),
                            ligne1: $('#ligne1').val(),
                            ligne2: $('#ligne2').val(),
                            clientActif: $('#clientActif').is(":checked") ? 1 : 0,
                            cPostale: $('#cPostale').val(),
                            id_ville: $('#id_ville').val(),
                            ville: $('#ville').val()
                        },
                        success: verifierReponse
                    });
                }
            }

            function modifierContact(){

            }

            function verifierReponse(reponse) {
                if (reponse == "true") {
                    window.location.href = '';
                } else {
                    alert("Erreur d'enregistrement");
                }
            }

            function init() {
                $('#btnAjouterClient').click(ajouterClient);
                $('#btnModifierClient').click(modifierClient);
                $('#btnAjouterContact').click(ajouterContact);
                $('#btnModifierContact').click(modifierContact);
            }


            $(document).ready(init);

        </script>
    </div>
</div>
