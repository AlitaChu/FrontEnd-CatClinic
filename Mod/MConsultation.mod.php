<?php

/* Notes techniques : 
 * 5-10-2017 --> Attention au nom des tables dans les requêtes qui deviennent case-sensitive avec PHP7.1 */
class MConsultation
{
    private $conn;
    
    private $value;
    
    /* Clé primaire de la spécialité */
    private $id_consultation;

    public function __construct($_id_consultation = null)
    {
        $this-> conn = new PDO(DATABASE, LOGIN, PASSWD);
        //$this->id_consultation = $_id_consultation;
        
        // Instanciation du membre $id_consultation
        $this->id_consultation = $_id_consultation;
        
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
        $query = 'INSERT INTO consultations (DATE_CONSULTATION, ID_ANIMAL, POIDS, MOTIF, COMPTE_RENDU_SOINS,  ID_VETERINAIRE)
                  values(:DATE, :ID_ANIMAL,:POIDS, :MOTIF, :COMPTE_RENDU_SOINS, :ID_VETERINAIRE)';
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':DATE',$this->value['date_cons'], PDO::PARAM_STR);
        $result->bindValue(':ID_ANIMAL',$this->value['animal'], PDO::PARAM_INT);
        $result->bindValue(':POIDS',$this->value['poids'], PDO::PARAM_STR);
        $result->bindValue(':MOTIF',$this->value['motif'], PDO::PARAM_STR);
        $result->bindValue(':COMPTE_RENDU_SOINS',$this->value['soins'], PDO::PARAM_STR);
        $result->bindValue(':ID_VETERINAIRE',$this->value['id_veterinaire'], PDO::PARAM_INT);
        
        $test = $result->execute();
  	
        return $test;
    }
    
    //Ajouter une méthode Modify() pour switcher sur insert/update/delete
    
    public function Delete()
    {
        $query = 'delete from consultations
                  where ID_CONSULTATION = :ID_CONSULTATION';
  	
  	    $result = $this->conn->prepare($query);
  	
  	    $result->bindValue(':ID_CONSULTATION', $this->id_consultation, PDO::PARAM_INT);
  	
  	    $result->execute(); //or die ($this->Error($result));
  	
  	    return;
    }
    
    public function Update()
    {
        $query = 'update consultations
    		      set MOTIF = :MOTIF,
    		      COMPTE_RENDU_SOINS = :COMPTE_RENDU_SOINS
    		      where ID_CONSULTATION = :ID_CONSULTATION';

        $result = $this->conn->prepare($query);

        $result->bindValue(':ID_CONSULTATION', $this->id_consultation, PDO::PARAM_INT);
        $result->bindValue(':MOTIF', $this->value['motif'], PDO::PARAM_STR);
        $result->bindValue(':COMPTE_RENDU_SOINS',$this->value['soins'], PDO::PARAM_STR);
    
        $result->execute();
   
        return;
  
    } // Update()
    
    //A voir si utilisé.......
    public function SelectAll()
    {
        $query = 'select co.ID_CONSULTATION, an.NOM as NOM_ANIMAL, an.ESPECE, an.SEXE, cl.NOM, cl.PRENOM, DAY(DATE_CONSULTATION) as DAY, MONTH(DATE_CONSULTATION) as MONTH, YEAR(DATE_CONSULTATION) as YEAR, MOTIF, COMPTE_RENDU_SOINS
                  from consultations co, clients cl, animaux an
                  where an.ID_ANIMAL = co.ID_ANIMAL
                  and an.ID_CLIENT = cl.ID_CLIENT
                  order by ID_CONSULTATION desc';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_CATEGORIE', $this->id_consultation, PDO::PARAM_INT);
        
        $result->execute(); //or die ($this->Error($result));
        
        return $result->fetchAll();
    }
    
    
    // Affiche en fonction de la consultation
    public function Select()
    {
        //echo $this->id_consultation;
        $query = 'select co.ID_CONSULTATION, an.NOM as NOM_ANIMAL, RACE, ESPECE, SEXE, cl.NOM, cl.PRENOM, POIDS, MOTIF,  COMPTE_RENDU_SOINS, ID_VETERINAIRE, DAY(DATE_CONSULTATION) as DAY, MONTH(DATE_CONSULTATION) as MONTH, YEAR(DATE_CONSULTATION) as YEAR, DAY(DATE_NAISSANCE) as DAY_NAISS, MONTH(DATE_NAISSANCE) as MONTH_NAISS, YEAR(DATE_NAISSANCE) as YEAR_NAISS
                  FROM consultations co, animaux an, clients cl
                  where co.ID_CONSULTATION = :ID_CONSULTATION
                  and an.ID_ANIMAL = co.ID_ANIMAL
                  and an.ID_CLIENT = cl.ID_CLIENT';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_CONSULTATION', $this->id_consultation, PDO::PARAM_INT);
        
        $result->execute(); // or die ($this->Error($result));
        
        return $result->fetchAll();
        //debug($result);
    }
    
    // Affiche en fonction de l'animal'
    public function SelectFromAn($_id_animal)
    {
        $query = 'select ID_CONSULTATION, POIDS, ID_ANIMAL, MOTIF, COMPTE_RENDU_SOINS, ID_VETERINAIRE, DAY(DATE_CONSULTATION) as DAY, MONTH(DATE_CONSULTATION) as MONTH, YEAR(DATE_CONSULTATION) as YEAR
                  FROM consultations
                  where ID_ANIMAL = :ID_ANIMAL';
        
        $result = $this->conn->prepare($query);
        
        $result->bindValue(':ID_ANIMAL', $_id_animal, PDO::PARAM_INT);
        
        $result->execute(); // or die ($this->Error($result));
        
        return $result->fetchAll();
        //debug($result);
    }
    

}