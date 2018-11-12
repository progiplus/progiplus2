use progiplus;

INSERT INTO civilite (libelle)
VALUES ("Mr"), ("Mme");

INSERT INTO tva (taux,actif)
VALUES (2.10,1),(5.50,1),(10.00,1),(20.00,1);

INSERT INTO ville (nom_ville, cp_ville)
VALUES ("Bordeaux","33000"),("Nerac","47600"),("Mimizan","40200");

INSERT INTO adresse (ligne1,ligne2,id_ville)
VALUES 
("24 rue des fauvettes","lieu dit Tartifume",2),
("35 rue du pot au feu",NULL,1),
("22 rue de la poste",NULL,1),
("2 avenue de la plage",NULL,3);

INSERT INTO client (code_client, raison_sociale, actif)
VALUES 
("Cl28",NULL,true),
("ClPro25","Peinture and Co",true),
("Cl29",NULL,true),
("ClPro30","Le roi du bricolage",true);

INSERT INTO contact (nom,prenom,service,id_client,id_civilite)
VALUES 	("Duck","Donald",NULL,1,1),
		("Baltazar","Picsou","PDG",2,1),
		("Duck","Daisy",NULL,3,2),
		("Duck","Fifi","Comptable",4,1);
INSERT INTO type_moyen_comm (libelle)
VALUES ("telephone"),("Fax"),("Mobile"),("email");

INSERT INTO moyen_comm (valeur, id_type_moyen_comm)
VALUES 
("0553349827",1),("0553345827",2),("0606060606",3),("Blablabla@email.fr",4);

INSERT INTO contact_comm (id_contact, id_mcomm)
VALUES (1,1),(2,2),(3,3),(4,4);

INSERT INTO liste_adresse(libelle,actif,id_client,id_adresse)
VALUES
("facturation",1,1,1),
("livraison",1,2,2),
("facturation",1,3,3),
("livraison",1,4,4);

INSERT INTO marque (nom)
VALUES ("Samsumg"),("Apple"),("Sony"),("LG"),("Huawei"),("Audi"),("Renault");

INSERT INTO gamme (libelle,actif,id_marque)
VALUES
("Galaxy",1,1),
("iPhone",1,2),
("iPad",1,2),
("xperia",1,3),
("G",1,4),
("Mate",1,5),
("P",1,5),
("TT",1,6),
("Clio",1,7),
("Megane",1,7);

INSERT INTO categorie(libelle,id_sous_categorie,actif)
VALUES
("Multimadia",NULL,1),
("Vehicule",NULL,1),
("Smartphone",1,1),
("Pc portable",1,1),
("Voiture",2,1);

INSERT INTO produit(reference,designation,prix_unitaire_ht,actif,id_categorie,id_gamme)
VALUES
("S9","Galaxy s9",700,1,3,1),
("S8","Galaxy s",600,1,3,1),
("7","iPhone 7",700,1,3,2),
("8","iPhone 8",800,1,3,2),
("Z3","Sony Z3",300,1,3,4),
("6","Lg g6",700,1,3,5),
("10","Mate 10",700,1,3,6),
("2.5l tsi","Audi tt essence",9999,1,4,8),
("2.2l tdi","clio",6000,1,4,9);

INSERT INTO devis(date_devis, duree_validite,actif,id_client, id_adresse)
VALUES
("2018-10-22",30,1,1,1),
("2018-10-12",30,1,2,2),
("2018-08-14",30,0,3,3),
("2018-07-11",30,0,4,4),
("2018-04-22",30,0,1,1),
("2018-03-12",30,0,2,2),
("2018-02-14",30,0,3,3),
("2018-01-11",30,0,4,4);

INSERT INTO ligne_devis_client(quantite,prixU,reference,id_tva,id_devis)
VALUES
(3,700,"S9",4,1),(2,600,"S8",4,1),(1,700,"10",4,1),
(1,300,"Z3",1,2),
(1,400,"Z3",1,3),
(1,9999,"2.5l tsi",2,4),
(5,800,"8",3,5),
(7,700,"6",3,6),
(7,700,"7",3,7),
(7,700,"6",3,8);

INSERT INTO facture(date_facture,actif,id_client,id_adresse,id_devis)
VALUES
("2018-10-22",1,1,1,1),
("2018-10-22",1,2,2,6),
("2018-10-22",1,2,2,5);

INSERT INTO ligne_facture_client(quantite,prixU,reference,id_tva,id_facture)
VALUES (3,700,"S9",4,1), (2,600,"S8",4,1), (1,700,"10",4,1), (7,700,"6",3,2),
(10,700,"10",1,3), (10,600,"S8",1,3);

INSERT INTO bl(date_bl,actif,id_adresse,id_facture)
VALUES 
("2018-10-22",1,1,1),
("2018-10-22",1,2,2),
("2018-11-07",1,2,3),
("2018-11-07",1,2,3);

INSERT INTO ligne_bl(quantite, id_bl, id_ligne_facture)
VALUES (3,1,1),(1,1,2),(5,2,4),(5,3,5),(5,4,5),(5,3,6),(5,4,6);