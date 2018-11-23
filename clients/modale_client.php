<?php
	require_once('../config.php');

          $nom = $prenom  = $codeClient = $raisonSocial = $service = $adresseC = $adresseF = $cPostale = $ville = $nomAdresse = "";
          $db = Database::connect();

          //je recois quelque chose dans l'adresse

?>

<div id="modaleClient" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class= "titreModale"></h2>
        </div>
        <div class="modal-body">
            <form method="post">

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

                        <div class="element"> <label style="width:170px;" for="id_adresse_facturation">Adresse de facturation :</label>
                            <input type="text" style="margin-right:34px;" id="id_adresse_facturation" name="id_adresse_facturation" value="<?php echo $adresseF; ?>"></div><br>
                        <div class="element"> <label style="width:170px;" for="id_adresse_comp">Complément d'adresse :</label>
                            <input type="text" style="margin-right:34px;" id="id_adresse_comp" name="id_adresse_comp" value="<?php echo $adresseC; ?>"></div><br>

                        <div class="element"> <label for="nomAdresse">Nom d'adresse :</label>
                            <input type="text" id="nomAdresse" name="nomAdresse" value="<?php echo $nomAdresse; ?>"></div> <br>


                        <div class="element"> <label for="cPostale">Code Postale :</label>
                            <input type="text" id="cPostale" name="postale" value="<?php echo $cPostale; ?>"></div> <br>

                        <div class="element"><label for="ville">Ville:</label>
                            <input type="text" id="ville" name="ville" value="<?php echo $ville; ?>"></div> <br><br>


                        <div class="element">
                            <input class="button" type="submit" onclick="afficherInfo()" value="Valider"><br>
                            <input class="button" id="btnAnnuler" type="reset" value="Annuler"></div><br>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function checkGenerique(that, idNew, valueNew) {
        var newElem = document.getElementById(idNew);
        if (that.options[that.selectedIndex].value === valueNew) {
            newElem.style.display = '';
        } else {
            newElem.style.display = 'none';
        }
    }

</script>

