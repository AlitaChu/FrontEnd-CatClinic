<?php

class VSpecialites
{
    public function __construct(){}
    public function __destruct(){}
  
    
    public function showSpecialites($_data)
    {
        //debug($_data);
        // Code html (vue) de la section 'spécialités' --->
        
        $ls_spe = '';        
        foreach ($_data as $val)
        {
            $ls_spe.= '<div class="text-center large-2 medium-4 cell">
        <a href="../Php/index.php?ex=spe&id='.$val['ID_ARTICLE'].'"><h3>'.$val['TITRE_ARTICLE'].'</h3>
            <p><img src="../img/'.$val['IMAGE'].'" alt="'.$val['IMG_ALT'].'"/></p>
          </a>
        </div>';
        }
    
        /* Exemple
        <div class="text-center large-2 medium-4 cell">
          <a href="">
            <h3>Radiographie</h3>
            <p><img src="../img/fullsize/radiographie.jpg" alt=""/></p>
          </a>
        </div> */

echo <<< HERE
<div class="white callout">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="large-10 medium-10 small-10 cell">
          <h2> Notre engagement : des services de qualité à travers nos spécialités! </h2>
          <p>Découvrez pour chacune de nos spécialité, notre panel de services, pour votre animal:</p>
      </div> 
      <div class="large-2 medium-2 small-2 cell">
        <p><img src="" alt="Photo de Chat"/></p>
      </div> 
    </div> 
    <div class="white callout grid-x grid-padding-x align-bottom">
      $ls_spe
    </div>  
  </div>
</div>


HERE;
     
    }
}

?>    