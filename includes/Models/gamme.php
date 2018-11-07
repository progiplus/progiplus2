<?php

namespace Model;

class Gamme
{
    private $_id;
    private $_libelle;
    private $_marque;
    
    public function __construct($id, $libelle, $marque)
    {
        // Chaque setter renvoit vrai ou faux selon qu'il ait effectué l'action ou non
        // On lève une exception si un setter renvoit faux.
        if(!$this->setId($id))
        {
            throw new \Exception("Gamme : id incorrect!");
        }
        if(!$this->setLibelle($libelle))
        {
            throw new \Exception("Gamme : libellé incorrect!");
        }
        if(!$this->setMarque($marque))
        {
            throw new \Exception("Gamme : marque incorrect!");
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

    public function getMarque()
    {
        return $this->_marque;
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

    public function setMarque($marque)
    {
        $ok = $marque instanceof Marque;
        if($ok)
        {
            $this->_marque = $marque;
        }
        return $ok;
    }
}

?>