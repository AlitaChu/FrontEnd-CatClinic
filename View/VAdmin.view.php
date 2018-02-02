<?php

class VAdmin
{
    public function __construct(){}
    public function __destruct(){}
  
    
    public function showAdmGeneral($_data)
    {
        //debug($_data);
        // Code html (vue) de la section 'administration' --->
        
        if(!isset($_GET['id_cat'])) {
            $list_cat = '<ul>';
            foreach ($_data as $val_cat) {
                $list_cat .= '<li><a href="../Php/index.php?ex=adm&id_cat='.$val_cat['ID_CATEGORIE'].'">'.$val_cat['TITRE_CATEGORIE'].'</a></li>';
            }
            $list_cat .= '</ul>';
            $view = $list_cat;
        } else {
            $list_art = '';
            foreach ($_data as $val_art) {
                $list_art .= '<p><a href="../Php/index.php?ex=adm&id_cat='.$val_art['ID_CATEGORIE'].'&id_art='.$val_art['ID_ARTICLE'].'">'.$val_art['TITRE_ARTICLE'].'</a></p>';
            }
            $view = '<p><a href="../Php/index.php?ex=adm"><< Retour</a></p>';
            $view .= $list_art;
        }
        
        /*if(!isset($_GET['id_cat'])) {
            $view = $list_cat;
        } else {
            $view = '';
        }*/

echo <<< HERE
<div class="white callout">
            <div class="grid-container">
              <div class="grid-x grid-padding-x">
                <div class="large-3 medium-6 small-12 cell">
                  <h2>Administration</h2> 
                </div> 
                <div class="large-9 medium-6 small-12 cell">
                  <hr/> 
                </div> 
              </div>
              <div class="grid-x grid-padding-x collapse">
                <div class="medium-3 cell">
                  <ul class="vertical tabs" data-tabs id="example-tabs">
                    <li class="tabs-title is-active"><a href="../Php/index.php?ex=adm&ex2=pan1" aria-selected="true">Général</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan2">Informations clientèle</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan3">Détails consultations</a></li>
                  </ul>
                </div>
                <div class="medium-9 cell">
                  <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Général : Bienvenue dans votre espace d'administration!</h3>
                      <p>Ici vous pouvez gérer (ajouter, modifier, supprimer) les articles parus sur votre site en sélectionnant une catégorie ci-dessous, ou ajouter un nouvel article.</p>
                      $view
                      <hr/>
HERE;
        
        
        if(!isset($_GET['id_art'])) {              
echo <<< HERE
                      <form action="../Php/index.php?ex=ins" method="post" enctype="multipart/form-data">  
                        <h3>Ajouter un nouvel article:</h3>
                        <div class="grid-x grid-padding-x">
                          <div class="large-3 medium-4 cell">
                            <label>Catégorie</label>
                            <select name="categorie">
                              <option value="2">Fiches conseils</option>
                              <option value="1">Nos spécialités</option>
                              <option value="3">L'actu de la clinique</option>
                            </select>
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="alt">Description de l'image</label>
                            <input type="text" name="alt" id="alt" placeholder="Description de l'image" />
                          </div>
                          <div class="large-5 medium-4 cell">
                            <label>Image</label>
                            <input type="hidden" name="fichier_old" value="" />
                            <input id="fichier" type="file" name="image" size="150" />
                          </div>
                        </div>
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" placeholder="Titre de l'article" />
                        <label for="sstitre1">Sous-titre (opt.)</label>
                        <input type="text" name="sstitre1" id="sstitre1" placeholder="Sous-titre (optionnel)" />
                        <label for="parag1">Paragraphe</label>
                        <textarea name="parag1" id="parag1" placeholder="Paragraphe"></textarea>
                        <label for="sstitre2">Sous-titre 2 (opt.)</label>
                        <input type="text" name="sstitre2" id="sstitre2" placeholder="Sous-titre 2 (optionnel)" />
                        <label for="parag2">Paragraphe 2 (opt.)</label>
                        <textarea name="parag2" id="parag2" placeholder="Paragraphe 2 (optionnel)"></textarea>
                        <label for="sstitre3">Sous-titre 3 (opt.)</label>
                        <input type="text" name="sstitre3" id="sstitre3" placeholder="Sous-titre 3 (optionnel)" />
                        <label for="parag3">Paragraphe 3 (opt.)</label>
                        <textarea name="parag3" id="parag3" placeholder="Paragraphe 3 (optionnel)"></textarea>
                        <input type="hidden" value="arti" name="arg" />
                        <input class="button" type="submit" value="Ajouter" />
                      </form>  
HERE;
        } else {
            //debug($_data);
            $titre = $_data[0]['TITRE_ARTICLE'];
            
echo <<< HERE
                      <form action="../Php/index.php?ex=ins" method="post" enctype="multipart/form-data">  
                        <p>Modifier l'article:</p>
                        <div class="grid-x grid-padding-x">
                          <div class="large-4 medium-4 cell">
                            <label for="categorie">Catégorie</label>
                            <select name="categorie">
                              <option value="2">Fiches conseils</option>
                              <option value="1">Nos spécialités</option>
                              <option value="3">L'actu de la clinique</option>
                            </select>
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="alt">Description de l'image</label>
                            <input type="text" name="alt" id="alt" placeholder="Description de l'image" />
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="image">Image</label>
                            <input type="hidden" name="fichier_old" value="" />
                            <input id="fichier" type="file" name="image" value="" size="150" maxlength="40" />
                          </div>
                        </div>
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" placeholder="Titre de l'article" value="$titre" />
                        <label for="sstitre1">Sous-titre (opt.)</label>
                        <input type="text" name="sstitre1" id="sstitre1" placeholder="Sous-titre (optionnel)" />
                        <label for="parag1">Paragraphe</label>
                        <textarea name="parag1" id="parag1" placeholder="Paragraphe"></textarea>
                        <label for="sstitre2">Sous-titre 2 (opt.)</label>
                        <input type="text" name="sstitre2" id="sstitre2" placeholder="Sous-titre 2 (optionnel)" />
                        <label for="parag2">Paragraphe 2 (opt.)</label>
                        <textarea name="parag2" id="parag2" placeholder="Paragraphe 2 (optionnel)"></textarea>
                        <label for="sstitre3">Sous-titre 3 (opt.)</label>
                        <input type="text" name="sstitre3" id="sstitre3" placeholder="Sous-titre 3 (optionnel)" />
                        <label for="parag3">Paragraphe 3 (opt.)</label>
                        <textarea name="parag3" id="parag3" placeholder="Paragraphe 3 (optionnel)"></textarea>
                        <input type="hidden" value="arti" name="arg" />
                        <input class="button" type="submit" value="Ajouter" />
                      </form>  
HERE;
            
        }
        
echo <<< HERE
                    </div>
                    <!--
                    <div class="tabs-panel" id="panel3v">
                      <p>Tableau des consultations</p>
                      <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
HERE;
     
    }
    
