<?php

namespace Model;

class Devis
{
    private $_id;
    private $_date;
    private $_validite;
    private $_actif;
    private $_client;

    public function __construct($id, $date, $validite, $actif, $client)
    {
        if (!$this->setId($id)) {
            throw new \Exception("Devis : Id incorrect!");
        }
        if (!$this->setDate($date)) {
            throw new \Exception("Devis : Date incorrecte!");
        }
        if (!$this->setValidite($validite)) {
            throw new \Exception("Devis : Validite incorrect!");
        }
        if (!$this->setActif($actif)) {
            throw new \Exception("Devis : Actif incorrecte!");
        }
        if (!$this->setClient($client)) {
            throw new \Exception("Devis : Client incorrect!");
        }
    }




    public function getId()
    {
        return $this->_id;
    }
    public function getDate()
    {
        return $this->_date;
    }

    public function getValidite()
    {
        return $this->_validite;
    }
    public function getActif()
    {
        return $this->_actif;
    }
    public function getClient()
    {
        return $this->_client;
    }
    public function setId($id)
    {
        $ok = is_int($id);
        if ($ok)
        {
            $this->_id = $id;
        }
        return $ok;
    }
    public function setDate($date)
    {
        $ok = is_date($date);
        if ($ok)
        {
            $this->_date = $date;
        }
        return $ok;
    }

    public function setValidite($validite)
    {
        $ok = is_int($validite);
        if ($ok)
        {
            $this->_validite = $validite;
        }
        return $ok;
    }
    public function setActif($actif)
    {
        $ok = is_bool($actif);
        if ($ok)
        {
            $this->_actif = $actif;
        }
        return $ok;
    }
    public function setClient($client)
    {
        $ok = $client instanceof Client;
        if ($ok)
        {
            $this->_client = $client;
        }
        return $ok;
    }

}
?>
