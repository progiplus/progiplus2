<?php

namespace Model;

class Ville
{
    private $_id;
    private $_nom;
    private $_codePostal;

    public function __construct($id, $nom, $code_postal)
    {
        if(!$this->setId($id))
        {
            throw new \Exception("Ville : Id incorrect!");
        }
        if(!$this->setNom($nom))
        {
            throw new \Exception("Ville : Nom incorrect");
        }
        if(!$this->setCode_Postal($code_postal))
        {
            throw new \Exception("Ville : Code postal incorrect");
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
    public function getCodePostal()
    {
        return $this->_codePostal;
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

    public function setCode_Postal($codePostal)
    {
        $ok = is_numeric($codePostal);
        if($ok)
        {
            $this->_codePostal = $codePostal;
        }
        return $ok;
    }


}
