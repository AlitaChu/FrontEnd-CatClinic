<?php

class VAdmin
{
    public function __construct(){}
    public function __destruct(){}
  
    
    public function showAdmGeneral($_data)
    {
        //debug($_data);
        // Code html (vue) de la section 'administration' --->
        $arg = 'arti';
        $_SESSION['arg'] = $arg;
        
        if(!isset($_GET['id_cat'])) {
            $list_cat = '<p>Catégories :</p><ul>';
            foreach ($_data as $val_cat) {
                $list_cat .= '<li><a href="../Php/index.php?ex=adm&id_cat='.$val_cat['ID_CATEGORIE'].'">'.$val_cat['TITRE_CATEGORIE'].'</a></li>';
            }
            $list_cat .= '</ul>';
            $view = $list_cat;
        } else {
            $list_art = '<p>Articles :</p><ul>';
            foreach ($_data as $val_art) {
                $list_art .= '<li><a href="../Php/index.php?ex=adm&id_cat='.$val_art['ID_CATEGORIE'].'&id_art='.$val_art['ID_ARTICLE'].'">'.$val_art['TITRE_ARTICLE'].'</a></li>';
            }
            $cat = isset($_data[0]['TITRE_CATEGORIE']) ? ' | '.$_data[0]['TITRE_CATEGORIE'].' :' : '';
            $list_art .= '</ul>';
            $view = '<p><a href="../Php/index.php?ex=adm"><< Retour</a>'.$cat.'</p>';
            $view .= $list_art;
        }
        
        if(!isset($_GET['id_art'])) {
            unset($_SESSION['id_rep']);
            $img_alt = '';
            $img = '';
            $titre = '';
            $contenu = '';
            $modif = 'Ajouter un nouvel article :';
            $button = '<input class="button" type="submit" value="Ajouter l\'article" />';
            $action = 'ins';
        }else{
            $_SESSION['id_rep'] = $_GET['id_art'];
            $img_alt = $_data[0]['IMG_ALT'];
            $img = '';
            $titre = $_data[0]['TITRE_ARTICLE'];
            $contenu = $_data[0]['DESCRIPTION'];
            $modif = 'Modifier l\'article : <em>(Dernière modification le '.$_data[0]['DAY'].'/'.$_data[0]['MONTH'].'/'.$_data[0]['YEAR'].')</em>';
            $button = '<input class="button" type="submit" value="Modifier l\'article" /><p><a class="warning button" href="../Php/index.php?ex=del">Supprimer l\'article</a></p>';
            $action = 'mod';
        }

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
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 cell">
                  <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Général : Bienvenue dans votre espace d'administration!</h3>
                      <p>Ici vous pouvez gérer (modifier, supprimer) les articles parus sur votre site en sélectionnant une catégorie ci-dessous, ou ajouter un nouvel article.</p>
                      $view
                      <hr/>

                      <form action="../Php/index.php?ex=$action" method="post" enctype="multipart/form-data">  
                        <p>$modif</p>
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
                            <input type="text" name="alt" id="alt"  value="$img_alt" placeholder="Description de l'image" />
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
                        <textarea name="parag1" id="parag1" placeholder="Paragraphe">$contenu</textarea>
                        <label for="sstitre2">Sous-titre 2 (opt.)</label>
                        <input type="text" name="sstitre2" id="sstitre2" placeholder="Sous-titre 2 (optionnel)" />
                        <label for="parag2">Paragraphe 2 (opt.)</label>
                        <textarea name="parag2" id="parag2" placeholder="Paragraphe 2 (optionnel)"></textarea>
                        <label for="sstitre3">Sous-titre 3 (opt.)</label>
                        <input type="text" name="sstitre3" id="sstitre3" placeholder="Sous-titre 3 (optionnel)" />
                        <label for="parag3">Paragraphe 3 (opt.)</label>
                        <textarea name="parag3" id="parag3" placeholder="Paragraphe 3 (optionnel)"></textarea>
                        <input type="hidden" value="$arg" name="arg" />
                        $button
                      </form>  

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
        $arg = 'user';
        $_SESSION['arg'] = $arg;
        
        $manimal = new MAnimal();
        $data_anim = $manimal-> Select(2);
        array_walk($data_anim, 'strip_xss');
        //debug($data_anim);
        
        $tr = '';
        foreach ($_data as $val_cli) {
                $tr .= '<tr><td>'.$val_cli['NOM'].'</td><td>'.$val_cli['PRENOM'].'</td><td>'.$val_cli['ADRESSE'].'</td><td>'.$val_cli['TELEPHONE'].'</td><td>'.$val_cli['EMAIL'].'</td><td><a href="../Php/index.php?ex=adm&ex2=pan2&id_cli='.$val_cli['ID_CLIENT'].'">Détails</a></td></tr>';
            }

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
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 cell">
                  <div class="tabs-content" data-tabs-content="example-tabs">
HERE;
        
        
echo <<< HERE
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Informations clientèle</h3>
                      <p>Ajouter un nouveau client :</p>
                      <form action="../Php/index.php?ex=ins" method="post">
                        <div class="grid-x grid-padding-x">
                          <div class="medium-4 cell">
                            <label>Nom :</label>
                            <input type="text" placeholder="Nom" />
                          </div>
                          <div class="medium-4 cell">
                            <label>Prénom :</label>
                            <input type="text" placeholder="Prénom" />
                          </div> 
                          <div class="medium-4 cell">
                            <label>EMail :</label>
                            <input type="text" placeholder="Email" />
                          </div>
                          <div class="medium-8 cell">
                            <label>Adresse :</label>
                            <input type="text" placeholder="Adresse" />
                          </div>
                          <div class="medium-4 cell">
                            <label>Téléphone :</label>
                            <input type="text" placeholder="Téléphone" />
                          </div> 
                          <div class="medium-4 cell">
                            <label>Mot de passe :</label>
                            <input type="password" placeholder="Mot de passe"/>
                            <input type="hidden" value="$arg" name="arg" />
                          </div>
                          <div class="medium-4 cell">
                            <label>Retapez le mot de passe :</label>
                            <input type="password" placeholder="Retaper le mot de passe"/>
                          </div>
                          <div class="medium-12 cell">
                            <input class="button" type="submit" value="Ajouter" />
                          </div>
                        </div>          
                      </form>
                      <hr/>
                      <p>Liste des clients :</p>
                      <table>
                        <thead>
                          <tr>
                            <th width="120">Nom</th>
                            <th width="120">Prénom</th>
                            <th width="120">Adresse</th>
                            <th width="100">Téléphone</th>
                            <th>Email</th>
                            <th>Ajout et détails animaux</th>
                          </tr>
                        </thead>
                        <tbody>
                          $tr  
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
        $arg = 'cons';
        $_SESSION['arg'] = $arg;
        

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
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 columns">
                  <div class="tabs-content" data-tabs-content="example-tabs">
HERE;
        
        
echo <<< HERE
                    <div class="tabs-panel is-active" id="panel1v">
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
    
    public function showAdmAdmin($_data)
    {
        //debug($_data);
        // Code html (vue) de la section 'administration' --->
        $arg = 'admi';
        $_SESSION['arg'] = $arg;
        

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
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan3">Détails consultations</a></li>
                    <li class="tabs-title is-active" aria-selected="true"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 columns">
                  <div class="tabs-content" data-tabs-content="example-tabs">
HERE;
        
        
echo <<< HERE
                    <div class="tabs-panel is-active" id="panel1v">
                      <p>Gestion des administrateurs</p>
                      <p>Check me out! I'm a super cool Tab panel with text content!</p>
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