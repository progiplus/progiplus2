<?php
	require_once('config.php');

	$db = Database::connect();

	$listeCategorie = $db->query('
	SELECT id_categorie, libelle FROM categorie
  ORDER BY libelle;
	');

  $listeMarque = $db->query('
  SELECT id_marque, nom FROM marque
  ORDER BY nom;
  ');

  $listeGamme = $db->query('
  SELECT id_gamme, libelle FROM gamme
  ORDER BY libelle;
  ');

	Database::disconnect();
?>

<!--Ajouter / Modifier un produit-->

<?php

?>

<div id="modaleProduit" class="modal">
  <div class="modal-content">
	  <div class="modal-header">
		<span class="close">&times;</span>
		<h2 class="titreModale"></h2>
	  </div>
	  <div class="modal-body">
		<form>
		  <p><label for="referenceProduit">Référence :</label>
		  <input type="text" id="referenceProduit" name="referenceProduit"></p>

		  <p><label for="designationProduit">Désignation :</label>
		  <input type="text" id="designationProduit" name="designationProduit"></p>

		  <p><label for="prixht_produit">Prix unitaire :</label>
		  <input type="text" id="prixht_produit" name="prixht_produit"></p>

		  <p><label for="marqueProduit">Marque :</label>
		  <select onchange="checkNewMarque" name="marqueProduit" id="marqueProduit">
			<option value="0">Sélectionnez</option>
			<?php while ($marque=$listeMarque->fetchObject()){
			  print"<option value=\"$marque->id_marque\">$marque->nom</option>";
			}?>
			<option value="newP">-Nouveau-</option>
			<input type="text" id="newMarque" name="newMarque">
			</select></p>

		  <p><label for="gammeProduit">Gamme :</label>
		  <select onchange="checkNewGamme" name="gammeProduit" id="gammeProduit">
			<option value="0">Sélectionnez</option>
			<?php while ($gamme=$listeGamme->fetchObject()){
			  print"<option value=\"$gamme->id_gamme\">$gamme->libelle</option>";
			}?>
			<option value="newG">-Nouveau-</option>
			<input type="text" id="newGamme" name="newGamme">
			</select></p>

		  <p><label for="catégorieProduit">Catégorie :</label>
		  <select onchange="checkNewCatégorie" name="catégorieProduit" id="catégorieProduit">
			<option value="0">Sélectionnez</option>
			<?php while ($categorie=$listeCategorie->fetchObject()){
			  print"<option value=\"$categorie->id_categorie\">$categorie->libelle</option>";
			}?>
			<option value="newC">-Nouveau-</option>
			<input type="text" id="newCatégorie" name="newCatégorie">
			</select></p>

		  <p>Cocher cette case pour désactiver le produit :<br>
		  <input type="checkbox" name="inactif" id="produitActif" /> <label for="inactif"></label></p>

		 <button type="button" id="btnAjouterProduit">Ajouter produit</button>
			 <button type="button" id="btnModifierProduit">Modifier produit</button>
		 <button type="button" id="btnAnnuler">Annuler</button>
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

var marqueProduit = document.getElementById('marqueProduit');
marqueProduit.onchange = checkNewMarque;
marqueProduit.onchange();

function checkNewMarque() {
  checkGenerique(this, 'newMarque', 'newP');
}

var gammeProduit = document.getElementById('gammeProduit');
gammeProduit.onchange = checkNewGamme;
gammeProduit.onchange();

function checkNewGamme() {
  checkGenerique(this, 'newGamme', 'newG');
}

var catégorieProduit = document.getElementById('catégorieProduit');
catégorieProduit.onchange = checkNewCatégorie;
catégorieProduit.onchange();

function checkNewCatégorie() {
  checkGenerique(this, 'newCatégorie', 'newC');
}

</script>
