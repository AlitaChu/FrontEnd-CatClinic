<?php
session_start();

/* $_SESSION : valeurs utilisée : voir dans require!
*/

// Pour test!!!
$_SESSION['adm']['id'] = 1;
$_SESSION['adm']['state'] = 'on';

require('../Inc/require.inc.php');

/*---------------- Session langues --------------------*/
if (isset ($_REQUEST['LANG'])) 
{
    $_SESSION['LANG'] = $_REQUEST['LANG'];
} 
else if (isset ($_SESSION['LANG'])) 
{
    $_SESSION['LANG'] = $_SESSION['LANG'];
}
else
{
    $_SESSION['LANG'] = 'FR';
}/*-------------------fin langues----------------------*/

debug($_SESSION);

//require('../Inc/admin.inc.php');
    
$EX = isset ($_REQUEST['ex']) ? $_REQUEST['ex'] : 'accueil';

/* La fonction de contrôle specialites() devra afficher le menu par défaut de la section 'specialites' */
/* La fonction de contrôle conseils() devra afficher le menu par défaut de la section 'conseils' */
/* La fonction de contrôle infos() devra afficher l'ancre' par défaut de la section 'infos' */

/* La fonction de contrôle login() vérifiera les infos envoyées par le formulaire, et affichera soit l'espace admin, soit l'espace membres */
/* La fonction de contrôle deconnect() a pour effet de vider $_SESSION['user'] */
switch ($EX) {
    case 'spe': specialites(); break;
    case 'fco': conseils(); break;
    case 'inf': infos(); break;   
    case 'log': login(); break;
    case 'dec': deconnect(); break;
    case 'ins': insert(); break;
    case 'mod': update(); break;
    case 'del': delete(); break;
    case 'mem': membres(); break;  
    case 'adm': admin(); break;
    case 'tes': test(); break;
    default : accueil(); break;
}/*-- finswitch */


/* --------------------------------------------------------------
 * FONCTIONS DE CONTROLE :  
 * home()
 * specialites()
 * conseils()
 * infos()
 ---------------------------------------------------------------*/
function accueil() {
    
    global $content;
    
    $content['title'] = 'Cat Clinic - Accueil';
    $content['description'] = 'Bienvenue dans votre clinique spécialisée dans le soin de vos félins';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../Html/accueil.html';
    
    return;
    
}/*-- accueil() */


function specialites() {
    
    global $content;
    
    $id = 1; // a remplacer par $_GET['idcat'] ou array
    
    if(!isset($_GET['id']))
    {
        $method = 'showSpecialites';
        $marticle = new MArticle();
        $data = $marticle-> SelectAllResume($id);
    } else
    {
        $method = 'showDetailsSpec';
        $marticle = new MArticle($_GET['id']);
        $data = $marticle-> Select();
    }
    array_walk($data, 'strip_xss');
    
    $content['title'] = 'Cat Clinic - Nos Specialités';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VSpecialites';
    
    $content['method'] = $method;
    $content['arg'] = $data;
    
    return;
    
}/*-- specialites() */


function conseils() {
    
    global $content;
    
    $id = 2; // a remplacer par $_GET['idcat'] ou array
    
    $marticle = new MArticle();
    $data = $marticle-> SelectResume($id);
    array_walk($data, 'strip_xss');
    
    $content['title'] = 'Cat Clinic - Conseils pour votre animal';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VHtml';
    $content['method'] = 'showConseils';
    
    $content['arg'] = $data;
    
    return;
    
}/*-- conseils() */


function infos() {
    
    global $content;
    
    $content['title'] = 'Cat Clinic - Informations générales';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    
    $html = '../Html/infos.html';
    $content['arg'] = $html;
    
    return;
    
}/*-- infos() */

/* --------------------------------------------------------------
 * FONCTIONS DE CONTROLE : (FORMULAIRE)
 * insert()
 * update()
 * delete()
 ---------------------------------------------------------------*/
