<?php
include_once ('../../../config.php');
if (isset($_POST['code'])){
	$id=$_POST['code'];

	$db = Database::connect();
	$statement = $db->prepare('
		SELECT 	client.code_client AS code_cli,
		client.id_client,
		client.raison_sociale AS rs,
		CONCAT(civ.libelle," ",contact.nom," ",contact.prenom) AS nom_cli,
		mcom.valeur, tmcom.libelle,
		adresse.ligne1 AS ligne1,adresse.ligne2 AS ligne2,
		CONCAT(ville.cp_ville," ",ville.nom_ville)AS ville
		FROM contact
		INNER JOIN client ON client.id_client = contact.id_client
		INNER JOIN civilite civ ON civ.id_civilite = contact.id_civilite
		INNER JOIN contact_comm ccom ON ccom.id_contact = contact.id_contact
		INNER JOIN moyen_comm mcom ON mcom.id_mcomm = ccom.id_mcomm
		INNER JOIN type_moyen_comm tmcom ON tmcom.id_type_moyen_comm = mcom.id_type_moyen_comm
		INNER JOIN adresse ON client.id_adresse_facturation = adresse.id_adresse
		INNER JOIN ville ON adresse.id_ville = ville.id_ville
		WHERE code_client = ? AND tmcom.libelle = "telephone"
	');
	$statement->execute(array($id));

	$client = $statement->fetchObject();
	Database::disconnect();

	print(json_encode($client));
}else{
    print('mauvais paramètre');
}

?>
