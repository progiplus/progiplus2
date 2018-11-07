<?php

namespace Model;

class Adresse
{
    private $_ligne1;
    private $_ligne2;
    private $_ville;

    public function __construct($ligne1, $ligne2, $ville)
    {
        if (!$this->setLigne1($ligne1))
        {
            throw new \Exception("Adresse : ligne 1  incorrecte!");
        }
        if (!$this->setLigne2($ligne2))
        {
            throw new \Exception("Adresse : ligne 2 incorrecte!");
        }
        if (!$this->setVille($ville))
        {
            throw new \Exception("Adresse :Ville incorrecte!");
        }
    }


    public function getLigne1()
    {
        return $this->_ligne1;
    }

    public function getLigne2()
    {
        return $this->_ligne2;
    }

    public function getVille()
    {
        return $this->_ville;
    }

    public function setLigne1($ligne1)
    {
        $ok = is_string($ligne1);
        if ($ok)
        {
            $this->_ligne1 = $ligne1;
        }
        return $ok;
    }


    public function setLigne2($ligne2)
    {
        $ok = is_string($ligne2) || $ligne2 == null;
        if ($ok)
        {
            $this->_ligne2 = $ligne2;
        }
        return $ok;
    }

    public function setVille($ville)
    {
        $ok = $ville instanceof Ville;
        if ($ok)
        {
            $this->_ville = $ville;
        }
        return $ok;
    }
}
?>