    public function showAdmClients($_data)
    {
        //debug($_data);
        // Code html (vue) de la section 'administration' --->
        
        $manimal = new MAnimal();
        $data_anim = $manimal-> Select(2);
        array_walk($data_anim, 'strip_xss');
        //debug($data_anim);

echo <<< HERE
<div class="white callout">
            <div class="grid-container">
              <div class="grid-x grid-padding-x">
                <div class="large-3 medium-6 small-12 cell">
                  <h2>Administration</h2> 
                </div> 
                <div class="large-9 medium-6 small-12 cell">
                  <hr/> 
                </div> 
              </div>
              <div class="grid-x grid-padding-x collapse">
                <div class="medium-3 cell">
                  <ul class="vertical tabs" data-tabs id="example-tabs">
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan1">Général</a></li>
                    <li class="tabs-title is-active" aria-selected="true"><a href="../Php/index.php?ex=adm&ex2=pan2">Informations clientèle</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan3">Détails consultations</a></li>
                  </ul>
                </div>
                <div class="medium-9 columns">
                  <div class="tabs-content" data-tabs-content="example-tabs">
HERE;
        
        
echo <<< HERE
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Informations clientèle</h3>
                      <table>
                        <thead>
                          <tr>
                            <th width="150">Nom</th>
                            <th>Prénom</th>
                            <th width="150">Adresse</th>
                            <th width="150">Téléphone</th>
                            <th>Email</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <form>
                              <td><input type="text" placeholder="Nom" /></td>
                              <td><input type="text" placeholder="Prénom" /></td>
                              <td><input type="text" placeholder="Adresse" /></td>
                              <td><input type="text" placeholder="Téléphone" /></td>
                              <td><input type="text" placeholder="Email" /></td>
                              <td><a class="button">+</a></td>
                            </form>
                          </tr>
                          <tr>
                            <td>Nom</td>
                            <td>Prénom</td>
                            <td>Adresse</td>
                            <td>Téléphone</td>
                            <td>Email</td>
                            <td>Plus de détails</td>
                          </tr>
                          <tr>
                            <td>Nom</td>
                            <td>Prénom</td>
                            <td>Adresse</td>
                            <td>Téléphone</td>
                            <td>Email</td>
                            <td>Plus de détails</td>
                          </tr>
                          <tr>
                            <td>Nom</td>
                            <td>Prénom</td>
                            <td>Adresse</td>
                            <td>Téléphone</td>
                            <td>Email</td>
                            <td>Plus de détails</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tabs-panel" id="panel3v">
                      <p>Tableau des consultations</p>
                      <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
HERE;
     
    }
    
    public function showAdmConsultations($_data)
    {
        //debug($_data);
        // Code html (vue) de la section 'administration' --->
        
        $manimal = new MAnimal();
        $data_anim = $manimal-> Select(2);
        array_walk($data_anim, 'strip_xss');
        //debug($data_anim);

echo <<< HERE
<div class="white callout">
            <div class="grid-container">
              <div class="grid-x grid-padding-x">
                <div class="large-3 medium-6 small-12 cell">
                  <h2>Administration</h2> 
                </div> 
                <div class="large-9 medium-6 small-12 cell">
                  <hr/> 
                </div> 
              </div>
              <div class="grid-x grid-padding-x collapse">
                <div class="medium-3 cell">
                  <ul class="vertical tabs" data-tabs id="example-tabs">
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan1">Général</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan2">Informations clientèle</a></li>
                    <li class="tabs-title is-active" aria-selected="true"><a href="../Php/index.php?ex=adm&ex2=pan3">Détails consultations</a></li>
                  </ul>
                </div>
                <div class="medium-9 columns">
                  <div class="tabs-content" data-tabs-content="example-tabs">
HERE;
        
        
echo <<< HERE
                    <div class="tabs-panel is-active" id="panel3v">
                      <p>Tableau des consultations</p>
                      <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
HERE;
     
    }
    
    public function showDetails($_data)
    {
        //debug($_data);
        //echo 'avec id ='.$_GET['id'];
        // Code html (vue) de la section 'spécialités' --->
        

echo <<< HERE


HERE;
     
    }
}

?>    