<?php
	require_once('../config.php');

          $nom = $prenom  = $codeClient = $raisonSocial = $service = $adresseC = $adresseF = $cPostale = $ville = $nomAdresse = "";
          $db = Database::connect();

          //je recois quelque chose dans l'adresse
                if (isset($_GET['id'])) //recuperer les donnees
                    //GET+POST modifier les donnees
                {
                    if(!empty($_POST)) //entrer les donnees
                    {
                        // MISE à JOUR
                        $idClient=$_POST['id_client'];
                        $nom=$_POST['nom'];
                        $prenom=$_POST['prenom'];
                        $codeClient=$_POST['code_client'];
                        $raisonSocial=$_POST['raison_sociale'];
                        $service=$_POST['service'];
                        $status=$_POST['actif'];
                        $adresseF=$_POST['id_adresse_facturation'];
                        $adresseC=$_POST['id_adresse_comp'];
                        $nomAdresse=$_POST['nomAdresse'];
                        $ville = $_POST['ville'];
                        $cPostale = $_POST['postale'];


                    }
                    else
                    {

                        // SELECT
                        $SQLQuery = 'select * from client where id_client='.$_GET['id'];
                        $result =$db->query($SQLQuery);
                        if ($Row=$result->fetchObject())
                        {
                            $codeClient= $Row ->codeClient;
                            $raisonSocial = $Row->raisonSocial;
                            $status = $Row->status;
                        }
                        $result->closecursor();
                    }
                }

            else
            {
                if(!empty($_POST))

                {
                        $codeClient=$_POST['code_client'];
                        $raisonSociale=$_POST['raison_sociale'];
                        $civilite=$_POST['gender'];
                        $nom=$_POST['nom'];
                        $prenom=$_POST['prenom'];
                        $service=$_POST['service'];
                        $adresseF=$_POST['id_adresse_facturation'];
                        $adresseC=$_POST['id_adresse_comp'];
                        $nomAdresse=$_POST['nomAdresse'];
                        $ville = $_POST['ville'];



                        $SQLville = 'INSERT INTO ville(nom_ville, cp_ville) VALUE ("'.$ville.'","'.$cPostale.'");';
                        $result = $db->query($SQLville);
                        $idVille = $db->lastInsertId();
                        $result->fetchObject();
                        $result->closeCursor();

                        $SQLadresse = 'INSERT INTO adresse(ligne1, ligne2, id_ville) VALUE("'.$adresseF.'","'.$adresseC.'",'.$idVille.');';
                        $result = $db->query($SQLadresse);
                        $idAdresse = $db->lastInsertId();
                        $result->fetchObject();
                        $result->closeCursor();

                        $SQLclient = 'INSERT INTO client (code_client, raison_sociale, actif, id_adresse_facturation) VALUE("'.$codeClient.'","'.$raisonSociale.'",1,'.$idAdresse.');';
                        $result = $db->query($SQLclient);
                        $idClient = $db->lastInsertId();
                        $result->fetchObject();
                        $result->closeCursor();

                        $SQLlisteadresse = 'INSERT INTO liste_adresse (libelle, actif, id_client, id_adresse) VALUE ("'.$nomAdresse.'",1, '.$idClient.', '.$idAdresse.');';
                        $result = $db->query($SQLlisteadresse);
                        $result->fetchObject();
                        $result->closeCursor();

                        $SQLcontact = 'INSERT INTO contact (nom, prenom, service,id_civilite, id_client) VALUE ("'.$nom.'","'.$prenom.'","'.$service.'",'.$civilite.','.$idClient.');';
                        $result = $db->query($SQLcontact);
                        $result->fetchObject();
                        $result->closeCursor();

                }
            }

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

