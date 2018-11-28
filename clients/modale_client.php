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
                    <input type="int" id="code_client_MC" name="code_client" required value=""></div><br>


                <div class="element"><label for="raison_social">Raison sociale :</label>
                    <input type="text" id="raison_sociale_MC" name="raison_sociale" required value=""></div><br>

                <div class="element" id="conteneurClientActif_MC"><label for="clientActif">Actif :</label>
                    <input type="checkbox" id="clientActif_MC" name="clientActif" required value=""><br><br></div>

                <div class="element" id="civilite_MC"><span style="margin-left:20px;">Civilité : </span>
                    <label for="mme">Mme</label><input type="radio" name="gender_MC" value="2" class="civilite" required />


                    <label for="mr">M.</label> <input type="radio" name="gender_MC" value="1" class="civilite" required /></div><br>


                <div class="element"> <label for="nom">Nom :</label>
                    <input type="text" id="nom_MC" name="nom" value=""></div><br>


                <div class="element"> <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom_MC" name="prenom" value=""></div><br><br>


                <div class="element"> <label for="service">Service :</label>
                    <input type="text" id="service_MC" name="service" value=""></div><br>


                <div class="element"> <label style="width:170px;" for="ligne2">Adresse de facturation :</label>
                    <input type="text" style="margin-right:34px;" id="ligne1_MC" name="id_adresse_facturation" value=""></div><br>
                <div class="element"> <label style="width:170px;" for="ligne2">Complément d'adresse :</label>
                    <input type="text" style="margin-right:34px;" id="ligne2_MC" name="id_adresse_comp" value=""></div><br>

                <div class="element"> <label for="nomAdresse">Nom d'adresse :</label>
                    <input type="text" id="nomAdresse_MC" name="nomAdresse" value=""></div> <br>


                <div class="element"> <label for="cPostale">Code Postale :</label>
                    <input type="text" id="cPostale_MC" name="postale" value=""></div> <br>

                <div class="element"><label for="ville">Ville:</label>
                    <input type="text" id="ville_MC" name="ville" value=""></div> <br><br>

                <input id="id_client_MC" type="hidden" value="">
                <input id="id_adresse_facturation_MC" type="hidden" value="">
                <input id="id_contact_MC" type="hidden" value="">
                <input id="id_ville_MC" type="hidden" value="">


                <div class="element centrer">
                    <input class="button" type="button" value="Ajouter" id="btnAjouterClient">
                    <input class="button" type="button" value="Modifier" id="btnModifierClient">
                    <input class="button" type="reset" value="Annuler" id="btnAnnulerClient">
                    <br>
                    <input class="button" type="button" value="Ajouter un contact" id="btnModaleAjouterContact">
                    <input class="button" type="button" value="Gérer adresse" id="btnModaleAdresse">
                </div>





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

                var radioCiv = document.getElementsByName("gender_MC");
                if (!radioCiv[0].checked && !radioCiv[1].checked) {
                    alert('vous devez choisir la civilité');
                    radioCiv[0].focus();
                    return false;
                }


                var codeClient = document.getElementById('code_client_MC');
                var raisonSocial = document.getElementById('raison_sociale_MC');
                var Hnom = document.getElementById('nom_MC');
                var Hprenom = document.getElementById('prenom_MC');
                var service = document.getElementById('service_MC');
                var ligne1 = document.getElementById('ligne1_MC');
                var ligne2 = document.getElementById('ligne2_MC');
                var ville = document.getElementById('ville_MC');
                var cPostale = document.getElementById('cPostale_MC');
                var nomAdresse = document.getElementById('nomAdresse_MC');


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
            
            function displayModal(idModal) {
               $('#' + idModal).show();
            }

            function closeModal() {
                    $(this).parent().parent().parent().hide();
                }
            
            function cancelModal(idModal) {
                    $('#' + idModal).hide();
                }

            //pour faire ajout et modif de client dans le modal (модальное окно)

            function ajouterClient() {
                if (verifSaisie()) {
                    $.ajax({

                        type: "POST",
                        url: "ajax.php",
                        data: {
                            action: "ajouterClient",
                            code_client: $('#code_client_MC').val(),
                            raison_sociale: $('#raison_sociale_MC').val(),
                            civilite: $('input[name="gender_MC"]:checked').val(),
                            nom: $('#nom_MC').val(),
                            prenom: $('#prenom_MC').val(),
                            service: $('#service_MC').val(),
                            ligne1: $('#ligne1_MC').val(),
                            ligne2: $('#ligne2_MC').val(),
                            nomAdresse: $('#nomAdresse_MC').val(),
                            cPostale: $('#cPostale_MC').val(),
                            ville: $('#ville_MC').val()
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
                            id_client: $('#id_client_MC').val(),
                            code_client: $('#code_client_MC').val(),
                            raison_sociale: $('#raison_sociale_MC').val(),
                            civilite: $('input[name="gender_MC"]:checked').val(),
                            id_contact: $('#id_contact_MC').val(),
                            nom: $('#nom_MC').val(),
                            prenom: $('#prenom_MC').val(),
                            service: $('#service_MC').val(),
                            id_adresse_facturation: $('#id_adresse_facturation_MC').val(),
                            nomAdresse: $('#nomAdresse_MC').val(),
                            ligne1: $('#ligne1_MC').val(),
                            ligne2: $('#ligne2_MC').val(),
                            clientActif: $('#clientActif_MC').is(":checked") ? 1 : 0,
                            cPostale: $('#cPostale_MC').val(),
                            id_ville: $('#id_ville_MC').val(),
                            ville: $('#ville_MC').val()
                        },
                        success: verifierReponse
                    });
                }
            }

            function verifierReponse(reponse) {
                if (reponse == "true") {
                    window.location.href = '';
                } else {
                    alert("Erreur d'enregistrement");
                }
            }
            
            function init_MC() {
                $('#btnAjouterClient').click(ajouterClient);
                $('#btnModifierClient').click(modifierClient);
                $('.close').click(closeModal);
                $('#btnAnnulerClient').click(function () {
                    cancelModal('modaleClient')
                });
                $('#btnAnnulerContact').click(function () {
                    cancelModal('modaleContact')
                });
                $('#btnAnnulerAdresse').click(function () {
                    cancelModal('modaleAdresse')
                });


                $('#btnModaleAjouterContact').click(function () {
                    $('#modaleClient').hide();
                    displayModal("modaleContact");
                });

                $('#btnModaleModifierContact').click(function () {
                    $('#modaleClient').hide();
                    displayModal("modaleContact");
                });
                $('#btnModaleAdresse').click(function () {
                    $('#modaleClient').hide();
                    displayModal("modaleAdresse");
                })
            }
            
            $('#btnModaleAjouterContact').click(function(){
                $('#modaleClient').hide();
                displayModal("modaleContact");
            });
            
            $('#btnModaleModifierContact').click(function(){
                $('#modaleClient').hide();
                displayModal("modaleContact");
            });
            $('#btnModaleAdresse').click(function(){
                $('#modaleClient').hide();
                displayModal("modaleAdresse");
                $('#modaleAdresse #idClient').val($('#modaleClient #idClient').val());
                $.ajax({

                        type: "POST",
                        url: "ajax.php",
                        data: {
                            action: "getAdresseClient",
                            idClient: $('#id_client').val()
                        },
                        success: listeAdresseClient
                });
            });
            
            function listeAdresseClient(liste)
            {
                $('#adresseFac').html(liste);
            }
            
            $(document).ready(init_MC);


        </script>
    </div>
</div>
