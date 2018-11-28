drop DATABASE IF EXISTS progiplus;
CREATE DATABASE progiplus;
use progiplus;

create table civilite(
	id_civilite int(10) PRIMARY KEY AUTO_INCREMENT,
	libelle VARCHAR(50) NOT NULL
);
CREATE TABLE ville(
	id_ville INT(10) PRIMARY KEY AUTO_INCREMENT,
	nom_ville VARCHAR(50) NOT NULL,
	cp_ville VARCHAR(5)
);
CREATE TABLE adresse(
	id_adresse INT(10) PRIMARY KEY AUTO_INCREMENT,
	ligne1 VARCHAR(50) NOT NULL,
	ligne2 VARCHAR(50),
	id_ville INT  NOT NULL,
	CONSTRAINT fk_id_ville FOREIGN KEY(id_ville) REFERENCES ville(id_ville)
);
CREATE TABLE client(
	id_client INT(10) PRIMARY KEY AUTO_INCREMENT,
	code_client VARCHAR(25) NOT NULL UNIQUE,
	raison_sociale VARCHAR(150),
    actif BOOL NOT NULL,
    id_adresse_facturation INT(10),
    CONSTRAINT fk_client_adresse FOREIGN KEY(id_adresse_facturation) REFERENCES adresse(id_adresse)
);
CREATE TABLE contact(
	id_contact INT(10) PRIMARY KEY AUTO_INCREMENT,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	service VARCHAR(50),
	id_client INT NOT NULL,
	id_civilite INT NOT NULL,
	CONSTRAINT fk_id_client FOREIGN KEY(id_client) REFERENCES client(id_client),
	CONSTRAINT fk_id_civilite FOREIGN KEY(id_civilite) REFERENCES civilite(id_civilite)
);
create TABLE type_moyen_comm(
	id_type_moyen_comm int(10) PRIMARY KEY AUTO_INCREMENT,
	libelle VARCHAR(50)NOT NULL
);
CREATE TABLE moyen_comm(
	id_mcomm INT(10) PRIMARY KEY AUTO_INCREMENT,
	valeur VARCHAR(50) NOT NULL,
	id_type_moyen_comm INT(10) NOT NULL,
	CONSTRAINT fk_id_type_moyen_comm FOREIGN KEY(id_type_moyen_comm) REFERENCES type_moyen_comm(id_type_moyen_comm)
);
CREATE TABLE contact_comm(
	id_contact_comm INT(10) PRIMARY KEY AUTO_INCREMENT,
	id_contact INT NOT NULL,
	id_mcomm INT NOT NULL,
	CONSTRAINT fk_id_contact FOREIGN KEY(id_contact) REFERENCES contact(id_contact),
	CONSTRAINT fk_id_mcomm FOREIGN KEY(id_mcomm) REFERENCES moyen_comm(id_mcomm)
);
CREATE TABLE liste_adresse(
	id_liste_adresse INT(10) PRIMARY KEY AUTO_INCREMENT,
	libelle VARCHAR(50) NOT NULL,
	actif BOOL NOT NULL,
	id_client INT(10) NOT NULL,
	id_adresse INT(10) NOT NULL,
	CONSTRAINT fk_id_client_l_adresse FOREIGN KEY(id_client) REFERENCES client(id_client),
	CONSTRAINT fk_id_adresse_l_adresse FOREIGN KEY(id_adresse) REFERENCES adresse(id_adresse)
);
CREATE TABLE tva(
	id_tva int (10) PRIMARY KEY AUTO_INCREMENT,
	taux FLOAT(4,2) NOT NULL,
	actif BOOL NOT NULL,
	CONSTRAINT chk_taux CHECK (taux > 0 )
);
CREATE TABLE categorie(
	id_categorie INT(10) PRIMARY KEY AUTO_INCREMENT,
	libelle VARCHAR(50) NOT NULL,
	id_sous_categorie int(10),
	actif BOOL NOT NULL,
	CONSTRAINT fk_id_sous_categorie FOREIGN KEY(id_sous_categorie) REFERENCES categorie(id_categorie)
);
CREATE TABLE marque(
	id_marque INT(10) PRIMARY KEY AUTO_INCREMENT,
	nom VARCHAR(100) NOT NULL
);
CREATE TABLE gamme(
	id_gamme INT(10) PRIMARY KEY AUTO_INCREMENT,
	libelle VARCHAR(50) NOT NULL,
	actif BOOL NOT NULL,
	id_marque INT(10) NOT NULL,
	CONSTRAINT fk_id_marque FOREIGN KEY(id_marque) REFERENCES marque(id_marque)
);
CREATE TABLE produit(
	reference VARCHAR(50) PRIMARY KEY,
	designation VARCHAR(50) NOT NULL,
	prix_unitaire_ht FLOAT(6,2) NOT NULL,
	actif BOOL NOT NULL,
	id_gamme INT(10) NOT NULL,
	id_categorie INT NOT NULL,
    id_tva INT NOT NULL,
	CONSTRAINT fk_id_gamme FOREIGN KEY(id_gamme) REFERENCES gamme(id_gamme),
	CONSTRAINT fk_id_categorie_produit FOREIGN KEY(id_categorie) REFERENCES categorie(id_categorie),
    CONSTRAINT fk_produit_tva FOREIGN KEY(id_tva) REFERENCES tva(id_tva),
	CONSTRAINT chk_prixUHt CHECK (prix_unitaire_ht > 0 )
);

