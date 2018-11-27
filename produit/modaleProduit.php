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

				<p><label for="nomNewM">Nom :</label>
	      <input type="text" name="nomNewM"></p>

				<p><label for="nomNewM" class="nomNewM">Marque à modifier :</label>
	      <select name="nomNewM">
	        <option value="0">Sélectionnez</option>
	        <?php
					while ($NewM=$listeMarque->fetchObject()){
	          print"<option value=\"$NewM->id_marque\">$NewM->nom</option>";
	        }?>
	        </select></p>

				<button type="button" id="btnAjouterMarque">Ajouter</button>
				<button type="button" id="btnModifierMarque">Modifier</button>
				<button type="button" id="btnAnnulerMarque">Annuler</button>

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

				<p><label for="nomNewG">Nom :</label>
	      <input type="text" name="nomNewG"></p>

				<p><label for="nomNewG" class="nomNewG">Gamme à modifier :</label>
	      <select name="nomNewG">
	        <option value="0">Sélectionnez</option>
	        <?php
					while ($NewG=$listeGammeOnly->fetchObject()){
	          print"<option value=\"$NewG->id_gamme\">$NewG->libelle</option>";
	        }?>
	        </select></p>

				<button type="button" id="btnAjouterGamme">Ajouter</button>
				<button type="button" id="btnModifierGamme">Modifier</button>
				<button type="button" id="btnAnnulerGamme">Annuler</button>

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

				<p><label for="nomNewC">Nom :</label>
	      <input type="text" name="nomNewC"></p>

				<p><label for="nomNewC" class="nomNewC">Catégorie à modifier :</label>
	      <select name="nomNewC">
	        <option value="0">Sélectionnez</option>
	        <?php
					while ($NewC=$listeCategorie->fetchObject()){
	          print"<option value=\"$NewC->id_categorie\">$NewC->libelle</option>";
	        }?>
	        </select></p>

				<button type="button" id="btnAjouterCategorie">Ajouter</button>
				<button type="button" id="btnModifierCategorie">Modifier</button>
				<button type="button" id="btnAnnulerCategorie">Annuler</button>

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
