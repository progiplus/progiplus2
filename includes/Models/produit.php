<?php

namespace Model;

class Produit
{
    private $_reference;
    private $_designation;
    private $_prixUnitaire;
    private $_actif;
    private $_gamme;
    private $_catProduit;
    
    public function __construct($ref, $designation, $prixUnit, $actif, $catProduit, $gamme)
    {
        // Chaque setter renvoit vrai ou faux selon qu'il ait effectué l'action ou non
        // On l�ve une exception si un setter renvoit faux.
        if(!$this->setReference($ref))
        {
            throw new \Exception("Produit : id incorrect!");
        }
        if(!$this->setDesignation($designation))
        {
            throw new \Exception("Produit : désignation incorrecte!");
        }
        if(!$this->setPrixUnitaire($prixUnit))
        {
            throw new \Exception("Produit : prix unitaire incorrect!");
        }
        if(!$this->setActif($actif))
        {
            throw new \Exception("Produit : actif incorrect!");
        }
        if(!$this->setGamme($gamme))
        {
            throw new \Exception("Produit : gamme incorrecte!");
        }
        if(!$this->setCatProduit($catProduit))
        {
            throw new \Exception("Produit : catégorie-produit incorrect!");
        }
    }
    
    public function getReference()
    {
        return $this->_reference;
    }
    
    public function getDesignation()
    {
        return $this->_designation;
    }
    
    public function getPrixUnitaire()
    {
        return $this->_prixUnitaire;
    }
    
    public function getActif()
    {
        return $this->_actif;
    }
    
    public function getGamme()
    {
        return $this->_gamme;
    }
    
    public function getCatProduit()
    {
        return $this->_catProduit;
    }
    
    public function setReference($id)
    {
        $ok = is_string($id);
        if($ok)
        {
            $this->_reference = $id;
        }
        return $ok;
    }
    
    public function setDesignation($libelle)
    {
        $ok = is_string($libelle);
        if($ok)
        {
            $this->_designation = $libelle;
        }
        return $ok;
    }
    
    public function setCatProduit($catParent)
    {
        $ok = $catParent instanceof CategorieProduit;
        if($ok)
        {
            $this->_marque = $catParent;
        }
        return $ok;
    }
    
    public function setPrixUnitaire($prixUnitaire)
    {
        $ok = is_numeric($prixUnitaire);
        if($ok)
        {
            $this->_prixUnitaire = $prixUnitaire;
        }
        return $ok;
    }
    
    public function setActif($actif)
    {
        $ok = is_bool($actif);
        if($ok)
        {
            $this->_actif = $actif;
        }
        return $ok;
    }
    
    public function setGamme($gamme)
    {
        $ok = $gamme instanceof Gamme;
        if($ok)
        {
            $this->_marque = $gamme;
        }
        return $ok;
        $this->_gamme = $gamme;
    }
    
}