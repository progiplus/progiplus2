<?php

namespace Model;

class Facture
{
    private $_id;
    private $_date;
    private $_actif;
    private $_adresse;
    private $_client;

    public function __construct($id, $date, $actif, $adresse, $client)
    {
        if (!$this->setId($id)) {
            throw new \Exception("facture : Id incorrect!");
        }
        if (!$this->setDate($date)) {
            throw new \Exception("facture : Date incorrecte!");
        }
        if (!$this->setActif($actif)) {
            throw new \Exception("facture : Actif incorrect!");
        }
        if (!$this->setAdresse($adresse)) {
            throw new \Exception("facture : Adresse incorrecte!");
        }
        if (!$this->setClient($client)) {
            throw new \Exception("facture : Client incorrect!");
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
    public function getActif()
    {
        return $this->_actif;
    }
    public function getAdresse()
    {
        return $this->_adresse;
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
    public function setActif($actif)
    {
        $ok = is_bool($actif);
        if ($ok)
        {
            $this->_actif = $actif;
        }
        return $ok;
    }
    public function setAdresse($adresse)
    {
        $ok = $adresse instanceof Adresse;
        if ($ok)
        {
            $this->_adresse = $adresse;
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