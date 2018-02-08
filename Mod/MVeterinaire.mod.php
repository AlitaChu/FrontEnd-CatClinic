<?php

/* Notes : 
 * --> Attention au nom des tables dans les requêtes qui deviennent case-sensitive */
class MVeterinaire
{
    private $conn;
    
    private $value;
    
    /* Clé primaire de l'acte' */
    private $id_veterinaire;

    public function __construct($_id_veterinaire = null)
    {
        $this-> conn = new PDO(DATABASE, LOGIN, PASSWD);
        
        $this->id_veterinaire = $_id_veterinaire;
        
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
        $query = 'INSERT INTO veterinaires (NOM, PRENOM, EMAIL, PASSWD, IMAGE, IMG_ALT, FONCTION, IS_VISIBLE, IS_ADMIN)
                  VALUES (:NOM, :PRENOM, :EMAIL, :PASSWD, :IMAGE, :IMG_ALT, :FONCTION, :IS_VISIBLE, :IS_ADMIN)
                  ';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':NOM', $this->value['nom'], PDO::PARAM_STR);
        $result->bindValue(':PRENOM', $this->value['premon'], PDO::PARAM_STR);
        $result->bindValue(':EMAIL', $this->value['email'], PDO::PARAM_STR);
        $result->bindValue(':PASSWD', $this->value['passwd'], PDO::PARAM_STR);
        $result->bindValue(':IMAGE', $this->value['img_veto'], PDO::PARAM_STR);
        $result->bindValue(':IMG_ALT', $this->value['img_alt'], PDO::PARAM_STR);
        $result->bindValue(':FONCTION', $this->value['fonction'], PDO::PARAM_STR);
        $result->bindValue(':IS_VISIBLE', $this->value['visible'], PDO::PARAM_INT);
        $result->bindValue(':IS_ADMIN', $this->value['admin'], PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    /* Sélectionne toute la nomenclature des actes pour menu select */
    public function SelectAll()
    {
        $query = 'select ID_VETERINAIRE, NOM, PRENOM, EMAIL, PASSWD, IMAGE, IMG_ALT, FONCTION, IS_VISIBLE, IS_ADMIN
                  from veterinaires';
        
        $result = $this->conn->prepare($query);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    /* Sélectionne les actes en fonction de la consultation */
    public function Select()
    {
        $query = 'select ID_VETERINAIRE, NOM, PRENOM, EMAIL, PASSWD, IMAGE, IMG_ALT, FONCTION, IS_VISIBLE, IS_ADMIN
                  from veterinaires
                  where ID_VETERINAIRE = :ID_VETERINAIRE
                  ';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_VETERINAIRE', $this->id_veterinaire, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    public function Delete()
    {
        $query = 'delete from actes
                  where ID_ACTE = :ID_ACTE';
  	
  	    $result = $this->conn->prepare($query);
  	
  	    $result->bindValue(':ID_ACTE', $this->id_veterinaire, PDO::PARAM_INT);
  	
  	    $result->execute(); //or die ($this->Error($result));
  	
  	    return;
    }

}