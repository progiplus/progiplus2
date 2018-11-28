<div id="modaleAdresse" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class= "titreModale">Ajout adresse et modification adresse facturation</h2>
        </div>
        <div class="modal-body">
           <br>
            <div id="container">
                <div class="element"><label for="adresseFac">Adresse de facturation :</label>
                             <select  id="adresseFac_MA" name="adresseFac" required value="">
                                 
                             </select></div><br>


                        <div class="element"><label for="nomAdresse">Nom adresse :</label>
                            <input id="nomAdresse_MA" name="nomAdresse" required value=""></div><br>


                        <div class="element"> <label for="ligne1">Ligne1 :</label>
                            <input id="ligne1_MA" name="ligne1" value=""></div><br>
                            
                       <div class="element"> <label for="ligne2">Ligne2 :</label>
                            <input id="ligne2_MA" name="ligne2" value=""></div><br>


                        <div class="element"> <label for="cp">Code postal :</label>
                            <input id="cp_MA" name="cp" value=""></div><br>



                        <div class="element"><label for="ville">Ville:</label>
                            <input id="ville_MA" name="ville" value=""></div> <br>

                        <input id="idClient_MA" type="hidden" name="idClient" value="">
                        <input id="idAdresseFacAvant_MA" type="hidden" name="idAdresseFacAvant_MA" value="">
                        <div class="element">
                            <input class="button" type="button" value="Valider" id="btnGererAdresse_MA">
                            <input class="button" type="reset" value="Annuler" id="btnAnnulerAdresse_MA"></div><br>
            </div>
    </div>
 </div>
</div>
<script type="text/javascript">
    function listeAdresseClient(liste)
    {
        $('#adresseFac_MA').html(liste);
        $('#adresseFac_MA').val($('#idAdresseFacAvant_MA').val());
    }

    function gererAdresse()
    {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                action: "gererAdresse",
                id_client: $('#idClient_MA').val(),
                id_adresse_facturation: $('#adresseFac_MA').val(),
                nomAdresse: $('#nomAdresse_MA').val(),
                ligne1: $('#ligne1_MA').val(),
                ligne2: $('#ligne2_MA').val(),
                cPostale: $('#cp_MA').val(),
                ville: $('#ville_MA').val()
            },
            success: verifierReponse
        });
    }

    function init_MA()
    {
        $('#btnGererAdresse_MA').click(gererAdresse);
        $('#btnAnnulerAdresse_MA').click(function () {
            cancelModal('modaleAdresse')
        });
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                action: "getAdresseClient",
                idClient: $('#idClient_MA').val()
            },
            success: listeAdresseClient
        });
        $('#nomAdresse_MA').val("");
        $('#ligne1_MA').val("");
        $('#ligne2_MA').val("");
        $('#cp_MA').val("");
        $('#ville_MA').val("");
    }

</script>