<?php

namespace Model;

class Client{

    private $_id;
    private $_codeClient;
    private $_raisonSociale;

    public function __construct($id, $codeClient, $raisonSociale){

      if(!$this->setId($id)){
          throw new \Exception("Client : id incorrect!");
      }

      if(!$this->setCodeClient($codeClient)){
          throw new \Exception("Client : code client incorrect!");
      }

      if(!$this->setRaisonSociale($raisonSociale)){
          throw new \Exception("Client : raison sociale incorrecte!");
      }
    }

    public function getId(){
      return $this->_id;
    }

    public function getCodeClient(){
      return $this->_codeClient;
    }

    public function getRaisonSociale(){
      return $this->_raisonSociale;
    }

    public function setId($id){
      $ok = is_int($id);
      if($ok){
        $this->_id = $id;
      }
      return $ok;
    }

    public function setCodeClient($codeClient){
      $ok = is_string($codeClient);
      if($ok){
        $this->_codeClient = $codeClient;
      }
      return $ok;
    }

    public function setRaisonSociale($raisonSociale){
      $ok = is_string($raisonSociale);
      if($ok){
        $this->_raisonSociale = $raisonSociale;
      }
      return $ok;
    }
}
?>
