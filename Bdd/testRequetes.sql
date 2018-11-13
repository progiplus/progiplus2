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

select p.reference, p.designation, l.quantite, p.prixunitaireht, t.taux
	from devis as d
	inner join lignedevis as l on l.id_devis = d.id
	inner join produit as p on p.id = l.id_produit
	inner join tva as t on t.id = l.id_tva
	where d.id = 1;
