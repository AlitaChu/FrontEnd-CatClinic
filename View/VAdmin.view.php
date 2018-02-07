<?php

class VAdmin
{
    public function __construct(){}
    public function __destruct(){}
  
    
    public function showAdmGeneral($_data)
    {
        /* Code html (vue) de la section 'administration : général, gestion de la parution des articles sur le site' ---> */
        $arg = 'arti';
        $_SESSION['adm']['arg'] = $arg;
        
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
            unset($_SESSION['adm']['id_rep']);
            $img_alt = '';
            $img = '';
            $titre = '';
            $contenu = '';
            $modif = 'Ajouter un nouvel article :';
            $button = '<input class="button" type="submit" value="Ajouter l\'article" />';
            $action = 'ins';
        }else{
            $_SESSION['adm']['id_rep'] = $_GET['id_art'];
            $img_alt = $_data[0]['IMG_ALT'];
            $img = '<img src="../img/'.$_data[0]['VIGNETTE'].'" alt=""  />';
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
                          <div class="large-3 medium-3 cell">
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
                          <div class="large-5 medium-5 cell">
                            <div class="grid-x grid-padding-x">
                              <div class="large-9 medium-9 cell">
                                <label for="image">Image</label>
                                <input type="hidden" name="fichier_old" value="" />
                                <input id="fichier" type="file" name="image" value="" size="150" maxlength="40" />
                              </div>
                              <div class="large-3 medium-3 cell">
                                $img
                              </div>
                            </div>  
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
        /* Code html (vue) de la sous-section 'administration : gestion de la clientèle' ---> */
        $arg = 'user';
        $_SESSION['adm']['arg'] = $arg;
        
        // à modifier avec le bon id_client!!!! à la place du 2!!!!
        $manimal = new MAnimal();
        $data_anim = $manimal-> Select(2);
        array_walk($data_anim, 'strip_xss');
        
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
                            <input type="text" name="nom" id="nom" placeholder="Nom" />
                          </div>
                          <div class="medium-4 cell">
                            <label>Prénom :</label>
                            <input type="text" name="prenom" id="prenom" placeholder="Prénom" />
                          </div> 
                          <div class="medium-4 cell">
                            <label>EMail :</label>
                            <input type="text" name="email" id="email" placeholder="Email" />
                          </div>
                          <div class="medium-8 cell">
                            <label>Adresse :</label>
                            <input type="text" name="adresse" id="adresse" placeholder="Adresse" />
                          </div>
                          <div class="medium-4 cell">
                            <label>Téléphone :</label>
                            <input type="text" name="telephone" id="telephone" placeholder="Téléphone" />
                          </div> 
                          <div class="medium-4 cell">
                            <label>Mot de passe :</label>
                            <input type="password" name="passwd1" id="passwd1" placeholder="Mot de passe"/>
                            <input type="hidden" value="$arg" name="arg" />
                          </div>
                          <div class="medium-4 cell">
                            <label>Retapez le mot de passe :</label>
                            <input type="password" name="passwd2" id="passwd2" placeholder="Retaper le mot de passe"/>
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
        // Code html (vue) de la sous-section 'administration : gestion des consultations' --->
        
        if(!isset($_GET['id_cons'])) {
            if (!isset($_GET['form'])) {
                unset($_SESSION['adm']['id_rep']);
                $titre = '<p><a href="../Php/index.php? ex=adm&ex2=pan3&form=true" class="button">Nouvelle consultation</a></p>
                          <p>Tableau des consultations :</p>';
                $tr = '<table>
                          <thead>
                              <tr>
                                  <th width="80">Date</th>
                                  <th width="100">Animal</th>
                                  <th width="80">Espèce</th>
                                  <th width="50">Sexe</th><th>Propriétaire</th>
                                  <th>Motif consultation</th><th>Compte-rendu et soins</th><th>Actes..</th>
                              </tr>
                          </thead>
                          <tbody>';
                foreach ($_data as $val_cons) {
                    $tr .= '<tr><td>'.$val_cons['DAY'].'/'.$val_cons['MONTH'].'/'.$val_cons['YEAR'].'</td>
                    <td>'.$val_cons['NOM_ANIMAL'].'</td><td>'.$val_cons['ESPECE'].'</td><td>'.$val_cons['SEXE'].'</td><td>'.$val_cons['NOM'].' '.$val_cons['PRENOM'].'</td>
                    <td>'.$val_cons['MOTIF'].'</td>
                    <td>'.$val_cons['COMPTE_RENDU_SOINS'].'</td>
                    <td><a href="../Php/index.php?ex=adm&ex2=pan3&id_cons='.$val_cons['ID_CONSULTATION'].'">Détails</a></td></tr>';
                }
                $tr .= '</tbody></table>';
                $view = $tr; 
            } else {
            $titre = '<p><a href="../Php/index.php?ex=adm&ex2=pan3"><< Retour</a> | Ajouter une nouvelle consultation :</p>';
            $view = $this-> showFormCons();
            }
        } else {
            $_SESSION['adm']['id_rep'] = $_GET['id_cons'];
            $titre = '<p><a href="../Php/index.php?ex=adm&ex2=pan3"><< Retour</a> | Détails de la consultation :</p>';
            $view = $this-> showFormCons($_data);
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
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan2">Informations clientèle</a></li>
                    <li class="tabs-title is-active" aria-selected="true"><a href="../Php/index.php?ex=adm&ex2=pan3">Détails consultations</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 columns">
                  <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                      <p>$titre</p>
                      $view  
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
        /* Code html (vue) de la sous-section 'administration : gestion des administrateurs' ---> */
        $arg = 'admi';
        $_SESSION['adm']['arg'] = $arg;
        

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
    
    public function showFormCons($_data = null)
    {
        /* Code html (vue) de la sous-section 'administration : consultations' ---> */
        $arg = 'cons';
        $_SESSION['adm']['arg'] = $arg;
        
        /* Liste des animaux et construction du input type=select pour sélectionner l'animal (et son id_ pour insert)*/
        $manimal = new MAnimal();
        $animaux = $manimal-> SelectAll();
        array_walk($animaux, 'strip_xss');
        
        $ani_opt = '';
        foreach ($animaux as $val_anim) {
            $ani_opt .= '<option value="'.$val_anim['ID_ANIMAL'].'">'.$val_anim['NOM_ANIMAL'].'</option>';
        }
        
        if($_data) {
            $naiss = ($_data[0]['SEXE'] == 'F')? 'née' : 'né';
            $sexe = ($_data[0]['SEXE'] == 'F')? 'femelle' : 'mâle';
            $animal = '<div class="white callout"><p><strong>'.$_data[0]['NOM_ANIMAL'].'</strong>, <em> '.$naiss.' le '.$_data[0]['DAY_NAISS'].'/'.$_data[0]['MONTH_NAISS'].'/'.$_data[0]['YEAR_NAISS'].'</em></p><p>'.$_data[0]['ESPECE'].' '.$sexe.' de race '.$_data[0]['RACE'].'</p></div>';
            $poids = $_data[0]['POIDS'];
            $motif = $_data[0]['MOTIF'];
            $soins = $_data[0]['COMPTE_RENDU_SOINS'];
            $date = '<div class="white callout"><p>Consultation du '.$_data[0]['DAY'].'/'.$_data[0]['MONTH'].'/'.$_data[0]['YEAR'].'</p></div>';
            $button = '<div class="grid-x grid-padding-x"><div class="large-8 small-6 cell"><input class="button" type="submit" value="Mettre à jour les données" /></div> <div class="large-4 small-6 cell"><p class="text-right"><a class="alert button" href="../Php/index.php?ex=del">Supprimer la consultation</a></p></div></div>';
            $action = 'mod';
        } else {
            $animal = '<label for="animal">Animal</label><select name="animal">'.$ani_opt.'</select>';
            $poids = '';
            $motif = '';
            $soins = '';
            $date = '<label for="date_cons">Date de la consultation</label><input type="date" name="date_cons" id="date_cons" />';
            $button = '<input class="button" type="submit" value="Enregistrer la consultation" />';
            $action = 'ins';
        }
        
        /* Formulaire d'insertion / modification des consultations */
        $form = '<form action="../Php/index.php?ex='.$action.'" method="post">  
                        <p></p>
                        <div class="grid-x grid-padding-x">
                          <div class="large-4 medium-4 cell">
                            '.$animal.'
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="poids">Poids (kg)</label>
                            <input type="text" name="poids" id="poids" value="'.$poids.'" />
                          </div>
                          <div class="large-4 medium-4 cell">
                            '.$date.'
                          </div>
                        </div>
                        <label for="motif">Motif de la consultation, description des symptômes</label>
                        <input type="text" name="motif" id="motif" placeholder="Motif, description" value="'.$motif.'" />
                        <label for="soins">Compte-rendu de la consultation et/ou suivi des soins</label>
                        <textarea name="soins" id="soins" placeholder="Compte-rendu, suivi et soins">'.$soins.'</textarea>
                        <input type="hidden" value="'.$arg.'" name="arg" />
                        '.$button.'
                      </form>';
        
        /* Si $_data, ajout du formulaire d'insertion des actes */  
        if ($_data) {
            
            $arg = 'acte';
            
            $_SESSION['adm']['id_cons'] = $_GET['id_cons'];
            
            $macte = new MActe();
            $actes = $macte-> SelectActe($_data[0]['ID_CONSULTATION']);
            array_walk($actes, 'strip_xss');
            $nomenclature = $macte-> SelectAll();
            array_walk($nomenclature, 'strip_xss');
            if($actes) {
                $_SESSION['adm']['arg'] = $arg;
            }
            
            $act_opt = '';
            foreach ($nomenclature as $val_act) {
                $act_opt .= '<option value="'.$val_act['ID_NOMENCLATURE'].'">'.$val_act['CODE'].' : '.$val_act['DESCRIPTIF'].'</option>';
            }
            
            $ls_actes = '<table><tbody>';
            $total = 0;
            foreach ($actes as $acte) {
                $ls_actes .= '<tr><td>'.$acte['DESCRIPTIF'].'</td><td>'.$acte['TARIF'].' € TTC</td><td><a class="small alert button" href="../Php/index.php?ex=del&ex2=pan3&id_cons='.$acte['ID_CONSULTATION'].'&act='.$acte['ID_ACTE'].'">Supprimer</a></td></tr>';
                $total += $acte['TARIF'];
            }
            $ls_actes .= '<tr><td class="text-right">TOTAL : </td><td>'.$total.' € TTC</td></tr></tbody></table>';
            
            $form .= '<hr />
                      <form action="../Php/index.php?ex=ins&ex2=pan3&id_cons='.$_data[0]['ID_CONSULTATION'].'" method="post">
                        <div class="grid-x grid-padding-x">
                          <div class="large-12 medium-12 cell">
                          <p>Actes effectués et facturation :</p>
                            '.$ls_actes.'
                          </div>
                          <div class="large-6 medium-6 cell">
                            <label for="actes">Ajouter un acte :</label>
                            <select name="acte" id="acte">'
                              .$act_opt.
                            '</select>
                          </div>
                          <div class="large-2 medium-2 cell">
                            <br /><input type="submit" class="button" value="Ajouter" />
                          </div>
                        </div>
                        <input type="hidden" value="'.$arg.'" name="arg" />
                        </form>';
        }
        
        return $form;
    }
    
}

?>    