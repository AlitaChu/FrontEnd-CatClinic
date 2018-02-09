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
            $nom_cat = isset($_data[0]['TITRE_CATEGORIE']) ? ' | '.$_data[0]['TITRE_CATEGORIE'].' :' : '';
            $list_art .= '</ul>';
            $cat = isset($_GET['id_art'])? '&id_cat='.$_data[0]['ID_CATEGORIE'] : '';
            $view = '<p><a href="../Php/index.php?ex=adm'.$cat.'"><< Retour</a>'.$nom_cat.'</p>';
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
            $button = '<div class="grid-x grid-padding-x"><div class="large-8 small-6 cell"><input class="button" type="submit" value="Modifier l\'article" /></div> <div class="large-4 small-6 cell"><p class="text-right"><a class="alert button" href="../Php/index.php?ex=del">Supprimer l\'article</a></p></div></div>';
            $action = 'mod';
        }
        
        $options = '';
        $mcat = new MCategorie();
        $ls = $mcat-> SelectCat();
  	    foreach ($ls as $val)
  	    {
            $selected = ((isset($_GET['id_art']) && $val['ID_CATEGORIE'] == $_GET['id_cat'])) ? ' selected="selected"' : '';
  	  
  	        $options .= '<option value="' . $val['ID_CATEGORIE'].'"'. $selected.'>'.$val['TITRE_CATEGORIE'].'</option>';
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
                    <li class="tabs-title is-active"><a href="../Php/index.php?ex=adm&ex2=pan1">Général</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan2">Gestion Clientèle / Animaux</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan3">Consultations et détails Facturation</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion Equipe / Administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 cell">
                  <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Général : Bienvenue dans votre espace d'administration!</h3>
                      <p>Ici vous pouvez gérer (modifier, supprimer) les articles parus sur votre site en les sélectionnant dans les catégories ci-dessous, ou ajouter un nouvel article.</p>
                      $view
                      <hr/>

                      <form action="../Php/index.php?ex=$action" method="post" enctype="multipart/form-data">  
                        <p>$modif</p>
                        <div class="grid-x grid-padding-x">
                          <div class="large-3 medium-3 cell">
                            <label for="categorie">Catégorie</label>
                            <select name="categorie" id="categorie">
                              $options
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
                                <input id="image" type="file" name="image" size="150" />
                              </div>
                              <div class="large-3 medium-3 cell">
                                $img
                              </div>
                            </div>  
                          </div>
                        </div>
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" placeholder="Titre de l'article" value="$titre" />
                        <div class="grid-x grid-padding-x">
                          <div class="large-8 medium-8 cell">
                            <label for="contenu">Paragraphe</label>
                            <textarea rows="15" name="contenu" id="contenu" placeholder="Contenu de l'article">$contenu</textarea>
                          </div>  
                          <div class="large-4 medium-4 cell">
                            <p>Balises utilisables :<br/>
                              <ul>
                                <li>Ajouter un sous-titre: 
                                <xmp><h3>Mon sous-titre</h3></xmp></li>
                                <li>Ajouter un paragraphe:<xmp><p>Contenu (texte) de mon paragraphe...</p></xmp></li>
                                <li>Ajouter une liste:<xmp><ul>
  <li>Premier élément de la liste</li>
  <li>Second élément... etc..</li>
</ul></xmp></li>
                                <li>Ajouter une liste ordonnée numérotée):<xmp><ol></ol></xmp></li>
                              </ul>
                          </div>
                        </div>
                        
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
        
        if(!isset($_GET['id_cli'])) {
            if (!isset($_GET['form'])) {
                unset($_SESSION['adm']['id_rep']);
                $titre = '<p><a href="../Php/index.php? ex=adm&ex2=pan2&form=true" class="button">Ajouter un nouveau client</a></p>
                          <h4 class="h5">Liste des clients :</h4>';
                $tr = '<table>
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
                        <tbody>';
                foreach ($_data as $val_client) {
                    $tr .= '<tr><td>'.$val_client['NOM'].'</td><td>'.$val_client['PRENOM'].'</td><td>'.$val_client['ADRESSE'].'</td><td>'.$val_client['TELEPHONE'].'</td><td>'.$val_client['EMAIL'].'</td><td><a href="../Php/index.php?ex=adm&ex2=pan2&id_cli='.$val_client['ID_CLIENT'].'">Détails</a></td></tr>';
                }
                $tr .= '</tbody></table>';
                $view = $tr; 
            } else {
            $titre = '<p><a href="../Php/index.php?ex=adm&ex2=pan2"><< Retour</a> | Ajouter un  nouveau client :</p>';
            $view = $this-> showFormClient();
            }
        } else {
            $_SESSION['adm']['id_rep'] = $_GET['id_cli'];
            $titre = '<p><a href="../Php/index.php?ex=adm&ex2=pan2"><< Retour</a> | Informations client :</p>';
            $view = $this-> showFormClient($_data);
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
                    <li class="tabs-title is-active"><a href="../Php/index.php?ex=adm&ex2=pan2">Gestion Clientèle / Animaux</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan3">Consultations et détails Facturation</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion Equipe / Administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 cell">
                  <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Gestion Clientèle / Animaux</h3>
                      <p>Ici vous pouvez gérer les informations relatives à la clientèle, ainsi qu'aux animaux.</p>
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
    
    public function showFormClient($_data = null)
    {
        /* Code html (vue) du formulaire 'administration : gestion clientèle' ---> */
        $arg = 'user';
        $_SESSION['adm']['arg'] = $arg;
        
        if($_data) {
            $nom = $_data[0]['NOM'];
            $prenom = $_data[0]['PRENOM'];
            $email = $_data[0]['EMAIL'];
            $adresse = $_data[0]['ADRESSE'];
            $tel = $_data[0]['TELEPHONE'];
            $button = '<div class="grid-x grid-padding-x"><div class="large-8 small-6 cell"><input class="button" type="submit" value="Mettre à jour les données" /></div> <div class="large-4 small-6 cell"><p class="text-right"><a class="alert button" href="../Php/index.php?ex=del">Supprimer le client</a></p></div></div>';
            $action = 'mod';
        } else {
            $nom = '';
            $prenom = '';
            $email = '';
            $adresse = '';
            $tel = '';
            $button = '<input class="button" type="submit" value="Enregistrer le client" />';
            $action = 'ins';
        }
        
        /* Formulaire d'insertion / modification des clients */
        $form = '<form action="../Php/index.php?ex='.$action.'" method="post">
                        <div class="grid-x grid-padding-x">
                          <div class="medium-4 cell">
                            <label for="nom">Nom :</label>
                            <input type="text" name="nom" id="nom" value="'.$nom.'" placeholder="Nom" />
                          </div>
                          <div class="medium-4 cell">
                            <label for="prenom">Prénom :</label>
                            <input type="text" name="prenom" id="prenom" value="'.$prenom.'" placeholder="Prénom" />
                          </div> 
                          <div class="medium-4 cell">
                            <label for="email">EMail :</label>
                            <input type="text" name="email" id="email" value="'.$email.'" placeholder="Email" />
                          </div>
                          <div class="medium-8 cell">
                            <label for="adresse">Adresse :</label>
                            <input type="text" name="adresse" id="adresse" value="'.$adresse.'" placeholder="Adresse" />
                          </div>
                          <div class="medium-4 cell">
                            <label for="telephone">Téléphone :</label>
                            <input type="text" name="telephone" id="telephone" value="'.$tel.'" placeholder="Téléphone" />
                          </div> 
                          <div class="medium-4 cell">
                            <label>Mot de passe :</label>
                            <input type="password" name="passwd1" id="passwd1" placeholder="Mot de passe"/>
                            <input type="hidden" value="'.$arg.'" name="arg" />
                          </div>
                          <div class="medium-4 cell">
                            <label>Retapez le mot de passe :</label>
                            <input type="password" name="passwd2" id="passwd2" placeholder="Retaper le mot de passe"/>
                          </div>
                          <div class="medium-12 cell">
                            '.$button.'
                          </div>
                        </div>          
                      </form>';
        
        /* Si $_data, ajout du formulaire d'insertion des animaux */  
        if ($_data) {
            
            $arg = 'anim';
            
            $_SESSION['adm']['id_client'] = $_GET['id_cli'];
            
            $manimal = new MAnimal();
            $animaux = $manimal-> Select($_data[0]['ID_CLIENT']);
            array_walk($animaux, 'strip_xss');
            
            if($animaux) {
                $_SESSION['adm']['arg'] = $arg;
            }
            
            $ls_anim = '<table><tbody>';
            $total = 0;
            foreach ($animaux as $animal) {
                $sexe = ($animal['SEXE'] == 'M')? 'mâle' : 'femelle';
                $naiss = ($animal['SEXE'] == 'M')? 'né' : 'née';
                $ls_anim .= '<tr><td><strong>'.$animal['NOM'].'</strong></td><td>'.$animal['ESPECE'].' '.$sexe.'</td><td>De race '.$animal['RACE'].'</td>
                <td>'.$naiss.' le '.$animal['DAY'].'/'.$animal['MONTH'].'/'.$animal['YEAR'].'</td>
                <td><a class="small alert button" href="../Php/index.php?ex=del&ex2=pan2&id_cli='.$animal['ID_CLIENT'].'&ani='.$animal['ID_ANIMAL'].'">Supprimer</a></td></tr>';
            }
            $ls_anim .= '</tbody></table>';
            
            if(!$animaux) {
                $ls_anim = '<p class="text-center">Aucun animal n\'est enregistré sur ce compte.</p>';
            }
            
            $form .= '<hr />
                      <form action="../Php/index.php?ex=ins" method="post">
                        <div class="grid-x grid-padding-x">
                          <div class="large-12 medium-12 cell">
                          <h3>Animaux enregistrés :</h3>
                            '.$ls_anim.'
                          <h3>Ajouter un animal :</h3>
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="nom_animal">Nom de l\'animal</label>
                            <input type="text" name="nom_animal" id="nom_animal" placeholder="Nom de l\'animal" />
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="espece">Espece</label>
                            <input type="text" name="espece" id="espece" placeholder="ex: Chat, Tigre, Lynx..." />
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="race">Race de l\'animal</label>
                            <input type="text" name="race" id="race" placeholder="Race de l\'animal" />
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label>Sexe de l\'animal</label>
                            <input type="radio" name="sexe" value="M" id="male">
                            <label for="male">Mâle</label>
                            <input type="radio" name="sexe" value="F" id="femelle">
                            <label for="femelle">Femelle</label>
                          </div>
                          <div class="large-4 medium-4 cell">
                            <label for="date_naiss">Né(e) le</label>
                            <input type="date" name="date_naiss" id="date_naiss">
                          </div>
                          <div class="large-12 medium-12 cell">
                          <input type="hidden" value="'.$arg.'" name="arg" />
                            <br /><input type="submit" class="button" value="Ajouter" />
                          </div>
                        </div>
                        </form>';
        }
        
        return $form;
    }
    
    public function showAdmConsultations($_data)
    {
        // Code html (vue) de la sous-section 'administration : gestion des consultations' --->
        
        if(!isset($_GET['id_cons'])) {
            if (!isset($_GET['form'])) {
                unset($_SESSION['adm']['id_rep']);
                $titre = '<p><a href="../Php/index.php? ex=adm&ex2=pan3&form=true" class="button">Nouvelle consultation</a></p>
                          <h4 class="h5">Tableau des consultations :</h4>';
                $tr = '<table>
                          <thead>
                              <tr>
                                  <th width="80">Date</th>
                                  <th width="100">Animal</th>
                                  <th width="80">Espèce</th>
                                  <th width="50">Sexe</th><th>Propriétaire</th>
                                  <th>Motif consultation</th><th>Compte-rendu et soins</th><th>Détails actes</th>
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
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan2">Gestion Clientèle / Animaux</a></li>
                    <li class="tabs-title is-active"><a href="../Php/index.php?ex=adm&ex2=pan3">Consultations et détails Facturation</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion Equipe / Administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 columns">
                  <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Consultations et détails Facturation</h3>
                      <p>Ici vous pouvez gérer l'ensemble des consultations, en ajouter de nouvelles, modifier les informations ou les supprimer, ainsi que les actes facturés.</p>
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
    
    public function showFormCons($_data = null)
    {
        /* Code html (vue) du formulaire 'administration : consultations' ---> */
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
    
    public function showAdmAdmin($_data)
    {
        //debug($_data);
        /* Code html (vue) de la sous-section 'administration : gestion des administrateurs' ---> */
        $arg = 'admi';
        $_SESSION['adm']['arg'] = $arg;
        
        $tr = '';
        foreach ($_data as $val_vet) {
                $equipe = ($val_vet['IS_VISIBLE'] == true)? 'OUI' : 'NON';
                $admin = ($val_vet['IS_ADMIN'] == true)? 'OUI' : 'NON';
                $tr .= '<tr><td>'.$val_vet['NOM'].'</td><td>'.$val_vet['PRENOM'].'</td><td>'.$val_vet['EMAIL'].'</td><td>'.$val_vet['FONCTION'].'</td>
                <td>'.$equipe.'</td>
                <td>'.$admin.'</td><td><a href="../Php/index.php?ex=adm&ex2=pan4&id_vet='.$val_vet['ID_VETERINAIRE'].'">Détails</a></td></tr>';
                $chek_visible = ((isset($_GET['id_vet']) && $val_vet['IS_VISIBLE'] == true)) ? 'checked' : '';
                $chek_admin = ((isset($_GET['id_vet']) && $val_vet['IS_ADMIN'] == true)) ? 'checked' : '';
        }
        
        if(!isset($_GET['id_vet'])) {
            unset($_SESSION['adm']['id_rep']);
            $nom = '';
            $prenom = '';
            $email = '';
            $fonction = '';
            $img_alt = '';
            $titre = 'Ajouter nouveau Membre d\'équipe / Administrateur :';
            $button = '<input class="button" type="submit" value="Ajouter" />';
            $action = 'ins';
            $view = '<hr /><h4 class="h5">Liste des membres de l\'équipe et Administrateurs :</h4>
                      <table>
                        <thead>
                          <tr>
                            <th width="120">Nom</th>
                            <th width="120">Prénom</th>
                            <th width="120">Email</th>
                            <th width="100">Fonction</th>
                            <th width="100">Membre de l\'équipe</th>
                            <th width="100">Administrateur</th>
                            <th>Ajout et détails compte</th>
                          </tr>
                        </thead>
                        <tbody>'.$tr.'</tbody>
                      </table>';
        } else {
            $_SESSION['adm']['id_rep'] = $_GET['id_vet'];
            $nom = $_data[0]['NOM'];
            $prenom = $_data[0]['PRENOM'];
            $email = $_data[0]['EMAIL'];
            $fonction = $_data[0]['EMAIL'];
            $img_alt = $_data[0]['EMAIL'];
            $titre = '<p><a href="../Php/index.php?ex=adm&ex2=pan4"><< Retour</a> | Informations personnelles (vous pouvez les modifier, ou les supprimer)</p>';
            $button = '<div class="grid-x grid-padding-x"><div class="large-8 small-6 cell"><input class="button" type="submit" value="Mettre à jour les données" /></div> <div class="large-4 small-6 cell"><p class="text-right"><a class="alert button" href="../Php/index.php?ex=del">Supprimer membre / administrateur</a></p></div></div>';
            $action = 'mod';
            $view = '';
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
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan2">Gestion Clientèle / Animaux</a></li>
                    <li class="tabs-title"><a href="../Php/index.php?ex=adm&ex2=pan3">Consultations et détails Facturation</a></li>
                    <li class="tabs-title is-active"><a href="../Php/index.php?ex=adm&ex2=pan4">Gestion Equipe / Administrateurs</a></li>
                  </ul>
                </div>
                <div class="medium-9 columns">
                  <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                      <h3>Gestion Equipe / Administrateurs</h3>
                      <p>Ici vous pouvez gérer les membres de l'équipe médicale, les informations visibles sur le site, et déterminer les droits concernant l'administration du site.</p>
                      <p>$titre</p>
                      <form action="../Php/index.php?ex=$action" method="post">
                          <div class="grid-x grid-padding-x">
                            <div class="medium-4 cell">
                              <label for="nom">Nom :</label>
                              <input type="text" name="nom" id="nom" value="$nom" placeholder="Nom" />
                            </div>
                            <div class="medium-4 cell">
                              <label for="prenom">Prénom :</label>
                              <input type="text" name="prenom" id="prenom" value="$prenom" placeholder="Prénom" />
                            </div> 
                            <div class="medium-4 cell">
                              <label for="email">EMail :</label>
                              <input type="text" name="email" id="email" value="$email" placeholder="Email" />
                            </div>
                            <div class="medium-4 cell">
                              <label for="image">Photo</label>
                              <input type="hidden" name="fichier_old" value="" />
                              <input id="image" type="file" name="image" size="150" />
                            </div>
                            <div class="medium-8 cell">
                              <label for="img_alt">Description de la photo :</label>
                              <input type="text" name="img_alt" id="img_alt" value="$img_alt" placeholder= />
                            </div>
                            <div class="medium-4 cell">
                              <label for="fonction">Fonction :</label>
                              <input type="text" name="fonction" id="fonction" value="$fonction" placeholder="Fonction" />
                            </div>
                           <div class="medium-4 cell">
                             Membre de l'équipe médicale :
                             <div class="switch large">
                                <input class="switch-input" id="visible" type="checkbox" name="visible" $chek_visible />
                                <label class="switch-paddle" for="visible">
                                  <span class="show-for-sr">Membre équipe</span>
                                  <span class="switch-active" aria-hidden="true">Oui</span>
                                  <span class="switch-inactive" aria-hidden="true">Non</span>
                                </label>
                              </div>
                           </div> 
                           <div class="medium-4 cell">
                             Droits administrateur :
                             <div class="switch large">
                                <input class="switch-input" id="admin" type="checkbox" name="admin" $chek_admin />
                                <label class="switch-paddle" for="admin">
                                  <span class="show-for-sr">Administrateur</span>
                                  <span class="switch-active" aria-hidden="true">Oui</span>
                                  <span class="switch-inactive" aria-hidden="true">Non</span>
                                </label>
                              </div>
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
                             $button
                            </div>
                          </div>          
                        </form>
                      $view
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