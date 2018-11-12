<!--Ajouter / Modifier un produit-->

<div id="modaleProduit" class="modal">
  <div class="modal-content">
  <div class="modal-header">
    <span class="close">&times;</span>
    <h2 class="titreModale"></h2>
  </div>
  <div class="modal-body">
    <form>
      <p><label for="libellé_produit">Référence :</label>
      <input type="text" id="libellé_produit" name="libellé_produit"></p>

      <p><label for="désignation_produit">Désignation :</label>
      <input type="text" id="désignation_produit" name="désignation_produit"></p>

      <p><label for="prixht_produit">Prix unitaire :</label>
      <input type="text" id="prixht_produit" name="prixht_produit"></p>

      <p><label for="marqueProduit">Marque :</label>
      <select onchange="checkNewMarque" name="marqueProduit" id="marqueProduit">
        <option value="0">Sélectionnez</option>
        <option value="newP">Nouveau</option>
        <input type="text" id="newMarque" name="newMarque">
        <button type="button" id="validerNewMarque" name="validerNewMarque">Valider</button>
      </select></p>

      <p><label for="gammeProduit">Gamme :</label>
      <select onchange="checkNewGamme" name="gammeProduit" id="gammeProduit">
        <option value="0">Sélectionnez</option>
        <option value="newG">Nouveau</option>
        <input type="text" id="newGamme" name="newGamme">
        <button type="button" id="validerNewGamme" name="validerNewGamme">Valider</button>
      </select></p>

      <p><label for="catégorieProduit">Catégorie :</label>
      <select onchange="checkNewCatégorie" name="catégorieProduit" id="catégorieProduit">
        <option value="0">Sélectionnez</option>
        <option value="newC">Nouveau</option>
        <input type="text" id="newCatégorie" name="newCatégorie">
        <button type="button" id="validerNewCatégorie" name="validerNewCatégorie">Valider</button>
      </select></p>

      <p>Cocher cette case pour désactiver le produit :<br>
      <input type="checkbox" name="inactif" id="inactif" /> <label for="inactif"></label></p>

     <button type="button">Valider</button>
     <button type="button">Annuler</button>
  </div>
  </div>
</div>

<script type="text/javascript">

function checkGenerique(that, idNew, idValider, valueNew) {
  var newElem = document.getElementById(idNew);
  var validerElem = document.getElementById(idValider);
  if (that.options[that.selectedIndex].value === valueNew) {
      newElem.style.display = '';
      validerElem.style.display = '';
  } else {
      newElem.style.display = 'none';
      validerElem.style.display = 'none';
  }
}

var marqueProduit = document.getElementById('marqueProduit');
marqueProduit.onchange = checkNewMarque;
marqueProduit.onchange();

function checkNewMarque() {
  checkGenerique(this, 'newMarque', 'validerNewMarque', 'newP');
}

var gammeProduit = document.getElementById('gammeProduit');
gammeProduit.onchange = checkNewGamme;
gammeProduit.onchange();

function checkNewGamme() {
  checkGenerique(this, 'newGamme', 'validerNewGamme', 'newG');
}

var catégorieProduit = document.getElementById('catégorieProduit');
catégorieProduit.onchange = checkNewCatégorie;
catégorieProduit.onchange();

function checkNewCatégorie() {
  checkGenerique(this, 'newCatégorie', 'validerNewCatégorie', 'newC');
}

</script>
