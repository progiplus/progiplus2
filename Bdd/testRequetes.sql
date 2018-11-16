use progiplus;

-- Lignes d'une facture avec quantité à livrer
SELECT lf.id_facture, lf.id_ligne_facture, lf.reference, p.designation, lf.quantite - IFNULL(SUM(lb.quantite), 0) as 'reste à livrer'
FROM facture as f 
INNER JOIN ligne_facture_client as lf ON f.id_facture = lf.id_facture
INNER JOIN produit as p ON lf.reference = p.reference
LEFT OUTER JOIN ligne_bl as lb ON lf.id_ligne_facture = lb.id_ligne_facture
WHERE f.id_facture = 1
GROUP BY lf.id_facture, lf.quantite, lf.reference, lf.id_ligne_facture, p.designation;

-- Liste des factures n'ayant pas été entièrement livré
SELECT DISTINCT lf.id_facture
FROM facture as f 
INNER JOIN ligne_facture_client as lf ON f.id_facture = lf.id_facture
LEFT OUTER JOIN ligne_bl as lb ON lf.id_ligne_facture = lb.id_ligne_facture
WHERE f.actif = TRUE
GROUP BY lf.id_facture, lf.quantite, lf.reference, lf.id_ligne_facture
HAVING lf.quantite - IFNULL(SUM(lb.quantite), 0) > 0;

-- Infos d'un devis
SELECT d.id_devis, SUM(l.quantite * l.prixU) as 'montant HT', SUM(l.quantite * l.prixU * t.taux/100) as 'tva',
		c.code_client, a.ligne1, a.ligne2, v.nom_ville, v.cp_ville
FROM devis d
INNER JOIN client c ON c.id_client = d.id_client 
INNER JOIN adresse a ON c.id_adresse_facturation = a.id_adresse
INNER JOIN ville v ON a.id_ville = v.id_ville
INNER JOIN ligne_devis_client l ON l.id_ligne_devis = d.id_devis
INNER JOIN produit p ON p.reference = l.reference
INNER JOIN tva t ON l.id_tva = t.id_tva
WHERE l.id_devis = 1
GROUP BY l.id_devis;

-- Info des lignes devis
SELECT p.reference, p.designation , l.quantite, l.prixU , 
l.quantite * l.prixU as 'montant ht', t.taux, t.taux/100 * l.quantite * l.prixU as 'tva'
FROM devis as d
INNER JOIN ligne_devis_client l ON l.id_ligne_devis = d.id_devis
INNER JOIN produit p ON p.reference = l.reference
INNER JOIN tva t ON l.id_tva = t.id_tva
WHERE l.id_devis = 1;