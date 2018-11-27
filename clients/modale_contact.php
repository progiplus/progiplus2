<?php
	require_once('../config.php');

          $nom = $prenom  = $codeClient = $raisonSocial = $service = $ligne1 = $ligne2 = $cPostale = $ville = $nomAdresse = "";
          $db = Database::connect();

          //je recois quelque chose dans l'adresse

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
                <div class="element"><label for="code">code client :</label>
                    <input type="int" id="code_client" name="code_client" required value=""></div><br>

                <div class="element"><label for="code">code contact :</label>
                    <input type="int" id="code_contact" name="code_contact" required value=""></div><br>

                <div class="element" id="civilite"><span style="margin-left:20px;">Civilité : </span>
                    <label for="mme">Mme</label><input type="radio" name="gender" value="2" class="civilite" required />
                    <label for="mr">M.</label> <input type="radio" name="gender" value="1" class="civilite" required /></div><br>

                <div class="element"><label for="code">Nom :</label>
                    <input type="int" id="nom_contact" name="nom_contact" required value=""></div><br>


                <div class="element"><label for="code">Prenom :</label>
                    <input type="int" id="prenom_contact" name="prenom_contact" required value=""></div><br>

                <div class="element"><label for="code">Service :</label>
                    <input type="int" id="service_contact" name="service_contact" required value=""></div><br>

                <input id="id_client" type="hidden" value="">
                <div id="listeMoyenComm">

                </div>
                <input class="button" type="reset" value="Ajouter" id="btnAjouterContact">
                <input class="button" type="reset" value="Annuler" id="btnAnnulerContact">
            </div>
            <script type="text/javascript" src="../includes/scripts/jquery-3.3.1.min.js"></script>
            <script>
                function getOptionTypeMoyenComm() {
                    return ''; //écrire en PHP les <option value="id">libellé</option>
                }

                function ajouterMoyenComm() {
                    $('#listeMoyenComm').append(
                        '<div class="moyenComm" data-idMoyenComm="null">' +
                        '    <select class="listeTypeMoyenComm">' +
                        '        ' + getOptionTypeMoyenComm() +
                        '    </select>' +
                        '    <label>Valeur :</label>' +
                        '    <input class="valeurMoyenComm" required value="">' +
                        '   <span class="ajoutMoyenComm">PLUS</span> ' +
                        '   <span class="supprimerMoyenComm">MOINS</span>' +
                        '</div>'
                    );
                    $('#listeMoyenComm .ajoutMoyenComm').last().click(ajouterMoyenComm);
                    $('#listeMoyenComm .supprimerMoyenComm').last().click(supprimerMoyenComm);
                }

                function supprimerMoyenComm(event) {
                    if ($(event.target).parent().data('idMoyenComm') != "null") {
                        //si pas null, le moyencomm existait avant, et donc il faut faire une requête ajax pour le supprimer
                        //si requête ajax échoue, effacer = false
                    }

                    $(event.target).parent().remove();
                }

                ajouterMoyenComm();

            </script>

        </div>
    </div>
</div>
<!--
                                    <div class="element"><label for="code">Prenom :</label>
                    <input type="int" id="prenom_contact" name="prenom_contact" required value=""></div><br>
-->
