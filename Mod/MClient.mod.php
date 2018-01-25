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
        //$this->id_article = $_id_article;
        
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
    
    //A voir si utilisé.......
    public function SelectAll($_id_categorie)
    {
        $query = 'select ID_CLIENT, NOM, PRENOM, EMAIL, PASSWD
                  from clients';
        
        $result = $this->conn->prepare($query);
        
        //$result->bindValue(':ID_CATEGORIE', $_id_categorie, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    /* Méthode SelectAll() allégée, pour éviter de ramener le gros texte contenu inutile pour les pages de sélection des articles */
    public function SelectAllResume($_id_categorie)
    {
        $query = 'select ID_ARTICLE, TITRE_ARTICLE, VIGNETTE, IMAGE, IMG_ALT, art.ID_CATEGORIE 
                  from articles art
                  where art.ID_CATEGORIE = :ID_CATEGORIE';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_CATEGORIE', $_id_categorie, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    public function Select()
    {
        //echo $this->id_article;
        $query = 'select ID_ARTICLE, TITRE_ARTICLE, DESCRIPTION, VIGNETTE, IMAGE, IMG_ALT, DAY(DATE_ARTICLE) as DAY, MONTH(DATE_ARTICLE) as MONTH, YEAR(DATE_ARTICLE) as YEAR, art.ID_CATEGORIE
                  FROM articles art
                  where ID_ARTICLE = :ID_ARTICLE';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_ARTICLE', $this->id_article, PDO::PARAM_INT);
        
        $result->execute(); // or die ($this->Error($result));
        
        return $result->fetchAll();
        //debug($result);
    }
    
    //Ajouter une méthode Modify() pour switcher sur insert/update/delete
    
    public function Delete()
    {
        $query = 'delete from articles
              where ID_ARTICLE = :ID_ARTICLE';
  	
  	    $result = $this->conn->prepare($query);
  	
  	    $result->bindValue(':ID_ARTICLE', $this->id_mail, PDO::PARAM_INT);
  	
  	    $result->execute(); //or die ($this->Error($result));
  	
  	    return;
    }
    
    //Ajouter méthode Update()

}