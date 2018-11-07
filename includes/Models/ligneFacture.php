<?php

namespace Model;

class ligneFacture
{
    private $_id;
    private $_produit;
    private $_quantite;
    private $_prixUnitaire;
    private $_tva;
    
    public function __construct($id, $produit, $quantite, $prixUnitaire, $tva)
    {
        // Chaque setter renvoit vrai ou faux selon qu'il ait effectu� l'action ou non
        // On l�ve une exception si un setter renvoit faux.
        if(!$this->setId($id))
        {
            throw new \Exception("LigneFacture : id incorrect!");
        }
        if(!$this->setQuantite($quantite))
        {
            throw new \Exception("LigneFacture : quantit� incorrecte!");
        }
        if(!$this->setPrixUnitaire($prixUnitaire))
        {
            throw new \Exception("LigneFacture : prix unitaire incorrect!");
        }
        if(!$this->setTVA($tva))
        {
            throw new \Exception("LigneFacture : tva incorrect!");
        }
        if(!$this->setProduit($produit))
        {
            throw new \Exception("LigneFacture : produit incorrect!");
        }
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function getProduit()
    {
        return $this->_produit;
    }
    
    public function getQuantite()
    {
        return $this->_quantite;
    }
    
    public function getPrixUnitaire()
    {
        return $this->_prixUnitaire;
    }
    
    public function getTVA()
    {
        return $this->_tva;
    }
    
    public function setId($id)
    {
        $ok = is_int($id);
        if($ok)
        {
            $this->_id = $id;
        }
        return $ok;
    }
    
    public function setProduit($produit)
    {
        $ok = $produit instanceof Produit;
        if($ok)
        {
            $this->_tva = $produit;
        }
        return $ok;
    }
    
    public function setQuantite($quantite)
    {
        $ok = is_int($quantite) && $quantite > 0;
        if($ok)
        {
            $this->_quantite = $quantite;
        }
        return $ok;
    }
    
    public function setPrixUnitaire($prixUnitaire)
    {
        $ok = is_numeric($prixUnitaire) && $prixUnitaire > 0;
        if($ok)
        {
            $this->_prixUnitaire = $prixUnitaire;
        }
        return $ok;
    }
    
    public function setTVA($tva)
    {
        $ok = $tva instanceof TVA;
        if($ok)
        {
            $this->_tva = $tva;
        }
        return $ok;
    }
    
}

?>