<?php

/* Notes techniques : 
 * 5-10-2017 --> Attention au nom des tables dans les requêtes qui deviennent case-sensitive avec PHP7.1 */
class MArticle
{
    private $conn;
    
    private $value;
    
    /* Clé primaire de la spécialité */
    private $id_article;

    public function __construct($_id_article = null)
    {
        $this-> conn = new PDO(DATABASE, LOGIN, PASSWD);
        
        // Instanciation du membre $id_article
        $this->id_article = $_id_article;
        
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
        $query = 'INSERT INTO articles (TITRE_ARTICLE, DESCRIPTION, VIGNETTE, IMAGE, IMG_ALT, DATE_ARTICLE, ID_CATEGORIE)
                  values(:TITRE_ARTICLE, :DESCRIPTION, :VIGNETTE, :IMAGE, :IMG_ALT, NOW(), :ID_CATEGORIE)';
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':TITRE_ARTICLE',$this->value['titre'], PDO::PARAM_STR);
        $result->bindValue(':DESCRIPTION',$this->value['contenu'], PDO::PARAM_STR);
        $result->bindValue(':VIGNETTE',$this->value['img_vig'], PDO::PARAM_STR);
        $result->bindValue(':IMAGE',$this->value['img'], PDO::PARAM_STR);
        $result->bindValue(':IMG_ALT',$this->value['alt'], PDO::PARAM_STR);
        $result->bindValue(':ID_CATEGORIE',$this->value['categorie'], PDO::PARAM_INT);
        
        $result->execute();
  	
        return;
    }
    
    public function Update()
    {
        $img = isset($this->value['img'])? ', VIGNETTE = :VIGNETTE,
    		      IMAGE = :IMAGE' : '';
        
        $query = 'update articles
    		      set TITRE_ARTICLE = :TITRE_ARTICLE,
    		      DESCRIPTION = :DESCRIPTION,
    		      IMG_ALT = :IMG_ALT,
    		      DATE_ARTICLE = NOW(),
    		      ID_CATEGORIE = :ID_CATEGORIE
                  '.$img.'
    		      where ID_ARTICLE = :ID_ARTICLE';

        $result = $this->conn->prepare($query);

        $result->bindValue(':TITRE_ARTICLE', $this->value['titre'], PDO::PARAM_STR);
        $result->bindValue(':DESCRIPTION', $this->value['contenu'], PDO::PARAM_STR);
        $result->bindValue(':IMG_ALT', $this->value['alt'], PDO::PARAM_STR);
        $result->bindValue(':ID_CATEGORIE',$this->value['categorie'], PDO::PARAM_INT);
        $result->bindValue(':ID_ARTICLE',$this->id_article, PDO::PARAM_STR);
    
        $result->execute();
   
        return;
  
    } // Update()
    
    //A voir si utilisé.......
    /*public function SelectAll()
    {
        $query = 'select ID_ARTICLE, TITRE_ARTICLE, DESCRIPTION, VIGNETTE, IMAGE, IMG_ALT, DAY(DATE_ARTICLE) as DAY, MONTH(DATE_ARTICLE) as MONTH, YEAR(DATE_ARTICLE) as YEAR, art.ID_CATEGORIE 
                  from articles art, categories cat
                 ';
        
        $result = $this->conn->prepare($query);
        
        //$result->bindValue(':ID_CATEGORIE', $_id_categorie, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }*/
    
    /* Méthode SelectAll() allégée, pour éviter de ramener le gros texte contenu inutile pour les pages de sélection des articles */
    public function SelectAllResume($_id_categorie)
    {
        $query = 'select ID_ARTICLE, TITRE_ARTICLE, VIGNETTE, IMAGE, IMG_ALT, art.ID_CATEGORIE, cat.ID_CATEGORIE, cat.TITRE_CATEGORIE
                  from articles art, categories cat
                  where art.ID_CATEGORIE = :ID_CATEGORIE
                  and art.ID_CATEGORIE = cat.ID_CATEGORIE';
        
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
        
        $result->bindValue(':ID_ARTICLE', $this-> id_article, PDO::PARAM_INT);
        
        $result->execute(); // or die ($this->Error($result));
        
        return $result->fetchAll();
        //debug($result);
    }
    
    
    public function Delete()
    {
        $query = 'delete from articles
              where ID_ARTICLE = :ID_ARTICLE';
  	
  	    $result = $this->conn->prepare($query);
  	
  	    $result->bindValue(':ID_ARTICLE', $this->id_article, PDO::PARAM_INT);
  	
  	    $result->execute(); //or die ($this->Error($result));
  	
  	    return;
    }
    
    //Ajouter méthode Update()

}