CREATE TABLE devis(
	id_devis INT(10) PRIMARY KEY AUTO_INCREMENT,
	date_devis DATE NOT NULL,
	duree_validite INT(3) NOT NULL,
	actif BOOL NOT NULL,
	id_client INT(10) NOT NULL,
    id_adresse INT(10) NOT NULL,
	CONSTRAINT chk_validite CHECK (duree_validite > 0 ),
	CONSTRAINT fk_id_client_devis FOREIGN KEY(id_client) REFERENCES client(id_client),
    CONSTRAINT fk_id_adresse_devis FOREIGN KEY(id_adresse) REFERENCES adresse(id_adresse)
);

CREATE TABLE facture(
	id_facture INT(10) PRIMARY KEY AUTO_INCREMENT,
	date_facture DATE NOT NULL,
	actif BOOL NOT NULL,
	id_client INT(10) NOT NULL,
	id_adresse INT(10) NOT NULL,
	id_devis INT(10),
	CONSTRAINT fk_id_client_facture FOREIGN KEY(id_client) REFERENCES client(id_client),
	CONSTRAINT fk_id_adresse_facture FOREIGN KEY(id_adresse) REFERENCES adresse(id_adresse),
	CONSTRAINT fk_id_devis FOREIGN KEY(id_devis) REFERENCES devis(id_devis)
);
CREATE TABLE ligne_devis_client(
	id_ligne_devis INT(10) PRIMARY KEY AUTO_INCREMENT,
	quantite FLOAT(5,2) NOT NULL,
    prixU FLOAT(6,2) NOT NULL,
	reference VARCHAR(50) NOT NULL,
	id_tva INT(10) NOT NULL,
	id_devis INT(10) NOT NULL,
	CONSTRAINT chk_quantiter CHECK (quantiter > 0 ),
	CONSTRAINT fk_reference_devis FOREIGN KEY(reference) REFERENCES produit(reference),
	CONSTRAINT fk_devis_tva FOREIGN KEY(id_tva) REFERENCES tva(id_tva),
	CONSTRAINT fk_devis FOREIGN KEY(id_devis) REFERENCES devis(id_devis)
);
CREATE TABLE ligne_facture_client(
	id_ligne_facture INT(10) PRIMARY KEY AUTO_INCREMENT,
	quantite FLOAT(5,2) NOT NULL,
	prixU FLOAT(6,2) NOT NULL,
	reference VARCHAR(50) NOT NULL,
	id_tva INT(10) NOT NULL,
	id_facture INT(10) NOT NULL,
	CONSTRAINT chk_quantiter CHECK (quantiter > 0 ),
	CONSTRAINT fk_reference_facture FOREIGN KEY(reference) REFERENCES produit(reference),
	CONSTRAINT fk_facture_tva FOREIGN KEY(id_tva) REFERENCES tva(id_tva),
	CONSTRAINT fk_facture FOREIGN KEY(id_facture) REFERENCES facture(id_facture)
);
CREATE TABLE bl(
	id_bl INT(10) PRIMARY KEY AUTO_INCREMENT,
	date_bl DATE NOT NULL,
	actif BOOL NOT NULL,
	id_adresse INT(10) NOT NULL,
	id_facture INT(10) NOT NULL,
	CONSTRAINT fk_id_adresse_bl FOREIGN KEY(id_adresse) REFERENCES adresse(id_adresse),
	CONSTRAINT fk_id_facture_bl FOREIGN KEY(id_facture) REFERENCES facture(id_facture)

);
CREATE TABLE ligne_bl(
	id_ligne_bl INT(10) PRIMARY KEY AUTO_INCREMENT,
	quantite FLOAT(5,2) NOT NULL,
    id_bl INT(10) NOT NULL,
	id_ligne_facture INT(10) NOT NULL,
	CONSTRAINT fk_bl FOREIGN KEY(id_bl) REFERENCES bl(id_bl),
	CONSTRAINT fk_ligne_bl_ligne_facture FOREIGN KEY(id_ligne_facture) REFERENCES ligne_facture_client(id_ligne_facture)
);

DELIMITER //
create procedure proc_devistofacture(var_id_devis INT)
begin
	DECLARE var_id_facture INT DEFAULT -1;
    
    INSERT INTO facture (date_facture, actif, id_client, id_adresse, id_devis)
	SELECT current_date(), d.actif, d.id_client, d.id_adresse, d.id_devis 
	FROM devis d
	WHERE d.id_devis = var_id_devis;
    
    SET var_id_facture = last_insert_id();

	INSERT INTO ligne_facture_client (quantite, prixU, reference, id_tva, id_facture)
	SELECT l.quantite, l.prixU, l.reference, l.id_tva, var_id_facture
	FROM ligne_devis_client l
	WHERE l.id_devis = var_id_devis;

end //
DELIMITER ;