function insert() {
    
    /* Vérification de la correspondance des mots de passe et encryptage */
    if(isset($_POST['passwd1']) && isset($_POST['passwd2'])) {
        if($_POST['passwd1'] === $_POST['passwd2']) {
            $_POST['passwd'] = $_POST['passwd1'];
        }
        isset($_POST['passwd']) ? $_POST['passwd'] = password_hash($_POST['passwd'], PASSWORD_BCRYPT) : ''; 
    }
    
    //debug($_POST);
    /* $_FILES = tabarray :
     * $_FILES['image']['name'] -> nom du fichier initial
     * $_FILES['image']['type'] -> type mime
     * $_FILES['image']['tmp_name'] -> chemin du fichier temporaire
     * $_FILES['image']['error'] -> s'il y a une erreur, à gérer!
     * $_FILES['image']['size'] -> taille du fichier */
    
    /* Teste s'il y a téléchargement d'une image : 
     * Vérifer 1. Attribut 'name' du form, 
               2. Présence de l'attribut enctype=" / ", 
               3.Vérifier init.php (si droit de télécharger) ainsi que le max upload */
    if (isset($_FILES['image']) && $_FILES['image']['tmp_name'])
    {
        /* Récupère les nouveaux noms de fichiers après traitement par la fonction upload() : */
        $filename_new = upload($_FILES['image']);
        $filename_vignette_new = 'vignettes/' . $filename_new;
        $filename_fullsize_new = 'fullsize/' . $filename_new;

        /* Redimensionne les images en fullsize */
        $fullsize_new = img_resize($_FILES['image']['tmp_name'], 450, 450);
        /* Génère l'image fullsize $fullsizeimage_new vers le fichier $filename_new en fonctoin de son mime : */
        switch ($_FILES['image']['type'])
        {
            case 'image/png'  : imagepng($fullsize_new, UPLOAD . $filename_fullsize_new, 0);  break;// 0 == compression minimum
            case 'image/jpeg' : imagejpeg($fullsize_new, UPLOAD . $filename_fullsize_new, 100); break;// 100 == compression maximum
            case 'image/gif'  : imagegif($fullsize_new, UPLOAD . $filename_fullsize_new);  break;
        }/*-- finswitch */

        /* Redimensionne l'image de la vignette : */
        $vignette_new = img_resize($_FILES['image']['tmp_name'], 150, 150);
        /* Génère l'image $image_new vers le fichier $file_new en fonction de son mime */
        switch ($_FILES['image']['type'])
        {
            case 'image/png'  : imagepng($vignette_new, UPLOAD . $filename_vignette_new, 0);  break;// 0 == compression minimum
            case 'image/jpeg' : imagejpeg($vignette_new, UPLOAD . $filename_vignette_new, 100); break;// 100 == compression maximum
            case 'image/gif'  : imagegif($vignette_new, UPLOAD . $filename_vignette_new);  break;
        }/*-- finswitch */

        /* Ajoute au tableau $_POST la clef ['IMG'] avec le nom du fichier pour insertion dans la base */
        $_POST['img'] = $filename_fullsize_new;
        $_POST['img_vig'] = $filename_vignette_new;
    }
    
    /* Switch de l'argument $_POST['arg'] passé en champ hidden, en fonction du formulaire d'insertion utilisé, déterminant le modèle à appeler */
    switch($_POST['arg']){
        case 'user': $retour = 'ex=adm&ex2=pan2';
                     $mtable = new MClient(); break;
        case 'anim': $retour = admin();
                     $mtable = new MAnimal(); break;
        case 'cons': $retour = 'ex=adm&ex2=pan3';
                     $_POST['id_veterinaire'] = $_SESSION['adm']['id'];
                     $mtable = new MConsultation(); break;
        case 'arti': $retour = admin();
                     $_POST['contenu'] = text_format();
                     $mtable = new MArticle(); break;
        case 'acte': $retour = admin();
                     $_POST['id_cons'] = $_SESSION['adm']['id_cons'];
                     $mtable = new MActe(); break;
        case 'admi': $mtable = new MVeterinaire(); break;
        default : die(); break;
    }/*-- finswitch */
    
    $mtable-> SetValue($_POST);
    $mtable-> Insert();
    
    header('Location:../Php/index.php?'.$retour);
    
}/*-- insert() */


function update() {
    
    $id_mod = isset($_SESSION['adm']['id_rep']) ? $_SESSION['adm']['id_rep'] : '';
    unset($_SESSION['adm']['id_rep']);
    
    /* Switch de l'argument $_POST['arg'] passé en champ hidden, en fonction du formulaire de modification utilisé, déterminant le modèle à appeler */
    switch($_POST['arg']){
        case 'user': $retour = 'ex=adm&ex2=pan2';
                     $mtable = new MClient(); break;
        case 'anim': $retour = admin();
                     $mtable = new MAnimal(); break;
        case 'cons': $retour = 'ex=adm&ex2=pan3';
                     $mtable = new MConsultation($id_mod); break;
        case 'arti': $retour = 'ex=adm';
                     $_POST['contenu'] = text_format();
                     $mtable = new MArticle($id_mod); break;
        case 'admi': $mtable = new MVeterinaire(); break;
        default : die(); break;
    }/*-- finswitch */
    
    $mtable-> SetValue($_POST);
    $mtable-> Update();
    
    header('Location:../Php/index.php?'.$retour);
    
}/*-- update() */


