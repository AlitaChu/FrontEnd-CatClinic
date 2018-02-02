<?php

/* Notes techniques : 
 * 5-10-2017 --> Attention au nom des tables dans les requêtes qui deviennent case-sensitive avec PHP7.1 */
class MClient
{
    private $conn;
    
    private $value;
    
    /* Clé primaire de la spécialité */
    private $id_client;

    public function __construct($_id_client = null)
    {
        $this-> conn = new PDO(DATABASE, LOGIN, PASSWD);
        
        // Instanciation du membre $id_article
        $this->id_client = $_id_client;
        
        return;
    }

    public function __destruct() {}

    public function setValue($_value)
    {
        $this-> value = $_value;
        //echo 'Tableau this->value';
        //debug($this-> value);
        return;
    }
    
    public function Insert()
    {
        $query = 'INSERT INTO clients (NOM, PRENOM, EMAIL, PASSWD, ADRESSE,  TELEPHONE)
                  values(:NOM, :PRENOM, :EMAIL, :PASSWD, :ADRESSE, :TELEPHONE)';
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':NOM',$this->value['nom'], PDO::PARAM_STR);
        $result->bindValue(':PRENOM',$this->value['prenom'], PDO::PARAM_STR);
        $result->bindValue(':EMAIL',$this->value['email'], PDO::PARAM_STR);
        $result->bindValue(':PASSWD',$this->value['passwd'], PDO::PARAM_STR);
        $result->bindValue(':ADRESSE',$this->value['adresse'], PDO::PARAM_STR);
        $result->bindValue(':TELEPHONE',$this->value['telephone'], PDO::PARAM_STR);
        
        $result->execute();
  	
        return;
    }
    
    //OK, voir pour ajouter un order by etc... pour tri rapide!
    public function SelectAll()
    {
        $query = 'select ID_CLIENT, NOM, PRENOM, EMAIL, PASSWD, ADRESSE, TELEPHONE
                  from clients';
        
        $result = $this->conn->prepare($query);
        
        //$result->bindValue(':ID_CATEGORIE', $_id_categorie, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    
    public function Select()
    {
        //echo $this->id_article;
        $query = 'select ID_CLIENT, NOM, PRENOM, EMAIL, PASSWD, ADRESSE, TELEPHONE
                  FROM clients
                  where ID_CLIENT = :ID_CLIENT';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_CLIENT', $this->id_client, PDO::PARAM_INT);
        
        $result->execute(); // or die ($this->Error($result));
        
        return $result->fetchAll();
        //debug($result);
    }
    
    //Ajouter une méthode Modify() pour switcher sur insert/update/delete
    
    public function Delete()
    {
        $query = 'delete from clients
              where ID_CLIENT = :ID_CLIENT';
  	
  	    $result = $this->conn->prepare($query);
  	
  	    $result->bindValue(':ID_CLIENT', $this->id_client, PDO::PARAM_INT);
  	
  	    $result->execute(); //or die ($this->Error($result));
  	
  	    return;
    }
    
    //Ajouter méthode Update()

}