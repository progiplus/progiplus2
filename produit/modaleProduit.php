<?php
	require_once('../config.php');

	$db = Database::connect();

	$listeCategorie = $db->query('
	SELECT id_categorie, libelle FROM categorie
  ORDER BY libelle;
	');

	$listeGamme = $db->query('
  SELECT id_gamme, concat(nom,\'/\',libelle) as libelle FROM gamme
	INNER JOIN marque ON marque.id_marque=gamme.id_marque
  ORDER BY libelle;
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

				<p><label for="nouveauNomMGC" class="nouveauNomMGC"></label>
 			 <input type="text" id="nouveauNomMGC" name="nouveauNomMGC"></p>

	     <button type="button" id="btnAjouterProduit">Ajouter produit</button>
			 <button type="button" id="btnModifierProduit">Modifier produit</button>
			 <button type="button" id="btnAjouterMarque">Ajouter marque</button>
			 <button type="button" id="btnAjouterGamme">Ajouter gamme</button>
			 <button type="button" id="btnAjouterCategorie">Ajouter categorie</button>
	     <button type="button" id="btnAnnuler">Annuler</button>

		 </form>
		</div>
  </div>
</div>

<!--Ajouter une marque / gamme / catégorie-->

<!-- <div id="modaleMGC" class="modal">
	<div class="modal-content">
	  <div class="modal-header">
	    <span class="close">&times;</span>
	    <h2 class="titreModale"></h2>
	  </div>
	  <div class="modal-body">
	    <form method="post">

				<p><label for="nomNewMarque">Nom :</label>
	      <input type="text" id="nomNewMarque" name="nomNewMarque"></p>

				<button type="button" id="btnAjouterMarque">Ajouter marque</button>
				<button type="button" id="btnAjouterGamme">Ajouter gamme</button>
				<button type="button" id="btnAjouterCategorie">Ajouter categorie</button>
				<button type="button" id="btnAnnuler2">Annuler</button>

			</form>
		</div>
	</div>
</div> -->

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
