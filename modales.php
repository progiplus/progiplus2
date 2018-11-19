<?php
	require_once('config.php');

	$db = Database::connect();

	$listeCategorie = $db->query('
	SELECT id_categorie, libelle FROM categorie
  ORDER BY libelle;
	');

  //  $listeMarque = $db->query('
  // SELECT id_marque, nom FROM marque
  //  ORDER BY nom;
  //  ');

  // $listeGamme = $db->query('
  // SELECT id_gamme, libelle FROM gamme
  // ORDER BY libelle;
  // ');

	$listeGamme = $db->query('
  SELECT id_gamme, concat(nom,\'/\',libelle) as libelle FROM gamme
	INNER JOIN marque ON marque.id_marque=gamme.id_marque
  ORDER BY libelle;
  ');

	Database::disconnect();
?>

<!--Ajouter / Modifier un produit-->

<?php

	 //if(isset($_POST['submit'])) {

		$id = isset($_GET['reference'])?$_GET['reference']:0;
			if (!empty($_POST)){

				$reference = $_POST['referenceProduit'];
				$designation = $_POST['designationProduit'];
				$prixht_produit = $_POST['prixht_produit'];
				$gammeProduit = $_POST['gammeProduit'];
				$catégorieProduit = $_POST['catégorieProduit'];
				$Query = "UPDATE produit SET designation = \"$designation\", prix_unitaire_ht = \"$prixht_produit\", id_gamme = $gammeProduit, id_categorie = $catégorieProduit WHERE reference = \"$reference\"";
				$Statement=$db->query($Query);
				$Statement->fetchObject();
				$Statement->closeCursor();

					if ($Statement->execute()){
						print('<script type="text/javascript">document.location.href=\'index.php\';</script>');
					}
			}
	 //}

?>

<div id="modaleProduit" class="modal">
  <div class="modal-content">
  <div class="modal-header">
    <span class="close">&times;</span>
    <h2 class="titreModale"></h2>
  </div>
  <div class="modal-body">
    <form method="post">
      <p><label for="referenceProduit">Référence :</label>
      <input type="text" id="referenceProduit" name="referenceProduit"></p>

      <p><label for="designationProduit">Désignation :</label>
      <input type="text" id="designationProduit" name="designationProduit"></p>

      <p><label for="prixht_produit">Prix unitaire HT :</label>
      <input type="text" id="prixht_produit" name="prixht_produit"></p>

      <!--<p><label for="marqueProduit">Marque :</label>
      <select onchange="checkNewMarque" name="marqueProduit" id="marqueProduit">
        <option value="0">Sélectionnez</option>
        <?php /*while ($marque=$listeMarque->fetchObject()){
          print"<option value=\"$marque->id_marque\">$marque->nom</option>";
        }*/?>
        <option value="newP">-Nouveau-</option>
        <input type="text" id="newMarque" name="newMarque">
			</select></p>-->

      <p><label for="gammeProduit">Marque / Gamme :</label>
      <select onchange="checkNewGamme" name="gammeProduit" id="gammeProduit">
        <option value="0">Sélectionnez</option>
        <?php while ($gamme=$listeGamme->fetchObject()){
          print"<option value=\"$gamme->id_gamme\">$gamme->libelle</option>";
        }?>
        <!-- <option value="newG">-Nouveau-</option>
        <input type="text" id="newGamme" name="newGamme"> -->
        </select></p>

      <p><label for="catégorieProduit">Catégorie :</label>
      <select onchange="checkNewCatégorie" name="catégorieProduit" id="catégorieProduit">
        <option value="0">Sélectionnez</option>
        <?php while ($categorie=$listeCategorie->fetchObject()){
          print"<option value=\"$categorie->id_categorie\">$categorie->libelle</option>";
        }?>
        <!-- <option value="newC">-Nouveau-</option>
        <input type="text" id="newCatégorie" name="newCatégorie"> -->
        </select></p>

      <!-- <p>Laisser cette case cochée pour activer le produit :<br>
      <input type="checkbox" name="inactif" id="produitActif" /> <label for="inactif"></label></p> -->

     <button type="submit" id="btnAjouterProduit">Ajouter produit</button>
		 <button type="submit" id="btnModifierProduit">Modifier produit</button>
     <button type="button" id="btnAnnuler">Annuler</button>
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

/*var marqueProduit = document.getElementById('marqueProduit');
marqueProduit.onchange = checkNewMarque;
marqueProduit.onchange();*/

// function checkNewMarque() {
//   checkGenerique(this, 'newMarque', 'newP');
// }

//TODO var gammeProduit = document.getElementById('gammeProduit');
// gammeProduit.onchange = checkNewGamme;
// gammeProduit.onchange();
//
// function checkNewGamme() {
//   checkGenerique(this, 'newGamme', 'newG');
// }
//
// var catégorieProduit = document.getElementById('catégorieProduit');
// catégorieProduit.onchange = checkNewCatégorie;
// catégorieProduit.onchange();
//
// function checkNewCatégorie() {
//   checkGenerique(this, 'newCatégorie', 'newC');
// }

</script>