function delete() {
    
    $id_del = isset($_SESSION['adm']['id_rep'])? $_SESSION['adm']['id_rep'] : '';
    unset($_SESSION['adm']['id_rep']);
    
    $arg = $_SESSION['adm']['arg'];
    unset($_SESSION['adm']['arg']);
    
    if($arg == 'acte') {
        // mettre une erreur de suppression car consultation non-vide
    }
    
    /* Sécurité : Vérification lors de la suppression d'un acte, pour qu'il appartienne bien à la consultation courante/mise en $_SESSION['adm']['id_rep'], même en interface admin, on sait jamais... */
    $act = '';
    if(isset($_GET['act'])) {
        $macte = new MActe($_GET['act']);
        $data = $macte-> SelectActe($id_del);
        foreach ($data as $val) {
            if ($val['ID_ACTE'] == $_GET['act']) {
                $act = $_GET['act'];
            } 
        }
    }
    
    switch($arg){
        case 'user': $retour = 'ex=adm&ex2=pan3';
                     $mtable = new MClient($id_del); break;
        case 'anim': $retour = admin();
                     $mtable = new MAnimal($id_del); break;
        case 'cons': $retour = 'ex=adm&ex2=pan3';
                     $mtable = new MConsultation($id_del); break;
        case 'arti': $retour = 'ex=adm';
                     $mtable = new MArticle($id_del); break;
        case 'acte': $mtable = new MActe($act); 
                     admin(); break;
        case 'admi': // verif si ce n'est pas l'admin principal sinon :
                     $mtable = new MVeterinaire($id_del); break;
        default : die(); break;
    }/*-- finswitch */
    
    $mtable-> Delete();
    
    header('Location:../Php/index.php?'.$retour);
    
}/*-- delete() */


/* --------------------------------------------------------------
 * FONCTIONS DE CONTROLE :  
 * login()
 * membre()
 * admin()
 ---------------------------------------------------------------*/
function admin() {
    
    global $content;
    
    /* Teste que le mode administration soit autorisé, sinon, affichage page d'erreur */
    if (isset($_SESSION['adm']['state']) && $_SESSION['adm']['state'] == 'on') {
        
        /* Panel 1 : Général, gestion de la parution des articles */
        function panel1() {
            if(isset($_GET['id_art'])) {
                $marticle = new MArticle($_GET['id_art']);
                $data = $marticle-> Select();
            } else if(isset($_GET['id_cat'])) {
                $marticle = new MArticle();
                $data = $marticle-> SelectAllResume($_GET['id_cat']);
            } else {
                $mcategorie = new MCategorie();
                $data = $mcategorie-> SelectCat();
            }
        array_walk($data, 'strip_xss');
        return $data;    
        }
    
        /* Panel 2 : Gestion de la clientèle et des animaux */
        function panel2() {
            if(isset($_GET['id_client'])) {
                $mclient = new MClient($_GET['id_art']);
                $data = $mclient-> Select();
            } else {
                $mclient = new MCLient();
                $data = $mclient-> SelectAll();
            }
            array_walk($data, 'strip_xss');
            return $data;    
        }
    
        /* Panel 3 : Gestion des consultations */
        function panel3() {
            if(isset($_GET['id_cons'])) {
                $mconsultation = new MConsultation($_GET['id_cons']);
                $data = $mconsultation-> Select();
            } else {
                unset($_SESSION['adm']['id_cons']);
                $mconsultation = new MConsultation();
                $data = $mconsultation-> SelectAll();
            }
            array_walk($data, 'strip_xss');
            return $data;    
        }
    
        /* Panel 1 : Gestion des administrateurs */
        function panel4() {
        
        //array_walk($data, 'strip_xss');
        //return $data;    
        }
    
        $content['title'] = 'Cat Clinic - Panneau d\'administration';
        $content['description'] = ' ... ';
        $content['keywords'] = '';
        $content['author'] = 'Lambert Nathaelle';
    
        $content['class'] = 'VAdmin';
    
        /* Affichage par défaut */
        $EX2 = isset ($_REQUEST['ex2']) ? $_REQUEST['ex2'] : 'pan1';

        switch ($EX2) {
            case 'pan1': $data = panel1();
                         $content['method'] = 'showAdmGeneral';
                         $content['arg'] = $data;
                         break;
            case 'pan2': $data = panel2();
                         $content['method'] = 'showAdmClients';
                         $content['arg'] = $data;
                         break;
            case 'pan3': $data = panel3();
                         $content['method'] = 'showAdmConsultations';
                         $content['arg'] = $data;
                         break;
            case 'pan4': $data = panel4();
                         $content['method'] = 'showAdmAdmin';
                         $content['arg'] = $data;
                         break;
            default : die(); break;
        }/*-- finswitch */
    
        return;
    } else {
        $content['title'] = 'Cat Clinic';
        $content['description'] = ' ... ';
        $content['keywords'] = '';
        $content['author'] = 'Lambert Nathaelle';
    
        $content['class'] = 'VHtml';
        $content['method'] = 'showHtml';
        $content['arg'] = '';
    }
    
    
    
}/*-- admin() */

/* ---------------------------------------------------------------
 * Mise en page - Architecture 
 --------------------------------------------------------------- */
require('../View/layout.view.php');

?>