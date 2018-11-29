<?php
require_once('../config.php');

$db = Database::connect();
$listeTypeMcomm = $db->query('
select id_type_moyen_comm, libelle
from type_moyen_comm');
Database::disconnect();
?>

<div id="modaleContact" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class="titreModale"></h2>
        </div>
        <div class="modal-body">
            <br>
            <div id="container">
                <!--<div class="element"><label for="code">code client :</label>
                    <input type="int" id="code_client" name="code_client" required value=""></div><br>

                
								<div class="element"><label for="code">code contact :</label>
									<input type="int" id="code_contact" name="code_contact" required value=""></div><br>
				-->

                <div class="element" id="civilite_contact"><span style="margin-left:20px;">Civilité : </span>
                    <label for="mme">Mme</label><input type="radio" name="gender_MCo" value="2" class="civilite" required />
                    <label for="mr">M.</label> <input type="radio" name="gender_MCo" value="1" class="civilite" required /></div><br>

                <div class="element"><label for="nom_contact">Nom :</label>
                    <input type="int" id="nom_contact" name="nom_contact" required value=""></div><br>


                <div class="element"><label for="prenom">Prenom :</label>
                    <input type="int" id="prenom_contact" name="prenom_contact" required value=""></div><br>

                <div class="element"><label for="service">Service :</label>
                    <input type="int" id="service_contact" name="service_contact" required value=""></div><br>

                <input id="id_client_MCo" type="hidden" value="">
                <div id="listeMoyenComm">

                </div>
                <input class="button" type="button" value="Ajouter" id="btnAjouterContact">
                <input class="button" type="reset" value="Annuler" id="btnAnnulerContact">
            </div>
            
            <script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
            <script>

				function initModaleContact(){
					$('#btnAjouterContact').click(ajouterContact);
					ajouterMoyenComm();
				}

				function getOptionTypeMoyenComm() {
					return '<?php
						
						while ($comm=$listeTypeMcomm->fetchObject()){
							print "<option value=\"$comm->id_type_moyen_comm\">$comm->libelle</option>";
							
						}  ?>';
				}
				
				function ajouterMoyenComm() {
					$('#listeMoyenComm').append(
						'<div class="moyenComm" data-idMoyenComm="null">' +
						'    <select class="listeTypeMoyenComm">' +
						'        ' + getOptionTypeMoyenComm() +
						'    </select>' +
						'    <label>Valeur :</label>' +
						'    <input class="valeur" required value="">' +
						'   <img src="../includes/assets/more.png" class="ajoutMoyenComm petit_logo"/>' +
						'   <img src="../includes/assets/less.png" class="supprimerMoyenComm petit_logo"/>' +
						'</div>'
					);
					$('#listeMoyenComm .ajoutMoyenComm').last().click(ajouterMoyenComm);
					$('#listeMoyenComm .supprimerMoyenComm').last().click(supprimerMoyenComm);
				}

				function ajouterContact() {
					var tabMoyen = new Array();
					var lignesMoyen = $('#listeMoyenComm .moyenComm');
					for(var i = 0; i < lignesMoyen.length; i++)
					{
						tabMoyen.push(
							{'type' : $('.listeTypeMoyenComm', lignesMoyen[i]).val(),
                                'valeur' : $('.valeur', lignesMoyen[i]).val()}
						);
					}
					if (verifSaisieContact()) {
						$.ajax({
							type: "POST",
							url: "ajax.php",
							data: {
								action: "ajouterContact",
								idClient: $('#id_client_MCo').val(),
								nom_contact: $('#nom_contact').val(),
								prenom_contact: $('#prenom_contact').val(),
								civilite_contact: $('input[name="gender_MCo"]:checked').val(),
								service_contact: $('#service_contact').val(),
                                moyensCom: tabMoyen
							},
							success: verifierReponse
						});
					}
				}

				function verifSaisieContact() {

					var radioCivC = document.getElementsByName("gender_MCo");
					if (!radioCivC[0].checked && !radioCivC[1].checked) {
						alert('vous devez choisir la civilité');
						radioCiv[0].focus();
						return false;
					}
     
					var raisonSocial = document.getElementById('raison_sociale');
					var Hnom = document.getElementById('nom_contact');
					var Hprenom = document.getElementById('prenom_contact');
					var service = document.getElementById('service_contact');

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

					return true;
				}

				function modifierContact() {
						if (verifSaisie()) {
							$.ajax({
		
								type: "POST",
								url: "ajax.php",
								data: {
									action: "modifierContact",
									id_client: $('#id_client').val(),
									code_client: $('#code_client').val(),
									raison_sociale: $('#raison_sociale').val(),
									civilite: $('input[name="gender"]:checked').val(),
									id_contact: $('#id_contact').val(),
									nom: $('#nom').val(),
									prenom: $('#prenom').val(),
									service: $('#service').val(),
		
								},
								success: verifierReponse
							});
						}
					}



				function supprimerMoyenComm(event) {
					if ($(event.target).parent().data('idMoyenComm') != "null") {
						//si pas null, le moyencomm existait avant, et donc il faut faire une requête ajax pour le supprimer
						//si requête ajax échoue, effacer = false
					}

					$(event.target).parent().remove();
				}
				$(document).ready(initModaleContact);
            </script>

        </div>
    </div>
</div>
<!--
                                    <div class="element"><label for="code">Prenom :</label>
                    <input type="int" id="prenom_contact" name="prenom_contact" required value=""></div><br>
-->
