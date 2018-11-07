<?php

namespace Model;

class MoyenComm
{
    private $_id_moyenCom;
    private $_coordonees;
    private $_typeMoyenCom;
    
    public function __construct($id_moyenCom, $coordonnees, $typeMoyenCom)
    {
        if(!$this->setId($id_moyenCom))
        {
            throw new \Exception("MoyenComm : id incorrect!");
        }
        if(!$this->setCoordonnees($coordonnees))
        {
            throw new \Exception("MoyenCom : coordonees incorrect!");
        }
        if(!$this->setTypeMoyenCom($typeMoyenCom))
        {
            throw new \Exception("MoyenCom : typeMoyenCom incorrect!");
        }
            
    }
    public function getId()
    {
        return $this->_id_moyenCom;
    }
    public function getCoordonnees(){
        return $this->_coordonees;
    }
	public function getTypeMoyenCom(){
		return $this->_typeMoyenCom;
	}
    
    
    public function setId($id_moyenCom)
    {
        $ok = is_int($id_moyenCom);
        if($ok)
        {
            $this->_id_moyenCom = $id_moyenCom;
        }
        return $ok;
    }
    public function setCoordonnees($coordonees)
    {
        $ok =is_string($coordonees);
        if($ok)
           {
              $this->_coordonees = $coordonees;
           }
        return $ok;
        
            
    }
     public function setTypeMoyenCom($typeMoyenCom)
    {
        $ok =is_string($typeMoyenCom);
        if($ok)
           {
              $this->_typeMoyenCom = $typeMoyenCom;
           }
        return $ok;
            
    }
}
    
?>