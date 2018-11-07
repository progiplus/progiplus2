<?php
namespace Model;

class TypeMoyenComm
{
    private $_id_type_moyen_com;
    private $_libelle_type_com;
    
    public function __construct($_id_type_moyen_com, $_libelle_type_com)
    {
        
         if(!$this->setId($_id_type_moyen_com))
        {
            throw new \Exception("type_moyen_comm : id incorrect!");
        }
        if(!$this->setLibelle($_libelle_type_com))
        {
            throw new \Exception("type_moyen_comm : libelle incorrect!");
        }
    }
    public function getId()
    {
        return $this->$_libelle_type_com;
    }

    public function getLibelle()
    {
        return $this->_libelle_type_com;
    }
    
    public function setId($_id_type_moyen_com)
    {
        $ok = is_int($_id_type_moyen_com);
        if($ok)
        {
            $this->_id_type_moyen_com = $_id_type_moyen_com;
        }
        return $ok;
    }
    
    public function setLibelle($_libelle_type_com)
    {
        $ok = is_string($_libelle_type_com);
        if($ok)
        {
            $this->_libelle_type_com=$_libelle_type_com;
        }
        return $ok;
    }

}

?>
