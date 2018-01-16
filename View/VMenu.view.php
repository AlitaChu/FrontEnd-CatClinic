<?php

class VMenu
{
    public function showMenu()
    {
        $mcat = new MCategorie();
        $data = $mcat-> SelectCat();
        //debug($data);
        
        // Affiche seulement les 2 première catégories :
        $li_cat = '';
        for ($i = 0; $i<2; $i++)
        {
            $marticle = new MArticle();
            $vals = $marticle-> SelectAllResume($i+1);
            
            $li = '';
            foreach ($vals as $val) {
                $li .= '<li><a href="../Php/index.php?ex='.$data[$i]['AB_CONTROL'].'&id='.$val['ID_ARTICLE'].'">'.$val['TITRE_ARTICLE'].'</a></li>';
            }
            
            $li_cat .= '<li class="has-submenu">
                      <a href="../Php/index.php?ex='.$data[$i]['AB_CONTROL'].'">'.$data[$i]['TITRE_CATEGORIE'].'</a>
                      <ul class="submenu menu vertical" data-submenu>'.$li.'</ul></li>';
            
            /* Exemple liste menu :
            <li class="has-submenu">
              <a href="../Php/index.php?ex=fco">Nos conseils</a>
                <ul class="submenu menu vertical" data-submenu>
                  <li><a href="#">One</a></li>
                    <li><a href="#">Two</a></li>
                    <li><a href="#">Three</a></li>
                </ul>
            </li>
            */
        }
        
        // Code html (vue) du menu de navigation principal --->
        echo <<< HERE
<div class="top-bar-container" data-sticky-container>
        <div class="sticky" data-sticky data-options="anchor: page; marginTop: 0; stickyOn: small;">
          <div class="top-bar grid-x grid-padding-x">
            <div class="medium-12 grid-container">
              <div class="grid-x grid-padding-x"> 
                <div><a href="../Php/index.php"><img src="../img/catClinic.png" width="100px" alt="Cat Clinic"/><img src="../img/logoChat-1.png" width="35px" alt="Logo Cat Clinic"/></a></div>
                <div class="top-bar-left large-6 medium-8">
                  <ul class="dropdown menu" data-dropdown-menu>
                    $li_cat
                    <li class="has-submenu">
                      <a href="../Php/index.php?ex=inf">Infos pratiques</a>
                      <ul class="submenu menu vertical" data-submenu>
                        <li><a href="#">One</a></li>
                        <li><a href="#">Two</a></li>
                        <li><a href="#">Three</a></li>
                      </ul>
                    </li>
                    <li><a href="#">Nous contacter</a></li>
                  </ul>
                </div>
                <div class="top-bar-right">
                  <ul class="menu">
                    <li><a href="#">Mon espace</a></li>
                    <li>
                      <input type="search" placeholder="Search">
                    </li>
                    <li>
                      <button type="button" class="button">Search</button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
HERE;
    }
}

?>    