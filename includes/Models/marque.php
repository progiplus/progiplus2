<?php

namespace Model;

class Marque
{
    private $_id;
    private $_nom;
    
    public function __construct($id, $nom)
    {
        // Chaque setter renvoit vrai ou faux selon qu'il ait effectu� l'action ou non
        // On l�ve une exception si un setter renvoit faux.
        if(!$this->setId($id))
        {
            throw new \Exception("Marque : id incorrect!");
        }
        if(!$this->setNom($nom))
        {
            throw new \Exception("Marque : nom incorrect!");
        }
    }
    
    public function getId()
    {
        return $this->_id;
    }

    public function getNom()
    {
        return $this->_nom;
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
    
    public function setNom($nom)
    {
        $ok = is_string($nom);
        if($ok)
        {
            $this->_nom = $nom;
        }
        return $ok;
    }

}

?>