<?php

/* Notes techniques : 
 * 5-10-2017 --> Attention au nom des tables dans les requêtes qui deviennent case-sensitive avec PHP7.1 */
class MCategorie
{
    private $conn;
    
    private $value;
    
    /* Clé primaire de la spécialité */
    private $id_categorie;

    public function __construct($_id_categorie = null)
    {
        $this-> conn = new PDO(DATABASE, LOGIN, PASSWD);
        //$this->id_article = $_id_article;
        
        // Instanciation du membre $id_article
        $this->id_categorie = $_id_categorie;
        
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
    
    /* Sélectionne les catégories */
    public function SelectCat()
    {
        $query = 'select ID_CATEGORIE, TITRE_CATEGORIE, AB_CONTROL
                  from categories';
        
        $result = $this->conn->prepare($query);
        
        //$result->bindValue(':ID_CATEGORIE', $_id_categorie, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }

}