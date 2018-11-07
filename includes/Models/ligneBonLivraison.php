<?php

namespace Model;

class ligneBonLivraison
{
    private $_id;
    private $_produit;
    private $_quantite;
    
    public function __construct($id, $produit, $quantite)
    {
        // Chaque setter renvoit vrai ou faux selon qu'il ait effectu� l'action ou non
        // On l�ve une exception si un setter renvoit faux.
        if(!$this->setId($id))
        {
            throw new \Exception("LigneBonLivraison : id incorrect!");
        }
        if(!$this->setQuantite($quantite))
        {
            throw new \Exception("LigneBonLivraison : quantit� incorrecte!");
        }
        if(!$this->setProduit($produit))
        {
            throw new \Exception("LigneBonLivraison : produit incorrect!");
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
    
}

?>