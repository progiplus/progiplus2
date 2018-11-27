<?php
	require_once('../config.php');

	$db = Database::connect();

	$listeTVA = $db->query('
	SELECT id_tva, taux FROM tva
	ORDER BY taux;
	');

	$listeCategorie = $db->query('
	SELECT id_categorie, libelle FROM categorie
  ORDER BY libelle;
	');

	$listeCategorie2 = $db->query('
	SELECT id_categorie, libelle FROM categorie
	ORDER BY libelle;
	');

	$listeGammeOnly = $db->query('
	SELECT id_gamme, libelle FROM gamme
	ORDER BY libelle;
	');

	$listeGamme = $db->query('
  SELECT id_gamme, concat(nom,\'/\',libelle) as libelle FROM gamme
	INNER JOIN marque ON marque.id_marque=gamme.id_marque
  ORDER BY libelle;
  ');

	$listeMarque = $db->query('
	SELECT id_marque, nom FROM marque
	ORDER BY nom;
	');

	Database::disconnect();

?>



<!--Ajouter / Modifier un produit-->

<div id="modaleProduit" class="modal">
  <div class="modal-content">
	  <div class="modal-header">
	    <span class="close">&times;</span>
	    <h2 class="titreModale"></h2>
	  </div>
	  <div class="modal-body">
	    <form method="post">
	      <p><label for="referenceProduit" class="referenceProduit">Référence :</label>
	      <input type="text" id="referenceProduit" name="referenceProduit"></p>

	      <p><label for="designationProduit" class="designationProduit">Désignation :</label>
	      <input type="text" id="designationProduit" name="designationProduit"></p>

	      <p><label for="prixht_produit" class="prixht_produit">Prix unitaire HT :</label>
	      <input type="text" id="prixht_produit" name="prixht_produit"></p>

				<p><label for="tva" class="tva">TVA :</label>
	      <select name="tva" id="tva">
	        <option value="0">Sélectionnez</option>
	        <?php while ($TVA=$listeTVA->fetchObject()){
	          print"<option value=\"$TVA->id_tva\">$TVA->taux</option>";
	        }?>
	        </select></p>

	      <p><label for="gammeProduit" class="gammeProduit">Marque / Gamme :</label>
	      <select name="gammeProduit" id="gammeProduit">
	        <option value="0">Sélectionnez</option>
	        <?php while ($gamme=$listeGamme->fetchObject()){
	          print"<option value=\"$gamme->id_gamme\">$gamme->libelle</option>";
	        }?>
	        </select></p>

	      <p><label for="catégorieProduit" class="catégorieProduit">Catégorie :</label>
	      <select name="catégorieProduit" id="catégorieProduit">
	        <option value="0">Sélectionnez</option>
	        <?php while ($categorie=$listeCategorie->fetchObject()){
	          print"<option value=\"$categorie->id_categorie\">$categorie->libelle</option>";
	        }?>
	        </select></p>

	     <button type="button" id="btnAjouterProduit">Ajouter produit</button>
			 <button type="button" id="btnModifierProduit">Modifier produit</button>
	     <button type="button" id="btnAnnuler">Annuler</button>

		 </form>
		</div>
  </div>
</div>

<!--Ajouter / modifier une marque-->

<div id="modaleMarque" class="modal">
	<div class="modal-content">
	  <div class="modal-header">
	    <span class="close">&times;</span>
	    <h2 class="titreModale">Ajouter ou Modifier une Marque</h2>
	  </div>
	  <div class="modal-body">
			<form method="post">
				<div class="partie">
					<div class="partieAjout">
						<p><label for="nomNewM">Nom :</label>
			      <input id="nomNewM" type="text" name="nomNewM"></p>

						<button type="button" id="btnAjouterMarque">Ajouter</button>
					</div>
				<div class="partieModif">
					<p><label for="nomNewM" class="nomNewM">Marque à modifier :</label>
		      <select onchange="modifyNameM()" name="nomNewM" id="selectM">
		        <option value="0">Sélectionnez</option>
		        <?php
						while ($NewM=$listeMarque->fetchObject()){
		          print"<option value=\"$NewM->id_marque\">$NewM->nom</option>";
		        }?>
						<input type="text" id="newMarque" name="newMarque">
		        </select></p>

					<button type="button" id="btnModifierMarque">Modifier</button>
				</div>

					<div class="boutonAnnuler">
						<button type="button" id="btnAnnulerMarque">Annuler</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Ajouter / modifier une gamme-->

<div id="modaleGamme" class="modal">
	<div class="modal-content">
	  <div class="modal-header">
	    <span class="close">&times;</span>
	    <h2 class="titreModale">Ajouter ou Modifier une Gamme</h2>
	  </div>
	  <div class="modal-body">
			<form method="post">
				<div class="partie">
					<div class="partieAjout">
						<p><label for="nomNewG">Nom :</label>
			      <input id="nomNewG" type="text" name="nomNewG"></p>

						<button type="button" id="btnAjouterGamme">Ajouter</button>
					</div>
				<div class="partieModif">
					<p><label for="nomNewG" class="nomNewG">Gamme à modifier :</label>
		      <select onchange="modifyNameG()" name="nomNewG" id="selectG">
		        <option value="0">Sélectionnez</option>
						<?php
						while ($NewG=$listeGammeOnly->fetchObject()){
		          print"<option value=\"$NewG->id_gamme\">$NewG->libelle</option>";
		        }?>
						<input type="text" id="newGamme" name="newGamme">
		        </select></p>

					<button type="button" id="btnModifierGamme">Modifier</button>
				</div>

					<div class="boutonAnnuler">
						<button type="button" id="btnAnnulerGamme">Annuler</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Ajouter / modifier une catégorie-->

<div id="modaleCategorie" class="modal">
	<div class="modal-content">
	  <div class="modal-header">
	    <span class="close">&times;</span>
	    <h2 class="titreModale">Ajouter ou Modifier une Catégorie</h2>
	  </div>
	  <div class="modal-body">
	    <form method="post">
				<div class="partie">
					<div class="partieAjout">
						<p><label for="nomNewC">Nom :</label>
			      <input id="nomNewC" type="text" name="nomNewC"></p>

						<button type="button" id="btnAjouterCategorie">Ajouter</button>
					</div>
				<div class="partieModif">
					<p><label for="nomNewC" class="nomNewC">Catégorie à modifier :</label>
		      <select onchange="modifyNameC()" name="nomNewC" id="selectC">
		        <option value="0">Sélectionnez</option>
		        <?php
						while ($NewC=$listeCategorie2->fetchObject()){
		          print"<option value=\"$NewC->id_categorie\">$NewC->libelle</option>";
		        }?>
						<input type="text" id="newCategorie" name="newCategorie">
		        </select></p>

					<button type="button" id="btnModifierCategorie">Modifier</button>
				</div>

					<div class="boutonAnnuler">
						<button type="button" id="btnAnnulerCategorie">Annuler</button>
					</div>
				</div>
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

function modifyNameM() {
    var valueModifM = document.getElementById("selectM");
    document.getElementById("newMarque").value = selectM.options[selectM.selectedIndex].text;
}

function modifyNameG() {
    var valueModifG = document.getElementById("selectG");
    document.getElementById("newGamme").value = selectG.options[selectG.selectedIndex].text;
}

function modifyNameC() {
    var valueModifC = document.getElementById("selectC");
    document.getElementById("newCategorie").value = selectC.options[selectC.selectedIndex].text;
}

$("#btnAjouterMarque").on('click', function(){
	$.ajax({
	 type: "POST",
	 url: "ajaxProduit.php",
	 data:{
		nomNewM: $("#nomNewM").val(),
		action: "ajouterMarque"
		},
	success: verifEnvoi
	})
});

$("#btnAjouterGamme").on('click', function(){
	$.ajax({
	 type: "POST",
	 url: "ajaxProduit.php",
	 data:{
		nomNewG: $("#nomNewG").val(),
		action: "ajouterGamme"
		},
	success: verifEnvoi
	})
});

$("#btnAjouterCategorie").on('click', function(){
	$.ajax({
	 type: "POST",
	 url: "ajaxProduit.php",
	 data:{
		nomNewC: $("#nomNewC").val(),
		action: "ajouterCategorie"
		},
	success: verifEnvoi
	})
});

function verifEnvoi(data){
	if (data=="true"){
		document.location.href='index.php';
	}else{
		alert("L'envoi a échoué.");
	}
}

</script>
