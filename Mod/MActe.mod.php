<?php

/* Notes : 
 * --> Attention au nom des tables dans les requêtes qui deviennent case-sensitive */
class MActe
{
    private $conn;
    
    private $value;
    
    /* Clé primaire de l'acte' */
    private $id_acte;

    public function __construct($_id_acte = null)
    {
        $this-> conn = new PDO(DATABASE, LOGIN, PASSWD);
        
        $this->id_acte = $_id_acte;
        
        return;
    }

    public function __destruct() {}

    public function setValue($_value)
    {
        $this-> value = $_value;
        
        return;
    }
    
    public function Insert()
    {
        $query = 'INSERT INTO actes (ID_CONSULTATION, ID_NOMENCLATURE)
                  VALUES (:ID_CONSULTATION, :ID_NOMENCLATURE)
                  ';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_CONSULTATION', $this->value['id_cons'], PDO::PARAM_INT);
        $result->bindValue(':ID_NOMENCLATURE', $this->value['acte'], PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    /* Sélectionne toute la nomenclature des actes pour menu select */
    public function SelectAll()
    {
        $query = 'select ID_NOMENCLATURE, CODE, DESCRIPTIF
                  from nomenclatures';
        
        $result = $this->conn->prepare($query);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    /* Sélectionne les actes en fonction de la consultation */
    public function SelectActe($_id_consultation)
    {
        $query = 'select ID_ACTE, ID_CONSULTATION, CODE, DESCRIPTIF, TARIF
                  from actes ac, nomenclatures no
                  where ID_CONSULTATION = :ID_CONSULTATION
                  and ac.ID_NOMENCLATURE = no.ID_NOMENCLATURE
                  ';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_CONSULTATION', $_id_consultation, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    public function Delete()
    {
        $query = 'delete from actes
                  where ID_ACTE = :ID_ACTE';
  	
  	    $result = $this->conn->prepare($query);
  	
  	    $result->bindValue(':ID_ACTE', $this->id_acte, PDO::PARAM_INT);
  	
  	    $result->execute(); //or die ($this->Error($result));
  	
  	    return;
    }

}