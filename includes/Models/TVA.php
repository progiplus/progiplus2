<?php

namespace Model;

class TVA
{
    private $_taux;
    private $_actif;
    
    public function __construct($taux, $actif)
    {
        // Chaque setter renvoit vrai ou faux selon qu'il ait effectu� l'action ou non
        // On l�ve une exception si un setter renvoit faux.
        if(!$this->setTaux($taux))
        {
            throw new \Exception("TVA : taux incorrect!");
        }
        if(!$this->setActif($actif))
        {
            throw new \Exception("TVA : actif incorrect!");
        }
    }
    
    public function getTaux()
    {
        return $this->_taux;
    }
    
    public function getActif()
    {
        return $this->_actif;
    }
    
    public function setTaux($taux)
    {
        $ok = is_numeric($taux) && $taux <= 1;
        if($ok)
        {
            $this->_taux = $taux;
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
    
}

?>