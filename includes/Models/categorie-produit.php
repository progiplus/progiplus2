<?php

namespace Model;

class CategorieProduit
{
    private $_id;
    private $_libelle;
    private $_catParent;
    
    public function __construct($id, $libelle, $catParent)
    {
        // Chaque setter renvoit vrai ou faux selon qu'il ait effectué l'action ou non
        // On lève une exception si un setter renvoit faux.
        if(!$this->setId($id))
        {
            throw new \Exception("Catégorie-Produit : id incorrect!");
        }
        if(!$this->setLibelle($libelle))
        {
            throw new \Exception("Catégorie-Produit : libellé incorrect!");
        }
        if(!$this->setCatParent($catParent))
        {
            throw new \Exception("Catégorie-Produit : catégorie parente incorrecte!");
        }
    }
    
    public function getId()
    {
        return $this->_id;
    }

    public function getLibelle()
    {
        return $this->_libelle;
    }

    public function getCatParent()
    {
        return $this->_catParent;
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

    public function setLibelle($libelle)
    {
        $ok = is_string($libelle);
        if($ok)
        {
            $this->_libelle = $libelle;
        }
        return $ok;
    }

    public function setCatParent($catParent)
    {
        $ok = $catParent instanceof CategorieProduit || $catParent == null;
        if($ok)
        {
            $this->_catParent = $catParent;
        }
        return $ok;
        
    }


}

?>