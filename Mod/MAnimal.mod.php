<?php

/* Notes techniques : 
 * 5-10-2017 --> Attention au nom des tables dans les requêtes qui deviennent case-sensitive avec PHP7.1 */
class MAnimal
{
    private $conn;
    
    private $value;
    
    /* Clé primaire de la spécialité */
    private $id_animal;

    public function __construct($_id_animal = null)
    {
        $this-> conn = new PDO(DATABASE, LOGIN, PASSWD);
        //$this->id_animal = $_id_animal;
        
        // Instanciation du membre $id_animal
        $this->id_animal = $_id_animal;
        
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
    
    public function SelectAll()
    {
        $query = 'select ID_ANIMAL, NOM as NOM_ANIMAL, SEXE, DATE_NAISSANCE, ID_CLIENT
                  from animaux';
        
        $result = $this->conn->prepare($query);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    /* Sélectionne les animaux en fonction des clients */
    public function Select($_id_client)
    {
        $query = 'select ID_ANIMAL, NOM, ESPECE, RACE, SEXE, DATE_NAISSANCE, ID_CLIENT
                  from animaux
                  where ID_CLIENT = :ID_CLIENT';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_CLIENT', $_id_client, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }

}